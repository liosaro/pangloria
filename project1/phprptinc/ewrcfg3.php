<?php

// PHP Report Maker 3.0 - configuration
// Database connection

define("EW_REPORT_CONN_HOST", "sql.byethost16.org", TRUE);
define("EW_REPORT_CONN_PORT", 3306, TRUE);
define("EW_REPORT_CONN_USER", "liosarpc", TRUE);
define("EW_REPORT_CONN_PASS", "proview2010$", TRUE);
define("EW_REPORT_CONN_DB", "liosarpc_pangloria", TRUE);

// Debug
//define("EW_REPORT_DEBUG_ENABLED", TRUE, TRUE); // Uncomment to debug SQL
//define("EW_REPORT_DEBUG_CHART_ENABLED", TRUE, TRUE); // Uncomment to debug chart XML
// General

define("EW_REPORT_IS_WINDOWS", (strtolower(substr(PHP_OS, 0, 3)) === 'win'), TRUE); // Is Windows OS
define("EW_REPORT_IS_PHP5", (phpversion() >= "5.0.0"), TRUE); // Is PHP5
define("EW_REPORT_PATH_DELIMITER", ((EW_REPORT_IS_WINDOWS) ? "\\" : "/"), TRUE); // Physical path delimiter
define("EW_REPORT_DEFAULT_DATE_FORMAT", "yyyy-mm-dd", TRUE); // Default date format
define("EW_REPORT_DATE_SEPARATOR", "-", TRUE); // Date separator
define("EW_REPORT_RANDOM_KEY", '&a1iT2C_1kX3sZ05', TRUE); // Random key for encryption
define("EW_REPORT_CHART_SCRIPT", 'ewchartfcf.php', TRUE);
define("EW_REPORT_CHART_WIDTH", 550, TRUE);
define("EW_REPORT_CHART_HEIGHT", 440, TRUE);
define("EW_REPORT_CHART_ALIGN", "middle", TRUE);
define("EW_REPORT_CHART_SHOW_BLANK_SERIES", FALSE, TRUE); // Show blank series

/**
 * Chart data encoding
 * Note: If you use non English languages, you need to set the encoding for
 * charting. Make sure your encoding is supported by your PHP and either
 * iconv functions or multibyte string functions are enabled. See PHP manual
 * for details
 * eg. define("EW_REPORT_ENCODING", "ISO-8859-1", true);
 */
define("EW_REPORT_ENCODING", "ISO-8859-1", TRUE); // enter your encoding here

/**
 * MySQL charset (for SET NAMES statement, not used by default)
 * Note: Read http://dev.mysql.com/doc/refman/5.0/en/charset-connection.html
 * before using this setting.
 */
define("EW_REPORT_MYSQL_CHARSET", "", TRUE);

/**
 * Password (MD5 and case-sensitivity)
 * Note: If you enable MD5 password, make sure that the passwords in your
 * user table are stored as MD5 hash (32-character hexadecimal number) of the
 * clear text password. If you also use case-insensitive password, convert the
 * clear text passwords to lower case first before calculating MD5 hash.
 * Otherwise, existing users will not be able to login.
 */
define("EW_REPORT_MD5_PASSWORD", FALSE, TRUE); // Use MD5 password
define("EW_REPORT_CASE_SENSITIVE_PASSWORD", FALSE, TRUE); // Case-sensitive password

// Database
define("EW_REPORT_DBMSNAME", "MySQL", ""); // MySQL
define("EW_REPORT_IS_MSACCESS", FALSE, TRUE); // Access (Reserved, NOT USED)
define("EW_REPORT_IS_MYSQL", TRUE, TRUE); // MySQL
define("EW_REPORT_DB_QUOTE_START", "`", TRUE);
define("EW_REPORT_DB_QUOTE_END", "`", TRUE);

