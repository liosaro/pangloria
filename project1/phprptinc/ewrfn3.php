<?php

// Functions for PHP Report Maker 3
// (C) 2007-2009 e.World Technology Limited
// Last url
function LastUrl() {
	return @$_COOKIE[EW_REPORT_PROJECT_NAME]['LastUrl'];
}

// Save last url
function SaveLastUrl() {
	$s = ewrpt_ServerVar("SCRIPT_NAME");
	$q = ewrpt_ServerVar("QUERY_STRING");
	if ($q <> "") $s .= "?" . $q;
	if (@$_COOKIE[EW_REPORT_PROJECT_NAME]['LastUrl'] == $s) $s = "";
	setcookie(EW_REPORT_PROJECT_NAME . '[LastUrl]', $s);
}

// Auto login
function AutoLogin() {
	if (@$_COOKIE[EW_REPORT_PROJECT_NAME]['AutoLogin'] == "autologin") {
		$usr = ewrpt_StripSlashes(@$_COOKIE[EW_REPORT_PROJECT_NAME]['UserName']);
		$pwd = TEAdecrypt(@$_COOKIE[EW_REPORT_PROJECT_NAME]['Password'], EW_REPORT_RANDOM_KEY);
		$AutoLogin = ValidateUser($usr, $pwd);
	} else {
		$AutoLogin = FALSE;
	}
	return $AutoLogin;
}

// Function to validate user
function ValidateUser($Username, $Password) {
	global $conn;
	$ValidateUser = FALSE;
	return $ValidateUser;
}

// Advanced User Level Security for PHP Report Maker 3.0
$arUserLevel = array();
$arUserLevelPriv = array();

// Define User Level Variables
$ewCurLvl = CurrentUserLevel();
$ewCurSec = NULL;

// No user level security
function SetUpUserLevel() {

	// User Level not used
}

// Get current user privilege
function CurrentUserLevelPriv($TableName) {
	return GetUserLevelPrivEx($TableName, CurrentUserLevel());
}

// Get user privilege based on table name and user level
function GetUserLevelPrivEx($TableName, $UserLevelID) {
	global $arUserLevelPriv;
	$userLevelPrivEx = 0;
	if (strval($UserLevelID) == "-1") {
		return 31;
	} elseif ($UserLevelID >=0) {
		if (is_array($arUserLevelPriv)) {
			foreach ($arUserLevelPriv as $row) {
				list($table, $levelid, $priv) = $row;
				if (strtolower($table) == strtolower(EW_REPORT_TABLE_PREFIX . $TableName) && strval($levelid) == strval($UserLevelID)) {
					if (is_null($priv) || !is_numeric($priv)) return 0;
					return intval($priv);
				}
			}
		}
	}
}

// Get current user level name
function CurrentUserLevelName() {
	return GetUserLevelName(CurrentUserLevel());
}

// Get user level name based on user level
function GetUserLevelName($UserLevelID) {
	global $arUserLevel;
	if (strval($UserLevelID) == "-1") {
		return "Administrator";
	} elseif ($UserLevelID >= 0) {
		if (is_array($arUserLevel)) {
			foreach ($arUserLevel as $row) {
				list($levelid, $name) = $row;
				if (strval($levelid) == strval($UserLevelID))
					return $name;
			}
		}
	}
}

// Show user levels
function ShowUserLevelInfo() {
	global $arUserLevel;
	global $arUserLevelPriv;
	echo "<pre class=\"phpreportmaker\">";
	print_r($arUserLevel);
	print_r($arUserLevelPriv);
	echo "</pre>";
	echo "<p>CurrentUserLevel = " . CurrentUserLevel() . "</p>";
}

// Function to check privilege for List page (for menu items)
function AllowList($TableName) {
	return (CurrentUserLevelPriv($TableName) & EW_ALLOW_LIST);
}

// Get current user name from session
function CurrentUserName() {
	return @$_SESSION[EW_REPORT_SESSION_USERNAME];
}

// Get current user id from session
function CurrentUserID() {
	return strval(@$_SESSION[EW_REPORT_SESSION_USERID]);
}

// Get current parent user id from session
function CurrentParentUserID() {
	return @$_SESSION[EW_REPORT_SESSION_PARENT_USERID];
}

// Get current user level from session
function CurrentUserLevel() {
	return @$_SESSION[EW_REPORT_SESSION_USERLEVEL];
}

// Check if user is logged in
function IsLoggedIn() {
	return (@$_SESSION[EW_REPORT_SESSION_STATUS] == "login");
}

// Check if user is system administrator
function IsSysAdmin() {
	return (@$_SESSION[EW_REPORT_SESSION_SYSTEM_ADMIN] == 1);
}

// Load user level from session
function LoadUserLevel() {
	SetupUserLevel();
}

// Functions to init arrays
function ewrpt_InitArray($iLen, $vValue) {
	if (function_exists('array_fill')) {
		return array_fill(0, $iLen, $vValue);
	} else {
		$aResult = array();
		for ($iCount = 0; $iCount < $iLen; $iCount++)
			$aResult[] = $vValue;
		return $aResult;
	}
}

function ewrpt_Init2DArray($iLen1, $iLen2, $vValue) {
	return ewrpt_InitArray($iLen1, ewrpt_InitArray($iLen2, $vValue));
}

// Functions to convert encoding
function ewrpt_ConvertToUtf8($str) {
	return ewrpt_Convert(EW_REPORT_ENCODING, "UTF-8", $str);
}

function ewrpt_ConvertFromUtf8($str) {
	return ewrpt_Convert("UTF-8", EW_REPORT_ENCODING, $str);
}

function ewrpt_Convert($from, $to, $str) {
	if ($from != "" && $to != "" && $from != $to) {
		if (function_exists("iconv")) {
			return iconv($from, $to, $str);
		} elseif (function_exists("mb_convert_encoding")) {
			return mb_convert_encoding($str, $to, $from);
		} else {
			return $str;
		}
	} else {
	return $str;
	}
}

// Check if valid operator
function ewrpt_IsValidOpr($Opr, $FldType) {
	$valid = ($Opr == "=" || $Opr == "<" || $Opr == "<=" ||
		$Opr == ">" || $Opr == ">=" || $Opr == "<>");
	if ($FldType == EW_REPORT_DATATYPE_STRING)
		$valid = ($valid || $Opr == "LIKE" || $Opr == "NOT LIKE" || $Opr == "STARTS WITH");
	return $valid;
}

// quote field values
function ewrpt_QuotedValue($Value, $FldType) {
	if (is_null($Value))
		return "NULL";
	switch ($FldType) {
	case EW_REPORT_DATATYPE_STRING:
	case EW_REPORT_DATATYPE_BLOB:
	case EW_REPORT_DATATYPE_MEMO:
	case EW_REPORT_DATATYPE_TIME:
			return "'" . ewrpt_AdjustSql($Value) . "'";
	case EW_REPORT_DATATYPE_DATE:
		return (EW_REPORT_IS_MSACCESS) ? "#" . ewrpt_AdjustSql($Value) . "#" :
			"'" . ewrpt_AdjustSql($Value) . "'";

//	case EW_REPORT_DATATYPE_GUID:
//		if (EW_REPORT_IS_MSACCESS) {
//			if (strlen($Value) == 38) {
//				return "{guid " . $Value . "}";
//			} elseif (strlen($Value) == 36) {
//				return "{guid {" . $Value . "}}";
//			}
//		} else {
//		  return "'" . $Value . "'";
//		}

	case EW_REPORT_DATATYPE_BOOLEAN: // enum('Y'/'N') or enum('1'/'0')
		return "'" . $Value . "'";
	default:
		return $Value;
	}
}

// Get distinct values
function ewrpt_GetDistinctValues($FldOpr, $sql) {
	global $conn;
	$ar = array();
	if (strval($sql) == "")
		return;
	$wrkrs = $conn->Execute($sql);
	if ($wrkrs && !$wrkrs->EOF) {
		$ar[] = ewrpt_ConvertValue($FldOpr, $wrkrs->fields[0]);
		$wrkrs->MoveNext();
		while (!$wrkrs->EOF) {
			$wrkval = ewrpt_ConvertValue($FldOpr, $wrkrs->fields[0]);
			$cntar = count($ar);
			if ($wrkval <> $ar[$cntar-1])
				$ar[] = $wrkval;
			$wrkrs->MoveNext();
		}
		$wrkrs->Close();
	}
	return $ar;
}

// Convert value
function ewrpt_ConvertValue($FldOpr, $val) {
	if (is_null($val)) {
		return EW_REPORT_NULL_VALUE;
	} elseif ($val == "") {
		return EW_REPORT_EMPTY_VALUE;
	}
	if (is_float($val))
		$val = (float)$val;
	if ($FldOpr == "")
		return $val;
	if ($ar = explode(" ", $val)) {
		$ar = explode("-", $ar[0]);
	} else {
		return $val;
	}
	if (!$ar || count($ar) <> 3)
		return $val;
	list($year, $month, $day) = $ar;
	switch (strtolower($FldOpr)) {
	case "year":
		return $year;
	case "quarter":
		return "$year|" . ceil(intval($month)/3);
	case "month":
		return "$year|$month";
	case "day":
		return "$year|$month|$day";
	case "date":
		return "$year-$month-$day";
	}
}

// Dropdown display values
function ewrpt_DropDownDisplayValue($v, $t, $fmt) {
	if ($v == EW_REPORT_NULL_VALUE) {
		return EW_REPORT_NULL_LABEL;
	} elseif ($v == EW_REPORT_EMPTY_VALUE) {
		return EW_REPORT_EMPTY_LABEL;
	}
	if ($t == "")
		return $v;
	$ar = explode("|", strval($v));
	switch (strtolower($t)) {
	case "year":
		return $v;
	case "quarter":
		if (count($ar) >= 2)
			return ewrpt_QuarterName($ar[1]) . " " . $ar[0];
	case "month":
		if (count($ar) >= 2)
			return ewrpt_MonthName($ar[1]) . " " . $ar[0];
	case "day":
		if (count($ar) >= 3)
			return ewrpt_FormatDateTime($ar[0] . "-" . $ar[1] . "-" . $ar[2], $fmt);
	case "date":
		return ewrpt_FormatDateTime($v, $fmt);
	}
}

// Quarter name
function ewrpt_QuarterName($q) {
	switch ($q) {
	case 1:
		return EW_REPORT_QUARTER_1;
	case 2:
		return EW_REPORT_QUARTER_2;
	case 3:
		return EW_REPORT_QUARTER_3;
	case 4:
		return EW_REPORT_QUARTER_4;
	default:
		return $q;
	}
}

