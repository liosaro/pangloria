<?php
        include("../../libreria/engine.php");

        //Para cancelar
        if(isset($_GET["cancelar"]))
        {
            $cod = $_GET["cancelar"];
            mfactura::cancelar($cod);
            include("facturas.php");
            exit();
        }
        //////////////////////////////



            $clstfactura = new mfactura();

            $clstfactura->cod = '';
            $clstfactura->numero = " <small>(No guardado)</small>";
            $clstfactura->tipoFactura = '';
            $clstfactura->tipoImpuesto = '';
            $clstfactura->valorImpuesto = '';
            $clstfactura->fecha = '';
            $clstfactura->vencimiento = '';
            $clstfactura->ncf = '';
            $clstfactura->cliente = '';
            $clstfactura->cnombre = '';

            $clstfactura->detalle = '';
            $clstfactura->itebis = '';
            $clstfactura->subtotal = '';
            $clstfactura->total = '';
            $clstfactura->generada = '';
            $clstfactura->mes = '';
            $clstfactura->per = '';
            $clstfactura->stad = '';


            if($_POST)
            {


                    $clstfactura->cod = $_POST['txtCod'];
                    $clstfactura->numero = $_POST['hfNumero'];

                $clstfactura->tipoFactura = $_POST['txtTipoFactura'];
                $clstfactura->tipoImpuesto = $_POST['txtTipoImpuesto'];
                $clstfactura->valorImpuesto = $_POST['txtValorImpuesto'];
                $clstfactura->fecha = $_POST['txtFecha'];
                $clstfactura->vencimiento = $_POST['txtVencimiento'];
                $clstfactura->ncf = $_POST['txtNcf'];
                $clstfactura->cliente = $_POST['txtCliente'];
                $clstfactura->cnombre = $_POST['txtCnombre'];
                $clstfactura->detalle = $_POST['txtConcepto'];
                $clstfactura->itebis = $_POST['txtItebis'];
                $clstfactura->subtotal = $_POST['txtSubtotal'];
                $clstfactura->total = $_POST['txtTotal'];
                $clstfactura->generada = 0;
                $clstfactura->mes = 0;
                $clstfactura->per = 0;
                $clstfactura->stad = 1;

                if(isset($_POST["txtCodigo"]))
                {
                    $codigos = $_POST["txtCodigo"];
                    $descripciones = $_POST["txtDescripcion"];
                    $montos = $_POST["txtMonto"];
                    $cantidades = $_POST["txtCantidad"];
                    $precios = $_POST["txtPrecio"];

                    foreach($codigos as $pos=>$codigo)
                    {
                        $clstfactura->addDetalle($codigo,  $descripciones[$pos], $montos[$pos], $cantidades[$pos], $precios[$pos]);

                    }
                }

                $clstfactura->guardar();



                echo mensajeDeAlerta("Datos Guardados");

                echo "
                        <script language='javascript'>
                            try{
                            document.getElementById('txtCod').value = $clstfactura->cod;

                            document.getElementById('hfNumero').value = '$clstfactura->numero';

                            document.getElementById('factNum').innerHTML = '$clstfactura->numero';
                            }
                            catch(ex)
                            {
                                alert(ex);
                            }
                        </script>
                    ";

                exit();
            }
            else
            {
                if(isset($_GET['id']))
                {

                    $clstfactura->cod = $_GET['id'] + 0;
                    $clstfactura->cargar();

                }
            }


            function mostrarDetalles($datos)
            {
                foreach($datos as $articulo)
                {
                    echo "


                    <tr>
                        <td>
                            <input ondblclick='seleccionarArticulo(this)' value='{$articulo->codigo}' class='requerido entero' type='text' name='txtCodigo[]'/>
                        </td>
                        <td>
                            <input value='{$articulo->nombre}' class='requerido' type='text' name='txtDescripcion[]'/>
                        </td>
                        <td>
                            <input value='{$articulo->cantidad}' class='requerido decimal' type='text' name='txtCantidad[]' size='5' onblur='actualizarTotales()'/>

                        </td>
                        <td>

                        <input value='{$articulo->precio}' class='requerido decimal Aderecha' type='text' name='txtPrecio[]' size='10' onblur='actualizarTotales()'/>

                        </td>

                        <td>
                            <input value='{$articulo->total}' readonly='readonly' class='requerido decimal Aderecha' type='text' name='txtMonto[]' onblur='actualizarTotales()'/>
                        </td>
                        <td align='right'>
                            <a onclick='quitarElemento(this.parentNode.parentNode)'><img class='manito' src='images/Remove.png'/></a>
                        </td>
                    </tr>

                    ";

                }

            }


            $cmbImpuesto = new comboBox('txtTipoImpuesto', new dataTable("select id, nombre from tipoimpuesto"));
            $cmbImpuesto->accion = "onchange='cargarImpuesto(this);'";
            $cmbImpuesto->class = 'requerido';
            $cmbImpuesto->selectValue = $clstfactura->tipoImpuesto;


            $data["id"][0]="credito";
            $data["id"][1]="contado";
            $data["name"][0]="credito";
            $data["name"][1]="contado";
            $cmbTipoFactura = new comboBox("txtTipoFactura", new dataTable($data));
            $cmbTipoFactura->class = 'requerido';
            $cmbTipoFactura->selectValue = $clstfactura->tipoFactura;

