<?php error_reporting (0);?>

<script type="text/javascript">
/*===============================ATAJO TECLADO ===========================*/


	var eventoControlado = false;

window.onload = function() { document.onkeypress = mostrarInformacionCaracter;

document.onkeyup = mostrarInformacionTecla; }




function mostrarInformacionCaracter(evObject) {

                var msg = ''; var elCaracter = String.fromCharCode(evObject.which);

                if (evObject.which!=0 && evObject.which!=13) {

                msg = 'Tecla pulsada: ' + elCaracter;

                control.innerHTML += msg + '-----------------------------<br/>'; }

                else { msg = 'Pulsada tecla especial';

                control.innerHTML += msg + '-----------------------------<br/>';}

                eventoControlado=true;

}



function mostrarInformacionTecla(evObject) {

                var msg = ''; var teclaPulsada = evObject.keyCode;



                eventoControlado = false;
  if(teclaPulsada == 112){

printPantalla();

  }


}

</script>
<?php


require_once "../model/Pedido.php";




include 'sin/ControlCode.php';
$objPedido = new Pedido();
$query_cli = $objPedido->Recuperar_informacion_tf($_GET["id"]);
$rp = $query_cli->fetch_object();




// colocamos las variables para el codigo qr

$Nit_Mi_Empresa = $rp->nit_sucursal;
$Numero_Factura =$rp->num_factura;
$Numero_Autorizacion= $rp->numero_autorizacion;// NUMERO AUTORIZACION
$Nit_Cliente= $rp->nit_cliente;// NIT
$Fecha_emision_factura= $rp->fecha; //FECHA DE TRANSACCION

$Total_Transaccion= $rp->total; // MONTO DE TRANSACCION
$Llave_autorizacion = $rp->llave_dosificacion;
$fecha_limite_emision=$rp->fecha_limite_emision;
$razon_Social = $rp->razon_social; //empresa farmacia
$direccion =$rp->direccion;
$telefono = $rp->telefono;
$Codigo_Control= $rp->codigo_control;
$nombre_cliente = $rp->nombre_cliente;
$leyenda_facturas =$rp->leyenda_facturas;


	 //imprimimos  Codigo de controlCode


	/*=============================================Crear Codigo QR==================================*/
	//Agregamos la libreria para genera códigos QR
	require "phpqrcode/qrlib.php";

	//Declaramos una carpeta temporal para guardar la imagenes generadas
	$dir = 'temp/';

	//Si no existe la carpeta la creamos
	if (!file_exists($dir))
        mkdir($dir);

        //Declaramos la ruta y nombre del archivo a generar
	$filename = $dir.'test.png';

        //Parametros de Condiguración

	$tamaño = 5; //Tamaño de Pixel
	$level = 'L'; //Precisión Baja
	$framSize = 3; //Tamaño en blanco




	$contenido =

	"$Nit_Mi_Empresa|$Numero_Factura|$Numero_Autorizacion|$Fecha_emision_factura|$Total_Transaccion|$Codigo_Control"; //Texto

        //Enviamos los parametros a la Función para generar código QR
	QRcode::png($contenido, $filename, $level, $tamaño, $framSize);

        //Mostramos la imagen generada






 ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
<script>
    function printPantalla()
{
   document.getElementById('cuerpoPagina').style.marginRight  = "0";
   document.getElementById('cuerpoPagina').style.marginTop = "1";
   document.getElementById('cuerpoPagina').style.marginLeft = "1";
   document.getElementById('cuerpoPagina').style.marginBottom = "0";
   document.getElementById('botonPrint').style.display = "none";
   window.print();
}
</script>
</head>
<body id="cuerpoPagina">



<div class="zona_impresion">
        <!-- codigo imprimir -->
<br>
<table border="0" align="center" width="300px">
    <tr>
      <BR>
        <br>
        <td align="center">
        .::<strong> <?php echo $razon_Social; ?></strong>::.<br>
        <?php echo $direccion; ?><br>

        <h3>FACTURA ORIGINAL</h3>

        </td>

    </tr>

    <tr>
      <td>
      <?php echo "NIT: "; ?>   <?php echo $Nit_Mi_Empresa ; ?><br>
    <?php echo "FACTURA No :". $Numero_Factura; ?> <br>
    <?php  echo "AUTORIZACION No:" ?> <?php echo $Numero_Autorizacion; ?> <br>
    <?php  echo "-----------------------------------------------------------------------------"; ?> <br>

  </td>

    </tr>

    <tr>
      <td align="center"></td>
    </tr>
    <tr>
        <td><?php echo "Fecha: ".$Fecha_emision_factura?></td>
    </tr>
    <tr>
        <td>Cliente : <?php echo $nombre_cliente; ?>

        <br>
            NIT/CI: <?php echo $Nit_Cliente; ?> </td>

    </tr>

</table>
<br>

<table border="0" align="center" width="300px">
    <tr>
        <td>CANT.</td>
        <td>DESCRIPCIÓN</td>
        <td align="right">IMPORTE</td>
    </tr>
    <tr>
      <td colspan="3">==========================================</td>
    </tr>
<td> <tr>
  <?php $query_ped = $objPedido->ImprimirDetallePedido($_GET["id"]);

      while ($reg = $query_ped->fetch_object()) {
      echo "<tr>";
      echo "<td>".$reg->cantidad."</td>";
      echo "<td>".$reg->nombre."</td>";
      echo "<td align='right'>".$reg->precio_venta."</td>";
      echo "</tr>";
      $cantidad+=$reg->cantidad;
			$total = $reg->total;
  } ?>
</tr> </td>

    <tr>
    <td>&nbsp;</td>
    <td align="right"><b>TOTAL:</b></td>
    <td align="right"><b><?php echo "Bs"?>  <?php echo $total;  ?></b></td>
    </tr>





</table>

<table  border="0" align="center" width="300px">
<tr>
  <td><?php echo"----------------------------------------------------------------------------" ?></td>
</tr>

<tr>
  <td> <?php echo 'CODIGO DE CONTROL : '; ?>  <?php echo $Codigo_Control; ?> <br>
<?php echo 'Fecha limite Emision :'; ?> <?php echo $fecha_limite_emision; ?>
<br>
<?php echo '<img src="'.$dir.basename($filename).'" /><hr/>';
 ?>

  </td>
</tr>
  <tr>
    <td style="font-size: 11px;"><?php echo $leyenda_facturas; ?></td>
  </tr>

  <tr>
    <td align="center"> Santa Cruz - Bolivia</td>
  </tr>

</table>



<br>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<p>

<div style="margin-left:245px;"><a href="#" id="botonPrint" onClick="printPantalla();"><img src="../img/printer.png" border="0" style="cursor:pointer" title="Imprimir"></a></div>
</body>
</html>