// Locale (if localeconv returns empty info)
define("DEFAULT_DATE_FORMAT", "yyyy-mm-dd", TRUE);
define("DEFAULT_CURRENCY_SYMBOL", "$", TRUE);
define("DEFAULT_MON_DECIMAL_POINT", ".", TRUE);
define("DEFAULT_MON_THOUSANDS_SEP", ",", TRUE);
define("DEFAULT_POSITIVE_SIGN", "", TRUE);
define("DEFAULT_NEGATIVE_SIGN", "-", TRUE);
define("DEFAULT_FRAC_DIGITS", 2, TRUE);
define("DEFAULT_P_CS_PRECEDES", TRUE, TRUE);
define("DEFAULT_P_SEP_BY_SPACE", FALSE, TRUE);
define("DEFAULT_N_CS_PRECEDES", TRUE, TRUE);
define("DEFAULT_N_SEP_BY_SPACE", FALSE, TRUE);
define("DEFAULT_P_SIGN_POSN", 3, TRUE);
define("DEFAULT_N_SIGN_POSN", 3, TRUE);

// Filter
define("EW_REPORT_NULL_LABEL", "(Null)", TRUE);
define("EW_REPORT_EMPTY_LABEL", "(Empty)", TRUE);
define("EW_REPORT_FILTER_PANEL_OPTION", 2, TRUE); // 1/2/3, 1 = always hide, 2 = always show, 3 = show when filtered

//define("EW_REPORT_SHOW_CURRENT_FILTER", TRUE, TRUE); // Uncomment to show current filter
// Session names

define("EW_REPORT_PROJECT_NAME", "project1", TRUE); // Project Name
define("EW_REPORT_PROJECT_VAR", "project1", TRUE); // Project Name
define("EW_REPORT_SESSION_STATUS", EW_REPORT_PROJECT_VAR . "_status", TRUE); // Login Status
define("EW_REPORT_SESSION_USERNAME", EW_REPORT_SESSION_STATUS . "_UserName", TRUE); // User Name
define("EW_REPORT_SESSION_USERID", EW_REPORT_SESSION_STATUS . "_UserID", TRUE); // User ID
define("EW_REPORT_SESSION_USERLEVEL", EW_REPORT_SESSION_STATUS . "_UserLevel", TRUE); // User Level
define("EW_REPORT_SESSION_PARENT_USERID", EW_REPORT_SESSION_STATUS . "_ParentUserID", TRUE); // Parent User ID
define("EW_REPORT_SESSION_SYSTEM_ADMIN", EW_REPORT_PROJECT_VAR . "_SysAdmin", TRUE); // System Admin
define("EW_REPORT_SESSION_AR_USER_LEVEL", EW_REPORT_PROJECT_NAME . "_arUserLevel", TRUE); // User Level Array
define("EW_REPORT_SESSION_AR_USER_LEVEL_PRIV", EW_REPORT_PROJECT_NAME . "_arUserLevelPriv", TRUE); // User Level Privilege Array

//define("EW_REPORT_SESSION_SECURITY", EW_REPORT_PROJECT_NAME . "_Security", TRUE); // Security Array
define("EW_REPORT_SESSION_MESSAGE", EW_REPORT_PROJECT_VAR . "_Message", TRUE); // System Message

// Hard-coded admin
define("EW_REPORT_ADMIN_USER_NAME", "", TRUE);
define("EW_REPORT_ADMIN_PASSWORD", "", TRUE);

// User admin
define("EW_REPORT_USERNAME_FIELD", "", TRUE);
define("EW_REPORT_PASSWORD_FIELD", "", TRUE);
define("EW_REPORT_USERID_FIELD", "", TRUE);
define("EW_REPORT_PARENT_USERID_FIELD", "", TRUE);
define("EW_REPORT_USERLEVEL_FIELD", "", TRUE);
define("EW_REPORT_LOGIN_SELECT_SQL", "", TRUE);

// User level constants
define("EW_ALLOW_LIST", 8, TRUE); // List
define("EW_ALLOW_REPORT", 8, TRUE); // Report
define("EW_ALLOW_ADMIN", 16, TRUE); // Admin
define("EW_SESSION_USER_LEVEL", EW_REPORT_SESSION_USERLEVEL, TRUE);

