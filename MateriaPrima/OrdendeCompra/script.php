<head> 
<?php require_once('../../Connections/basepangloria.php'); 
mysql_select_db($database_basepangloria, $basepangloria);
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Documento sin título</title> 

<?php  
// consulto la el ultimo numero de orden emitida, en este caso el encabezado, y lo ordeno de forma desendente
$query_ulencado = "SELECT IDORDEN FROM TRNENCAORDCOMPRA ORDER BY IDORDEN DESC";
$ulencado = mysql_query($query_ulencado, $basepangloria) or die(mysql_error());
$row_ulencado = mysql_fetch_assoc($ulencado);
//verificamos que se marcara al menos 1 checkbox 
echo '<pre>';
echo '<p>Se guardaron los siguientes registros:</p>';
echo '<p>__________________________________________________</p>';
if (isset($_POST['very'])) { 
     foreach($_POST['very'] as $idMatPrima) { 
	 			$sql1="SELECT * FROM TRNDETALLECOTIZACION where IDDETALLE = '$idMatPrima'";
				$rs1=mysql_query($sql1);
				$fill = mysql_fetch_array($rs1);
				mysql_query("INSERT INTO TRNDETALLEORDENCOMPRA (IDORDEN, IDMATPRIMA, IDUNIDAD, CANTPRODUCTO, PRECIOUNITARIO) VALUES ('".$row_ulencado['IDORDEN']."','".$fill['IDMATPRIMA']."','".$fill['IDUNIDAD']."','".$fill['CANTPRODUCTO']."','".$fill['PRECIOUNITARIO']."' )") or die(mysql_error());
			   echo '<p>Detalle de Entrada: '.$idMatPrima.'</p>';
			   echo '<p>Canitdad de Producto: '.$fill['CANTPRODUCTO'].'</p>';
			   echo '<p>Materia Prima: '.$fill['IDMATPRIMA'].'</p>';
			   echo '<p>Unidad de Medida: '.$fill['IDUNIDAD'].'</p>';
			   echo '<p>Canidad: '.$fill['CANTPRODUCTO'].'</p>';
			   echo '<p>Precio Unitario: '.$fill['PRECIOUNITARIO'].'</p>';
			   echo '<p>+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++</p>';
     } 
}?> 
</head> 
 
<body> 
</body> 
</html>