<?php
// Copyright (C) 2010 Combodo SARL
//
//   This program is free software; you can redistribute it and/or modify
//   it under the terms of the GNU General Public License as published by
//   the Free Software Foundation; version 3 of the License.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of the GNU General Public License
//   along with this program; if not, write to the Free Software
//   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

/**
 * Define filters for a given class of objects (formerly named "filter") 
 *
 * @author      Erwan Taloc <erwan.taloc@combodo.com>
 * @author      Romain Quetiez <romain.quetiez@combodo.com>
 * @author      Denis Flaven <denis.flaven@combodo.com>
 * @license     http://www.opensource.org/licenses/gpl-3.0.html LGPL
 */

class DBObjectSearch
{
	private $m_aClasses; // queried classes (alias => class name), the first item is the class corresponding to this filter (the rest is coming from subfilters)
	private $m_aSelectedClasses; // selected for the output (alias => class name)
	private $m_oSearchCondition;
	private $m_aParams;
	private $m_aFullText;
	private $m_aPointingTo;
	private $m_aReferencedBy;
	private $m_aRelatedTo;

	// By default, some information may be hidden to the current user
	// But it may happen that we need to disable that feature
	private $m_bAllowAllData = false;

	public function __construct($sClass, $sClassAlias = null)
	{
		if (is_null($sClassAlias)) $sClassAlias = $sClass;
		assert('is_string($sClass)');
		assert('MetaModel::IsValidClass($sClass)'); // #@# could do better than an assert, or at least give the caller's reference
		// => idee d'un assert avec call stack (autre utilisation = echec sur query SQL)

		$this->m_aSelectedClasses = array($sClassAlias => $sClass);
		$this->m_aClasses = array($sClassAlias => $sClass);
		$this->m_oSearchCondition = new TrueExpression;
		$this->m_aParams = array();
		$this->m_aFullText = array();
		$this->m_aPointingTo = array();
		$this->m_aReferencedBy = array();
		$this->m_aRelatedTo = array();
	}

	public function AllowAllData() {$this->m_bAllowAllData = true;}
	public function IsAllDataAllowed() {return $this->m_bAllowAllData;}

	public function GetClassName($sAlias) {return $this->m_aClasses[$sAlias];}
	public function GetJoinedClasses() {return $this->m_aClasses;}

	public function GetClass()
	{
		return reset($this->m_aSelectedClasses);
	}
	public function GetClassAlias()
	{
		reset($this->m_aSelectedClasses);
		return key($this->m_aSelectedClasses);
	}

	public function GetFirstJoinedClass()
	{
		return reset($this->m_aClasses);
	}
	public function GetFirstJoinedClassAlias()
	{
		reset($this->m_aClasses);
		return key($this->m_aClasses);
	}

	public function SetSelectedClasses($aNewSet)
	{
		$this->m_aSelectedClasses = array();
		foreach ($aNewSet as $sAlias => $sClass)
		{
			if (!array_key_exists($sAlias, $this->m_aClasses))
			{
				throw new CoreException('Unexpected class alias', array('alias'=>$sAlias, 'expected'=>$this->m_aClasses));
			}
			$this->m_aSelectedClasses[$sAlias] = $sClass;
		}
	}

	public function GetSelectedClasses()
	{
		return $this->m_aSelectedClasses;
	}


	public function IsAny()
	{
		// #@# todo - if (!$this->m_oSearchCondition->IsTrue()) return false;
		if (count($this->m_aFullText) > 0) return false;
		if (count($this->m_aPointingTo) > 0) return false;
		if (count($this->m_aReferencedBy) > 0) return false;
		if (count($this->m_aRelatedTo) > 0) return false;
		return true;
	}
	
	public function Describe()
	{
		// To replace __Describe
	}

	public function DescribeConditionPointTo($sExtKeyAttCode)
	{
		if (!isset($this->m_aPointingTo[$sExtKeyAttCode])) return "";
		$oFilter = $this->m_aPointingTo[$sExtKeyAttCode];
		if ($oFilter->IsAny()) return "";
		$oAtt = MetaModel::GetAttributeDef($this->GetClass(), $sExtKeyAttCode);
		return $oAtt->GetLabel()." having ({$oFilter->DescribeConditions()})";
	}