// Month name
function ewrpt_MonthName($m) {
	switch ($m) {
	case 1:
		return EW_REPORT_MONTH_JAN;
	case 2:
		return EW_REPORT_MONTH_FEB;
	case 3:
		return EW_REPORT_MONTH_MAR;
	case 4:
		return EW_REPORT_MONTH_APR;
	case 5:
		return EW_REPORT_MONTH_MAY;
	case 6:
		return EW_REPORT_MONTH_JUN;
	case 7:
		return EW_REPORT_MONTH_JUL;
	case 8:
		return EW_REPORT_MONTH_AUG;
	case 9:
		return EW_REPORT_MONTH_SEP;
	case 10:
		return EW_REPORT_MONTH_OCT;
	case 11:
		return EW_REPORT_MONTH_NOV;
	case 12:
		return EW_REPORT_MONTH_DEC;
	default:
		return $m;
	}
}

// Join array
function ewrpt_JoinArray($ar, $sep, $ft, $pos=0) {
	if (!is_array($ar))
		return "";
	$arwrk = array_slice($ar, $pos); // return array from position pos
	$cntar = count($arwrk);
	for ($i = 0; $i < $cntar; $i++)
		$arwrk[$i] = ewrpt_QuotedValue($arwrk[$i], $ft);
	return implode($sep, $arwrk);
}

// Unformat date time based on format type
function ewrpt_UnFormatDateTime($dt, $namedformat) {
	$dt = trim($dt);
	while (strpos($dt, "  ") !== FALSE) $dt = str_replace("  ", " ", $dt);
	$arDateTime = explode(" ", $dt);
	if (count($arDateTime) == 0) return $dt;
	$arDatePt = explode(EW_REPORT_DATE_SEPARATOR, $arDateTime[0]);
	if ($namedformat == 0 || $namedformat == 1 || $namedformat == 2 || $namedformat == 8) {
		$arDefFmt = explode(EW_REPORT_DATE_SEPARATOR, EW_REPORT_DEFAULT_DATE_FORMAT);
		if ($arDefFmt[0] == "yyyy") {
			$namedformat = 9;
		} elseif ($arDefFmt[0] == "mm") {
			$namedformat = 10;
		} elseif ($arDefFmt[0] == "dd") {
			$namedformat = 11;
		}
	}
	if (count($arDatePt) == 3) {
		switch ($namedformat) {
		case 5:
		case 9: //yyyymmdd
			list($year, $month, $day) = $arDatePt;
			break;
		case 6:
		case 10: //mmddyyyy
			list($month, $day, $year) = $arDatePt;
			break;
		case 7:
		case 11: //ddmmyyyy
			list($day, $month, $year) = $arDatePt;
			break;
		default:
			return $dt;
		}
		if (strlen($year) <= 4 && strlen($month) <= 2 && strlen($day) <= 2) {
			return $year . "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-" .
				 str_pad($day, 2, "0", STR_PAD_LEFT) .
				((count($arDateTime) > 1) ? " " . $arDateTime[1] : "");
		} else {
			return $dt;
		}
	} else {
		return $dt;
	}
}

// ViewValue
// - return &nbsp; if empty
function ewrpt_ViewValue($value) {
	if ($value <> "")
		return $value;
	else
		return "&nbsp;";
}