?>

<h2>Factura #:<span id='factNum'><?php echo $clstfactura->numero; ?></span></h2>
<form method="post" id="frmFR" action="modulos/facturas/factura.php" onsubmit="return validarTF();">
  <input  type="hidden" id="txtCod" name="txtCod" value="<?php echo $clstfactura->cod ; ?>" />
  <input type='hidden' value='<?php echo $clstfactura->numero; ?>' name='hfNumero' id='hfNumero'/>
  <input type="hidden" id="txtValorImpuesto" name="txtValorImpuesto" value="<?php echo $clstfactura->valorImpuesto ; ?>" />



  <table border="0" width="800" class=" ui-tabs ui-widget ui-widget-content ui-corner-all" >
    <tr>
        <td colspan="2">


         <table >
          <tr>
            <td><strong>Fecha</strong> <input class='fechamysql requerido' type='text' value='<?php echo $clstfactura->fecha; ?>' name='txtFecha' id='txtFecha'></td>
            <td><strong>Vencimiento</strong> <input class="fechamysql " name="txtVencimiento" type="text" id="txtVencimiento" value="<?php echo $clstfactura->vencimiento; ?>" size="5" />
            Dias</td>
        </tr>
          <tr>
            <td><div align="right"><strong>Impuesto


          :</strong><?php $cmbImpuesto->display(); ?></div></td>
            <td><strong>NCF:</strong>
                  <input class='' readonly type='text' value='<?php echo $clstfactura->ncf; ?>' name='txtNcf' id='txtNcf'/>          </td>
    </tr>
  </table>        </td>
    </tr>



    <tr>
      <td><div align="right"><strong>Cliente:</strong></div></td>
      <td><input class="requerido controlLargo" value="<?php echo $clstfactura->cnombre; ?>"  name="txtCnombre" id='divCliente' type="text" onclick="seleccionarCliente();" readonly />
        <input type="hidden" name="txtCliente" id="txtClienteId" value="<?php echo $clstfactura->cliente; ?>" />      </td>
    </tr>
    <tr>
      <td><div align="right"><strong>Concepto</strong></div></td>
      <td><textarea class="requerido controlLargo" id="txtConcepto" name="txtConcepto"><?php echo $clstfactura->detalle; ?></textarea>      </td>
    </tr>

    <tr>
        <td><div align="right"><strong>Tipo</strong>:</div></td>
        <td>
            <?php
                $cmbTipoFactura->display();
            ?>

            </td>
    </tr>
    <tr>
      <td colspan="2">
          <fieldset>
            <legend> <strong>Cargos de la factura:</strong></legend>


        <table border="0" width="100%" class="">
          <thead>
            <tr>
              <th>Codigo</th>
              <th>Descripcion</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Monto</th>
            </tr>
          </thead>
          <tbody id="tbDetalleTF">
            <?php mostrarDetalles($clstfactura->detalles) ; ?>
          </tbody>
        </table>
         <span style="padding: 10px 4px; font-size:90%" id="toolbar" class="ui-widget-header ui-corner-all">
        <button id="addDetail" type="button" onclick="agregarItem()">Agregar Detalle</button></td>
        </span>
    </tr>
    <tr>
      <th colspan="2">Sub-Total
        <label>
        <input name="txtSubtotal" class='Aderecha' type="text" id="txtSubTotal" value="<?php echo $clstfactura->subtotal; ?>" style="margin-right:20px;" size="15" readonly />
        </label>
        ITBIS
        <input name="txtItebis" class='Aderecha' type="text" id="txtItebis" value="<?php echo $clstfactura->itebis; ?>" style="margin-right:20px;" size="15"  readonly="readonly" />
        Total
      <input name="txtTotal" class='Aderecha' type="text" id="txtTotal" value="<?php echo $clstfactura->total; ?>" size="17" readonly/>      </th>
    </tr>
  </table>
  </fieldset>
