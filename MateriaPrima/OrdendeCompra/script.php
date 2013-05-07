<head> 
<?php require_once('../../Connections/basepangloria.php'); 
mysql_select_db($database_basepangloria, $basepangloria);
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Documento sin título</title> 
<?php  

 

//verificamos que se marcara al menos 1 checkbox 
echo '<pre>';
if (isset($_POST['very'])) { 
     foreach($_POST['very'] as $idMatPrima) { 
	 			$sql1="SELECT * FROM TRNDETALLECOTIZACION where IDDETALLE = '$idMatPrima'";
				$rs1=mysql_query($sql1);
				$fill = mysql_fetch_array($rs1);
	 	       echo '<p>Detalle de Entrada: '.$idMatPrima.'</p>';
			   echo '<p>Canitdad de Producto: '.$fill['CANTPRODUCTO'].'</p>';
			   echo '<p>Materia Prima: '.$fill['IDMATPRIMA'].'</p>';
			   echo '<p>Precio Unitario: '.$fill['PRECIOUNITARIO'].'</p>';
			   echo '<p>++++++++++++++++++++++++++++++++++++++++++++++++++++++++++</p>';
     } 
}?> 
</head> 
 
<body> 
</body> 
</html>