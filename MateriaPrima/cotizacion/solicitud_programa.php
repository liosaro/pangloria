<?php
require_once('../../Connections/basepangloria.php');

 $q_prove = "SELECT * FROM CATPROVEEDOR where ELIMIN = 0";
   mysql_select_db($database_basepangloria, $basepangloria);
   $res4 = mysql_query($q_prove, $basepangloria) or die(mysql_error());
   //$row2 = mysql_fetch_assoc($res2);

   $cmb_prove = '<select id="proveedor"  name="proveedor">';
   while ($fila = mysql_fetch_assoc($res4)) {
        $cmb_prove .= '<option value="'.$fila['CORREOPROVEEDOR'].'">'.$fila['NOMBREPROVEEDOR'].'</option>';
   }
   $cmb_prove .= '</select>';



 ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>Formulario X</title>
</head>


<body>

        <div id="formulario">
       <?php
  $fecha_hoy = date('d/m/y');

 $usu = '';

 $usu  = strtoupper($_SESSION['login_usuario']);   // me dice quien esta conectado!




$numsol = $nummax + 1 ;

$datos = '<form id="sole" name="sole" enctype="multipart/form-data" action="enviar.php" method="post">
     <table width="753" border="0" align="center">
      <tr>
        <th width="364" scope="col"><div align="center"><img src="logo.png" alt="" /></div></th>
        <th width="803" scope="col"><div align="center">
          <p><font color="#006699" size="6" face="Calibri"> SOLICITUD DE COTIZACION PAN GLORIA</font></p>
          </div></th>
      </tr>
      <tr>
        <th colspan="2" scope="col"><div align="left"><font color="#FF6600" size="+4">_________________________________</font></div></th>
      </tr>
    </table>
    <div align="left"></div>
    <table border = "0" width="753" align="center">
      <tr>
      <td colspan="1" align="left" valign="top" height="65px" ><font face="calibri" color="#808080" >No. Solicitud: &nbsp; </font><big><font font face="Calibri" color="#808080"> '.$numsol.' </font></big><br></td>
        <input type="hidden" name="numsol" id="numsol" face="calibri" color="#808080" value="'.$numsol.'">
      <td colspan="1" align="right" valign="top" height="65px" ><font face="calibri" color="#808080" >Fecha: </font><big><font font face="Calibri" color="#808080"> '.$fecha_hoy.' </fecha></big><br></td>
      </tr>
      <tr>
        <td width="315"><font face="calibri" color="#808080" >Enviado a:</font>:</td>
        <td>'.$cmb_prove.'</td>
      </tr>
      <tr>
        <td><font face="calibri" color="#808080">Solicitante</font>:</td>
        <td><input type="text" name="solicitante" size="50" face="calibri" value="'.$usu.'"  /></td>
      </tr>
      <tr>
        <td><font face="calibri" color="#808080">Material Requerido</font>:</td>
        <td><font face="calibri"><input type="text" name="requerimiento" size="50"/></font></td>
      </tr>
      <tr>
        <td><font face="calibri" color="#808080">Descripcion</font>:</td>
        <td><font face="calibri"><textarea rows="4" name = "descripcion" cols="37" ></textarea></font></td>
      </tr>
      <tr>
        <td><font face="calibri" color="#808080">Detalle Solicitado</font>:</td>
        <td><font face="calibri"><textarea rows="4" name = "detalles" cols="37" ></textarea></font></td>
      </tr>
      <tr>
        <td><font face="calibri" color="#808080">Usuarios/Departamentos relacionados</font>:</td>
        <td><input type="text" name="usuarios" size="50" face="calibri" /></td>
      </tr>
      <tr>
        <td><font face="calibri" color="#808080">Comentarios</font>:</td>
        <td><textarea rows="4" name = "comentarios" cols="37" ></textarea></td>
      </tr>
       <tr>
        <td><font face="calibri" color="#808080">Definir Prioridad</font>:</td>
        <td><select name="prioridad" value="options"
          <option selected="selected" >Seleccione...</option>
          <option >Urgente</option>
          <option >Normal</option>
          <option >Bajo</option>
        </select>        </td>
      </tr>
     <tr>
        <td><font face="calibri" color="#808080">Archivo de Referencia</font>:</td>
        <td><img src="attach.png" width="40" height="40" />
        <input type="file" name="fileToUpload"  id="fileToUpload" size="28">

      </td>
           </tr>
             </table>
     <div align="center"><p><font color="#999999" face="Calibri" >Enviar Solicitud</font><br><input type="image" name="enviar" src="sendemail.png"></p>
     </div>

  </form>';

  echo ($datos);


          ?>
        </div>

</body>
</html>