// FormatDateTime
// Format a timestamp, datetime, date or time field from MySQL
// $namedformat:
// 0 - General Date,
// 1 - Long Date,
// 2 - Short Date (Default),
// 3 - Long Time,
// 4 - Short Time,
// 5 - Short Date (yyyy/mm/dd),
// 6 - Short Date (mm/dd/yyyy),
// 7 - Short Date (dd/mm/yyyy)
function ewrpt_FormatDateTime($ts, $namedformat) {
	$DefDateFormat = str_replace("yyyy", "%Y", EW_REPORT_DEFAULT_DATE_FORMAT);
	$DefDateFormat = str_replace("mm", "%m", $DefDateFormat);
	$DefDateFormat = str_replace("dd", "%d", $DefDateFormat);
	if (is_numeric($ts)) // timestamp
	{
		switch (strlen($ts)) {
			case 14:
				$patt = '/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
				break;
			case 12:
				$patt = '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
				break;
			case 10:
				$patt = '/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/';
				break;
			case 8:
				$patt = '/(\d{4})(\d{2})(\d{2})/';
				break;
			case 6:
				$patt = '/(\d{2})(\d{2})(\d{2})/';
				break;
			case 4:
				$patt = '/(\d{2})(\d{2})/';
				break;
			case 2:
				$patt = '/(\d{2})/';
				break;
			default:
				return $ts;
		}
		if ((isset($patt))&&(preg_match($patt, $ts, $matches)))
		{
			$year = $matches[1];
			$month = @$matches[2];
			$day = @$matches[3];
			$hour = @$matches[4];
			$min = @$matches[5];
			$sec = @$matches[6];
		}
		if (($namedformat==0)&&(strlen($ts)<10)) $namedformat = 2;
	}
	elseif (is_string($ts))
	{
		if (preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/', $ts, $matches)) // datetime
		{
			$year = $matches[1];
			$month = $matches[2];
			$day = $matches[3];
			$hour = $matches[4];
			$min = $matches[5];
			$sec = $matches[6];
		}
		elseif (preg_match('/(\d{4})-(\d{2})-(\d{2})/', $ts, $matches)) // date
		{
			$year = $matches[1];
			$month = $matches[2];
			$day = $matches[3];
			if ($namedformat==0) $namedformat = 2;
		}
		elseif (preg_match('/(^|\s)(\d{2}):(\d{2}):(\d{2})/', $ts, $matches)) // time
		{
			$hour = $matches[2];
			$min = $matches[3];
			$sec = $matches[4];
			if (($namedformat==0)||($namedformat==1)) $namedformat = 3;
			if ($namedformat==2) $namedformat = 4;
		}
		else
		{
			return $ts;
		}
	}
	else
	{
		return $ts;
	}
	if (!isset($year)) $year = 0; // dummy value for times
	if (!isset($month)) $month = 1;
	if (!isset($day)) $day = 1;
	if (!isset($hour)) $hour = 0;
	if (!isset($min)) $min = 0;
	if (!isset($sec)) $sec = 0;
	$uts = @mktime($hour, $min, $sec, $month, $day, $year);
	if ($uts < 0 || $uts == FALSE || // failed to convert
		(intval($year) == 0 && intval($month) == 0 && intval($day) == 0)) {
		$year = substr_replace("0000", $year, -1 * strlen($year));
		$month = substr_replace("00", $month, -1 * strlen($month));
		$day = substr_replace("00", $day, -1 * strlen($day));
		$hour = substr_replace("00", $hour, -1 * strlen($hour));
		$min = substr_replace("00", $min, -1 * strlen($min));
		$sec = substr_replace("00", $sec, -1 * strlen($sec));
		$DefDateFormat = str_replace("yyyy", $year, EW_REPORT_DEFAULT_DATE_FORMAT);
		$DefDateFormat = str_replace("mm", $month, $DefDateFormat);
		$DefDateFormat = str_replace("dd", $day, $DefDateFormat);
		switch ($namedformat) {
			case 0:
				return $DefDateFormat." $hour:$min:$sec";
				break;
			case 1://unsupported, return general date
				return $DefDateFormat." $hour:$min:$sec";
				break;
			case 2:
				return $DefDateFormat;
				break;
			case 3:
				if (intval($hour)==0)
					return "12:$min:$sec AM";
				elseif (intval($hour)>0 && intval($hour)<12)
					return "$hour:$min:$sec AM";
				elseif (intval($hour)==12)
					return "$hour:$min:$sec PM";
				elseif (intval($hour)>12 && intval($hour)<=23)
					return (intval($hour)-12).":$min:$sec PM";
				else
					return "$hour:$min:$sec";
				break;
			case 4:
				return "$hour:$min:$sec";
				break;
			case 5:
				return "$year". EW_REPORT_DATE_SEPARATOR . "$month" . EW_REPORT_DATE_SEPARATOR . "$day";
				break;
			case 6:
				return "$month". EW_REPORT_DATE_SEPARATOR ."$day" . EW_REPORT_DATE_SEPARATOR . "$year";
				break;
			case 7:
				return "$day" . EW_REPORT_DATE_SEPARATOR ."$month" . EW_REPORT_DATE_SEPARATOR . "$year";
				break;
		}
	} else {
		switch ($namedformat) {
			case 0:
				return strftime($DefDateFormat." %H:%M:%S", $uts);
				break;
			case 1:
				return strftime("%A, %B %d, %Y", $uts);
				break;
			case 2:
				return strftime($DefDateFormat, $uts);
				break;
			case 3:
				return strftime("%I:%M:%S %p", $uts);
				break;
			case 4:
				return strftime("%H:%M:%S", $uts);
				break;
			case 5:
				return strftime("%Y" . EW_REPORT_DATE_SEPARATOR . "%m" . EW_REPORT_DATE_SEPARATOR . "%d", $uts);
				break;
			case 6:
				return strftime("%m" . EW_REPORT_DATE_SEPARATOR . "%d" . EW_REPORT_DATE_SEPARATOR . "%Y", $uts);
				break;
			case 7:
				return strftime("%d" . EW_REPORT_DATE_SEPARATOR . "%m" . EW_REPORT_DATE_SEPARATOR . "%Y", $uts);
				break;
		}
	}
}

// FormatCurrency
// FormatCurrency(Expression[,NumDigitsAfterDecimal [,IncludeLeadingDigit
//  [,UseParensForNegativeNumbers [,GroupDigits]]]])
// NumDigitsAfterDecimal is the numeric value indicating how many places to the
// right of the decimal are displayed
// -1 Use Default
// The IncludeLeadingDigit, UseParensForNegativeNumbers, and GroupDigits
// arguments have the following settings:
// -1 True
// 0 False
// -2 Use Default
function ewrpt_FormatCurrency($amount, $NumDigitsAfterDecimal, $IncludeLeadingDigit = -2, $UseParensForNegativeNumbers = -2, $GroupDigits = -2) {
	if (!is_numeric($amount))
		return $amount;

	// export the values returned by localeconv into the local scope
	extract(localeconv());

	// set defaults if locale is not set
	if (empty($currency_symbol)) $currency_symbol = DEFAULT_CURRENCY_SYMBOL;
	if (empty($mon_decimal_point)) $mon_decimal_point = DEFAULT_MON_DECIMAL_POINT;
	if (empty($mon_thousands_sep)) $mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	if (empty($positive_sign)) $positive_sign = DEFAULT_POSITIVE_SIGN;
	if (empty($negative_sign)) $negative_sign = DEFAULT_NEGATIVE_SIGN;
	if (empty($frac_digits) || $frac_digits == CHAR_MAX) $frac_digits = DEFAULT_FRAC_DIGITS;
	if (empty($p_cs_precedes) || $p_cs_precedes == CHAR_MAX) $p_cs_precedes = DEFAULT_P_CS_PRECEDES;
	if (empty($p_sep_by_space) || $p_sep_by_space == CHAR_MAX) $p_sep_by_space = DEFAULT_P_SEP_BY_SPACE;
	if (empty($n_cs_precedes) || $n_cs_precedes == CHAR_MAX) $n_cs_precedes = DEFAULT_N_CS_PRECEDES;
	if (empty($n_sep_by_space) || $n_sep_by_space == CHAR_MAX) $n_sep_by_space = DEFAULT_N_SEP_BY_SPACE;
	if (empty($p_sign_posn) || $p_sign_posn == CHAR_MAX) $p_sign_posn = DEFAULT_P_SIGN_POSN;
	if (empty($n_sign_posn) || $n_sign_posn == CHAR_MAX) $n_sign_posn = DEFAULT_N_SIGN_POSN;

	// check $NumDigitsAfterDecimal
	if ($NumDigitsAfterDecimal > -1)
		$frac_digits = $NumDigitsAfterDecimal;

	// check $UseParensForNegativeNumbers
	if ($UseParensForNegativeNumbers == -1) {
		$n_sign_posn = 0;
		if ($p_sign_posn == 0) {
			if (DEFAULT_P_SIGN_POSN != 0)
				$p_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$p_sign_posn = 3;
		}
	} elseif ($UseParensForNegativeNumbers == 0) {
		if ($n_sign_posn == 0)
			if (DEFAULT_P_SIGN_POSN != 0)
				$n_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$n_sign_posn = 3;
	}

	// check $GroupDigits
	if ($GroupDigits == -1) {
		$mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	} elseif ($GroupDigits == 0) {
		$mon_thousands_sep = "";
	}

	// start by formatting the unsigned number
	$number = number_format(abs($amount),
							$frac_digits,
							$mon_decimal_point,
							$mon_thousands_sep);

	// check $IncludeLeadingDigit
	if ($IncludeLeadingDigit == 0) {
		if (substr($number, 0, 2) == "0.")
			$number = substr($number, 1, strlen($number)-1);
	}
	if ($amount < 0) {
		$sign = $negative_sign;

		// "extracts" the boolean value as an integer
		$n_cs_precedes  = intval($n_cs_precedes  == true);
		$n_sep_by_space = intval($n_sep_by_space == true);
		$key = $n_cs_precedes . $n_sep_by_space . $n_sign_posn;
	} else {
		$sign = $positive_sign;
		$p_cs_precedes  = intval($p_cs_precedes  == true);
		$p_sep_by_space = intval($p_sep_by_space == true);
		$key = $p_cs_precedes . $p_sep_by_space . $p_sign_posn;
	}
	$formats = array(

	  // currency symbol is after amount
	  // no space between amount and sign

	  '000' => '(%s' . $currency_symbol . ')',
	  '001' => $sign . '%s ' . $currency_symbol,
	  '002' => '%s' . $currency_symbol . $sign,
	  '003' => '%s' . $sign . $currency_symbol,
	  '004' => '%s' . $sign . $currency_symbol,

	  // one space between amount and sign
	  '010' => '(%s ' . $currency_symbol . ')',
	  '011' => $sign . '%s ' . $currency_symbol,
	  '012' => '%s ' . $currency_symbol . $sign,
	  '013' => '%s ' . $sign . $currency_symbol,
	  '014' => '%s ' . $sign . $currency_symbol,

	  // currency symbol is before amount
	  // no space between amount and sign

	  '100' => '(' . $currency_symbol . '%s)',
	  '101' => $sign . $currency_symbol . '%s',
	  '102' => $currency_symbol . '%s' . $sign,
	  '103' => $sign . $currency_symbol . '%s',
	  '104' => $currency_symbol . $sign . '%s',

	  // one space between amount and sign
	  '110' => '(' . $currency_symbol . ' %s)',
	  '111' => $sign . $currency_symbol . ' %s',
	  '112' => $currency_symbol . ' %s' . $sign,
	  '113' => $sign . $currency_symbol . ' %s',
	  '114' => $currency_symbol . ' ' . $sign . '%s');

  // lookup the key in the above array
	return sprintf($formats[$key], $number);
}

// FormatNumber
// FormatNumber(Expression[,NumDigitsAfterDecimal [,IncludeLeadingDigit
// 	[,UseParensForNegativeNumbers [,GroupDigits]]]])
// NumDigitsAfterDecimal is the numeric value indicating how many places to the
// right of the decimal are displayed
// -1 Use Default
// The IncludeLeadingDigit, UseParensForNegativeNumbers, and GroupDigits
// arguments have the following settings:
// -1 True
// 0 False
// -2 Use Default
function ewrpt_FormatNumber($amount, $NumDigitsAfterDecimal, $IncludeLeadingDigit = -2, $UseParensForNegativeNumbers = -2, $GroupDigits = -2) {
	if (!is_numeric($amount))
		return $amount;

	// export the values returned by localeconv into the local scope
	extract(localeconv());

	// set defaults if locale is not set
	if (empty($currency_symbol)) $currency_symbol = DEFAULT_CURRENCY_SYMBOL;
	if (empty($mon_decimal_point)) $mon_decimal_point = DEFAULT_MON_DECIMAL_POINT;
	if (empty($mon_thousands_sep)) $mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	if (empty($positive_sign)) $positive_sign = DEFAULT_POSITIVE_SIGN;
	if (empty($negative_sign)) $negative_sign = DEFAULT_NEGATIVE_SIGN;
	if (empty($frac_digits) || $frac_digits == CHAR_MAX) $frac_digits = DEFAULT_FRAC_DIGITS;
	if (empty($p_cs_precedes) || $p_cs_precedes == CHAR_MAX) $p_cs_precedes = DEFAULT_P_CS_PRECEDES;
	if (empty($p_sep_by_space) || $p_sep_by_space == CHAR_MAX) $p_sep_by_space = DEFAULT_P_SEP_BY_SPACE;
	if (empty($n_cs_precedes) || $n_cs_precedes == CHAR_MAX) $n_cs_precedes = DEFAULT_N_CS_PRECEDES;
	if (empty($n_sep_by_space) || $n_sep_by_space == CHAR_MAX) $n_sep_by_space = DEFAULT_N_SEP_BY_SPACE;
	if (empty($p_sign_posn) || $p_sign_posn == CHAR_MAX) $p_sign_posn = DEFAULT_P_SIGN_POSN;
	if (empty($n_sign_posn) || $n_sign_posn == CHAR_MAX) $n_sign_posn = DEFAULT_N_SIGN_POSN;

	// check $NumDigitsAfterDecimal
	if ($NumDigitsAfterDecimal > -1)
		$frac_digits = $NumDigitsAfterDecimal;

	// check $UseParensForNegativeNumbers
	if ($UseParensForNegativeNumbers == -1) {
		$n_sign_posn = 0;
		if ($p_sign_posn == 0) {
			if (DEFAULT_P_SIGN_POSN != 0)
				$p_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$p_sign_posn = 3;
		}
	} elseif ($UseParensForNegativeNumbers == 0) {
		if ($n_sign_posn == 0)
			if (DEFAULT_P_SIGN_POSN != 0)
				$n_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$n_sign_posn = 3;
	}

	// check $GroupDigits
	if ($GroupDigits == -1) {
		$mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	} elseif ($GroupDigits == 0) {
		$mon_thousands_sep = "";
	}

	// start by formatting the unsigned number
	$number = number_format(abs($amount),
						  $frac_digits,
						  $mon_decimal_point,
						  $mon_thousands_sep);

	// check $IncludeLeadingDigit
	if ($IncludeLeadingDigit == 0) {
		if (substr($number, 0, 2) == "0.")
			$number = substr($number, 1, strlen($number)-1);
	}
	if ($amount < 0) {
		$sign = $negative_sign;
		$key = $n_sign_posn;
	} else {
		$sign = $positive_sign;
		$key = $p_sign_posn;
	}
	$formats = array(
		'0' => '(%s)',
		'1' => $sign . '%s',
		'2' => $sign . '%s',
		'3' => $sign . '%s',
		'4' => $sign . '%s');

	// lookup the key in the above array
	return sprintf($formats[$key], $number);
}

// FormatPercent
// FormatPercent(Expression[,NumDigitsAfterDecimal [,IncludeLeadingDigit
// 	[,UseParensForNegativeNumbers [,GroupDigits]]]])
// NumDigitsAfterDecimal is the numeric value indicating how many places to the
// right of the decimal are displayed
// -1 Use Default
// The IncludeLeadingDigit, UseParensForNegativeNumbers, and GroupDigits
// arguments have the following settings:
// -1 True
// 0 False
// -2 Use Default
function ewrpt_FormatPercent($amount, $NumDigitsAfterDecimal, $IncludeLeadingDigit = -2, $UseParensForNegativeNumbers = -2, $GroupDigits = -2) {
	if (!is_numeric($amount))
		return $amount;

	// export the values returned by localeconv into the local scope
	extract(localeconv());

	// set defaults if locale is not set
	if (empty($currency_symbol)) $currency_symbol = DEFAULT_CURRENCY_SYMBOL;
	if (empty($mon_decimal_point)) $mon_decimal_point = DEFAULT_MON_DECIMAL_POINT;
	if (empty($mon_thousands_sep)) $mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	if (empty($positive_sign)) $positive_sign = DEFAULT_POSITIVE_SIGN;
	if (empty($negative_sign)) $negative_sign = DEFAULT_NEGATIVE_SIGN;
	if (empty($frac_digits) || $frac_digits == CHAR_MAX) $frac_digits = DEFAULT_FRAC_DIGITS;
	if (empty($p_cs_precedes) || $p_cs_precedes == CHAR_MAX) $p_cs_precedes = DEFAULT_P_CS_PRECEDES;
	if (empty($p_sep_by_space) || $p_sep_by_space == CHAR_MAX) $p_sep_by_space = DEFAULT_P_SEP_BY_SPACE;
	if (empty($n_cs_precedes) || $n_cs_precedes == CHAR_MAX) $n_cs_precedes = DEFAULT_N_CS_PRECEDES;
	if (empty($n_sep_by_space) || $n_sep_by_space == CHAR_MAX) $n_sep_by_space = DEFAULT_N_SEP_BY_SPACE;
	if (empty($p_sign_posn) || $p_sign_posn == CHAR_MAX) $p_sign_posn = DEFAULT_P_SIGN_POSN;
	if (empty($n_sign_posn) || $n_sign_posn == CHAR_MAX) $n_sign_posn = DEFAULT_N_SIGN_POSN;

	// check $NumDigitsAfterDecimal
	if ($NumDigitsAfterDecimal > -1)
		$frac_digits = $NumDigitsAfterDecimal;

	// check $UseParensForNegativeNumbers
	if ($UseParensForNegativeNumbers == -1) {
		$n_sign_posn = 0;
		if ($p_sign_posn == 0) {
			if (DEFAULT_P_SIGN_POSN != 0)
				$p_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$p_sign_posn = 3;
		}
	} elseif ($UseParensForNegativeNumbers == 0) {
		if ($n_sign_posn == 0)
			if (DEFAULT_P_SIGN_POSN != 0)
				$n_sign_posn = DEFAULT_P_SIGN_POSN;
			else
				$n_sign_posn = 3;
	}

	// check $GroupDigits
	if ($GroupDigits == -1) {
		$mon_thousands_sep = DEFAULT_MON_THOUSANDS_SEP;
	} elseif ($GroupDigits == 0) {
		$mon_thousands_sep = "";
	}

	// start by formatting the unsigned number
	$number = number_format(abs($amount)*100,
							$frac_digits,
							$mon_decimal_point,
							$mon_thousands_sep);

	// check $IncludeLeadingDigit
	if ($IncludeLeadingDigit == 0) {
		if (substr($number, 0, 2) == "0.")
			$number = substr($number, 1, strlen($number)-1);
	}
	if ($amount < 0) {
		$sign = $negative_sign;
		$key = $n_sign_posn;
	} else {
		$sign = $positive_sign;
		$key = $p_sign_posn;
	}
	$formats = array(
		'0' => '(%s%%)',
		'1' => $sign . '%s%%',
		'2' => $sign . '%s%%',
		'3' => $sign . '%s%%',
		'4' => $sign . '%s%%');

	// lookup the key in the above array
	return sprintf($formats[$key], $number);
}

// Add slashes for SQL
function ewrpt_AdjustSql($val) {
	$val = addslashes(trim($val));
	return $val;
}

// Build Report SQL
function ewrpt_BuildReportSql($sSelect, $sWhere, $sGroupBy, $sHaving, $sOrderBy, $sFilter, $sSort) {
	$sDbWhere = $sWhere;
	if ($sDbWhere <> "") $sDbWhere = "(" . $sDbWhere . ")";
	if ($sFilter <> "") {
		if ($sDbWhere <> "") $sDbWhere .= " AND ";
		$sDbWhere .= "(" . $sFilter . ")";
	}
	$sDbOrderBy = ewrpt_UpdateSortFields($sOrderBy, $sSort);
	$sSql = $sSelect;
	if ($sDbWhere <> "") $sSql .= " WHERE " . $sDbWhere;
	if ($sGroupBy <> "") $sSql .= " GROUP BY " . $sGroupBy;
	if ($sHaving <> "") $sSql .= " HAVING " . $sHaving;
	if ($sDbOrderBy <> "") $sSql .= " ORDER BY " . $sDbOrderBy;
	return $sSql;
}

// Update sort fields
function ewrpt_UpdateSortFields($sOrderBy, $sSort) {
	if ($sOrderBy == "") {
		return $sSort;
	} elseif ($sSort == "") {
		return $sOrderBy;
	} else {

		// Merge sort field list
		$arorderby = ewrpt_GetSortFlds($sOrderBy);
		$cntorderby = count($arorderby);
		$arsort = ewrpt_GetSortFlds($sSort);
		$cntsort = count($arsort);
		for ($i = 0; $i < $cntsort; $i++) {

			// Get sort field
			$sortfld = trim($arsort[$i]);
			if (strtoupper(substr($sortfld,-4)) == " ASC") {
				$sortfld = trim(substr($sortfld,0,-4));
			} elseif (strtoupper(substr($sortfld,-5)) == " DESC") {
				$sortfld = trim(substr($sortfld,0,-4));
			}
			for ($j = 0; $j < $cntorderby; $j++) {

				// Get orderby field
				$orderfld = trim($arorderby[$j]);
				if (strtoupper(substr($orderfld,-4)) == " ASC") {
					$orderfld = trim(substr($orderfld,0,-4));
				} elseif (strtoupper(substr($orderfld,-5)) == " DESC") {
					$orderfld = trim(substr($orderfld,0,-4));
				}

				// Replace field
				if ($orderfld == $sortfld) {
					$arorderby[$j] = $arsort[$i];
					break;
				}
			}

			// Append field
			if ($orderfld <> $sortfld)
				$arorderby[] = $arsort[$i];
		}
		return implode(", ", $arorderby);
	}
}

// Get sort fields
function ewrpt_GetSortFlds($flds) {
	$offset = -1;
	$fldpos = 0;
	$ar = array();
	while ($offset = strpos($flds, ",", $offset + 1)) {
		$orderfld = substr($flds,$fldpos,$offset-$fldpos);
		if ((strtoupper(substr($orderfld,-4)) == " ASC") || (strtoupper(substr($orderfld,-5)) == " DESC")) {
			$fldpos = $offset+1;
			$ar[] = $orderfld;
		}
	}
	$ar[] = substr($flds,$fldpos);
	return $ar;
}

// Get reverse sort
function ewrpt_ReverseSort($sorttype) {
	return ($sorttype == "ASC") ? "DESC" : "ASC";
}

// Construct a crosstab field name
function ewrpt_CrossTabField($smrytype, $smryfld, $colfld, $datetype, $val, $qc, $alias="") {
	if ($val == EW_REPORT_NULL_VALUE) {
		$wrkval = "NULL";
		$wrkqc = "";
	} elseif ($val == EW_REPORT_EMPTY_VALUE) {
		$wrkval = "";
		$wrkqc = $qc;
	} else {
		$wrkval = $val;
		$wrkqc = $qc;
	}
	switch ($smrytype) {
	case "SUM":
		$fld = $smrytype . "(" . $smryfld . "*" . ewrpt_SQLDistinctFactor(EW_REPORT_DBMSNAME, $colfld, $datetype, $val, $qc) . ")";
		break;
	case "COUNT":
		$fld = "SUM(" . ewrpt_SQLDistinctFactor(EW_REPORT_DBMSNAME, $colfld, $datetype, $wrkval, $wrkqc) . ")";
		break;
	case "MIN":
	case "MAX":
		$aggwrk = ewrpt_SQLDistinctFactor(EW_REPORT_DBMSNAME, $colfld, $datetype, $wrkval, $wrkqc);
		$fld = $smrytype . "(IF(" . $aggwrk . "=0,NULL," . $smryfld . "))";
		break;
	case "AVG":
		$sumwrk = "SUM(" . $smryfld . "*" .
			ewrpt_SQLDistinctFactor(EW_REPORT_DBMSNAME, $colfld, $datetype, $wrkval, $wrkqc) . ")";
		if ($alias != "")
			$sumwrk .= " AS SUM_" . $alias;
		$cntwrk =	"SUM(" .
			ewrpt_SQLDistinctFactor(EW_REPORT_DBMSNAME, $colfld, $datetype, $wrkval, $wrkqc) . ")";
		if ($alias != "")
			$cntwrk .= " AS CNT_" . $alias;
		return $sumwrk . ", " . $cntwrk;
	}
	if ($alias != "")
		$fld .= " AS " . $alias;
	return $fld;
}

// Construct SQL Distinct factor (MySQL)
// y: IF(YEAR(`OrderDate`)=1996,1,0))
// q: IF(QUARTER(`OrderDate`)=1,1,0))
// m: IF(MONTH(`OrderDate`)=1,1,0))
function ewrpt_SQLDistinctFactor($dbmsName, $sFld, $dateType, $val, $qc) {
	if ($dateType == "y" && is_numeric($val)) {
		return "IF(YEAR(" . $sFld . ")=" . $val . ",1,0)";
	} elseif ($dateType == "q" && is_numeric($val)) {
		return "IF(QUARTER(" . $sFld . ")=" . $val . ",1,0)";
	} elseif ($dateType == "m" && is_numeric($val)) {
		return "IF(MONTH(" . $sFld . ")=" . $val . ",1,0)";
	} else {
		if ($val == "NULL") {
			return "IF(" . $sFld . " IS NULL,1,0)";
		} else {
			return "IF(" . $sFld . "=" . $qc . ewrpt_AdjustSql($val) . $qc . ",1,0)";
		}
	}
}

// Evaluate summary value
function ewrpt_SummaryValue($val1, $val2, $ityp) {
	switch ($ityp) {
	case "SUM":
	case "COUNT":
	case "AVG":
		if (is_null($val2) || !is_numeric($val2)) {
			return $val1;
		} else {
			return ($val1 + $val2);
		}
	case "MIN":
		if (is_null($val2) || !is_numeric($val2)) {
			return $val1; // Skip null and non-numeric
		} elseif (is_null($val1)) {
			return $val2; // Initialize for first valid value
		} elseif ($val1 < $val2) {
			return $val1;
		} else {
			return $val2;
		}
	case "MAX":
		if (is_null($val2) || !is_numeric($val2)) {
			return $val1; // Skip null and non-numeric
		} elseif (is_null($val1)) {
			return $val2; // Initialize for first valid value
		} elseif ($val1 > $val2) {
			return $val1;
		} else {
			return $val2;
		}
	}
}

// Match filter value
function ewrpt_MatchedFilterValue($ar, $value) {
	if (!is_array($ar)) {
		return (strval($ar) == strval($value));
	} else {
		foreach ($ar as $val) {
			if (strval($val) == strval($value))
				return TRUE;
		}
		return FALSE;
	}
}

// Render repeat column table
// rowcnt - zero based row count
function ewrpt_RepeatColumnTable($totcnt, $rowcnt, $repeatcnt, $rendertype) {
	$sWrk = "";
	if ($rendertype == 1) { // Render control start
		if ($rowcnt == 0) $sWrk .= "<table class=\"" . EW_REPORT_ITEM_TABLE_CLASSNAME . "\">";
		if ($rowcnt % $repeatcnt == 0) $sWrk .= "<tr>";
		$sWrk .= "<td>";
	} elseif ($rendertype == 2) { // Render control end
		$sWrk .= "</td>";
		if ($rowcnt % $repeatcnt == $repeatcnt - 1) {
			$sWrk .= "</tr>";
		} elseif ($rowcnt == $totcnt - 1) {
			for ($i = ($rowcnt % $repeatcnt) + 1; $i < $repeatcnt; $i++) {
				$sWrk .= "<td>&nbsp;</td>";
			}
			$sWrk .= "</tr>";
		}
		if ($rowcnt == $totcnt - 1) $sWrk .= "</table>";
	}
	return $sWrk;
}

// Check if the value is selected
function ewrpt_IsSelectedValue(&$ar, $value, $ft) {
	if (!is_array($ar))
		return TRUE;
	$af = (substr($value, 0, 2) == "@@");
	foreach ($ar as $val) {
		if ($af || substr($val, 0, 2) == "@@") { // Advanced filters
			if ($val == $value)
				return TRUE;
		} else {
			if (ewrpt_CompareValue($val, $value, $ft))
				return TRUE;
		}
	}
	return FALSE;
}

// Set up distinct values
// ar: array for distinct values
// val: value
// label: display value
// dup: check duplicate
function ewrpt_SetupDistinctValues(&$ar, $val, $label, $dup) {
	$isarray = is_array($ar);
	if ($dup && $isarray && in_array($val, array_keys($ar)))
		return;
	if (!$isarray) {
		$ar = array($val => $label);
	} elseif ($val == EW_REPORT_EMPTY_VALUE || $val == EW_REPORT_NULL_VALUE) { // Null/Empty
		$ar = array_reverse($ar, TRUE);
		$ar[$val] = $label; // Insert at top
		$ar = array_reverse($ar, TRUE);
	} else {
		$ar[$val] = $label; // Default insert at end
	}
}

// Compare values based on field type
function ewrpt_CompareValue($v1, $v2, $ft) {
	switch ($ft) {

	// Case adBigInt, adInteger, adSmallInt, adTinyInt, adUnsignedTinyInt, adUnsignedSmallInt, adUnsignedInt, adUnsignedBigInt
	case 20:
	case 3:
	case 2:
	case 16:
	case 17:
	case 18:
	case 19:
	case 21:
		if (is_numeric($v1) && is_numeric($v2)) {
			return (intval($v1) == intval($v2));
		}
		break;

	// Case adSingle, adDouble, adNumeric, adCurrency
	case 4:
	case 5:
	case 131:
	case 6:
		if (is_numeric($v1) && is_numeric($v2)) {
			return ((float)$v1 == (float)$v2);
		}
		break;

	//	Case adDate, adDBDate, adDBTime, adDBTimeStamp
	case 7:
	case 133:
	case 134:
	case 135:
		if (is_numeric(strtotime($v1)) && is_numeric(strtotime($v2))) {
			return (strtotime($v1) == strtotime($v2));
		}
		break;
	default:
		return (strcmp($v1, $v2) == 0); // treat as string
	}
}

// "Past"
function ewrpt_IsPast() {
	return ("(@@fld@@ < '" . date("Y-m-d H:i:s") . "')");
}

// "Future";
function ewrpt_IsFuture() {
	return ("(@@fld@@ > '" . date("Y-m-d H:i:s") . "')");
}

// "Last 30 days"
function ewrpt_IsLast30Days() {
	$dt1 = date("Y-m-d", strtotime("-29 days"));
	$dt2 = date("Y-m-d", strtotime("+1 days"));
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Last 14 days"
function ewrpt_IsLast14Days() {
	$dt1 = date("Y-m-d", strtotime("-13 days"));
	$dt2 = date("Y-m-d", strtotime("+1 days"));
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Last 7 days"
function ewrpt_IsLast7Days() {
	$dt1 = date("Y-m-d", strtotime("-6 days"));
	$dt2 = date("Y-m-d", strtotime("+1 days"));
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Next 30 days"
function ewrpt_IsNext30Days() {
	$dt1 = date("Y-m-d");
	$dt2 = date("Y-m-d", strtotime("+30 days"));
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Next 14 days"
function ewrpt_IsNext14Days() {
	$dt1 = date("Y-m-d");
	$dt2 = date("Y-m-d", strtotime("+14 days"));
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Next 7 days"
function ewrpt_IsNext7Days() {
	$dt1 = date("Y-m-d");
	$dt2 = date("Y-m-d", strtotime("+7 days"));
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Yesterday"
function ewrpt_IsYesterday() {
	$dt1 = date("Y-m-d", strtotime("-1 days"));
	$dt2 = date("Y-m-d");
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Today"
function ewrpt_IsToday() {
	$dt1 = date("Y-m-d");
	$dt2 = date("Y-m-d", strtotime("+1 days"));
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Tomorrow"
function ewrpt_IsTomorrow() {
	$dt1 = date("Y-m-d", strtotime("+1 days"));
	$dt2 = date("Y-m-d", strtotime("+2 days"));
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Last month"
function ewrpt_IsLastMonth() {
	$dt1 = date("Y-m", strtotime("-1 months")) . "-01";
	$dt2 = date("Y-m") . "-01";
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "This month"
function ewrpt_IsThisMonth() {
	$dt1 = date("Y-m") . "-01";
	$dt2 = date("Y-m", strtotime("+1 months")) . "-01";
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Next month"
function ewrpt_IsNextMonth() {
	$dt1 = date("Y-m", strtotime("+1 months")) . "-01";
	$dt2 = date("Y-m", strtotime("+2 months")) . "-01";
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Last two weeks"
function ewrpt_IsLast2Weeks() {
	if (strtotime("this Sunday") == strtotime("today")) {
		$dt1 = date("Y-m-d", strtotime("-14 days this Sunday"));
		$dt2 = date("Y-m-d", strtotime("this Sunday"));
	} else {
		$dt1 = date("Y-m-d", strtotime("-14 days last Sunday"));
		$dt2 = date("Y-m-d", strtotime("last Sunday"));
	}
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Last week"
function ewrpt_IsLastWeek() {
	if (strtotime("this Sunday") == strtotime("today")) {
		$dt1 = date("Y-m-d", strtotime("-7 days this Sunday"));
		$dt2 = date("Y-m-d", strtotime("this Sunday"));
	} else {
		$dt1 = date("Y-m-d", strtotime("-7 days last Sunday"));
		$dt2 = date("Y-m-d", strtotime("last Sunday"));
	}
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "This week"
function ewrpt_IsThisWeek() {
	if (strtotime("this Sunday") == strtotime("today")) {
		$dt1 = date("Y-m-d", strtotime("this Sunday"));
		$dt2 = date("Y-m-d", strtotime("+7 days this Sunday"));
	} else {
		$dt1 = date("Y-m-d", strtotime("last Sunday"));
		$dt2 = date("Y-m-d", strtotime("+7 days last Sunday"));
	}
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Next week"
function ewrpt_IsNextWeek() {
	if (strtotime("this Sunday") == strtotime("today")) {
		$dt1 = date("Y-m-d", strtotime("+7 days this Sunday"));
		$dt2 = date("Y-m-d", strtotime("+14 days this Sunday"));
	} else {
		$dt1 = date("Y-m-d", strtotime("+7 days last Sunday"));
		$dt2 = date("Y-m-d", strtotime("+14 days last Sunday"));
	}
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Next two week"
function ewrpt_IsNext2Weeks() {
	if (strtotime("this Sunday") == strtotime("today")) {
		$dt1 = date("Y-m-d", strtotime("+7 days this Sunday"));
		$dt2 = date("Y-m-d", strtotime("+21 days this Sunday"));
	} else {
		$dt1 = date("Y-m-d", strtotime("+7 days last Sunday"));
		$dt2 = date("Y-m-d", strtotime("+21 days last Sunday"));
	}
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Last year"
function ewrpt_IsLastYear() {
	$dt1 = date("Y", strtotime("-1 years")) . "-01-01";
	$dt2 = date("Y") . "-01-01";
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "This year"
function ewrpt_IsThisYear() {
	$dt1 = date("Y") . "-01-01";
	$dt2 = date("Y", strtotime("+1 years")) . "-01-01";
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Next year"
function ewrpt_IsNextYear() {
	$dt1 = date("Y", strtotime("+1 years")) . "-01-01";
	$dt2 = date("Y", strtotime("+2 years")) . "-01-01";
	return ("(@@fld@@ >= '$dt1' AND @@fld@@ < '$dt2')");
}

// "Next year"
function ewrpt_DaysInMonth($y, $m) {
	if (in_array($m, array(1, 3, 5, 7, 8, 10, 12))) {
		return 31;
	} elseif (in_array($m, array(4, 6, 9, 11))) {
		return 30;
	} elseif ($m == 2) {
		return ($y % 4 == 0) ? 29 : 28;
	}
	return 0;
}

// Function to calculate date difference
function ewrpt_DateDiff($dateTimeBegin, $dateTimeEnd, $interval = "d") {
	$dateTimeBegin = strtotime($dateTimeBegin);
	if ($dateTimeBegin === -1 || $dateTimeBegin === FALSE)
		return FALSE;
	$dateTimeEnd = strtotime($dateTimeEnd);
	if($dateTimeEnd === -1 || $dateTimeEnd === FALSE)
		return FALSE;
	$dif = $dateTimeEnd - $dateTimeBegin;	
	$arBegin = getdate($dateTimeBegin);
	$dateBegin = mktime(0, 0, 0, $arBegin["mon"], $arBegin["mday"], $arBegin["year"]);
	$arEnd = getdate($dateTimeEnd);
	$dateEnd = mktime(0, 0, 0, $arEnd["mon"], $arEnd["mday"], $arEnd["year"]);
	$difDate = $dateEnd - $dateBegin;
	switch ($interval) {
		case "s": // seconds
			return $dif;
		case "n": // minutes
			return ($dif > 0) ? floor($dif/60) : ceil($dif/60);
		case "h": // hours
			return ($dif > 0) ? floor($dif/3600) : ceil($dif/3600);
		case "d": // days
			return ($difDate > 0) ? floor($difDate/86400) : ceil($difDate/86400);
		case "w": // weeks
			return ($difDate > 0) ? floor($difDate/604800) : ceil($difDate/604800);
		case "ww": // calendar weeks
			$difWeek = (($dateEnd - $arEnd["wday"]*86400) - ($dateBegin - $arBegin["wday"]*86400))/604800;
			return ($difWeek > 0) ? floor($difWeek) : ceil($difWeek);
		case "m": // months
			return (($arEnd["year"]*12 + $arEnd["mon"]) -	($arBegin["year"]*12 + $arBegin["mon"]));
		case "yyyy": // years
			return ($arEnd["year"] - $arBegin["year"]);
	}
}

// Set up distinct values from ext. filter
function ewrpt_SetupDistinctValuesFromFilter(&$ar, $af) {
	if (is_array($af)) {
		foreach ($af as $value) {
			ewrpt_SetupDistinctValues($ar, $value[0], $value[1], FALSE);
		}
	}
}

// Get group value
// - Get the group value based on field type, group type and interval
// - ft: field type
// * 1: numeric, 2: date, 3: string
// - gt: group type
// * numeric: i = interval, n = normal
// * date: d = Day, w = Week, m = Month, q = Quarter, y = Year
// * string: f = first nth character, n = normal
// - intv: interval
function ewrpt_GroupValue($val, $ft, $grp, $intv) {
	switch ($ft) {

	// Case adBigInt, adInteger, adSmallInt, adTinyInt, adSingle, adDouble, adNumeric, adCurrency, adUnsignedTinyInt, adUnsignedSmallInt, adUnsignedInt, adUnsignedBigInt (numeric)
	case 20:
	case 3:
	case 2:
	case 16:
	case 4:
	case 5:
	case 131:
	case 6:
	case 17:
	case 18:
	case 19:
	case 21:
		if (!is_numeric($val)) return $val;	
		$wrkIntv = intval($intv);
		if ($wrkIntv <= 0) $wrkIntv = 10;
		switch ($grp) {
			case "i":
				return intval($val/$wrkIntv);
			default:
				return $val;
		}

	// Case adDate, adDBDate, adDBTime, adDBTimeStamp (date)
//	case 7:
//	case 133:
//	case 134:
//	case 135:
	// Case adLongVarChar, adLongVarWChar, adChar, adWChar, adVarChar, adVarWChar (string)

	case 201: // string
	case 203:
	case 129:
	case 130:
	case 200:
	case 202:
		$wrkIntv = intval($intv);
		if ($wrkIntv <= 0) $wrkIntv = 1;
		switch ($grp) {
			case "f":
				return substr($val, 0, $wrkIntv);
			default:
				return $val;
		}
	default:
		return $val; // ignore
	}
}

// Display group value
function ewrpt_DisplayGroupValue($val, $ft, $grp, $intv) {
	if (is_null($val)) return $val;
	switch ($ft) {

	// Case adBigInt, adInteger, adSmallInt, adTinyInt, adSingle, adDouble, adNumeric, adCurrency, adUnsignedTinyInt, adUnsignedSmallInt, adUnsignedInt, adUnsignedBigInt (numeric)
	case 20:
	case 3:
	case 2:
	case 16:
	case 4:
	case 5:
	case 131:
	case 6:
	case 17:
	case 18:
	case 19:
	case 21:
		$wrkIntv = intval($intv);
		if ($wrkIntv <= 0) $wrkIntv = 10;
		switch ($grp) {
			case "i":
				return strval($val*$wrkIntv) . " - " . strval(($val+1)*$wrkIntv);
			default:
				return $val;
		}
		break;

	// Case adDate, adDBDate, adDBTime, adDBTimeStamp (date)
	case 7:
	case 133:
	case 134:
	case 135:
		$ar = explode("|", $val);
		switch ($grp) {
			Case "y":
				return $ar[0];
			Case "q":
				return ewrpt_FormatQuarter($ar[0], $ar[1]);
			Case "m":
				return ewrpt_FormatMonth($ar[0], $ar[1]);
			Case "w":
				return ewrpt_FormatWeek($ar[0], $ar[1]);
			Case "d":
				return ewrpt_FormatDay($ar[0], $ar[1], $ar[2]);
			Case "h":
				return ewrpt_FormatHour($ar[0]);
			Case "min":
				return ewrpt_FormatMinute($ar[0]);
			default:
				return $val;
		}
		break;
	default: // string and others
		return $val; // ignore
	}
}

function ewrpt_FormatQuarter($y, $q) {
	return "Q" . $q . "/" . $y;
}

function ewrpt_FormatMonth($y, $m) {
	return $m . "/" . $y;
}

function ewrpt_FormatWeek($y, $w) {
	return "WK" . $w . "/" . $y;
}

function ewrpt_FormatDay($y, $m, $d) {
	return $y . "-" . $m . "-" . $d;
}

function ewrpt_FormatHour($h) {
	if (intval($h) == 0) {
		return "12 AM";
	} elseif (intval($h) < 12) {
		return $h . " AM";
	} elseif (intval($h) == 12) {
		return "12 PM";
	} else {
		return ($h-12) . " PM";
	}
}

function ewrpt_FormatMinute($n) {
	return $n . " MIN";
}

// Get JavaScript data in the form of:
// [value1, text1, selected], [value2, text2, selected], ...
// where value1: "value 1", text1: "text 1": selected: true|false
function ewrpt_GetJsData(&$arv, &$ars, $ft) {
	$jsdata = "";
	if (is_array($arv)) {
		foreach ($arv as $key => $value) {
			$jsselect = (ewrpt_IsSelectedValue($ars, $key, $ft)) ? "true" : "false";
			if ($jsdata <> "") $jsdata .= ",";
			$jsdata .= "[\"" . ewrpt_EscapeJs($key) . "\",\"" . ewrpt_EscapeJs($value) . "\",$jsselect]";
		}
	}
	return $jsdata;
}

// Check if selected value
function ewrpt_SelectedValue(&$ar, $val, $ft, $af) {
	if (!is_array($ar)) {
		return TRUE;
	} else {
		$isaf = (substr($val, 0, 2) == "@@");
		foreach ($ar as $value) {
			if ($val == "" && $value == EW_REPORT_EMPTY_VALUE) { // Empty string
				return TRUE;
			} elseif (is_null($val) && $value == EW_REPORT_NULL_VALUE) { // Null value
				return TRUE;
			} elseif ($isaf || substr($value, 0, 2) == "@@") { // Advanced filter
				if (is_array($af) && !is_null($val)) {
					$result = ewrpt_SelectedFilter($af, $value, $val); // Process popup filter
					if ($result) return TRUE;
				}
			} elseif (ewrpt_CompareValue($value, $val, $ft)) {
				return TRUE;
			}
		}
	}
	return FALSE;
}

// Return detail filter SQL
function ewrpt_DetailFilterSQL($fn, $val, $ft, $gt="", $gi=0, $sql="") {
	$sqlwrk = $fn;
	if ($sql <> "") {
		$sqlwrk = str_replace("%s", $fn, $sql) . " = " . str_replace("%s", ewrpt_QuotedValue($val, $ft), $sql);
	} else {
		$sqlwrk .= " = " . ewrpt_QuotedValue($val, $ft);
	}
	return $sqlwrk;
}

// Return popup filter SQL
function ewrpt_FilterSQL(&$ar, $fn, $ft, $af, $gt="", $gi=0, $sql="") {
	if (!is_array($ar)) {
		return TRUE;
	} else {
		$sqlwrk = "";
		$i = 0;
		foreach ($ar as $value) {
			if ($value == EW_REPORT_EMPTY_VALUE) { // Empty string
				$sqlwrk .= "$fn = '' OR ";
			} elseif ($value == EW_REPORT_NULL_VALUE) { // Null value
				$sqlwrk .= "$fn IS NULL OR ";
			} elseif (substr($value, 0, 2) == "@@") { // Advanced filter
				if (is_array($af)) {
					$afsql = ewrpt_AdvancedFilterSQL($af, $value); // Process popup filter
					if (!is_null($afsql))
						$sqlwrk .= str_replace("@@fld@@", $fn, $afsql) . " OR ";
				}
			} elseif ($sql <> "") {
				$sqlwrk .= str_replace("%s", $fn, $sql) . " = '" . $value . "' OR ";
			} else {
				$sqlwrk .= "$fn IN (" . ewrpt_JoinArray($ar, ", ", $ft, $i) . ") OR ";
				break;
			}
			$i++;
		}
	}
	if ($sqlwrk != "")
		$sqlwrk = "(" . substr($sqlwrk, 0, -4) . ")";
	return $sqlwrk;
}

// Return Advanced Filter SQL
function ewrpt_AdvancedFilterSQL(&$ar, $val) {
	if (!is_array($ar)) {
		return NULL;
	} elseif (is_null($val)) {
		return NULL;
	} else {
		foreach ($ar as $value) {
			if (strval($val) == strval($value[0])) {
				return $value[2];
			}
		}
		return NULL;
	}
}

// Check for ext. filter
function ewrpt_SelectedFilter(&$ar, $sel, $val) {
	if (!is_array($ar)) {
		return TRUE;
	} elseif (is_null($val)) {
		return FALSE;
	} else {
		foreach ($ar as $value) {
			if (strval($sel) == strval($value[0])) {
				$sEvalFunc = $value[2];
				return $sEvalFunc($val);
			}
		}
		return TRUE;
	}
}

// Truncate memo field based on specified length,
// string truncated to nearest space or CrLf
function ewrpt_TruncateMemo($str, $ln) {
	if (strlen($str) > 0 && strlen($str) > $ln) {
		$k = 0;
		while ($k >= 0 && $k < strlen($str)) {
			$i = strpos($str, " ", $k);
			$j = strpos($str,chr(10), $k);
			if ($i === FALSE && $j === FALSE) { // Not able to truncate
				return $str;
			} else { // Get nearest space or CrLf
				if ($i > 0 && $j > 0) {
					if ($i < $j) {
						$k = $i;
					} else {
						$k = $j;
					}
				} elseif ($i > 0) {
					$k = $i;
				} elseif ($j > 0) {
					$k = $j;
				}

				// Get truncated text
				if ($k >= $ln) {
					return substr($str, 0, $k) . "...";
				} else {
					$k++;
				}
			}
		}
	} else {
		return $str;
	}
}

// Escape string for JavaScript
function ewrpt_EscapeJs($str) {
	$str = strval($str);
	$str = str_replace("\"", "\\\"", $str);
	$str = str_replace("\r", "\\r", $str);
	$str = str_replace("\n", "\\n", $str);
	return $str;
}

// Set chart parameters
function ewrpt_SetChartParam(&$Params, $Name, $Value, $Output) {
	$Params[$Name] = Array($Name, $Value, $Output);
}

// Add chart parameters
function ewrpt_AddChartParam(&$Params, $Name, $Value, $Output) {
	$Params[$Name] = Array($Name, $Value, $Output);
}

// Show chart (FusionCharts Free)
// typ: chart type (1/2/3/4/...)
// id: chart id
// parms: "bgcolor=FFFFFF|..."
// trends: trend lines
function ewrpt_ShowChartFCF($typ, $id, &$parms, &$trends, &$data, &$series, $width, $height, $align) {
	if (empty($typ))
		$typ = 1;

	// Get chart swf
	switch ($typ) {

	// Single Series
	case 1:	$chartswf = "FCF_Column2D.swf"; break; // Column 2D
	case 2:	$chartswf = "FCF_Pie2D.swf"; break; // Pie 2D
	case 3:	$chartswf = "FCF_Bar2D.swf"; break; // Bar 2D
	case 4: $chartswf = "FCF_Line.swf"; break; // Line 2D
	case 5: $chartswf = "FCF_Column3D.swf"; break; // Column 3D
	case 6: $chartswf = "FCF_Pie3D.swf"; break; // Pie 3D
	case 7: $chartswf = "FCF_Area2D.swf"; break; // Area 2D
	case 8: $chartswf = "FCF_Doughnut2D.swf"; break; // Doughnut 2D

	// Multi Series
	case 9: $chartswf = "FCF_MSColumn2D.swf"; break; // Multi-series Column 2D
	case 10: $chartswf = "FCF_MSColumn3D.swf"; break; // Multi-series Column 3D
	case 11: $chartswf = "FCF_MSLine.swf"; break; // Multi-series Line 2D
	case 12: $chartswf = "FCF_MSArea2D.swf"; break; // Multi-series Area 2D
	case 13: $chartswf = "FCF_MSBar2D.swf"; break; // Multi-series Bar 2D

	// Stacked
	case 14: $chartswf = "FCF_StackedColumn2D.swf"; break; // Stacked Column 2D
	case 15: $chartswf = "FCF_StackedColumn3D.swf"; break; // Stacked Column 3D
	case 16: $chartswf = "FCF_StackedArea2D.swf"; break; // Stacked Area 2D
	case 17: $chartswf = "FCF_StackedBar2D.swf"; break; // Stacked Bar 2D

	// Combination (Not yet supported)
	case 18: $chartswf = "FCF_MSColumn3DLineDY.swf"; break; // Multi-series Column 3D Line Dual Y Chart
	case 19: $chartswf = "FCF_MSColumn2DLineDY.swf"; break; // Multi-series Column 2D Line Dual Y Chart

	// Default
	default: $chartswf = "FCF_Column2D.swf"; // Default = Column 2D
	}
	$urlxml = EW_REPORT_CHART_SCRIPT . "?id=$id";
	$urltext = $urlxml . "&text=1";

	// Save parms/trends to session
	$_SESSION[$id . "_parms"] = $parms;
	$_SESSION[$id . "_trends"] = $trends;

	// Save chart data to session
	$_SESSION[$id . "_data"] = $data;

	// Save chart series to session
	$_SESSION[$id . "_series"] = $series;

	// Set width, height and align
	if (is_numeric($width) && is_numeric($height)) {
		$wrkwidth = $width;
		$wrkheight = $height;
	} else { // default
		$wrkwidth = EW_REPORT_CHART_WIDTH;
		$wrkheight = EW_REPORT_CHART_WIDTH;
	}
	if (strtolower($align) == "left" || strtolower($align) == "right") {
		$wrkalign = strtolower($align);
	} else {
		$wrkalign = EW_REPORT_CHART_ALIGN; // default
	}

	// Output JavaScript for FCF
	$wrk = "<script type=\"text/javascript\">\n";
	$wrk .= "var chartwidth = \"$wrkwidth\";\n";
	$wrk .= "var chartheight = \"$wrkheight\";\n";
	$wrk .= "var chartalign = \"$wrkalign\";\n";
	$wrk .= "var charturl = \"$urlxml\";\n";
	$wrk .= "var chartid = \"div_$id\";\n";
	$wrk .= "var chartswf = \"FusionChartsFree/Charts/$chartswf\";\n";
	$wrk .= "var chart = new FusionCharts(chartswf, \"ewchart\", chartwidth, chartheight);\n";
	$wrk .= "chart.addParam(\"wmode\", \"transparent\");\n";
	$wrk .= "chart.setDataURL(charturl);\n";
	$wrk .= "chart.render(chartid);\n";
	$wrk .= "</script>\n";

	// Add debug url
	if (defined("EW_REPORT_DEBUG_CHART_ENABLED"))
		$wrk .= "<p><b>For debugging only</b>: View <a href=\"$urlxml\" target=\"_blank\">XML</a> or <a href=\"$urltext\" target=\"_blank\">text</a> data for above chart</p>";
	return $wrk;
}

// Load Chart Series
function ewrpt_LoadChartSeries($sSql, &$ar, $dt) {
	global $conn;
	$rscht = $conn->Execute($sSql);
	while ($rscht && !$rscht->EOF) {
		$ar[] = ewrpt_ChartSeriesValue($rscht->fields[0], $dt); // Series value
		$rscht->MoveNext();
	}
}

// Load Chart Data
function ewrpt_LoadChartData($sSql, &$ar, $dt) {
	global $conn;
	$rscht = $conn->Execute($sSql);
	while ($rscht && !$rscht->EOF) {
		$temp = array();
		$temp[0] = ewrpt_ChartXValue($rscht->fields[0], $dt); // X value

//echo "0: " . $rscht->fields[0] . "<br>";
		$temp[1] = ewrpt_ChartSeriesValue($rscht->fields[1], $dt); // Series value
		$temp[2] = $rscht->fields[2]; // Y value

//echo "1: " . $rscht->fields[1] . "<br>";
		$ar[] = $temp;
		$rscht->MoveNext();
	}
}

// Get Chart X value
function ewrpt_ChartXValue($val, $dt) {
	if ($dt == "xyq") {
		$ar = explode("|", $val);
		if (count($ar) >= 2)
			return $ar[0] . " " . ewrpt_QuarterName($ar[1]);
		else
			return $val;
	}
	elseif ($dt == "xym") {
		$ar = explode("|", $val);
		if (count($ar) >= 2)
			return $ar[0] . " " . ewrpt_MonthName($ar[1]);
		else
			return $val;
	}
	elseif ($dt == "xq") {
		return ewrpt_QuarterName($val);
	}
	elseif ($dt == "xm") {
		return ewrpt_MonthName($val);
	}
	else {
		return $val;
	}
}

// Get Chart Series value
function ewrpt_ChartSeriesValue($val, $dt) {
	if ($dt == "syq") {
		$ar = explode("|", $val);
		if (count($ar) >= 2)
			return $ar[0] . " " . ewrpt_QuarterName($ar[1]);
		else
			return $val;
	}
	elseif ($dt == "sym") {
		$ar = explode("|", $val);
		if (count($ar) >= 2)
			return $ar[0] . " " . ewrpt_MonthName($ar[1]);
		else
			return $val;
	}
	elseif ($dt == "sq") {
		return ewrpt_QuarterName($val);
	}
	elseif ($dt == "sm") {
		return ewrpt_MonthName($val);
	}
	else {
		return $val;
	}
}

// Sort chart data
function ewrpt_SortChartData(&$ar, $opt) {
	if ($opt < 1 || $opt > 4)
		return;
	if (is_array($ar)) {
		$cntar = count($ar);
		for ($i = 0; $i < $cntar; $i++) {
			for ($j = $i+1; $j < $cntar; $j++) {
				switch ($opt) {
					case 1: // X values ascending
						$bSwap = ($ar[$i][0] > $ar[$j][0]) || ($ar[$i][0] == $ar[$j][0] && $ar[$i][1] > $ar[$j][1]);
						break;
					case 2: // X values descending
						$bSwap = ($ar[$i][0] < $ar[$j][0]) || ($ar[$i][0] == $ar[$j][0] && $ar[$i][1] < $ar[$j][1]);
						break;
					case 3: // Y values ascending
						$bSwap = ($ar[$i][2] > $ar[$j][2]);
						break;
					case 4: // Y values descending
						$bSwap = ($ar[$i][2] < $ar[$j][2]);
				}
				if ($bSwap) {
			   	$tmpname1 = $ar[$i][0];
					$tmpname2 = $ar[$i][1];
					$tmpval = $ar[$i][2];
			   	$ar[$i][0] = $ar[$j][0];
					$ar[$i][1] = $ar[$j][1];
					$ar[$i][2] = $ar[$j][2];
		   		$ar[$j][0] = $tmpname1;
					$ar[$j][1] = $tmpname2;
					$ar[$j][2] = $tmpval;
				}
			}
		}
	}
}

// Sort chart multi series data
function ewrpt_SortMultiChartData(&$ar, $opt, $n) {
	if ($opt < 1 || $opt > 4)
		return;
	if ($n <= 0)
		return;
	if (is_array($ar)) {
		$nCat = intval(count($ar)/$n);
		if (count($ar) % $n == 0) {
			for ($i = 0; $i <= $nCat-2; $i++) {
				for ($j = $i+1; $j <= $nCat-1; $j++) {
					switch ($opt) {
					case 1: // X values ascending
						$bSwap = ($ar[$i*$n][0] > $ar[$j*$n][0]);
						break;
					case 2: // X values descending
						$bSwap = ($ar[$i*$n][0] < $ar[$j*$n][0]);
						break;
					case 3:
					case 4: // Y values
						$tmpY1 = 0;
						$tmpY2 = 0;
						for ($k = 0; $k <= $n-1; $k++) {
							$tmpY1 += $ar[$i*$n+$k][2];
							$tmpY2 += $ar[$j*$n+$k][2];
						}
						if ($opt == 3) {
							$bSwap = ($tmpY1 > $tmpY2);
						} elseif ($opt == 4) {
							$bSwap = ($tmpY1 < $tmpY2);
						}
					}
					if ($bSwap) {
						for ($k = 0; $k <= $n-1; $k++) {
							$tmpname1 = $ar[$i*$n+$k][0];
							$tmpname2 = $ar[$i*$n+$k][1];
							$tmpval = $ar[$i*$n+$k][2];
							$ar[$i*$n+$k][0] = $ar[$j*$n+$k][0];
							$ar[$i*$n+$k][1] = $ar[$j*$n+$k][1];
							$ar[$i*$n+$k][2] = $ar[$j*$n+$k][2];
							$ar[$j*$n+$k][0] = $tmpname1;
							$ar[$j*$n+$k][1] = $tmpname2;
							$ar[$j*$n+$k][2] = $tmpval;
						}
					}
				}
			}
		}
	}
}

// Load array from sql
function ewrpt_LoadArrayFromSql($sql, &$ar) {
	global $conn;
	if (strval($sql) == "")
		return;
	$rswrk = $conn->Execute($sql);
	if ($rswrk) {
		while (!$rswrk->EOF) {
			$v = $rswrk->fields[0];
			if (is_null($v)) {
				$v = EW_REPORT_NULL_VALUE;
			} elseif ($v == "") {
				$v = EW_REPORT_EMPTY_VALUE;
			}
			if (!is_array($ar))
				$ar = array();
			$ar[] = $v;
			$rswrk->MoveNext();
		}
		$rswrk->Close();
	}
}

// Function to Match array
function ewrpt_MatchedArray(&$ar1, &$ar2) {
	if (!is_array($ar1) && !is_array($ar2)) {
		return TRUE;
	} elseif (is_array($ar1) && is_array($ar2)) {
		return (count(array_diff($ar1, $ar2)) == 0);
	}
	return FALSE;
}

// Write a value to file for debug
function ewrpt_Trace($msg) {
	$filename = "debug.txt";
	if (!$handle = fopen($filename, 'a')) exit;
	if (is_writable($filename)) fwrite($handle, $msg . "\n");
	fclose($handle);
}

// Connection/Query error handler
function ewrpt_ErrorFn($DbType, $ErrorType, $ErrorNo, $ErrorMsg, $Param1, $Param2, $Object) {
	if ($ErrorType == 'CONNECT') {
		$msg = "Failed to connect to $Param2 at $Param1. Error: " . $ErrorMsg;
	} elseif ($ErrorType == 'EXECUTE') {
		$msg = "Failed to execute SQL: $Param1. Error: " . $ErrorMsg;
	} 
	$_SESSION[EW_REPORT_SESSION_MESSAGE] = $msg;
}

// Connect to database
function &ewrpt_Connect() {
	$object =& new mysqlt_driver_ADOConnection();
	if (defined("EW_REPORT_DEBUG_ENABLED"))
		$object->debug = TRUE;
	$object->port = EW_REPORT_CONN_PORT;
	$object->raiseErrorFn = 'ewrpt_ErrorFn';
	$object->Connect(EW_REPORT_CONN_HOST, EW_REPORT_CONN_USER, EW_REPORT_CONN_PASS, EW_REPORT_CONN_DB);
	if (EW_REPORT_MYSQL_CHARSET <> "")
		$object->Execute("SET NAMES '" . EW_REPORT_MYSQL_CHARSET . "'");
	$object->raiseErrorFn = '';
	return $object;
}

// Get script name (function name is prefix with "ew_" only for compatibility with PHPMaker)
function ew_ScriptName() {
	$sn = ewrpt_ServerVar("PHP_SELF");
	if (empty($sn)) $sn = ewrpt_ServerVar("SCRIPT_NAME");
	if (empty($sn)) $sn = ewrpt_ServerVar("ORIG_PATH_INFO");
	if (empty($sn)) $sn = ewrpt_ServerVar("ORIG_SCRIPT_NAME");
	if (empty($sn)) $sn = ewrpt_ServerVar("REQUEST_URI");
	if (empty($sn)) $sn = ewrpt_ServerVar("URL");
	if (empty($sn)) $sn = "UNKNOWN";
	return $sn;
}

// Get server variable by name
function ewrpt_ServerVar($Name) {
	$str = @$_SERVER[$Name];
	if (empty($str)) $str = @$_ENV[$Name];
	return $str;
}

// Strip slashes
function ewrpt_StripSlashes($value) {
	if (!get_magic_quotes_gpc()) return $value;
	if (is_array($value)) { 
		return array_map('ewrpt_StripSlashes', $value);
	} else {
		return stripslashes($value);
	}
}

// Escape chars for XML
function ewrpt_XmlEncode($val) {
	return htmlspecialchars(strval($val));
}

// Encode html
function ewrpt_HtmlEncode($exp) {
	return htmlspecialchars(strval($exp));
}

// View Option Separator
function ewrpt_ViewOptionSeparator($rowcnt) {
	return ", ";
}

// Functions for TEA encryption/decryption
function long2str($v, $w) {
	$len = count($v);
	$s = array();
	for ($i = 0; $i < $len; $i++)
	{
		$s[$i] = pack("V", $v[$i]);
	}
	if ($w) {
		return substr(join('', $s), 0, $v[$len - 1]);
	}	else {
		return join('', $s);
	}
}

function str2long($s, $w) {
	$v = unpack("V*", $s. str_repeat("\0", (4 - strlen($s) % 4) & 3));
	$v = array_values($v);
	if ($w) {
		$v[count($v)] = strlen($s);
	}
	return $v;
}

function TEAencrypt($str, $key) {
	if ($str == "") {
		return "";
	}
	$v = str2long($str, true);
	$k = str2long($key, false);
	$cntk = count($k);
	if ($cntk < 4) {
		for ($i = $cntk; $i < 4; $i++) {
			$k[$i] = 0;
		}
	}
	$n = count($v) - 1;
	$z = $v[$n];
	$y = $v[0];
	$delta = 0x9E3779B9;
	$q = floor(6 + 52 / ($n + 1));
	$sum = 0;
	while (0 < $q--) {
		$sum = int32($sum + $delta);
		$e = $sum >> 2 & 3;
		for ($p = 0; $p < $n; $p++) {
			$y = $v[$p + 1];
			$mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
			$z = $v[$p] = int32($v[$p] + $mx);
		}
		$y = $v[0];
		$mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
		$z = $v[$n] = int32($v[$n] + $mx);
	}
	return ewrpt_UrlEncode(long2str($v, false));
}

function TEAdecrypt($str, $key) {
	$str = ewrpt_UrlDecode($str);
	if ($str == "") {
		return "";
	}
	$v = str2long($str, false);
	$k = str2long($key, false);
	$cntk = count($k);
	if ($cntk < 4) {
		for ($i = $cntk; $i < 4; $i++) {
			$k[$i] = 0;
		}
	}
	$n = count($v) - 1;
	$z = $v[$n];
	$y = $v[0];
	$delta = 0x9E3779B9;
	$q = floor(6 + 52 / ($n + 1));
	$sum = int32($q * $delta);
	while ($sum != 0) {
		$e = $sum >> 2 & 3;
		for ($p = $n; $p > 0; $p--) {
			$z = $v[$p - 1];
			$mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
			$y = $v[$p] = int32($v[$p] - $mx);
		}
		$z = $v[$n];
		$mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
		$y = $v[0] = int32($v[0] - $mx);
		$sum = int32($sum - $delta);
	}
	return long2str($v, true);
}

function int32($n) {
	while ($n >= 2147483648) $n -= 4294967296;
	while ($n <= -2147483649) $n += 4294967296;
	return (int)$n;
}

function ewrpt_UrlEncode($string) {
	$data = base64_encode($string);
	return str_replace(array('+','/','='), array('-','_','.'), $data);
}

function ewrpt_UrlDecode($string) {
	$data = str_replace(array('-','_','.'), array('+','/','='), $string);
	return base64_decode($data);
}

// display elapsed time (in seconds)
function ewrpt_calcElapsedTime($time) {
	$endtime = ewrpt_microtime();
	return ('page processing time: ' . ($endtime - $time) . " seconds");
}

// return microtime in floating point
function ewrpt_microtime() {
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

/**
 * Pager item class
 */

class cPagerItem {
	var $Start;
	var $Text;
	var $Enabled;
}

/**
 * Numeric pager class
 */

class cNumericPager {
	var $Items = array();
	var $Count, $FromIndex, $ToIndex, $RecordCount, $PageSize, $Range;
	var $FirstButton, $PrevButton, $NextButton, $LastButton;
	var $ButtonCount = 0;
	var $Visible = TRUE;

	function cNumericPager($StartRec, $DisplayRecs, $TotalRecs, $RecRange)
	{
		$this->FirstButton = new cPagerItem;
		$this->PrevButton = new cPagerItem;
		$this->NextButton = new cPagerItem;
		$this->LastButton = new cPagerItem;
		$this->FromIndex = intval($StartRec);
		$this->PageSize = intval($DisplayRecs);
		$this->RecordCount = intval($TotalRecs);
		$this->Range = intval($RecRange);
		if ($this->PageSize == 0) return;
		if ($this->FromIndex > $this->RecordCount)
			$this->FromIndex = $this->RecordCount;
		$this->ToIndex = $this->FromIndex + $this->PageSize - 1;
		if ($this->ToIndex > $this->RecordCount)
			$this->ToIndex = $this->RecordCount;

		// setup
		$this->SetupNumericPager();

		// update button count
		if ($this->FirstButton->Enabled) $this->ButtonCount++;
		if ($this->PrevButton->Enabled) $this->ButtonCount++;
		if ($this->NextButton->Enabled) $this->ButtonCount++;
		if ($this->LastButton->Enabled) $this->ButtonCount++;
		$this->ButtonCount += count($this->Items);
	}

	// Add pager item
	function AddPagerItem($StartIndex, $Text, $Enabled)
	{
		$Item = new cPagerItem;
		$Item->Start = $StartIndex;
		$Item->Text = $Text;
		$Item->Enabled = $Enabled;
		$this->Items[] = $Item;
	}

	// Setup pager items
	function SetupNumericPager()
	{
		if ($this->RecordCount > $this->PageSize) {
			$Eof = ($this->RecordCount < ($this->FromIndex + $this->PageSize));
			$HasPrev = ($this->FromIndex > 1);

			// First Button
			$TempIndex = 1;
			$this->FirstButton->Start = $TempIndex;
			$this->FirstButton->Enabled = ($this->FromIndex > $TempIndex);

			// Prev Button
			$TempIndex = $this->FromIndex - $this->PageSize;
			if ($TempIndex < 1) $TempIndex = 1;
			$this->PrevButton->Start = $TempIndex;
			$this->PrevButton->Enabled = $HasPrev;

			// Page links
			if ($HasPrev || !$Eof) {
				$x = 1;
				$y = 1;
				$dx1 = intval(($this->FromIndex-1)/($this->PageSize*$this->Range))*$this->PageSize*$this->Range + 1;
				$dy1 = intval(($this->FromIndex-1)/($this->PageSize*$this->Range))*$this->Range + 1;
				if (($dx1+$this->PageSize*$this->Range-1) > $this->RecordCount) {
					$dx2 = intval($this->RecordCount/$this->PageSize)*$this->PageSize + 1;
					$dy2 = intval($this->RecordCount/$this->PageSize) + 1;
				} else {
					$dx2 = $dx1 + $this->PageSize*$this->Range - 1;
					$dy2 = $dy1 + $this->Range - 1;
				}
				while ($x <= $this->RecordCount) {
					if ($x >= $dx1 && $x <= $dx2) {
						$this->AddPagerItem($x, $y, $this->FromIndex<>$x);
						$x += $this->PageSize;
						$y++;
					} elseif ($x >= ($dx1-$this->PageSize*$this->Range) && $x <= ($dx2+$this->PageSize*$this->Range)) {
						if ($x+$this->Range*$this->PageSize < $this->RecordCount) {
							$this->AddPagerItem($x, $y . "-" . ($y+$this->Range-1), TRUE);
						} else {
							$ny = intval(($this->RecordCount-1)/$this->PageSize) + 1;
							if ($ny == $y) {
								$this->AddPagerItem($x, $y, TRUE);
							} else {
								$this->AddPagerItem($x, $y . "-" . $ny, TRUE);
							}
						}
						$x += $this->Range*$this->PageSize;
						$y += $this->Range;
					} else {
						$x += $this->Range*$this->PageSize;
						$y += $this->Range;
					}
				}
			}

			// Next Button
			$TempIndex = $this->FromIndex + $this->PageSize;
			$this->NextButton->Start = $TempIndex;
			$this->NextButton->Enabled = !$Eof;

			// Last Button
			$TempIndex = intval(($this->RecordCount-1)/$this->PageSize)*$this->PageSize + 1;
			$this->LastButton->Start = $TempIndex;
			$this->LastButton->Enabled = ($this->FromIndex < $TempIndex);
		}
	}
}

/**
 * PrevNext pager class
 */

class cPrevNextPager {
	var $FirstButton, $PrevButton, $NextButton, $LastButton;
	var $CurrentPage, $PageCount, $FromIndex, $ToIndex, $RecordCount;
	var $Visible = TRUE;

	function cPrevNextPager($StartRec, $DisplayRecs, $TotalRecs)
	{
		$this->FirstButton = new cPagerItem;
		$this->PrevButton = new cPagerItem;
		$this->NextButton = new cPagerItem;
		$this->LastButton = new cPagerItem;
		$this->FromIndex = intval($StartRec);
		$this->PageSize = intval($DisplayRecs);
		$this->RecordCount = intval($TotalRecs);
		if ($this->PageSize == 0) return;
		$this->CurrentPage = intval(($this->FromIndex-1)/$this->PageSize) + 1;
		$this->PageCount = intval(($this->RecordCount-1)/$this->PageSize) + 1;
		if ($this->FromIndex > $this->RecordCount)
			$this->FromIndex = $this->RecordCount;
		$this->ToIndex = $this->FromIndex + $this->PageSize - 1;
		if ($this->ToIndex > $this->RecordCount)
			$this->ToIndex = $this->RecordCount;

		// First Button
		$TempIndex = 1;
		$this->FirstButton->Start = $TempIndex;
		$this->FirstButton->Enabled = ($TempIndex <> $this->FromIndex);

		// Prev Button
		$TempIndex = $this->FromIndex - $this->PageSize;
		if ($TempIndex < 1) $TempIndex = 1;
		$this->PrevButton->Start = $TempIndex;
		$this->PrevButton->Enabled = ($TempIndex <> $this->FromIndex);

		// Next Button
		$TempIndex = $this->FromIndex + $this->PageSize;
		if ($TempIndex > $this->RecordCount)
			$TempIndex = $this->FromIndex;
		$this->NextButton->Start = $TempIndex;
		$this->NextButton->Enabled = ($TempIndex <> $this->FromIndex);

		// Last Button
		$TempIndex = intval(($this->RecordCount-1)/$this->PageSize)*$this->PageSize + 1;
		$this->LastButton->Start = $TempIndex;
		$this->LastButton->Enabled = ($TempIndex <> $this->FromIndex);
  }
}
?>