<br />

 <span style="padding: 10px 4px; font-size:90%" id="toolbar" class="ui-widget-header ui-corner-all">
  <button id="btnOK" type="submit">Aceptar</button>
  <button id="btnPrint" type="button" onclick="imprimir();">Imprimir</button>
   <button id="btnMail" type="button" onclick="enviarFactura();">Enviar</button>
  <button id="btnCancel" type="button" onclick="cancelar();">Cancelar</button>
  <button type="button" id='btnAnular' onclick="eliminar();">Anular</button>
 </span>
</form>
<div id="divResultFR"> </div>
<script language="javascript">

$("#btnOK").button({
            icons: {
                primary: 'ui-icon-check'
            }});

$("#btnPrint").button({
            icons: {
                primary: 'ui-icon-print'
            }});

$("#addDetail").button({
            icons: {
                primary: 'ui-icon-plus'
            }});
$("#btnMail").button({
            icons: {
                primary: 'ui-icon-mail-closed'
            }});

$("#btnCancel").button({
            icons: {
                primary: 'ui-icon-cancel'
            }});

$("#btnAnular").button({
            icons: {
                primary: 'ui-icon-close'
            }});


    function enviarFactura()
    {
        cod = parseInt(document.getElementById("txtCod").value);
        if(cod > 0)
        {
            abrirOpcion("divEnvio","Impresion de Factura", "modulos/reportes/enviarFactura.php?id="+cod,true,800,600);
        }
        else
        {
            alert("Debe guardar la factura para poder imprimirla");
        }
    }

    function validarTF()
    {
        if(!document.getElementById("txtTipoFactura1").checked && !document.getElementById("txtTipoFactura1").checked)
        {
            alert('Debe indicar el tipo de factura');
            return false;
        }
        return true;

    }

    var farticulo = null;
    function seleccionarArticulo(obj)
    {
            farticulo = obj;
            abrirOpcion("divconsultaArticulos","Busqueda de Articulos", "modulos/articulos/busquedaArticulo.php",true);

    }

    function elegirArticulo(cod, nombre, precio)
    {
            $("#divconsultaArticulos").dialog('close');
            farticulo.value = cod;
            farticulo.parentNode.parentNode.childNodes[1].childNodes[0].value = nombre;
            farticulo.parentNode.parentNode.childNodes[3].childNodes[0].value = precio;
            actualizarTotales();
    }

    function seleccionarCliente()
    {
            abrirOpcion("divconsultaCliente","Busqueda de Cliente", "modulos/clientes/busquedaCliente.php",true);

    }

    function imprimir()
    {
        cod = parseInt(document.getElementById("txtCod").value);
        if(cod > 0)
        {
            abrirOpcion("divImpresion","Impresion de Factura", "modulos/facturas/imprimirFactura.php?id="+cod,true,800,600);
        }
        else
        {
            alert("Debe guardar la factura para poder imprimirla");
        }
    }

    function elegirCliente(cod, nombre)
    {
        document.getElementById("divCliente").value = nombre;
        document.getElementById("txtClienteId").value = cod;
        $("#divconsultaCliente").dialog('option', 'hide', 'slide');
        $("#divconsultaCliente").dialog('close');
    }

    function cancelar()
    {
        cargarEn('divPestanas', "modulos/facturas/facturas.php", "");


    }

    function eliminar()
    {
        if(confirm("Desea anular la factura actual \n *Esta accion no se puede recuperar*"))
        {
            try{
            cod = document.getElementById("txtCod").value;+

            cargarEn('divPestanas', "modulos/facturas/factura.php?cancelar="+cod, "");
            }
            catch(ex)
            {
                alert(ex);
            }
        }
    }

        function actualizarTotales()
    {
        total = 0;
        subtotal = 0;
        totales = document.getElementsByName("txtMonto[]");
        cantidades = document.getElementsByName("txtCantidad[]");
        precios = document.getElementsByName("txtPrecio[]");

        for(x=0; x<totales.length; x++)
        {


            ttotal = parseFloat(precios[x].value) * parseFloat(cantidades[x].value);

            totales[x].value = (isNaN(ttotal))?0:ttotal;

            tvar = parseFloat(totales[x].value);
            subtotal += (isNaN(tvar))?0:tvar;


        }

        vitebis = parseInt(document.getElementById("txtValorImpuesto").value) ;

        vitebis = (isNaN(vitebis))?0:(vitebis / 100);
        itebis = subtotal * vitebis;

        //document.getElementById("txtTotal").value = parseFloat(total).toFixed(2);
        document.getElementById("txtSubTotal").value = parseFloat(subtotal);
        document.getElementById("txtItebis").value = itebis;
        document.getElementById("txtTotal").value = parseFloat(subtotal + itebis);
    }

    function agregarItem()
    {
        tr = document.createElement('tr');

        txt = document.createElement('input');
        txt.type = "text";
        txt.name = "txtCodigo[]";
        txt.setAttribute('class', 'requerido entero');
        txt.setAttribute('ondblclick','seleccionarArticulo(this)');
        td = document.createElement('td');
        td.appendChild(txt);
        tr.appendChild(td);

        txt = document.createElement('input');
        txt.type = "text";
        txt.setAttribute('class', 'requerido');
        txt.name = "txtDescripcion[]";
        td = document.createElement('td');
        td.appendChild(txt);
        tr.appendChild(td);

        txt = document.createElement('input');
        txt.type = "text";
        txt.name = "txtCantidad[]";
        txt.size = 5;
        txt.setAttribute('class', 'requerido decimal');
        txt.setAttribute('onblur', 'actualizarTotales()');
        txt.value = 1;
        td = document.createElement('td');
        td.appendChild(txt);
        tr.appendChild(td);

        txt = document.createElement('input');
        txt.type = "text";
        txt.name = "txtPrecio[]";
        txt.size = 10;
        txt.setAttribute('class', 'requerido decimal Aderecha');
        txt.setAttribute('onblur', 'actualizarTotales()');
        td = document.createElement('td');
        td.appendChild(txt);
        tr.appendChild(td);

        txt = document.createElement('input');
        txt.type = "text";
        txt.name = "txtMonto[]";
        txt.setAttribute("readonly","readonly");
        txt.setAttribute('class', 'requerido decimal Aderecha');
        txt.setAttribute('onblur', 'actualizarTotales()');
        td = document.createElement('td');
        td.appendChild(txt);
        tr.appendChild(td);

        txt = document.createElement('a');
        txt.innerHTML = "<img class='manito' src='images/Remove.png'/>";
        txt.setAttribute('onclick','quitarElemento(this.parentNode.parentNode)');
        td = document.createElement('td');
        td.appendChild(txt);
        tr.appendChild(td);

        document.getElementById('tbDetalleTF').appendChild(tr);

    }

    function quitarElemento(obj)
    {
        if(confirm("Desea eliminar este detalle"))
        {
            document.getElementById('tbDetalleTF').removeChild(obj);
            actualizarTotales();
        }

    }

    function cargarImpuesto(combo)
    {
         $.ajax({
            type: 'POST',
            url: 'modulos/facturas/cargarImpuesto.php',


            data: "id="+combo.value,
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {

                document.getElementById("txtValorImpuesto").value = parseInt(data);
                actualizarTotales();

            }
        });

    }

    asgForm($("#frmFR"), $("#divResultFR"));
</script>