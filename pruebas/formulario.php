<? 
require_once('../Connections/basepangloria.php');
mysql_select_db($database_basepangloria, $basepangloria); 
// Realizar la conexión a la BD .. Seleccionar la BD a usar. 

// Ejecutar la consulta para obtener los datos de la BD. 
$resultado=mysql_query("SELECT IDMATPRIMA, IDUNIDAD, CANTPRODUCTO, PRECIOUNITARIO FROM TRNDETALLECOTIZACION"); 

// Se inicial el formulario 
echo "<form action=\"procesar.php\" method=\"post\"> \n"; 

// Extraemos y componemos los checbox dinámicos de los datos de nuestra tabla de la BD. 
while ($row = mysql_fetch_array($resultado)){ 
  echo "<input type=\"checkbox\" name=\"seleccion[]\" value=\"".$row['IDMATPRIMA']."\">".$row['CANTPRODUCTO']."<br>"; 
} 

// Cerramos el formulario y ponemos nuestro botón de Submit. 
echo "<input type=\"submit\" name=\"Submit\" value=\"Enviar\">"; 
echo "</form>"; 
?>