<?php
// Copyright (C) 2012 Combodo SARL
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

require_once(APPROOT.'application/forms.class.inc.php');

/**
 * Base class for all 'dashlets' (i.e. widgets to be inserted into a dashboard)
 *
 */
abstract class Dashlet
{
	protected $sId;
	protected $bRedrawNeeded;
	protected $bFormRedrawNeeded;
	protected $aProperties; // array of {property => value}
	protected $aCSSClasses;
	
	public function __construct($sId)
	{
		$this->sId = $sId;
		$this->bRedrawNeeded = true; // By default: redraw each time a property changes
		$this->bFormRedrawNeeded = false; // By default: no need to redraw the form (independent fields)
		$this->aProperties = array(); // By default: there is no property
		$this->aCSSClasses = array('dashlet');
	}

	// Assuming that a property has the type of its default value, set in the constructor
	//
	public function Str2Prop($sProperty, $sValue)
	{
		$refValue = $this->aProperties[$sProperty];
		$sRefType = gettype($refValue);
		if ($sRefType == 'boolean')
		{
			$ret = ($sValue == 'true');
		}
		else
		{
			$ret = $sValue;
			settype($ret, $sRefType);
		}
		return $ret;
	}

	public function Prop2Str($value)
	{
		if (gettype($value) == 'boolean')
		{
			$sRet = $value ? 'true' : 'false';
		}
		else
		{
			$sRet = (string) $value;
		}
		return $sRet;
	}

	public function FromDOMNode($oDOMNode)
	{
		foreach ($this->aProperties as $sProperty => $value)
		{
			$this->oDOMNode = $oDOMNode->getElementsByTagName($sProperty)->item(0);
			if ($this->oDOMNode != null)
			{
				$newvalue = $this->Str2Prop($sProperty, $this->oDOMNode->textContent);
				$this->aProperties[$sProperty] = $newvalue;
			}
		}
	}

	public function ToDOMNode($oDOMNode)
	{
		foreach ($this->aProperties as $sProperty => $value)
		{
			$sXmlValue = $this->Prop2Str($value);
			$oPropNode = $oDOMNode->ownerDocument->createElement($sProperty, $sXmlValue);
			$oDOMNode->appendChild($oPropNode);
		}
	}
	
	public function FromXml($sXml)
	{
		$oDomDoc = new DOMDocument('1.0', 'UTF-8');
		$oDomDoc->loadXml($sXml);
		$this->FromDOMNode($oDomDoc->firstChild);
	}
	
	public function FromParams($aParams)
	{
		foreach ($this->aProperties as $sProperty => $value)
		{
			if (array_key_exists($sProperty, $aParams))
			{
				$this->aProperties[$sProperty] = $aParams[$sProperty];
			}
		}
	}
	
	public function DoRender($oPage, $bEditMode = false, $aExtraParams = array())
	{
		$sCSSClasses = implode(' ', $this->aCSSClasses);
		if ($bEditMode)
		{
			$sId = $this->GetID();
			$oPage->add('<div class="'.$sCSSClasses.'" id="dashlet_'.$sId.'">');
		}
		else
		{
			$oPage->add('<div class="'.$sCSSClasses.'">');
		}
		$this->Render($oPage, $bEditMode, $aExtraParams);
		$oPage->add('</div>');
		if ($bEditMode)
		{
			$sClass = get_class($this);
			$oPage->add_ready_script(
<<<EOF
$('#dashlet_$sId').dashlet({dashlet_id: '$sId', dashlet_class: '$sClass'});
EOF
			);
		}
	}
	
	public function SetID($sId)
	{
		$this->sId = $sId;
	}
	
	public function GetID()
	{
		return $this->sId;
	}
	
	abstract public function Render($oPage, $bEditMode = false, $aExtraParams = array());
		
	abstract public function GetPropertiesFields(DesignerForm $oForm);
	
	public function ToXml(DOMNode $oContainerNode)
	{
		
	}

	public function Update($aValues, $aUpdatedFields)
	{
		foreach($aUpdatedFields as $sProp)
		{
			if (array_key_exists($sProp, $this->aProperties))
			{
				$this->aProperties[$sProp] = $aValues[$sProp];
			}
		}
		return $this;
	}
	

	public function IsRedrawNeeded()
	{
		return $this->bRedrawNeeded;
	}
	
	public function IsFormRedrawNeeded()
	{
		return $this->bFormRedrawNeeded;
	}
	
