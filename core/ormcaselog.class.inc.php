<?php
// Copyright (C) 2011 Combodo SARL
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

define('CASELOG_DATE_FORMAT', 'Y-m-d H:i:s');
define('CASELOG_HEADER_FORMAT', 'On %1$s, %2$s wrote:');
define('CASELOG_VISIBLE_ITEMS', 2);
define('CASELOG_SEPARATOR', "\n".'========== %1$s : %2$s (%3$d) ============'."\n\n");

//require_once(APPROOT.'/core/userrights.class.inc.php');
//require_once(APPROOT.'/application/webpage.class.inc.php');

/**
 * Class to store a "case log" in a structured way, keeping track of its successive entries
 */
class ormCaseLog {
	protected $m_sLog;
	protected $m_aIndex;
	
	/**
	 * Initializes the log with the first (initial) entry
	 * @param $sLog string The text of the whole case log
	 * @param $aIndex hash The case log index
	 */
	public function __construct($sLog = '', $aIndex = array())
	{
		$this->m_sLog = $sLog;
		$this->m_aIndex = $aIndex;
	}
	
	public function GetText()
	{
		return $this->m_sLog;
	}
	
	public function GetIndex()
	{
		return $this->m_aIndex;
	}

	public function __toString()
	{
		return $this->m_sLog;
	}
	
	public function GetAsHTML(WebPage $oP = null, $bEditMode = false, $aTransfoHandler = null)
	{
		$sHtml = '';
		$iPos = 0;
		for($index=count($this->m_aIndex)-1 ; $index >= 0 ; $index--)
		{
			if ($index < count($this->m_aIndex) - CASELOG_VISIBLE_ITEMS)
			{
				$sOpen = '';
				$sDisplay = 'style="display:none;"';
			}
			else
			{
				$sOpen = ' open';
				$sDisplay = '';
			}
			$iPos += $this->m_aIndex[$index]['separator_length'];
			$sTextEntry = substr($this->m_sLog, $iPos, $this->m_aIndex[$index]['text_length']);
			$sTextEntry = str_replace("\n", "<br/>", htmlentities($sTextEntry, ENT_QUOTES, 'UTF-8'));
			if (!is_null($aTransfoHandler))
			{
				$sTextEntry = call_user_func($aTransfoHandler, $sTextEntry);
			}
			$iPos += $this->m_aIndex[$index]['text_length'];

			$sEntry = '<div class="caselog_header'.$sOpen.'">';
			$sEntry .= sprintf(CASELOG_HEADER_FORMAT, $this->m_aIndex[$index]['date']->format(CASELOG_DATE_FORMAT), $this->m_aIndex[$index]['user_name']);
			$sEntry .= '</div>';
			$sEntry .= '<div class="caselog_entry"'.$sDisplay.'>';
			$sEntry .= $sTextEntry;
			$sEntry .= '</div>';
			$sHtml = $sHtml.$sEntry;
		}

		// Process the case of an eventual remainder (quick migration of AttributeText fields)
		if ($iPos < (strlen($this->m_sLog) - 1))
		{
			$sTextEntry = substr($this->m_sLog, $iPos);
			$sTextEntry = str_replace("\n", "<br/>", htmlentities($sTextEntry, ENT_QUOTES, 'UTF-8'));
			if (!is_null($aTransfoHandler))
			{
				$sTextEntry = call_user_func($aTransfoHandler, $sTextEntry);
			}

			if (count($this->m_aIndex) == 0)
			{
				$sHtml .= "<div>$sTextEntry</div>\n";
			}
			else
			{
				if (count($this->m_aIndex) - CASELOG_VISIBLE_ITEMS > 0)
				{
					$sOpen = '';
					$sDisplay = 'style="display:none;"';
				}
				else
				{
					$sOpen = ' open';
					$sDisplay = '';
				}
				$sHtml .= '<div class="caselog_header'.$sOpen.'">';
				$sHtml .= '&nbsp;';
				$sHtml .= '</div>';
				$sHtml .= '<div class="caselog_entry"'.$sDisplay.'>';
				$sHtml .= $sTextEntry;
				$sHtml .= '</div>';
			}
		}
		$sHtml = '<div class="caselog">'.$sHtml.'</div>';
		return $sHtml;
	}
	
	/**
	 * Add a new entry to the log and updates the internal index
	 * @param $sText string The text of the new entry 
	 */
	public function AddLogEntry($sText)
	{
		$sDate = date(CASELOG_DATE_FORMAT);
		$sSeparator = sprintf(CASELOG_SEPARATOR, $sDate, UserRights::GetUserFriendlyName(), UserRights::GetUserId());
		$iSepLength = strlen($sSeparator);
		$iTextlength = strlen($sText);
		$this->m_sLog = $sSeparator.$sText.$this->m_sLog; // Latest entry printed first
		$this->m_aIndex[] = array(
			'user_name' => UserRights::GetUserFriendlyName(),	
			'user_id' => UserRights::GetUserId(),	
			'date' => new DateTime(),	
			'text_length' => $iTextlength,	
			'separator_length' => $iSepLength,	
		);
	}

	/**
	 * Get the latest entry from the log
	 */
	public function GetLatestEntry()
	{
		$iLast = count($this->m_aIndex) - 1;
		$aLastEntry = $this->m_aIndex[$iLast];
		$sRes = substr($this->m_sLog, $aLastEntry['separator_length'], $aLastEntry['text_length']);
		return $sRes;
	}
}
?>