	public function DescribeConditionRefBy($sForeignClass, $sForeignExtKeyAttCode)
	{
		if (!isset($this->m_aReferencedBy[$sForeignClass][$sForeignExtKeyAttCode])) return "";
		$oFilter = $this->m_aReferencedBy[$sForeignClass][$sForeignExtKeyAttCode];
		if ($oFilter->IsAny()) return "";
		$oAtt = MetaModel::GetAttributeDef($sForeignClass, $sForeignExtKeyAttCode);
		return "being ".$oAtt->GetLabel()." for ".$sForeignClass."s in ({$oFilter->DescribeConditions()})";
	}

	public function DescribeConditionRelTo($aRelInfo)
	{
		$oFilter = $aRelInfo['flt'];
		$sRelCode = $aRelInfo['relcode'];
		$iMaxDepth = $aRelInfo['maxdepth'];
		return "related ($sRelCode... peut mieux faire !, $iMaxDepth dig depth) to a {$oFilter->GetClass()} ({$oFilter->DescribeConditions()})";
	}

	public function DescribeConditions()
	{
		$aConditions = array();

		$aCondFT = array();
		foreach($this->m_aFullText as $sFullText)
		{
			$aCondFT[] = " contain word(s) '$sFullText'";
		}
		if (count($aCondFT) > 0)
		{
			$aConditions[] = "which ".implode(" and ", $aCondFT);
		}

		// #@# todo - review textual description of the JOIN and search condition (is that still feasible?)
		$aConditions[] = $this->RenderCondition();

		$aCondPoint = array();
		foreach($this->m_aPointingTo as $sExtKeyAttCode=>$oFilter)
		{
			if ($oFilter->IsAny()) continue;
			$aCondPoint[] = $this->DescribeConditionPointTo($sExtKeyAttCode);
		}
		if (count($aCondPoint) > 0)
		{
			$aConditions[] = implode(" and ", $aCondPoint);
		}

		$aCondReferred= array();
		foreach($this->m_aReferencedBy as $sForeignClass=>$aReferences)
		{
			foreach($aReferences as $sForeignExtKeyAttCode=>$oForeignFilter)
			{
				if ($oForeignFilter->IsAny()) continue;
				$aCondReferred[] = $this->DescribeConditionRefBy($sForeignClass, $sForeignExtKeyAttCode);
			}
		}
		foreach ($this->m_aRelatedTo as $aRelInfo)
		{
			$aCondReferred[] = $this->DescribeConditionRelTo($aRelInfo);
		}
		if (count($aCondReferred) > 0)
		{
			$aConditions[] = implode(" and ", $aCondReferred);
		}

		return implode(" and ", $aConditions);		
	}
	
	public function __DescribeHTML()
	{
		try
		{
			$sConditionDesc = $this->DescribeConditions();
		}
		catch (MissingQueryArgument $e)
		{
			$sConditionDesc = '?missing query argument?';
		}
		if (!empty($sConditionDesc))
		{
			return "Objects of class '".$this->GetClass()."', $sConditionDesc";
		}
		return "Any object of class '".$this->GetClass()."'";
	}

	protected function TransferConditionExpression($oFilter, $aTranslation)
	{
		$oTranslated = $oFilter->GetCriteria()->Translate($aTranslation, false);
		$this->AddConditionExpression($oTranslated);
		// #@# what about collisions in parameter names ???
		$this->m_aParams = array_merge($this->m_aParams, $oFilter->m_aParams);
	}

	public function ResetCondition()
	{
		$this->m_oSearchCondition = new TrueExpression();
		// ? is that usefull/enough, do I need to rebuild the list after the subqueries ?
	}

	public function AddConditionExpression($oExpression)
	{
		$this->m_oSearchCondition = $this->m_oSearchCondition->LogAnd($oExpression); 
	}