	static public function GetInfo()
	{
		return array(
			'label' => '',
			'icon' => '',
			'description' => '',
		);
	}
	
	public function GetForm()
	{
		$oForm = new DesignerForm();
		$oForm->SetPrefix("dashlet_". $this->GetID());
		$oForm->SetParamsContainer('params');
		
		$this->GetPropertiesFields($oForm);
		
		$oDashletClassField = new DesignerHiddenField('dashlet_class', '', get_class($this));
		$oForm->AddField($oDashletClassField);
		
		$oDashletIdField = new DesignerHiddenField('dashlet_id', '', $this->GetID());
		$oForm->AddField($oDashletIdField);
		
		return $oForm;
	}
	
	static public function IsVisible()
	{
		return true;
	}
	
	static public function CanCreateFromOQL()
	{
		return false;
	}
	
	public function GetPropertiesFieldsFromOQL(DesignerForm $oForm, $sOQL)
	{
		// Default: do nothing since it's not supported
	}
}

class DashletEmptyCell extends Dashlet
{
	public function __construct($sId)
	{
		parent::__construct($sId);
	}
	
	public function Render($oPage, $bEditMode = false, $aExtraParams = array())
	{
		$oPage->add('&nbsp;');
	}

	public function GetPropertiesFields(DesignerForm $oForm)
	{
	}
	
	static public function GetInfo()
	{
		return array(
			'label' => 'Empty Cell',
			'icon' => 'images/dashlet-text.png',
			'description' => 'Empty Cell Dashlet Placeholder',
		);
	}
	
	static public function IsVisible()
	{
		return false;
	}
}

class DashletHelloWorld extends Dashlet
{
	public function __construct($sId)
	{
		parent::__construct($sId);
		$this->aProperties['text'] = 'Hello World';
	}
	
	public function Render($oPage, $bEditMode = false, $aExtraParams = array())
	{
		$sId = 'chart_'.($bEditMode? 'edit_' : '').$this->sId;
		$oPage->add('<div id="chart_'.$sId.'" class="dashlet-content"></div>');
		$oPage->add_ready_script("$('#chart_{$sId}').pie_chart();");
	}

	public function GetPropertiesFields(DesignerForm $oForm)
	{
		$oField = new DesignerTextField('text', 'Text', $this->aProperties['text']);
		$oForm->AddField($oField);
	}
	
	static public function GetInfo()
	{
		return array(
			'label' => 'Hello World',
			'icon' => 'images/dashlet-text.png',
			'description' => 'Hello World test Dashlet',
		);
	}
}

class DashletObjectList extends Dashlet
{
	public function __construct($sId)
	{
		parent::__construct($sId);
		$this->aProperties['title'] = 'Hardcoded list of "my requests"';
		$this->aProperties['query'] = 'SELECT UserRequest AS i WHERE i.caller_id = :current_contact_id AND status NOT IN ("closed", "resolved")';
		$this->aProperties['menu'] = false;
	}
	
	public function Render($oPage, $bEditMode = false, $aExtraParams = array())
	{
		$sTitle = $this->aProperties['title'];
		$sQuery = $this->aProperties['query'];
		$sShowMenu = $this->aProperties['menu'] ? '1' : '0';

		$oPage->add('<div style="text-align:center" class="dashlet-content">');
		$oFilter = DBObjectSearch::FromOQL($sQuery);
		$oBlock = new DisplayBlock($oFilter, 'list');
		$aExtraParams = array(
			'menu' => $sShowMenu,
		);
		$sBlockId = 'block_'.$this->sId.($bEditMode ? '_edit' : ''); // make a unique id (edition occuring in the same DOM)
		$oBlock->Display($oPage, $sBlockId, $aExtraParams);
		$oPage->add('</div>');
	}

	public function GetPropertiesFields(DesignerForm $oForm)
	{
		$oField = new DesignerTextField('title', 'Title', $this->aProperties['title']);
		$oForm->AddField($oField);

		$oField = new DesignerLongTextField('query', 'Query', $this->aProperties['query']);
		$oForm->AddField($oField);

		$oField = new DesignerBooleanField('menu', 'Menu', $this->aProperties['menu']);
		$oForm->AddField($oField);
	}

	static public function GetInfo()
	{
		return array(
			'label' => 'Object list',
			'icon' => 'images/dashlet-list.png',
			'description' => 'Object list dashlet',
		);
	}
	
	static public function CanCreateFromOQL()
	{
		return true;
	}
	
