<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Documento sin título</title>
</head>

<body>
<table width="845" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" align="center" bgcolor="#003399"><h1>Detalle De La Cotizacion</h1></td>
    <td width="197" align="center" bgcolor="#003399">&nbsp;</td>
  </tr>
  <tr>
    <td width="160">ID detalle</td>
    <td width="214"><label for="idcdetalle"></label>
    <input type="text" name="idcdetalle" id="idcdetalle" /></td>
    <td width="43">&nbsp;</td>
    <td width="231">ID de la materia prima</td>
    <td><form id="form5" name="form5" method="post" action="">
      <label for="idmateria"></label>
      <input type="text" name="idmateria" id="idmateria" />
    </form></td>
  </tr>
  <tr>
    <td>ID encabezado</td>
    <td><label for="idencabezado"></label>
      <form id="form1" name="form1" method="post" action="">
        <label for="idencabezado"></label>
        <input type="text" name="idencabezado" id="idencabezado" />
      </form></td>
    <td>&nbsp;</td>
    <td>Precio unitario</td>
    <td><form id="form6" name="form6" method="post" action="">
      <label for="textfield2"></label>
      <label for="select3"></label>
      <select name="select3" id="select3">
        <option>precio</option>
      </select>
    </form></td>
  </tr>
  <tr>
    <td>Cantidad del producto</td>
    <td><select name="Cantidad" id="Cantidad">
      <option value="1">Cantidad</option>
    </select></td>
    <td>&nbsp;</td>
    <td>Estado</td>
    <td><form id="form4" name="form4" method="post" action="">
      <label for="select2"></label>
      <select name="select2" id="select2">
        <option value="1">pendiente</option>
      </select>
    </form></td>
  </tr>
  <tr>
    <td>Unidad</td>
    <td><form id="form2" name="form2" method="post" action="">
      <label for="select"></label>
      <select name="select" id="select">
        <option>Tipo</option>
      </select>
    </form></td>
    <td>&nbsp;</td>
    <td>ID unidad</td>
    <td><form id="form3" name="form3" method="post" action="">
      <label for="select2"></label>
    </form>
      <label for="idunidad"></label>
    <input type="text" name="idunidad" id="idunidad" /></td>
  </tr>
</table>
<input type="submit" name="button" id="button" value="Agregar" />
<input type="submit" name="button2" id="button2" value="Quitar" />
<input type="submit" name="button3" id="button3" value="Enviar" />
</body>
</html>