	public function AddCondition($sFilterCode, $value, $sOpCode = null)
	{
		MyHelpers::CheckKeyInArray('filter code', $sFilterCode, MetaModel::GetClassFilterDefs($this->GetClass()));
		$oFilterDef = MetaModel::GetClassFilterDef($this->GetClass(), $sFilterCode);

		$oField = new FieldExpression($sFilterCode, $this->GetClassAlias());
		if (empty($sOpCode))
		{
			if ($sFilterCode == 'id')
			{
				$sOpCode = '=';
			}
			else
			{
				$oAttDef = MetaModel::GetAttributeDef($this->GetClass(), $sFilterCode);
				$oNewCondition = $oAttDef->GetSmartConditionExpression($value, $oField, $this->m_aParams);
				$this->AddConditionExpression($oNewCondition);
				return;
			}
		}
		MyHelpers::CheckKeyInArray('operator', $sOpCode, $oFilterDef->GetOperators());

		// Preserve backward compatibility - quick n'dirty way to change that API semantic
		//
		switch($sOpCode)
		{
		case 'SameDay':
		case 'SameMonth':
		case 'SameYear':
		case 'Today':
		case '>|':
		case '<|':
		case '=|':
			throw new CoreException('Deprecated operator, please consider using OQL (SQL) expressions like "(TO_DAYS(NOW()) - TO_DAYS(x)) AS AgeDays"', array('operator' => $sOpCode));
			break;

		case "IN":
			if (!is_array($value)) $value = array($value);
			$sListExpr = '('.implode(', ', CMDBSource::Quote($value)).')';
			$sOQLCondition = $oField->Render()." IN $sListExpr";
			break;

		case "NOTIN":
			if (!is_array($value)) $value = array($value);
			$sListExpr = '('.implode(', ', CMDBSource::Quote($value)).')';
			$sOQLCondition = $oField->Render()." NOT IN $sListExpr";
			break;

		case 'Contains':
			$this->m_aParams[$sFilterCode] = "%$value%";
			$sOperator = 'LIKE';
			break;

		case 'Begins with':
			$this->m_aParams[$sFilterCode] = "$value%";
			$sOperator = 'LIKE';
			break;

		case 'Finishes with':
			$this->m_aParams[$sFilterCode] = "%$value";
			$sOperator = 'LIKE';
			break;

		default:
			$this->m_aParams[$sFilterCode] = $value;
			$sOperator = $sOpCode;
		}

		switch($sOpCode)
		{
		case "IN":
		case "NOTIN":
			$oNewCondition = Expression::FromOQL($sOQLCondition);
			break;

		case 'Contains':
		case 'Begins with':
		case 'Finishes with':
		default:
			$oRightExpr = new VariableExpression($sFilterCode);
			$oNewCondition = new BinaryExpression($oField, $sOperator, $oRightExpr);
		}

		$this->AddConditionExpression($oNewCondition);
	}

	public function AddCondition_FullText($sFullText)
	{
		$this->m_aFullText[] = $sFullText;
	}

	protected function AddToNameSpace(&$aClassAliases, &$aAliasTranslation)
	{
		$sOrigAlias = $this->GetClassAlias();
		if (array_key_exists($sOrigAlias, $aClassAliases))
		{
			$sNewAlias = MetaModel::GenerateUniqueAlias($aClassAliases, $sOrigAlias, $this->GetClass());
			$this->m_aSelectedClasses[$sNewAlias] = $this->GetClass();
			unset($this->m_aSelectedClasses[$sOrigAlias]);

			// Translate the condition expression with the new alias
			$aAliasTranslation[$sOrigAlias]['*'] = $sNewAlias;
		}

		// add the alias into the filter aliases list
		$aClassAliases[$this->GetClassAlias()] = $this->GetClass();
		
		foreach($this->m_aPointingTo as $sExtKeyAttCode=>$oFilter)
		{
			$oFilter->AddToNameSpace($aClassAliases, $aAliasTranslation);
		}

		foreach($this->m_aReferencedBy as $sForeignClass=>$aReferences)
		{
			foreach($aReferences as $sForeignExtKeyAttCode=>$oForeignFilter)
			{
				$oForeignFilter->AddToNameSpace($aClassAliases, $aAliasTranslation);
			}
		}
	}

	public function AddCondition_PointingTo(DBObjectSearch $oFilter, $sExtKeyAttCode)
	{
		$aAliasTranslation = array();
		$res = $this->AddCondition_PointingTo_InNameSpace($oFilter, $sExtKeyAttCode, $this->m_aClasses, $aAliasTranslation);
		$this->TransferConditionExpression($oFilter, $aAliasTranslation);
		return $res;
	}