	public function GetPropertiesFieldsFromOQL(DesignerForm $oForm, $sOQL)
	{
		$oField = new DesignerTextField('title', 'Title', '');
		$oForm->AddField($oField);

		$oField = new DesignerHiddenField('query', 'Query', $sOQL);
		$oForm->AddField($oField);

		$oField = new DesignerBooleanField('menu', 'Menu', $this->aProperties['menu']);
		$oForm->AddField($oField);
	}
}

abstract class DashletGroupBy extends Dashlet
{
	public function __construct($sId)
	{
		parent::__construct($sId);
		$this->aProperties['title'] = 'Hardcoded list of Contacts grouped by location';
		$this->aProperties['query'] = 'SELECT Contact';
		$this->aProperties['group_by'] = 'location_name';
		$this->aProperties['style'] = 'table';
	}

	public function Render($oPage, $bEditMode = false, $aExtraParams = array())
	{
		$sTitle = $this->aProperties['title'];
		$sQuery = $this->aProperties['query'];
		$sGroupBy = $this->aProperties['group_by'];
		$sStyle = $this->aProperties['style'];

		if ($sQuery == '')
		{
			$oPage->add('<p>Please enter a valid OQL query</p>');
		}
		elseif ($sGroupBy == '')
		{
			$oPage->add('<p>Please select the field on which the objects will be grouped together</p>');
		}
		else
		{
			$oFilter = DBObjectSearch::FromOQL($sQuery);
			$sClassAlias = $oFilter->GetClassAlias();

			if (preg_match('/^(.*):(.*)$/', $sGroupBy, $aMatches))
			{
				$sAttCode = $aMatches[1];
				$sFunction = $aMatches[2];

				switch($sFunction)
				{
				case 'hour':
					$sGroupByLabel = 'Hour of '.$sAttCode. ' (0-23)';
					$sGroupByExpr = "DATE_FORMAT($sClassAlias.$sAttCode, '%H')"; // 0 -> 31
					break;

				case 'month':
					$sGroupByLabel = 'Month of '.$sAttCode. ' (1 - 12)';
					$sGroupByExpr = "DATE_FORMAT($sClassAlias.$sAttCode, '%m')"; // 0 -> 31
					break;

				case 'day_of_week':
					$sGroupByLabel = 'Day of week for '.$sAttCode. ' (sunday to saturday)';
					$sGroupByExpr = "DATE_FORMAT($sClassAlias.$sAttCode, '%w')";
					break;

				case 'day_of_month':
					$sGroupByLabel = 'Day of month for'.$sAttCode;
					$sGroupByExpr = "DATE_FORMAT($sClassAlias.$sAttCode, '%e')"; // 0 -> 31
					break;

				default:
					$sGroupByLabel = 'Unknown group by function '.$sFunction;
					$sGroupByExpr = $sClassAlias.'.'.$sAttCode;
				}
			}
			else
			{
				$sAttCode = $sGroupBy;

				$sGroupByExpr = $sClassAlias.'.'.$sAttCode;
				$sGroupByLabel = MetaModel::GetLabel($oFilter->GetClass(), $sAttCode);
			}

			switch($sStyle)
			{
			case 'bars':
				$sType = 'open_flash_chart';
				$aExtraParams = array(
					'chart_type' => 'bars',
					'chart_title' => $sTitle,
					'group_by' => $sGroupByExpr,
					'group_by_label' => $sGroupByLabel,
				);
				$sHtmlTitle = ''; // done in the itop block
				break;

			case 'pie':
				$sType = 'open_flash_chart';
				$aExtraParams = array(
					'chart_type' => 'pie',
					'chart_title' => $sTitle,
					'group_by' => $sGroupByExpr,
					'group_by_label' => $sGroupByLabel,
				);
				$sHtmlTitle = ''; // done in the itop block
				break;

			case 'table':
			default:
				$sHtmlTitle = htmlentities(Dict::S($sTitle), ENT_QUOTES, 'UTF-8'); // done in the itop block
				$sType = 'count';
				$aExtraParams = array(
					'group_by' => $sGroupByExpr,
					'group_by_label' => $sGroupByLabel,
				);
				break;
			}
	
			$oPage->add('<div style="text-align:center" class="dashlet-content">');
			if ($sHtmlTitle != '')
			{
				$oPage->add('<h1>'.$sHtmlTitle.'</h1>');
			}
			$sBlockId = 'block_'.$this->sId.($bEditMode ? '_edit' : ''); // make a unique id (edition occuring in the same DOM)
			$oBlock = new DisplayBlock($oFilter, $sType);
			$oBlock->Display($oPage, $sBlockId, $aExtraParams);
			$oPage->add('</div>');
		}
	}

