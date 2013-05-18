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

mysql_select_db($database_basepangloria, $basepangloria);
$query_ultimaorden = "SELECT IDORDEN FROM TRNENCAORDCOMPRA ORDER BY IDORDEN DESC";
$ultimaorden = mysql_query($query_ultimaorden, $basepangloria) or die(mysql_error());
$row_ultimaorden = mysql_fetch_assoc($ultimaorden);
$totalRows_ultimaorden = mysql_num_rows($ultimaorden);

mysql_select_db($database_basepangloria, $basepangloria);
$query_carcoti = "SELECT IDENCABEZADO, FECHACOTIZACION FROM TRNCABEZACOTIZACION ORDER BY FECHACOTIZACION DESC";
$carcoti = mysql_query($query_carcoti, $basepangloria) or die(mysql_error());
$row_carcoti = mysql_fetch_assoc($carcoti);
$totalRows_carcoti = mysql_num_rows($carcoti);

$colname_concoti = "-1";
if (isset($_GET['varia'])) {
  $colname_concoti = $_GET['varia'];
}
mysql_select_db($database_basepangloria, $basepangloria);
$query_concoti = sprintf("SELECT IDDETALLE, IDMATPRIMA, IDUNIDAD, CANTPRODUCTO, PRECIOUNITARIO FROM TRNDETALLECOTIZACION WHERE IDENCABEZADO = %s", GetSQLValueString($colname_concoti, "int"));
$concoti = mysql_query($query_concoti, $basepangloria) or die(mysql_error());
$row_concoti = mysql_fetch_assoc($concoti);
$totalRows_concoti = mysql_num_rows($concoti);

mysql_select_db($database_basepangloria, $basepangloria);
$query_ULTIMOENCA = "SELECT * FROM TRNENCAORDCOMPRA ORDER BY IDORDEN DESC";
$ULTIMOENCA = mysql_query($query_ULTIMOENCA, $basepangloria) or die(mysql_error());
$row_ULTIMOENCA = mysql_fetch_assoc($ULTIMOENCA);
$totalRows_ULTIMOENCA = mysql_num_rows($ULTIMOENCA);

$maxRows_concoti = 10;
$pageNum_concoti = 0;
if (isset($_GET['pageNum_concoti'])) {
  $pageNum_concoti = $_GET['pageNum_concoti'];
}
$startRow_concoti = $pageNum_concoti * $maxRows_concoti;

$colname_concoti = "-1";
if (isset($_GET['coti'])) {
  $colname_concoti = $_GET['coti'];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript">
 function Abrir_ventana (pagina) {
 var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
 window.open(pagina,"",opciones);
 }
 </script>
<link href="../../css/forms.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="820" border="0">
  <tr>
    <td align="center">Ingreso de Orden de Compra</td>
  </tr>
  <tr>
    <td><table width="820" border="0">
      <tr>
        <td width="158" class="etifactu"><span class="etifactu">Codigo de Orden de Compra</span></td>
        <td width="309" class="retorno"><?php echo $row_ULTIMOENCA['IDORDEN']; ?></td>
        <td width="60" class="etifactu">Cotizacion que genera</td>
        <td width="275" class="retorno"><?php echo $row_ULTIMOENCA['NUMEROCOTIZACIO']; ?></td>
      </tr>
      <tr>
        <td class="etifactu">Fecha de Emision</td>
        <td class="retorno"><?php echo $row_ULTIMOENCA['FECHAEMISIONORDCOM']; ?></td>
        <td class="etifactu">Fecha de Entrega</td>
        <td class="retorno"><?php echo $row_ULTIMOENCA['FECHAENTREGA']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><a href="compras.php" target="popup" onClick="window.open(this.href, this.target, 'width=810,height=285,resizable = 0'); return false;">Nuevo Encabezado</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="script.php">
      <table width="820" border="1" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="7" bgcolor="#999999"><p>Cargar detalle desde la Cotizacion:
              <label for="carcoti"></label>
              <select name="carcoti" id="carcoti" onchange="window.location.href='concotiza.php?varia='+document.getElementById(this.id).value ;">
                <?php
do {  
?>
                <option value="<?php echo $row_carcoti['IDENCABEZADO']?>"><?php echo $row_carcoti['IDENCABEZADO']?>---<?php echo $row_carcoti['FECHACOTIZACION']?></option>
                <?php
} while ($row_carcoti = mysql_fetch_assoc($carcoti));
  $rows = mysql_num_rows($carcoti);
  if($rows > 0) {
      mysql_data_seek($carcoti, 0);
	  $row_carcoti = mysql_fetch_assoc($carcoti);
  }
?>
              </select>
            </p></td>
          </tr>
        <tr>
          <td width="166" bgcolor="#999999">Agregar</td>
          <td width="166" bgcolor="#999999">Numero Referencial</td>
          <td width="166" bgcolor="#999999">Materia Prima</td>
          <td width="144" bgcolor="#999999">Unidad de Medida</td>
          <td width="195" bgcolor="#999999">Cantida de Producto</td>
          <td width="208" bgcolor="#999999">Precio Unitario</td>
          <td width="208" bgcolor="#999999"> Costo</td>
        </tr>
        <?php do { ?>
        <?php $conuniconcoti = $row_concoti['IDUNIDAD'];
$query_Recordset1 = sprintf("SELECT TIPOUNIDAD FROM CATUNIDADES WHERE IDUNIDAD = '$conuniconcoti'", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $basepangloria) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$conmatconcoti = $row_concoti['IDMATPRIMA']; 
$query_nommateria = sprintf("SELECT DESCRIPCION FROM CATMATERIAPRIMA WHERE IDMATPRIMA = '$conmatconcoti'", GetSQLValueString($colname_nommateria, "int"));
$nommateria = mysql_query($query_nommateria, $basepangloria) or die(mysql_error());
$row_nommateria = mysql_fetch_assoc($nommateria);
$totalRows_nommateria = mysql_num_rows($nommateria);

?>
        <tr>
          <td><input name="very[]" type="checkbox" id="very[]" value="<?php echo $row_concoti['IDDETALLE']; ?>" checked="checked" /></td>
          <td><?php echo $row_concoti['IDDETALLE']; ?></td>
          <td><?php echo $row_nommateria['DESCRIPCION']; ?></td>
          <td><?php echo $row_Recordset1['TIPOUNIDAD']; ?></td>
          <td><?php echo $row_concoti['CANTPRODUCTO']; ?></td>
          <td><?php echo $row_concoti['PRECIOUNITARIO']; ?></td>
          <td><?php echo $row_concoti['PRECIOUNITARIO']*$row_concoti['CANTPRODUCTO'] ; ?></td>
        </tr>
        <?php } while ($row_concoti = mysql_fetch_assoc($concoti)); ?>
      </table>
      <table width="820" border="0">
        <tr>
          <td align="right" bgcolor="#CCCCCC">Total de la Compra</td>
          <td bgcolor="#CCCCCC"><?php 
	$result = mysql_query("Select sum(CANTPRODUCTO * PRECIOUNITARIO ) as total from TRNDETALLECOTIZACION where IDENCABEZADO = " . $_GET['varia']);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	echo $row['total'];
	 ?></td>
        </tr>
      </table>
      <input type="submit" name="enviar" id="enviar" value="Enviar"  />
    </form></td>
  </tr>
</table>
<p class="etifactu"><span class="retorno"></span></p>
</body>
</html>
<?php
mysql_free_result($ultimaorden);

mysql_free_result($carcoti);

mysql_free_result($concoti);

mysql_free_result($ULTIMOENCA);
?>