	protected function AddCondition_PointingTo_InNameSpace(DBObjectSearch $oFilter, $sExtKeyAttCode, &$aClassAliases, &$aAliasTranslation)
	{
		if (!MetaModel::IsValidKeyAttCode($this->GetClass(), $sExtKeyAttCode))
		{
			throw new CoreWarning("The attribute code '$sExtKeyAttCode' is not an external key of the class '{$this->GetClass()}' - the condition will be ignored");
		}
		$oAttExtKey = MetaModel::GetAttributeDef($this->GetClass(), $sExtKeyAttCode);
		if(!MetaModel::IsSameFamilyBranch($oFilter->GetClass(), $oAttExtKey->GetTargetClass()))
		{
			throw new CoreException("The specified filter (pointing to {$oFilter->GetClass()}) is not compatible with the key '{$this->GetClass()}::$sExtKeyAttCode', which is pointing to {$oAttExtKey->GetTargetClass()}");
		}

		if (array_key_exists($sExtKeyAttCode, $this->m_aPointingTo))
		{
			$this->m_aPointingTo[$sExtKeyAttCode]->MergeWith_InNamespace($oFilter, $aClassAliases, $aAliasTranslation);
		}
		else
		{
			$oFilter->AddToNamespace($aClassAliases, $aAliasTranslation);

			// #@# The condition expression found in that filter should not be used - could be another kind of structure like a join spec tree !!!!
			// $oNewFilter = clone $oFilter;
			// $oNewFilter->ResetCondition();

			$this->m_aPointingTo[$sExtKeyAttCode] = $oFilter;
		}
	}

	public function AddCondition_ReferencedBy(DBObjectSearch $oFilter, $sForeignExtKeyAttCode)
	{
		$aAliasTranslation = array();
		$res = $this->AddCondition_ReferencedBy_InNameSpace($oFilter, $sForeignExtKeyAttCode, $this->m_aClasses, $aAliasTranslation);
		$this->TransferConditionExpression($oFilter, $aAliasTranslation);
		return $res;
	}

	protected function AddCondition_ReferencedBy_InNameSpace(DBObjectSearch $oFilter, $sForeignExtKeyAttCode, &$aClassAliases, &$aAliasTranslation)
	{
		$sForeignClass = $oFilter->GetClass();
		$sForeignClassAlias = $oFilter->GetClassAlias();
		if (!MetaModel::IsValidKeyAttCode($sForeignClass, $sForeignExtKeyAttCode))
		{
			throw new CoreException("The attribute code '$sForeignExtKeyAttCode' is not an external key of the class '{$sForeignClass}' - the condition will be ignored");
		}
		$oAttExtKey = MetaModel::GetAttributeDef($sForeignClass, $sForeignExtKeyAttCode);
		if(!MetaModel::IsSameFamilyBranch($this->GetClass(), $oAttExtKey->GetTargetClass()))
		{
			throw new CoreException("The specified filter (objects referencing an object of class {$this->GetClass()}) is not compatible with the key '{$sForeignClass}::$sForeignExtKeyAttCode', which is pointing to {$oAttExtKey->GetTargetClass()}");
		}
		if (array_key_exists($sForeignClass, $this->m_aReferencedBy) && array_key_exists($sForeignExtKeyAttCode, $this->m_aReferencedBy[$sForeignClass]))
		{
			$this->m_aReferencedBy[$sForeignClass][$sForeignExtKeyAttCode]->MergeWith_InNamespace($oFilter, $aClassAliases, $aAliasTranslation);
		}
		else
		{
			$oFilter->AddToNamespace($aClassAliases, $aAliasTranslation);

			// #@# The condition expression found in that filter should not be used - could be another kind of structure like a join spec tree !!!!
			//$oNewFilter = clone $oFilter;
			//$oNewFilter->ResetCondition();

			$this->m_aReferencedBy[$sForeignClass][$sForeignExtKeyAttCode]= $oFilter;
		}
	}

	public function AddCondition_LinkedTo(DBObjectSearch $oLinkFilter, $sExtKeyAttCodeToMe, $sExtKeyAttCodeTarget, DBObjectSearch $oFilterTarget)
	{
		$oLinkFilterFinal = clone $oLinkFilter;
		$oLinkFilterFinal->AddCondition_PointingTo($sExtKeyAttCodeToMe);

		$this->AddCondition_ReferencedBy($oLinkFilterFinal, $sExtKeyAttCodeToMe);
	}

	public function AddCondition_RelatedTo(DBObjectSearch $oFilter, $sRelCode, $iMaxDepth)
	{
		MyHelpers::CheckValueInArray('relation code', $sRelCode, MetaModel::EnumRelations());
		$this->m_aRelatedTo[] = array('flt'=>$oFilter, 'relcode'=>$sRelCode, 'maxdepth'=>$iMaxDepth);
	}

	public function MergeWith($oFilter)
	{
		$aAliasTranslation = array();
		$res = $this->MergeWith_InNamespace($oFilter, $this->m_aClasses, $aAliasTranslation);
		$this->TransferConditionExpression($oFilter, $aAliasTranslation);
		return $res;
	}