	public function GetPropertiesFields(DesignerForm $oForm)
	{
		$oField = new DesignerTextField('title', 'Title', $this->aProperties['title']);
		$oForm->AddField($oField);

		$oField = new DesignerLongTextField('query', 'Query', $this->aProperties['query']);
		$oForm->AddField($oField);

		// Group by field: build the list of possible values (attribute codes + ...)
		$oSearch = DBObjectSearch::FromOQL($this->aProperties['query']);
		$sClass = $oSearch->GetClass();
		$aGroupBy = array();
		foreach(MetaModel::ListAttributeDefs($sClass) as $sAttCode => $oAttDef)
		{
			if (!$oAttDef->IsScalar()) continue; // skip link sets

			$sLabel = $oAttDef->GetLabel();
			if ($oAttDef->IsExternalKey(EXTKEY_ABSOLUTE))
			{
				$sLabel = $oAttDef->GetLabel().' (strict)';
			}

			$aGroupBy[$sAttCode] = $sLabel;

			if ($oAttDef instanceof AttributeDateTime)
			{
				$aGroupBy[$sAttCode.':hour'] = $oAttDef->GetLabel().' (hour)';
				$aGroupBy[$sAttCode.':month'] = $oAttDef->GetLabel().' (month)';
				$aGroupBy[$sAttCode.':day_of_week'] = $oAttDef->GetLabel().' (day of week)';
				$aGroupBy[$sAttCode.':day_of_month'] = $oAttDef->GetLabel().' (day of month)';
			}
		}

		$oField = new DesignerComboField('group_by', 'Group by', $this->aProperties['group_by']);
		$oField->SetAllowedValues($aGroupBy);
		$oForm->AddField($oField);

		$aStyles = array(
			'pie' => 'Pie chart',
			'bars' => 'Bar chart',
			'table' => 'Table',
		);
		
		$oField = new DesignerComboField('style', 'Style', $this->aProperties['style']);
		$oField->SetAllowedValues($aStyles);
		$oForm->AddField($oField);
	}
	
	public function Update($aValues, $aUpdatedFields)
	{
		if (in_array('query', $aUpdatedFields))
		{
			$sCurrQuery = $aValues['query'];
			$oCurrSearch = DBObjectSearch::FromOQL($sCurrQuery);
			$sCurrClass = $oCurrSearch->GetClass();

			$sPrevQuery = $this->aProperties['query'];
			$oPrevSearch = DBObjectSearch::FromOQL($sPrevQuery);
			$sPrevClass = $oPrevSearch->GetClass();

			if ($sCurrClass != $sPrevClass)
			{
				$this->bFormRedrawNeeded = true;
				// wrong but not necessary - unset($aUpdatedFields['group_by']);
				$this->aProperties['group_by'] = '';
			}
		}
		$oDashlet = parent::Update($aValues, $aUpdatedFields);
		
		if (in_array('style', $aUpdatedFields))
		{
			switch($aValues['style'])
			{
				// Style changed, mutate to the specified type of chart
				case 'pie':
				$oDashlet = new DashletGroupByPie($this->sId);
				break;
					
				case 'bars':
				$oDashlet = new DashletGroupByBars($this->sId);
				break;
					
				case 'table':
				$oDashlet = new DashletGroupByTable($this->sId);
				break;
			}
			$oDashlet->FromParams($aValues);
			$oDashlet->bRedrawNeeded = true;
			$oDashlet->bFormRedrawNeeded = true;
		}
		return $oDashlet;
	}

	static public function GetInfo()
	{
		return array(
			'label' => 'Objects grouped by...',
			'icon' => 'images/dashlet-object-grouped.png',
			'description' => 'Grouped objects dashlet',
		);
	}
	
	static public function CanCreateFromOQL()
	{
		return true;
	}
	
