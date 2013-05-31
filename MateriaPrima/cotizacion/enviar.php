
<?php

require_once('class.phpmailer.php');

$departamento        = $_POST["departamento"];
$solicitante         = $_POST["solicitante"];
$programa_propuesto  = $_POST["requerimiento"];
$descripcion         = $_POST["descripcion"];
$detalles            = $_POST["detalles"];
$usuarios            = $_POST["usuarios"];
$comentarios         = $_POST["comentarios"];
$prioridad           = $_POST["prioridad"];
$numsol              = $_POST["numsol"];
//$fileToUpload        = $_POST["fileToUpload"];
#$fileToUpload        = $_FILES["fileToUpload"]["name"];
$hoy = date('d/M/y');



$asunto = 'Nueva Solicitud de Desarrollo'    ;
$mensaje = "
      <html>
      <head>
      <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
      <title>Solicitud</title>
          <style type='text/css'>
          <!--
          .Estilo1 {font-family: Calibri}
          .Estilo3 {
          	font-family: Calibri;
          	font-size: x-large;
          	font-weight: bold;
          	color: #006699;
          }
          .Estilo4 {color: #666666}
      .Estilo5 {
      	color: #CC6633;
      	font-size: 60px;
      }
      .Estilo7 {font-family: Calibri; color: #999999; }
          -->
          </style>
      </head>

<body>
<table width='685' height='384' border='0' bgcolor='#FFFFFF'>
      <tr>
        <td width='170'><img src='logo.png' class='Estilo1' /></td>
        <td colspan='3'><div align='left'><span class='Estilo3'>SOLICITUD DE COTIZACION PAN GLORIA</span></div></td>
      </tr>
      <tr>
        <td colspan='3'><span class='Estilo5'>____________________________</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align='right' class='Estilo4'><span class='Estilo1'>No. de Solicitud</span></div></td>
        <td>&nbsp;</td>
        <td><font face='calibri' color='#333333'><input name='textfield2' type='text' size='50' face='calibri' style='font-family:Calibri' value='".$numsol."' /></font></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align='right' class='Estilo4'><span class='Estilo1'>DEPARTAMENTO</span></div></td>
        <td width='19'>&nbsp;</td>
        <td width='288'><form id='form1' name='form1' method='post' action=''>
          <label>  <font face='calibri' color='#333333'>
          <input name='textfield' type='text' size='50' face='calibri' value='".$departamento."' />  </font>
            </label>
        </form>    </td>
        <td width='16'>&nbsp;</td>
      </tr>
      <tr>
        <td><div align='right' class='Estilo4'><span class='Estilo1'>SOLICITANTE</span></div></td>
        <td>&nbsp;</td>
        <td><font face='calibri' color='#333333'><input name='textfield2' type='text' size='50' face='calibri' style='font-family:Calibri' value='".$solicitante."' /></font></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align='right' class='Estilo4'><span class='Estilo1'>MATERIAL REQUERIDO </span></div></td>
        <td>&nbsp;</td>
        <td><font face='calibri' color='#333333'><input name='textfield3' type='text' size='50' face='calibri' style='font-family:Calibri' value='".$programa_propuesto."'/></font></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align='right' class='Estilo4'><span class='Estilo1'>DESCRIPCION</span></div></td>
        <td>&nbsp;</td>
        <td><font face='calibri' color='#333333'><input name='textfield4' type='text' size='200' face='calibri'  value='".$descripcion."'/></font></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align='right' class='Estilo4'><span class='Estilo1'>DETALLES SOLICITADO</span></div></td>
        <td>&nbsp;</td>
        <td><font face='calibri' color='#333333'><input name='textfield5' type='text' size='200' face='calibri' value='".$detalles."'/></font></td>
      </tr>
      <tr>
        <td><div align='right' class='Estilo4'><span class='Estilo1'>USUARIOS</span></div></td>
        <td>&nbsp;</td>
        <td><font face='calibri' color='#333333'><input name='textfield6' type='text' size='50' face='calibri' value='".$usuarios."' /></font></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align='right' class='Estilo4'><span class='Estilo1'>COMENTARIOS</span></div></td>
        <td>&nbsp;</td>
        <td><font face='calibri' color='#333333'><input name='textfield7' type='text' size='200' face='calibri' value='".$comentarios."'/></font></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align='right' class='Estilo4'><span class='Estilo1'>PRIORIDAD</span></div></td>
        <td>&nbsp;</td>
        <td><font face='calibri' color='#333333'><input name='textfield32' type='text' size='50' face='calibri' value='".$prioridad."' />  </font>		</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan='3'><span class='Estilo5'>____________________________</span></td>
        <td>&nbsp;</td>
      </tr>



</table>

</body>
    </html>
    ";


   $headers  = 'MIME-Version: 1.0' . "\r\n";
   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
   $headers .= 'From: Solicitud de Desarrollo <donotreply@gmail.com>';

  //SAVE

move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],
$fileToUpload =  "uploads/".$_FILES["fileToUpload"]["name"]);

$mail = new PHPMailer();
$body = $mensaje;
$mail->SetFrom('donotreply@pan-gloria.com', 'Cotizacion Pan Gloria');
$address = $para;
$mail->AddAddress("santiago_m24@hotmail.com","Santiago");
$mail->AddAddress("ggloribel_m@hotmail.com","Glenda");
$mail->Subject    = $asunto;
/// asignamos el mensaje
$mail->MsgHTML($body);
$mail->AddAttachment($fileToUpload);      // attachment
/// finalmente lo enviamos
if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
}

else
 {
  #echo "Message sent!";

  #mail($para,$asunto,$mensaje,$headers,$file);

  echo "<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
<title>Solicitud</title>
</head>

<body>

  <form method='POST' action ='enviar.php' >
    <table width='753' border='0' align='center'>
      <tr>
        <th width='364' scope='col'><div align='left'><img src='logo.png'/></div></th>
        <th width='803' scope='col'>
          <p><font color='#006699' size='6' face='Calibri'> SOLICITUD DE COTIZACION PAN GLORIA </font></p>
          </th>
      </tr>
      <tr>
        <th colspan='2' scope='col'><div align='left'><font color='#FF6600' size='+4'>_________________________________</font></div></th>
      </tr>
    </table>
    <div align='left'></div>
    <table width='753' align='center'>
      <tr>
        <td width='92'>&nbsp;</td>
        <td width='649'>&nbsp;</td>
      </tr>
      <tr>
        <td>  </td>
        <td><font color='#999999' size='5' face='Calibri'>Solicitud Enviada Correctamente ... </font></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align='right'><a href='solicitud_programa.php'><img src='back3.png' alt='' width='69' height='72' /></a></div></td>
      </tr>
    </table>
  </form>
</body>

</html>" ; }



  ?>

