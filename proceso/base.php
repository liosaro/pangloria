<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Control de Empleados</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><table width="1024" border="0">
      <tr>
        <td align="right"><div class="tope" id="admin2tope">
          <ul id="MenuBar1" class="MenuBarHorizontal">
            <li><a class="MenuBarItemSubmenu" href="#">Orden de Produccion</a>
              <ul>
                <li><a href="#">Elemento 1.1</a></li>
                <li><a href="#">Elemento 1.2</a></li>
                <li><a href="#">Elemento 1.3</a></li>
              </ul>
            </li>
            <li><a href="#" class="MenuBarItemSubmenu MenuBarItemSubmenu">Materia Prima</a>
              <ul>
                <li><a href="#">Pedido Materia Prima</a></li>
                <li><a href="#">Salida Materia Prima</a></li>
                <li><a href="#">Elemento sin t&iacute;tulo</a></li>
                <li><a href="#">Entrega de Materia Prima</a></li>
                <li><a href="#">Justificacion Perdia Materia Prima</a></li>
              </ul>
            </li>
            <li><a class="MenuBarItemSubmenu" href="#">Controles</a>
              <ul>
                <li><a class="MenuBarItemSubmenu" href="#">Producto en Horno</a>
                  <ul>
                    <li><a href="#">Ingresar Nuevo Control</a></li>
                    <li><a href="#">Consultar Control</a></li>
                  </ul>
                </li>
                <li><a href="#">Control de Produccion</a></li>
                <li><a href="#">Materia Prima</a></li>
              </ul>
            </li>
            <li><a href="#" class="MenuBarItemSubmenu MenuBarItemSubmenu">Producto</a>
              <ul>
                <li><a href="#">Administrar Productos</a></li>
                <li><a href="#">Justificar Perdida Productos</a></li>
              </ul>
            </li>
            <li><a href="#">Reporte de Trabajo</a></li>

          Salir
          </ul>
        </div>
          <div class="menuser" id="usermenuadmin">
            <table width="1024" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div class="usuario" id="user1">
                  <table width="204,8" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="bottom"><img src="../imagenes/icono/Man_Red_256.png" width="45" height="45" /><img src="../imagenes/icono/Supervisor-256.png" width="45" height="45" /><img src="../imagenes/icono/Judge-256.png" width="45" height="45" alt="Consultar Empleados" /></td>
                    </tr>
                    <tr>
                      <td align="center"><h4>Empleados</h4></td>
                    </tr>
                  </table>
                </div></td>
                <td><div class="usuario" id="user2">
                <table width="204,8" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="bottom"><img src="../imagenes/icono/shopping_cart_128.png" width="45" height="45" /><img src="../imagenes/icono/Shopping-cart-256.png" width="45" height="45" /><img src="../imagenes/icono/Red-Wallet-256.png" width="45" height="45" /></td>
                    </tr>
                    <tr>
                      <td align="center"><h4>Compras</h4></td>
                    </tr>
                  </table>
                </div></td>
                <td><div class="usuario" id="user3">
                <table width="204,8" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="bottom"><img src="../imagenes/icono/Invoice-256.png" width="45" height="45" /><img src="../imagenes/icono/Safe-256.png" width="45" height="45" /><img src="../imagenes/icono/Cash-register-256.png" width="45" height="45" /></td>
                    </tr>
                    <tr>
                      <td align="center"><h4>Cotizaciones</h4></td>
                    </tr>
                  </table>
                </div></td>
                <td><div class="usuario" id="user4">
                <table width="204,8" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="bottom"><img src="../imagenes/icono/Delivery-Truck.png" width="45" height="45" /><img src="../imagenes/icono/Card-file.png" width="45" height="45" /><img src="../imagenes/icono/Time.png" width="45" height="45" /></td>
                    </tr>
                    <tr>
                      <td align="center"><h4>Proveedores</h4></td>
                    </tr>
                  </table>
                </div></td>
                <td><div class="usuario" id="user5">
                <table width="204,8" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="bottom"><img src="../imagenes/icono/Banana-128.png" width="45" height="45" /><img src="../imagenes/icono/Breakfast-Box-128.png" width="45" height="45" /><img src="../imagenes/icono/Compurter-256.png" width="45" height="45" /></td>
                    </tr>
                    <tr>
                      <td align="center"><h4>Materia Prima</h4></td>
                    </tr>
                  </table>
                </div></td>
              </tr>
            </table>
          </div>
          <div class="content" id="contenidoadminphp2"><table width="1024" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="184" bgcolor="#006CA7"><div class="menuiz" id="menuizquierdo">
      <div id="Accordion1" class="Accordion" tabindex="0">
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">Ubicaciones</div>
          <div class="AccordionPanelContent">
            <div class="AccordionPanelContent">
              <p>Ingresar Ubicaciones</p>
              <p>Modificar Ubicaciones</p>
              <p>Eliminar Ubicaciones</p>
              <p>Consultar Ubicaciones</p>
              <p>Informe de Ubicaciones            </p>
            </div>
          </div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">Medidas Peso</div>
          <div class="AccordionPanelContent">
            <p>Ingresar Unidades</p>
            <p>Modificar Unidades</p>
            <p>Eliminar Unidades</p>
            <p>Consultar Unidades</p>
            <p>Informe de Unidades</p>
          </div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">Cotizaciones</div>
          <div class="AccordionPanelContent">
            <p>Ingresar Cotizacion</p>
            <p>Modificar Cotizacion</p>
            <p>Eliminar Coticacion</p>
            <p>Consultar Cotizacion</p>
            <p>Informe de Cotizacion          </p>
          </div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">Compras</div>
          <div class="AccordionPanelContent">
            <p>Ingresar Compra</p>
            <p>Modificar Compra</p>
            <p>Eliminar Compra</p>
            <p>Consultar Compra</p>
            <p>Informe de Compras</p>
          </div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">Entrada Inventario</div>
          <div class="AccordionPanelContent">
            <p>Ingresar Entrada</p>
            <p>Modificar Entrada</p>
            <p>Eliminar Entrada</p>
            <p>Consultar Entrada</p>
            <p>Informe de Entradas</p>
          </div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">Materia Prima</div>
          <div class="AccordionPanelContent">
            <p>Ingresar Materia</p>
            <p>Modificar Materia</p>
            <p>Eliminar Materia</p>
            <p>Consultar Materia</p>
            <p>Informe de Materias</p>
          </div>
        </div>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab">Vendedores</div>
          <div class="AccordionPanelContent">
            <p>Ingresar Vendedor</p>
            <p>Modificar Vendedor</p>
            <p>Eliminar Vendedor</p>
            <p>Consultar Vendedor</p>
            <p>Informe de Vendedores</p>
          </div>
        </div>
</div>
    </div></td>
    <td width="840" align="center" valign="middle"><div class="cont">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><img src="../imagenes/logotipo.png" alt="" width="242" height="114" /></p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </div></td>
  </tr>
</table>
</div>
          <div class="foot" id="footeradmin2">
            <table width="1024" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="184" align="center"><div class="menuiz" id="footmenuizquiradmin2">CCEMAG </div></td>
                <td width="840" align="center"><div class="footer" id="footeradmincont2">
                  <table width="1024" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center">UNICAES 2012 </td>
                      <td align="center"><?php
							echo date("d-m-Y H:i:s");
						?></td>
                    </tr>
                  </table>
                </div></td>
              </tr>
            </table>
          </div></td>

      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>

 
            
            
            