	public function GetPropertiesFieldsFromOQL(DesignerForm $oForm, $sOQL)
	{
		$oField = new DesignerTextField('title', 'Title', '');
		$oForm->AddField($oField);

		$oField = new DesignerHiddenField('query', 'Query', $sOQL);
		$oForm->AddField($oField);

		// Group by field: build the list of possible values (attribute codes + ...)
		$oSearch = DBObjectSearch::FromOQL($this->aProperties['query']);
		$sClass = $oSearch->GetClass();
		$aGroupBy = array();
		foreach(MetaModel::ListAttributeDefs($sClass) as $sAttCode => $oAttDef)
		{
			if (!$oAttDef->IsScalar()) continue; // skip link sets
			if ($oAttDef->IsExternalKey(EXTKEY_ABSOLUTE)) continue; // skip external keys
			$aGroupBy[$sAttCode] = $oAttDef->GetLabel();

			if ($oAttDef instanceof AttributeDateTime)
			{
				//date_format(start_date, '%d')
				$aGroupBy['date_of_'.$sAttCode] = 'Day of '.$oAttDef->GetLabel();
			}

		}

		$oField = new DesignerComboField('group_by', 'Group by', $this->aProperties['group_by']);
		$oField->SetAllowedValues($aGroupBy);
		$oForm->AddField($oField);

		$oField = new DesignerHiddenField('style', '', $this->aProperties['style']);
		$oForm->AddField($oField);
	}
}

class DashletGroupByPie extends DashletGroupBy
{
	public function __construct($sId)
	{
		parent::__construct($sId);
		$this->aProperties['style'] = 'pie';
	}
	
	static public function GetInfo()
	{
		return array(
			'label' => 'Pie Chart',
			'icon' => 'images/dashlet-pie-chart.png',
			'description' => 'Pie Chart',
		);
	}
}
class DashletGroupByPie2 extends DashletGroupByPie
{
	public function Render($oPage, $bEditMode = false, $aExtraParams = array())
	{
		$sTitle = addslashes($this->aProperties['title']);
		
		$sQuery = $this->aProperties['query'];
		$sGroupBy = $this->aProperties['group_by'];

		$oSearch = DBObjectSearch::FromOQL($sQuery);
		$sClassAlias = $oSearch->GetClassAlias();
		$aQueryParams = array();
		
		$aGroupBy = array();
		$oGroupByExp = Expression::FromOQL($sClassAlias.'.'.$sGroupBy);
		$aGroupBy['grouped_by_1'] = $oGroupByExp;
		$sSql = MetaModel::MakeGroupByQuery($oSearch, $aQueryParams, $aGroupBy);
		$aRes = CMDBSource::QueryToArray($sSql);

		$aGroupBy = array();
		$aLabels = array();
		$iTotalCount = 0;
		foreach ($aRes as $aRow)
		{
			$sValue = $aRow['grouped_by_1'];
			$aLabels[] = ($sValue == '') ? 'Empty (%%.%%)' : $sValue.' (%%.%%)'; //TODO: localize
			$aGroupBy[] = (int) $aRow['_itop_count_'];
			$iTotalCount += $aRow['_itop_count_'];
		}

		$aURLs = array();
		$sContext = ''; //TODO get the context ??
		foreach($aGroupBy as $sValue => $iValue)
		{
			// Build the search for this subset
			$oSubsetSearch = clone $oSearch;
			$oCondition = new BinaryExpression($oGroupByExp, '=', new ScalarExpression($sValue));
			$oSubsetSearch->AddConditionExpression($oCondition);
			$aURLs[] = 'http://www.combodo.com/itop'; //utils::GetAbsoluteUrlAppRoot()."pages/UI.php?operation=search&format=html{$sContext}&filter=".addslashes($oSubsetSearch->serialize());
		}

		$sJSValues = json_encode($aGroupBy);
		$sJSHrefs = json_encode($aURLs);
		$sJSLabels = json_encode($aLabels);
		
		$sId = 'chart_'.($bEditMode? 'edit_' : '').$this->sId;
		$oPage->add('<div id="chart_'.$sId.'" class="dashlet-content"></div>');
		$oPage->add_ready_script("$('#chart_{$sId}').pie_chart({chart_label: '$sTitle', values: $sJSValues, labels: $sJSLabels, hrefs: $sJSHrefs });");
	}

	static public function GetInfo()
	{
		return array(
			'label' => 'Pie (Raphael)',
			'icon' => 'images/dashlet-pie-chart.png',
			'description' => 'Pure JS Pie Chart',
		);
	}
}


class DashletGroupByBars extends DashletGroupBy
{
	public function __construct($sId)
	{
		parent::__construct($sId);
		$this->aProperties['style'] = 'bars';
	}
	