// User id constants
define("EW_USER_ID_IS_HIERARCHICAL", TRUE, TRUE); // Hierarchical user id

// Table level constants
define("EW_REPORT_TABLE_PREFIX", "||PHPReportMaker||", TRUE);
define("EW_REPORT_TABLE_GROUP_PER_PAGE", "grpperpage", TRUE);
define("EW_REPORT_TABLE_START_GROUP", "start", TRUE);
define("EW_REPORT_TABLE_CHILD_USER_ID", "childuserid", TRUE);
define("EW_REPORT_TABLE_ORDER_BY", "order", TRUE);
define("EW_REPORT_TABLE_ORDER_BY_TYPE", "ordertype", TRUE);

// Data types
define("EW_REPORT_DATATYPE_NONE", 0, TRUE);
define("EW_REPORT_DATATYPE_NUMBER", 1, TRUE);
define("EW_REPORT_DATATYPE_DATE", 2, TRUE);
define("EW_REPORT_DATATYPE_STRING", 3, TRUE);
define("EW_REPORT_DATATYPE_BOOLEAN", 4, TRUE);
define("EW_REPORT_DATATYPE_MEMO", 5, TRUE);
define("EW_REPORT_DATATYPE_BLOB", 6, TRUE);
define("EW_REPORT_DATATYPE_TIME", 7, TRUE);
define("EW_REPORT_DATATYPE_GUID", 8, TRUE);
define("EW_REPORT_DATATYPE_OTHER", 9, TRUE);

// Empty/Null/Init/all values
define("EW_REPORT_EMPTY_VALUE", "##empty##", TRUE);
define("EW_REPORT_NULL_VALUE", "##null##", TRUE);
define("EW_REPORT_INIT_VALUE", "##init##", TRUE);
define("EW_REPORT_ALL_VALUE", "##all##", TRUE);

// Boolean values for ENUM('Y'/'N') or ENUM(1/0)
define("EW_REPORT_TRUE_STRING", "'Y'", TRUE);
define("EW_REPORT_FALSE_STRING", "'N'", TRUE);

// Month Quarter names
define("EW_REPORT_QUARTER_1", "1st Quarter", TRUE);
define("EW_REPORT_QUARTER_2", "2nd Quarter", TRUE);
define("EW_REPORT_QUARTER_3", "3rd Quarter", TRUE);
define("EW_REPORT_QUARTER_4", "4th Quarter", TRUE);
define("EW_REPORT_MONTH_JAN", "Jan", TRUE);
define("EW_REPORT_MONTH_FEB", "Feb", TRUE);
define("EW_REPORT_MONTH_MAR", "Mar", TRUE);
define("EW_REPORT_MONTH_APR", "Apr", TRUE);
define("EW_REPORT_MONTH_MAY", "May", TRUE);
define("EW_REPORT_MONTH_JUN", "Jun", TRUE);
define("EW_REPORT_MONTH_JUL", "Jul", TRUE);
define("EW_REPORT_MONTH_AUG", "Aug", TRUE);
define("EW_REPORT_MONTH_SEP", "Sep", TRUE);
define("EW_REPORT_MONTH_OCT", "Oct", TRUE);
define("EW_REPORT_MONTH_NOV", "Nov", TRUE);
define("EW_REPORT_MONTH_DEC", "Dec", TRUE);

// Export
define("EW_REPORT_EXPORT_ALL", TRUE, TRUE); // Export all records

// Checkbox and radio button groups
define("EW_REPORT_ITEM_TEMPLATE_CLASSNAME", "ewTemplate", TRUE);
define("EW_REPORT_ITEM_TABLE_CLASSNAME", "ewItemTable", TRUE);
?>
<?php

// Menu
define("EW_REPORT_MENUBAR_VERTICAL_CLASSNAME", "ewMenuBarVertical", TRUE);
define("EW_REPORT_MENUBAR_SUBMENU_CLASSNAME", "", TRUE);
define("EW_REPORT_MENUBAR_RIGHTHOVER_IMAGE", "", TRUE);
?>
