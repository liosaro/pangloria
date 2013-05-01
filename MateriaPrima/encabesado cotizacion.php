<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="820px" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" align="center" bgcolor="#003399"><h1>Encabezado De La Cotizacion</h1></td>
    <td width="172" align="center" bgcolor="#003399">&nbsp;</td>
  </tr>
  <tr>
    <td width="153">ID encabezado</td>
    <td width="221"><label for="idencabezado"></label>
    <input type="text" name="idencabezado" id="idencabezado" /></td>
    <td width="43">&nbsp;</td>
    <td width="231">Validez de la oferta</td>
    <td><form id="form1" name="form1" method="post" action="">
      <label for="Oferta"></label>
      <select name="Oferta" id="Oferta">
        <option value="1">oferta</option>
      </select>
    </form></td>
  </tr>
  <tr>
    <td>ID vendedor</td>
    <td><label for="idvendedor"></label>
      <select name="idvendedor" id="idvendedor">
        <option value="1">Julio Cesar Flores</option>
    </select></td>
    <td>&nbsp;</td>
    <td>Condicion de pago</td>
    <td><select name="idproveedor4" id="idproveedor4">
      <option value="1">Credito Fiscal</option>
      <option value="2">Factura Comercial</option>
    </select></td>
  </tr>
  <tr>
    <td>ID proveedor</td>
    <td><select name="idproveedor" id="idproveedor">
      <option value="1">Pagado</option>
      <option value="2">Pendiente</option>
    </select></td>
    <td>&nbsp;</td>
    <td>FPlazo de la entrega</td>
    <td><input type="text" name="idcompra3" id="date" />
      <?php
					  $myCalendar = new tc_calendar("date5", true, false);
					  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
					  //$myCalendar->setDate(date('d'), date('m'), date('Y'));
					  $myCalendar->setPath("calendar/");
					  $myCalendar->setYearInterval(2000, 2015);
					  $myCalendar->dateAllow('2008-05-13', '2015-03-01');
					  $myCalendar->setDateFormat('j F Y');
					  //$myCalendar->setHeight(350);
					  //$myCalendar->autoSubmit(true, "form1");
					  $myCalendar->setAlignment('left', 'bottom');
					  $myCalendar->setSpecificDate(array("2011-04-01", "2011-04-04", "2011-12-25"), 0, 'year');
					  $myCalendar->setSpecificDate(array("2011-04-10", "2011-04-14"), 0, 'month');
					  $myCalendar->setSpecificDate(array("2011-06-01"), 0, '');
					  $myCalendar->writeScript();
					  ?></td>
  </tr>
  <tr>
    <td>Fecha de la cotizacion</td>
    <td><form id="form2" name="form2" method="post" action="">
        <label for="fecha cotizacion"></label>
          <input type="text" name="fecha cotizacion" id="fecha cotizacion" />
        </form></td>
    <td>&nbsp;</td>
    <td>Cotizacion del empleado</td>
    <td><select name="idproveedor2" id="idproveedor2">
      <option value="1">Francisco Javier Flores</option>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<input type="submit" name="button" id="button" value="Agregar" />
<input type="submit" name="button2" id="button2" value="Quitar" />
<input type="submit" name="button3" id="button3" value="Enviar" />
</body>
</html>