	static public function GetInfo()
	{
		return array(
			'label' => 'Bar Chart',
			'icon' => 'images/dashlet-bar-chart.png',
			'description' => 'Bar Chart',
		);
	}
}

class DashletGroupByTable extends DashletGroupBy
{
	public function __construct($sId)
	{
		parent::__construct($sId);
		$this->aProperties['style'] = 'table';
	}
	
	static public function GetInfo()
	{
		return array(
			'label' => 'Group By (table)',
			'icon' => 'images/dashlet-groupby-table.png',
			'description' => 'List (Grouped by a field)',
		);
	}
}


class DashletHeaderStatic extends Dashlet
{
	public function __construct($sId)
	{
		parent::__construct($sId);
		$this->aProperties['title'] = 'Contacts';
		$this->aProperties['icon'] = 'itop-config-mgmt-1.0.0/images/contact.png';
	}
	
	public function Render($oPage, $bEditMode = false, $aExtraParams = array())
	{
		$sTitle = $this->aProperties['title'];
		$sIcon = $this->aProperties['icon'];

		$sTitleReady = str_replace(':', '_', $sTitle);
		$sIconPath = utils::GetAbsoluteUrlModulesRoot().$sIcon;

		$oPage->add('<div class="dashlet-content">');
		$oPage->add('<div class="main_header">');

		$oPage->add('<img src="'.$sIconPath.'">');
		$oPage->add('<h1>'.Dict::S($sTitleReady).'</h1>');

		$oPage->add('</div>');
		$oPage->add('</div>');
	}

	public function GetPropertiesFields(DesignerForm $oForm)
	{
		$oField = new DesignerTextField('title', 'Title', $this->aProperties['title']);
		$oForm->AddField($oField);

		$oField = new DesignerTextField('icon', 'Icon', $this->aProperties['icon']);
		$oForm->AddField($oField);
	}
	
	static public function GetInfo()
	{
		return array(
			'label' => 'Header',
			'icon' => 'images/dashlet-header.png',
			'description' => 'Header with stats (grouped by...)',
		);
	}
}


class DashletHeaderDynamic extends Dashlet
{
	public function __construct($sId)
	{
		parent::__construct($sId);
		$this->aProperties['title'] = 'Contacts';
		$this->aProperties['icon'] = 'itop-config-mgmt-1.0.0/images/contact.png';
		$this->aProperties['subtitle'] = 'Contacts';
		$this->aProperties['query'] = 'SELECT Contact';
		$this->aProperties['group_by'] = 'status';
		$this->aProperties['values'] = 'active,inactive,terminated';
	}
	
	public function Render($oPage, $bEditMode = false, $aExtraParams = array())
	{
		$sTitle = $this->aProperties['title'];
		$sIcon = $this->aProperties['icon'];
		$sSubtitle = $this->aProperties['subtitle'];
		$sQuery = $this->aProperties['query'];
		$sGroupBy = $this->aProperties['group_by'];
		$sValues = $this->aProperties['values'];

		$oFilter = DBObjectSearch::FromOQL($sQuery);
		$sClass = $oFilter->GetClass();

		$sTitleReady = str_replace(':', '_', $sTitle);
		$sSubtitleReady = str_replace(':', '_', $sSubtitle);
		$sIconPath = utils::GetAbsoluteUrlModulesRoot().$sIcon;

		$aValues = null;
		if (MetaModel::IsValidAttCode($sClass, $sGroupBy))
		{
			if ($sValues == '')
			{
				$aAllowed = MetaModel::GetAllowedValues_att($sClass, $sGroupBy);
				if (is_array($aAllowed))
				{
					$aValues = array_keys($aAllowed);
				}
			}
			else
			{
				$aValues = explode(',', $sValues);
			}
		}

		if (is_array($aValues))
		{
			// Stats grouped by <group_by>
			$aCSV = implode(',', $aValues);
			$aExtraParams = array(
				'title[block]' => $sTitleReady,
				'label[block]' => $sSubtitleReady,
				'status[block]' => $sGroupBy,
				'status_codes[block]' => $aCSV,
				'context_filter' => 1,
			);
		}
		else
		{
			// Simple stats
			$aExtraParams = array(
				'title[block]' => $sTitleReady,
				'label[block]' => $sSubtitleReady,
				'context_filter' => 1,
			);
		}

		$oPage->add('<div class="dashlet-content">');
		$oPage->add('<div class="main_header">');

		$oPage->add('<img src="'.$sIconPath.'">');

		$oBlock = new DisplayBlock($oFilter, 'summary');
		$sBlockId = 'block_'.$this->sId.($bEditMode ? '_edit' : ''); // make a unique id (edition occuring in the same DOM)
		$oBlock->Display($oPage, $sBlockId, $aExtraParams);

		$oPage->add('</div>');
		$oPage->add('</div>');
	}