	protected function MergeWith_InNamespace($oFilter, &$aClassAliases, &$aAliasTranslation)
	{
		if ($this->GetClass() != $oFilter->GetClass())
		{
			throw new CoreException("Attempting to merge a filter of class '{$this->GetClass()}' with a filter of class '{$oFilter->GetClass()}'");
		}

		// Translate search condition into our aliasing scheme
		$aAliasTranslation[$oFilter->GetClassAlias()]['*'] = $this->GetClassAlias(); 

		$this->m_aFullText = array_merge($this->m_aFullText, $oFilter->m_aFullText);
		$this->m_aRelatedTo = array_merge($this->m_aRelatedTo, $oFilter->m_aRelatedTo);

		foreach($oFilter->m_aPointingTo as $sExtKeyAttCode=>$oExtFilter)
		{
			$this->AddCondition_PointingTo_InNamespace($oExtFilter, $sExtKeyAttCode, $aClassAliases, $aAliasTranslation);
		}
		foreach($oFilter->m_aReferencedBy as $sForeignClass => $aReferences)
		{
			foreach($aReferences as $sForeignExtKeyAttCode => $oForeignFilter)
			{
				$this->AddCondition_ReferencedBy_InNamespace($oForeignFilter, $sForeignExtKeyAttCode, $aClassAliases, $aAliasTranslation);
			}
		}
	}

	public function GetCriteria() {return $this->m_oSearchCondition;}
	public function GetCriteria_FullText() {return $this->m_aFullText;}
	public function GetCriteria_PointingTo($sKeyAttCode = "")
	{
		if (empty($sKeyAttCode))
		{
			return $this->m_aPointingTo;
		}
		if (!array_key_exists($sKeyAttCode, $this->m_aPointingTo)) return null;
		return $this->m_aPointingTo[$sKeyAttCode];
	}
	public function GetCriteria_ReferencedBy($sRemoteClass = "", $sForeignExtKeyAttCode = "")
	{
		if (empty($sRemoteClass))
		{
			return $this->m_aReferencedBy;
		}
		if (!array_key_exists($sRemoteClass, $this->m_aReferencedBy)) return null;
		if (empty($sForeignExtKeyAttCode))
		{
			return $this->m_aReferencedBy[$sRemoteClass];
		}
		if (!array_key_exists($sForeignExtKeyAttCode, $this->m_aReferencedBy[$sRemoteClass])) return null;
		return $this->m_aReferencedBy[$sRemoteClass][$sForeignExtKeyAttCode];
	}
	public function GetCriteria_RelatedTo()
	{
		return $this->m_aRelatedTo;
	}
	public function GetInternalParams()
	{
		return $this->m_aParams;
	}

	public function RenderCondition()
	{
		return $this->m_oSearchCondition->Render($this->m_aParams, false);
	}

	public function serialize($bDevelopParams = false, $aContextParams = null)
	{
		$sOql = $this->ToOql($bDevelopParams, $aContextParams);
		return base64_encode(serialize(array($sOql, $this->m_aParams)));
	}
	
	static public function unserialize($sValue)
	{
		$aData = unserialize(base64_decode($sValue));
		$sOql = $aData[0];
		$aParams = $aData[1];
		// We've tried to use gzcompress/gzuncompress, but for some specific queries
		// it was not working at all (See Trac #193)
		// gzuncompress was issuing a warning "data error" and the return object was null
		return self::FromOQL($sOql, $aParams);
	}

	// SImple BUt Structured Query Languag - SubuSQL
	//
	static private function Value2Expression($value)
	{
		$sRet = $value;
		if (is_array($value))
		{
			$sRet = VS_START.implode(', ', $value).VS_END;
		}
		else if (!is_numeric($value))
		{
			$sRet = "'".addslashes($value)."'";
		}
		return $sRet;
	}
	static private function Expression2Value($sExpr)
	{
		$retValue = $sExpr;
		if ((substr($sExpr, 0, 1) == "'") && (substr($sExpr, -1, 1) == "'"))
		{
			$sNoQuotes = substr($sExpr, 1, -1);
			return stripslashes($sNoQuotes);
		}
		if ((substr($sExpr, 0, 1) == VS_START) && (substr($sExpr, -1, 1) == VS_END))
		{
			$sNoBracket = substr($sExpr, 1, -1);
			$aRetValue = array();
			foreach (explode(",", $sNoBracket) as $sItem)
			{
				$aRetValue[] = self::Expression2Value(trim($sItem));
			}
			return $aRetValue;
		}
		return $retValue;
	}

