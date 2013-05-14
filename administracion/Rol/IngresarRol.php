<?php require_once('../../Connections/basepangloria.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO CATROL (IDROL, DESCRIPCION) VALUES (%s, %s)",
                       GetSQLValueString($_POST['IDROL'], "int"),
                       GetSQLValueString($_POST['DESCRIPCION'], "text"));

  mysql_select_db($database_basepangloria, $basepangloria);
  $Result1 = mysql_query($insertSQL, $basepangloria) or die(mysql_error());
}

$maxRows_consIngreRol = 10;
$pageNum_consIngreRol = 0;
if (isset($_GET['pageNum_consIngreRol'])) {
  $pageNum_consIngreRol = $_GET['pageNum_consIngreRol'];
}
$startRow_consIngreRol = $pageNum_consIngreRol * $maxRows_consIngreRol;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consIngreRol = "SELECT * FROM CATROL ORDER BY IDROL DESC";
$query_limit_consIngreRol = sprintf("%s LIMIT %d, %d", $query_consIngreRol, $startRow_consIngreRol, $maxRows_consIngreRol);
$consIngreRol = mysql_query($query_limit_consIngreRol, $basepangloria) or die(mysql_error());
$row_consIngreRol = mysql_fetch_assoc($consIngreRol);

if (isset($_GET['totalRows_consIngreRol'])) {
  $totalRows_consIngreRol = $_GET['totalRows_consIngreRol'];
} else {
  $all_consIngreRol = mysql_query($query_consIngreRol);
  $totalRows_consIngreRol = mysql_num_rows($all_consIngreRol);
}
$totalPages_consIngreRol = ceil($totalRows_consIngreRol/$maxRows_consIngreRol)-1;

$queryString_consIngreRol = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consIngreRol") == false && 
        stristr($param, "totalRows_consIngreRol") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consIngreRol = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consIngreRol = sprintf("&totalRows_consIngreRol=%d%s", $totalRows_consIngreRol, $queryString_consIngreRol);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<table width="820" border="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
    </form>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
        <table width="100%" border="0">
          <tr>
            <td colspan="4" align="center" bgcolor="#999999"><h1>Ingresar Rol</h1></td>
          </tr>
          <tr>
            <td>Id Rol:</td>
            <td><input name="IDROL" type="text" disabled="disabled" value="" size="32" /></td>
            <td>DESCRIPCION:</td>
            <td><input type="text" name="DESCRIPCION" value="" size="32" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" align="center"><input type="submit" value="Insertar registro" /></td>
          </tr>
        </table>
        <p>
          <input type="hidden" name="MM_insert" value="form2" />
        </p>
        <p>          <a href="<?php printf("%s?pageNum_consIngreRol=%d%s", $currentPage, 0, $queryString_consIngreRol); ?>"><img src="../../imagenes/icono/Back-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consIngreRol=%d%s", $currentPage, max(0, $pageNum_consIngreRol - 1), $queryString_consIngreRol); ?>"><img src="../../imagenes/icono/Backward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consIngreRol=%d%s", $currentPage, min($totalPages_consIngreRol, $pageNum_consIngreRol + 1), $queryString_consIngreRol); ?>"><img src="../../imagenes/icono/Forward-32.png" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consIngreRol=%d%s", $currentPage, $totalPages_consIngreRol, $queryString_consIngreRol); ?>"><img src="../../imagenes/icono/Next-32.png" width="32" height="32" /></a></p>
        <table border="1">
          <tr>
            <td>IDROL</td>
            <td>DESCRIPCION</td>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_consIngreRol['IDROL']; ?></td>
              <td><?php echo $row_consIngreRol['DESCRIPCION']; ?></td>
            </tr>
            <?php } while ($row_consIngreRol = mysql_fetch_assoc($consIngreRol)); ?>
</table>
      </form></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($consIngreRol);
?>