	public function GetPropertiesFields(DesignerForm $oForm)
	{
		$oField = new DesignerTextField('title', 'Title', $this->aProperties['title']);
		$oForm->AddField($oField);

		$oField = new DesignerTextField('icon', 'Icon', $this->aProperties['icon']);
		$oForm->AddField($oField);

		$oField = new DesignerTextField('subtitle', 'Subtitle', $this->aProperties['subtitle']);
		$oForm->AddField($oField);

		$oField = new DesignerTextField('query', 'Query', $this->aProperties['query']);
		$oForm->AddField($oField);

		// Group by field: build the list of possible values (attribute codes + ...)
		$oSearch = DBObjectSearch::FromOQL($this->aProperties['query']);
		$sClass = $oSearch->GetClass();
		$aGroupBy = array();
		foreach(MetaModel::ListAttributeDefs($sClass) as $sAttCode => $oAttDef)
		{
			if (!$oAttDef->IsScalar()) continue; // skip link sets

			$sLabel = $oAttDef->GetLabel();
			if ($oAttDef->IsExternalKey(EXTKEY_ABSOLUTE))
			{
				$sLabel = $oAttDef->GetLabel().' (strict)';
			}

			$aGroupBy[$sAttCode] = $sLabel;
		}
		$oField = new DesignerComboField('group_by', 'Group by', $this->aProperties['group_by']);
		$oField->SetAllowedValues($aGroupBy);
		$oForm->AddField($oField);

		$oField = new DesignerTextField('values', 'Values (CSV list)', $this->aProperties['values']);
		$oForm->AddField($oField);
	}
	
	static public function GetInfo()
	{
		return array(
			'label' => 'Header with statistics',
			'icon' => 'images/dashlet-header-stats.png',
			'description' => 'Header with stats (grouped by...)',
		);
	}
}


class DashletBadge extends Dashlet
{
	public function __construct($sId)
	{
		parent::__construct($sId);
		$this->aProperties['class'] = 'Contact';
		$this->aCSSClasses[] = 'dashlet-inline';
		$this->aCSSClasses[] = 'dashlet-badge';
	}
	
	public function Render($oPage, $bEditMode = false, $aExtraParams = array())
	{
		$sClass = $this->aProperties['class'];

		$oPage->add('<div class="dashlet-content">');

		$oFilter = new DBObjectSearch($sClass);
		$oBlock = new DisplayBlock($oFilter, 'actions');
		$aExtraParams = array(
			'context_filter' => 1,
		);
		$sBlockId = 'block_'.$this->sId.($bEditMode ? '_edit' : ''); // make a unique id (edition occuring in the same DOM)
		$oBlock->Display($oPage, $sBlockId, $aExtraParams);

		$oPage->add('</div>');
	}

	public function GetPropertiesFields(DesignerForm $oForm)
	{
		$oField = new DesignerTextField('class', 'Class', $this->aProperties['class']);
		$oForm->AddField($oField);
	}
	
	static public function GetInfo()
	{
		return array(
			'label' => 'Badge',
			'icon' => 'images/dashlet-badge.png',
			'description' => 'Object Icon with new/search',
		);
	}
}


class DashletProto extends Dashlet
{
	public function __construct($sId)
	{
		parent::__construct($sId);
		$this->aProperties['class'] = 'Foo';
	}
	
