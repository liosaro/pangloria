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

$maxRows_consultacargo = 5;
$pageNum_consultacargo = 0;
if (isset($_GET['pageNum_consultacargo'])) {
  $pageNum_consultacargo = $_GET['pageNum_consultacargo'];
}
$startRow_consultacargo = $pageNum_consultacargo * $maxRows_consultacargo;

mysql_select_db($database_basepangloria, $basepangloria);
$query_consultacargo = "SELECT * FROM CATCARGO ORDER BY IDCARGO DESC";
$query_limit_consultacargo = sprintf("%s LIMIT %d, %d", $query_consultacargo, $startRow_consultacargo, $maxRows_consultacargo);
$consultacargo = mysql_query($query_limit_consultacargo, $basepangloria) or die(mysql_error());
$row_consultacargo = mysql_fetch_assoc($consultacargo);

if (isset($_GET['totalRows_consultacargo'])) {
  $totalRows_consultacargo = $_GET['totalRows_consultacargo'];
} else {
  $all_consultacargo = mysql_query($query_consultacargo);
  $totalRows_consultacargo = mysql_num_rows($all_consultacargo);
}
$totalPages_consultacargo = ceil($totalRows_consultacargo/$maxRows_consultacargo)-1;

$queryString_consultacargo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultacargo") == false && 
        stristr($param, "totalRows_consultacargo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultacargo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultacargo = sprintf("&totalRows_consultacargo=%d%s", $totalRows_consultacargo, $queryString_consultacargo);

$queryString_consultacargo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consultacargo") == false && 
        stristr($param, "totalRows_consultacargo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consultacargo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consultacargo = sprintf("&totalRows_consultacargo=%d%s", $totalRows_consultacargo, $queryString_consultacargo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Control de Empleados</title>
<link href="../../style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="content" id="contenidoadminphp2">
  <table width="844" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="844" align="center"><div class="cont">
        <form action="filtromodificacargo.php" method="post" name="envioproductomodifica" target="modiprodu" id="envioproductomodifica">
          <table width="1026" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="800" colspan="6" align="left">&nbsp;
                <iframe src="modificadorcargo.php" name="modiprodu" width="830" height="250" align="middle" scrolling="auto" frameborder="0" id="modiprodu"></iframe>
                <p><a href="<?php printf("%s?pageNum_consultacargo=%d%s", $currentPage, 0, $queryString_consultacargo); ?>"><img src="../../imagenes/icono/Back-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultacargo=%d%s", $currentPage, max(0, $pageNum_consultacargo - 1), $queryString_consultacargo); ?>"><img src="../../imagenes/icono/Backward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultacargo=%d%s", $currentPage, min($totalPages_consultacargo, $pageNum_consultacargo + 1), $queryString_consultacargo); ?>"><img src="../../imagenes/icono/Forward-32.png" alt="" width="32" height="32" /></a><a href="<?php printf("%s?pageNum_consultacargo=%d%s", $currentPage, $totalPages_consultacargo, $queryString_consultacargo); ?>"><img src="../../imagenes/icono/Next-32.png" alt="" width="32" height="32" /></a></p>
                <table width="830" border="1">
                  <tr>
                    <td colspan="3">&nbsp;</td>
                    </tr>
                  <tr>
                    <td>Modificar</td>
                    <td>Id del Cargo</td>
                    <td>Nombre del Cargo</td>
                    </tr>
                  <?php do { ?>
                    <tr>
                      <td><a href="modificadorcargo.php?root=<?php echo $row_consultacargo['IDCARGO']; ?>" target="modiprodu">Modificar</a></td>
                      <td><?php echo $row_consultacargo['IDCARGO']; ?></td>
                      <td><?php echo $row_consultacargo['CARGO']; ?></td>
                      </tr>
                    <?php } while ($row_consultacargo = mysql_fetch_assoc($consultacargo)); ?>
                </table></td>
            </tr>
            </table>
        </form>
      </div></td>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($consultacargo);

?>