	// Alternative to object mapping: the data are transfered directly into an array
	// This is 10 times faster than creating a set of objects, and makes sense when optimization is required
	public function ToDataArray($aColumns = array(), $aOrderBy = array(), $aArgs = array())
	{
		$sSQL = MetaModel::MakeSelectQuery($this, $aOrderBy, $aArgs);
		$resQuery = CMDBSource::Query($sSQL);
		if (!$resQuery) return;

		if (count($aColumns) == 0)
		{
			$aColumns = array_keys(MetaModel::ListAttributeDefs($this->GetClass()));
			// Add the standard id (as first column)
			array_unshift($aColumns, 'id');
		}

		$aQueryCols = CMDBSource::GetColumns($resQuery);

		$sClassAlias = $this->GetClassAlias();
		$aColMap = array();
		foreach ($aColumns as $sAttCode)
		{
			$sColName = $sClassAlias.$sAttCode;
			if (in_array($sColName, $aQueryCols))
			{
				$aColMap[$sAttCode] = $sColName;
			}
		}

		$aRes = array();
		while ($aRow = CMDBSource::FetchArray($resQuery))
		{
			$aMappedRow = array();
			foreach ($aColMap as $sAttCode => $sColName)
			{
				$aMappedRow[$sAttCode] = $aRow[$sColName];
			}
			$aRes[] = $aMappedRow;
		}
		CMDBSource::FreeResult($resQuery);
		return $aRes;
	}

	public function ToOQL($bDevelopParams = false, $aContextParams = null)
	{
		// Currently unused, but could be useful later
		$bRetrofitParams = false;

		if ($bDevelopParams)
		{
			if (is_null($aContextParams))
			{
				$aParams = array_merge($this->m_aParams);
			}
			else
			{
				$aParams = array_merge($aContextParams, $this->m_aParams);
			}
		}
		else
		{
			// Leave it as is, the rendering will be made with parameters in clear
			$aParams = null;
		}
	
		$sSelectedClasses = implode(', ', array_keys($this->m_aSelectedClasses));
		$sRes = 'SELECT '.$sSelectedClasses.' FROM';

		$sRes .= ' '.$this->GetClass().' AS '.$this->GetClassAlias();
		$sRes .= $this->ToOQL_Joins();
		$sRes .= " WHERE ".$this->m_oSearchCondition->Render($aParams, $bRetrofitParams);

		// Temporary: add more info about other conditions, necessary to avoid strange behaviors with the cache
		foreach($this->m_aFullText as $sFullText)
		{
			$sRes .= " AND MATCHES '$sFullText'";
		}
		return $sRes;
	}

	protected function ToOQL_Joins()
	{
		$sRes = '';
		foreach($this->m_aPointingTo as $sExtKey=>$oFilter)
		{
			$sRes .= ' JOIN '.$oFilter->GetClass().' AS '.$oFilter->GetClassAlias().' ON '.$this->GetClassAlias().'.'.$sExtKey.' = '.$oFilter->GetClassAlias().'.id';
			$sRes .= $oFilter->ToOQL_Joins();
		}
		foreach($this->m_aReferencedBy as $sForeignClass=>$aReferences)
		{
			foreach($aReferences as $sForeignExtKeyAttCode=>$oForeignFilter)
			{
				$sRes .= ' JOIN '.$oForeignFilter->GetClass().' AS '.$oForeignFilter->GetClassAlias().' ON '.$oForeignFilter->GetClassAlias().'.'.$sForeignExtKeyAttCode.' = '.$this->GetClassAlias().'.id';
				$sRes .= $oForeignFilter->ToOQL_Joins();
			}
		}
		return $sRes;
	}