	public function Render($oPage, $bEditMode = false, $aExtraParams = array())
	{
		$sClass = $this->aProperties['class'];

		$oFilter = DBObjectSearch::FromOQL('SELECT FunctionalCI AS fci');
		$sGroupBy1 = 'status';
		//$sGroupBy2 = 'org_id_friendlyname';
		$sGroupBy2 = 'org_id';
		$sHtmlTitle = "Hardcoded on $sGroupBy1 and $sGroupBy2...";

		$sAlias = $oFilter->GetClassAlias();

		$oGroupByExp1 = new FieldExpression($sGroupBy1, $sAlias);
		$sGroupByLabel1 = MetaModel::GetLabel($oFilter->GetClass(), $sGroupBy1);
		
		$oGroupByExp2 = new FieldExpression($sGroupBy2, $sAlias);
		$sGroupByLabel2 = MetaModel::GetLabel($oFilter->GetClass(), $sGroupBy2);
		
		$aGroupBy = array();
		$aGroupBy['grouped_by_1'] = $oGroupByExp1;
		$aGroupBy['grouped_by_2'] = $oGroupByExp2;
		$sSql = MetaModel::MakeGroupByQuery($oFilter, array(), $aGroupBy);
		$aRes = CMDBSource::QueryToArray($sSql);
		
		$iTotalCount = 0;
		$aData = array();
		$oAppContext = new ApplicationContext();
		$sParams = $oAppContext->GetForLink();
		foreach ($aRes as $aRow)
		{
			$iCount = $aRow['_itop_count_'];
			$iTotalCount += $iCount;

			$sValue1 = $aRow['grouped_by_1'];
			$sValue2 = $aRow['grouped_by_2'];

			$sDisplayValue1 = $aGroupBy['grouped_by_1']->MakeValueLabel($oFilter, $sValue1, $sValue1); // default to the raw value
			$sDisplayValue2 = $aGroupBy['grouped_by_2']->MakeValueLabel($oFilter, $sValue2, $sValue2); // default to the raw value

			// Build the search for this subset
			$oSubsetSearch = clone $oFilter;
			$oCondition = new BinaryExpression($oGroupByExp1, '=', new ScalarExpression($sValue1));
			$oSubsetSearch->AddConditionExpression($oCondition);
			$oCondition = new BinaryExpression($oGroupByExp2, '=', new ScalarExpression($sValue2));
			$oSubsetSearch->AddConditionExpression($oCondition);
		
			$sFilter = urlencode($oSubsetSearch->serialize());
			$aData[] = array (
				'group1' => $sDisplayValue1,
				'group2' => $sDisplayValue2,
				'value' => "<a href=\"".utils::GetAbsoluteUrlAppRoot()."pages/UI.php?operation=search&dosearch=1&$sParams&filter=$sFilter\">$iCount</a>"
			); // TO DO: add the context information
		}
		$aAttribs =array(
			'group1' => array('label' => $sGroupByLabel1, 'description' => ''),
			'group2' => array('label' => $sGroupByLabel2, 'description' => ''),
			'value' => array('label'=> Dict::S('UI:GroupBy:Count'), 'description' => Dict::S('UI:GroupBy:Count+'))
		);


		$oPage->add('<div style="text-align:center" class="dashlet-content">');

		$oPage->add('<h1>'.$sHtmlTitle.'</h1>');
		$oPage->p(Dict::Format('UI:Pagination:HeaderNoSelection', $iTotalCount));
		$oPage->table($aAttribs, $aData);

		$oPage->add('</div>');
	}

	public function GetPropertiesFields(DesignerForm $oForm)
	{
		$oField = new DesignerTextField('class', 'Class', $this->aProperties['class']);
		$oForm->AddField($oField);
	}
	
	static public function GetInfo()
	{
		return array(
			'label' => 'Test3D',
			'icon' => 'images/dashlet-groupby2-table.png',
			'description' => 'Group by on two dimensions',
		);
	}
}

class DashletHeatMap extends Dashlet
{
	public function __construct($sId)
	{
		parent::__construct($sId);
		$this->aProperties['class'] = 'Contact';
		$this->aProperties['title'] = 'Test';
	}
	
	public function Render($oPage, $bEditMode = false, $aExtraParams = array())
	{
		$sTitle = addslashes($this->aProperties['title']);
	
		$sId = 'chart_'.($bEditMode? 'edit_' : '').$this->sId;
		$oPage->add('<div id="chart_'.$sId.'" class="dashlet-content"></div>');
		$oPage->add_ready_script("$('#chart_{$sId}').heatmap_chart({chart_label: '$sTitle'});");
	}
	
	public function GetPropertiesFields(DesignerForm $oForm)
	{
		$oField = new DesignerTextField('title', 'Title', $this->aProperties['title']);
		$oForm->AddField($oField);
		
		$oField = new DesignerTextField('class', 'Class', $this->aProperties['class']);
		$oForm->AddField($oField);
	}
	
	static public function GetInfo()
	{
		return array(
			'label' => 'Heatmap (Raphael)',
			'icon' => 'images/dashlet-heatmap.png',
			'description' => 'Pure JS Heat Map Chart',
		);
	}
}