	protected function OQLExpressionToCondition($sQuery, $oExpression, $aClassAliases)
	{
		if ($oExpression instanceof BinaryOqlExpression)
		{
			$sOperator = $oExpression->GetOperator();
			$oLeft = $this->OQLExpressionToCondition($sQuery, $oExpression->GetLeftExpr(), $aClassAliases);
			$oRight = $this->OQLExpressionToCondition($sQuery, $oExpression->GetRightExpr(), $aClassAliases);
			return new BinaryExpression($oLeft, $sOperator, $oRight);
		}
		elseif ($oExpression instanceof FieldOqlExpression)
		{
			$sClassAlias = $oExpression->GetParent();
			$sFltCode = $oExpression->GetName();
			if (empty($sClassAlias))
			{
				// Try to find an alias
				// Build an array of field => array of aliases
				$aFieldClasses = array();
				foreach($aClassAliases as $sAlias => $sReal)
				{
					foreach(MetaModel::GetFiltersList($sReal) as $sAnFltCode)
					{
						$aFieldClasses[$sAnFltCode][] = $sAlias;
					}
				}
				if (!array_key_exists($sFltCode, $aFieldClasses))
				{
					throw new OqlNormalizeException('Unknown filter code', $sQuery, $oExpression->GetNameDetails(), array_keys($aFieldClasses));
				}
				if (count($aFieldClasses[$sFltCode]) > 1)
				{
					throw new OqlNormalizeException('Ambiguous filter code', $sQuery, $oExpression->GetNameDetails());
				}
				$sClassAlias = $aFieldClasses[$sFltCode][0];
			}
			else
			{
				if (!array_key_exists($sClassAlias, $aClassAliases))
				{
					throw new OqlNormalizeException('Unknown class [alias]', $sQuery, $oExpression->GetParentDetails(), array_keys($aClassAliases));
				}
				$sClass = $aClassAliases[$sClassAlias];
				if (!MetaModel::IsValidFilterCode($sClass, $sFltCode))
				{
					throw new OqlNormalizeException('Unknown filter code', $sQuery, $oExpression->GetNameDetails(), MetaModel::GetFiltersList($sClass));
				}
			}

			return new FieldExpression($sFltCode, $sClassAlias);
		}
		elseif ($oExpression instanceof VariableOqlExpression)
		{
			return new VariableExpression($oExpression->GetName());
		}
		elseif ($oExpression instanceof TrueOqlExpression)
		{
			return new TrueExpression;
		}
		elseif ($oExpression instanceof ScalarOqlExpression)
		{
			return new ScalarExpression($oExpression->GetValue());
		}
		elseif ($oExpression instanceof ListOqlExpression)
		{
			$aItems = array();
			foreach ($oExpression->GetItems() as $oItemExpression)
			{
				$aItems[] = $this->OQLExpressionToCondition($sQuery, $oItemExpression, $aClassAliases);
			}
			return new ListExpression($aItems);
		}
		elseif ($oExpression instanceof FunctionOqlExpression)
		{
			$aArgs = array();
			foreach ($oExpression->GetArgs() as $oArgExpression)
			{
				$aArgs[] = $this->OQLExpressionToCondition($sQuery, $oArgExpression, $aClassAliases);
			}
			return new FunctionExpression($oExpression->GetVerb(), $aArgs);
		}
		else
		{
			throw new CoreException('Unknown expression type', array('class'=>get_class($oExpression), 'query'=>$sQuery));
		}
	}

	// Create a search definition that leads to 0 result, still a valid search object
	static public function FromEmptySet($sClass)
	{
		$oResultFilter = new DBObjectSearch($sClass);
		$oResultFilter->m_oSearchCondition = new FalseExpression;
		return $oResultFilter;
	}

	static protected $m_aOQLQueries = array();

	// Do not filter out depending on user rights
	// In particular when we are currently in the process of evaluating the user rights...
	static public function FromOQL_AllData($sQuery, $aParams = null)
	{
		$oRes = self::FromOQL($sQuery, $aParams);
		$oRes->AllowAllData();
		return $oRes;
	}

	static public function FromOQL($sQuery, $aParams = null)
	{
		if (empty($sQuery)) return null;

		// Query caching
		$bOQLCacheEnabled = true;
		if ($bOQLCacheEnabled && array_key_exists($sQuery, self::$m_aOQLQueries))
		{
			// hit!
			return clone self::$m_aOQLQueries[$sQuery];
		}

		$oOql = new OqlInterpreter($sQuery);
		$oOqlQuery = $oOql->ParseObjectQuery();
		
		$sClass = $oOqlQuery->GetClass();
		$sClassAlias = $oOqlQuery->GetClassAlias();

		if (!MetaModel::IsValidClass($sClass))
		{
			throw new OqlNormalizeException('Unknown class', $sQuery, $oOqlQuery->GetClassDetails(), MetaModel::GetClasses());
		}

		$oResultFilter = new DBObjectSearch($sClass, $sClassAlias);
		$aAliases = array($sClassAlias => $sClass);

		// Maintain an array of filters, because the flat list is in fact referring to a tree
		// And this will be an easy way to dispatch the conditions
		// $oResultFilter will be referenced by the other filters, or the other way around...
		$aJoinItems = array($sClassAlias => $oResultFilter);

		$aJoinSpecs = $oOqlQuery->GetJoins();
		if (is_array($aJoinSpecs))
		{
			foreach ($aJoinSpecs as $oJoinSpec)
			{
				$sJoinClass = $oJoinSpec->GetClass();
				$sJoinClassAlias = $oJoinSpec->GetClassAlias();
				if (!MetaModel::IsValidClass($sJoinClass))
				{
					throw new OqlNormalizeException('Unknown class', $sQuery, $oJoinSpec->GetClassDetails(), MetaModel::GetClasses());
				}
				if (array_key_exists($sJoinClassAlias, $aAliases))
				{
					if ($sJoinClassAlias != $sJoinClass)
					{
						throw new OqlNormalizeException('Duplicate class alias', $sQuery, $oJoinSpec->GetClassAliasDetails());
					}
					else
					{
						throw new OqlNormalizeException('Duplicate class name', $sQuery, $oJoinSpec->GetClassDetails());
					}
				} 

				// Assumption: ext key on the left only !!!
				// normalization should take care of this
				$oLeftField = $oJoinSpec->GetLeftField();
				$sFromClass = $oLeftField->GetParent();
				$sExtKeyAttCode = $oLeftField->GetName();

				$oRightField = $oJoinSpec->GetRightField();
				$sToClass = $oRightField->GetParent();
				$sPKeyDescriptor = $oRightField->GetName();
				if ($sPKeyDescriptor != 'id')
				{
					throw new OqlNormalizeException('Wrong format for Join clause (right hand), expecting an id', $sQuery, $oRightField->GetNameDetails(), array('id'));
				}

				$aAliases[$sJoinClassAlias] = $sJoinClass;
				$aJoinItems[$sJoinClassAlias] = new DBObjectSearch($sJoinClass, $sJoinClassAlias);

				if (!array_key_exists($sFromClass, $aJoinItems))
				{
					throw new OqlNormalizeException('Unknown class in join condition (left expression)', $sQuery, $oLeftField->GetParentDetails(), array_keys($aJoinItems));
				}
				if (!array_key_exists($sToClass, $aJoinItems))
				{
					throw new OqlNormalizeException('Unknown class in join condition (right expression)', $sQuery, $oRightField->GetParentDetails(), array_keys($aJoinItems));
				}
				$aExtKeys = array_keys(MetaModel::GetExternalKeys($aAliases[$sFromClass]));
				if (!in_array($sExtKeyAttCode, $aExtKeys))
				{
					throw new OqlNormalizeException('Unknown external key in join condition (left expression)', $sQuery, $oLeftField->GetNameDetails(), $aExtKeys);
				}

				if ($sFromClass == $sJoinClassAlias)
				{
					$aJoinItems[$sToClass]->AddCondition_ReferencedBy($aJoinItems[$sFromClass], $sExtKeyAttCode);
				}
				else
				{
					$aJoinItems[$sFromClass]->AddCondition_PointingTo($aJoinItems[$sToClass], $sExtKeyAttCode);
				}
			}
		}

		// Check and prepare the select information
		$aSelected = array();
		foreach ($oOqlQuery->GetSelectedClasses() as $oClassDetails)
		{
			$sClassToSelect = $oClassDetails->GetValue();
			if (!array_key_exists($sClassToSelect, $aAliases))
			{
				throw new OqlNormalizeException('Unknown class [alias]', $sQuery, $oClassDetails, array_keys($aAliases));
			}
			$aSelected[$sClassToSelect] = $aAliases[$sClassToSelect];
		}
		$oResultFilter->m_aClasses = $aAliases;
		$oResultFilter->SetSelectedClasses($aSelected);

		$oConditionTree = $oOqlQuery->GetCondition();
		if ($oConditionTree instanceof Expression)
		{
			$oResultFilter->m_oSearchCondition = $oResultFilter->OQLExpressionToCondition($sQuery, $oConditionTree, $aAliases);
		}

		if (!is_null($aParams))
		{
			$oResultFilter->m_aParams = $aParams;
		}

		if ($bOQLCacheEnabled)
		{
			self::$m_aOQLQueries[$sQuery] = clone $oResultFilter;
		}

		return $oResultFilter;
	}

	public function toxpath()
	{
		// #@# a voir...
	}
	static public function fromxpath()
	{
		// #@# a voir...
	}
}


?>
