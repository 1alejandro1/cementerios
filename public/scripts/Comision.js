	$(document).on("ready", init);// Inciamos el jquery

function init(){

    $('#tblComision').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoComision();// Ni bien carga la pagina que cargue el metodo

	$("#VerForm").hide();// Ocultamos el formulario

	$("form#frmComision").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos

	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm


	$("#btnBuscarContratoCom").click(AbrirModalContratoCom);



    $('#txtPorcentaje').change(function() {
        ActualizaPorcentaje($('#txtPorcentaje').val(),$('#txtMonto').val(),$('#txtPrecio').val());
    });
    $('#txtMonto').change(function() {
        ActualizaMonto($('#txtPorcentaje').val(),$('#txtMonto').val(),$('#txtPrecio').val());
    });
    $('#cboFormadePago').change(function() {
        ActualizaCuotas();
    });


	$("#btnAgregarContratoCom").click(function(e) {
		e.preventDefault();

		var opt = $("input[name=optContratoBusqueda]:checked");

  		$("#txtIdContrato").val(opt.val());

		$("#txtContrato").val(opt.attr("data-nombre"));

		$("#txtCementerio").val(opt.attr("data-cementerio"));

		$("#txtSector").val(opt.attr("data-sector"));

		$("#txtLote").val(opt.attr("data-lote"));

		$("#txtFila").val(opt.attr("data-fila"));

		$("#txtColumna").val(opt.attr("data-columna"));

		$("#txtFechaContrato").val(opt.attr("data-fechacontrato"));

		$("#txtPrecio").val(opt.attr("data-precio"));

		$("#txtEjecutivoVenta").val(opt.attr("data-ejecutivoventa"));

		$("#txtFechaComision").val(opt.attr("data-fechacomision"));

		$("#modalListadoContrato").modal("hide");
	});



	function SaveOrUpdate(e){

		e.preventDefault();// para que no se recargue la pagina

		$("#txtMonto1raCuota").attr('disabled',false);
		$("#txtMonto2daCuota").attr('disabled',false);
		$("#txtMonto3raCuota").attr('disabled',false);
		$("#txtMonto4taCuota").attr('disabled',false);
		$("#txtFecha1raCuota").attr('disabled',false);
		$("#txtFecha2daCuota").attr('disabled',false);
		$("#txtFecha3raCuota").attr('disabled',false);
		$("#txtFecha4taCuota").attr('disabled',false);

        $.post("./ajax/ComisionAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            swal("Mensaje del Sistema", r, "success");

            Limpiar();

            ListadoComision();

            OcultarForm();

        });

	};


	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdComision").val("");

		$("#").val("");

		$("#txtContrato").val("");

		$("#txtFechaContrato").val("");

		$("#txtPrecio").val("");

		$("#txtCementerio").val("");

		$("#txtSector").val("");

		$("#txtLote").val("");

		$("#txtFila").val("");

		$("#txtColumna").val("");

		$("#txtFechaComision").val("");

		$("#txtPorcentaje").val("");

		$("#txtMonto").val("");

		$("#txtFormadePago").val("");

		$("#txtMonto1raCuota").val("0");

		$("#txtFecha1raCuota").val("");

		$("#txtMonto2daCuota").val("0");

		$("#txtFecha2daCuota").val("");

		$("#txtMonto3raCuota").val("0");

		$("#txtFecha3raCuota").val("");

		$("#txtMonto4taCuota").val("0");

		$("#txtFecha4taCuota").val("");
	}

	function VerForm(){

		$("#VerForm").show();// Mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();

	}



	function OcultarForm(){

		$("#VerForm").hide();// Mostramos el formulario

		$("#btnNuevo").show();// ocultamos el boton nuevo

		$("#VerListado").show();

	}



}



function ListadoComision(){

        var tabla = $('#tblComision').dataTable(

        {   "aProcessing": true,

            "aServerSide": true,

            dom: 'Bfrtip',

            buttons: [

                'copyHtml5',

                'excelHtml5',

                'csvHtml5',

                'pdfHtml5'

            ],

            "aoColumns":[

                    {   "mDataProp": "0"},

                    {   "mDataProp": "1"},

                    {   "mDataProp": "2"},

                    {   "mDataProp": "3"},

                    {   "mDataProp": "4"},

                    {   "mDataProp": "5"}

            ],"ajax":

                {

                    url: './ajax/ComisionAjax.php?op=list',

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };



function eliminarComision(id){

	swal({
	  title: "¿Esta Seguro de eliminar la Comisión seleccionada?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		$.post("./ajax/ComisionAjax.php?op=delete", {id : id}, function(e) {

			swal("Mensaje del Sistema", e, "success");

			ListadoComision();

        });
	});

/*
	bootbox.confirm("¿Esta Seguro de eliminar la Comisión seleccionada?", function(result){ 

		if(result){// si el result es true

			$.post("./ajax/ComisionAjax.php?op=delete", {id : id}, function(e) {

				swal("Mensaje del Sistema", e, "success");

				ListadoComision();

            });

		}

	})
*/
}


function cargarDataComision(id, idcontrato,fechacomision,nrocontrato,fechacontrato,ejecutivoventa,cementerio,sector,lote,fila,columna,precio,porcentaje,monto,formadepago, monto1racuota,fecha1racuota,monto2dacuota,fecha2dacuota,monto3racuota,fecha3racuota,monto4tacuota,fecha4tacuota) {
//function cargarDataComision(id, idcontrato,fechacomision,nrocontrato,fechacontrato,ejecutivoventa,cementerio,sector,lote,fila,columna) {

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();


		$("#txtIdComision").val(id);

		$("#txtIdContrato").val(idcontrato);

		$("#txtContrato").val(nrocontrato);

		$("#txtFechaContrato").val(fechacontrato);

		$("#txtPrecio").val(precio);

		$("#txtCementerio").val(cementerio);

		$("#txtSector").val(sector);

		$("#txtLote").val(lote);

		$("#txtFila").val(fila);

		$("#txtColumna").val(columna);

		$("#txtEjecutivoVenta").val(ejecutivoventa);

		$("#txtFechaComision").val(fechacomision);

		$("#txtPorcentaje").val(porcentaje);

		$("#txtMonto").val(monto);

		$("#cboFormadePago").val(formadepago);

		$("#txtMonto1raCuota").val(monto1racuota);

		$("#txtFecha1raCuota").val(fecha1racuota);

		$("#txtMonto2daCuota").val(monto2dacuota);

		$("#txtFecha2daCuota").val(fecha2dacuota);

		$("#txtMonto3raCuota").val(monto3racuota);

		$("#txtFecha3raCuota").val(fecha3racuota);

		$("#txtMonto4taCuota").val(monto4tacuota);

		$("#txtFecha4taCuota").val(fecha4tacuota);

		$("#txtMonto1raCuota").attr('disabled',true);
		$("#txtMonto2daCuota").attr('disabled',true);
		$("#txtMonto3raCuota").attr('disabled',true);
		$("#txtMonto4taCuota").attr('disabled',true);

		ActualizaCuotas();

	}

	function AbrirModalContratoCom(){

		$("#modalListadoContrato").modal("show");

		$.post("./ajax/ComisionAjax.php?op=listContrato", function(r){

            $("#ContratoDetalle").html(r);

            $('#tblContratosCom').DataTable();

        });

	}

	function ActualizaPorcentaje(porcentaje, monto, precio) {

		var porcentajen = parseFloat(porcentaje);
		var monton = parseFloat(monto);
		var precion = parseFloat(precio);

		if (porcentajen<0) {
			porcentajen = porcentajen * -1;
		}
		if (monton<0) {
			monton = monton * -1;
		}
		if (porcentajen==0) {
			$("#btnRegComision").attr('disabled',true);
		} else {
			$("#btnRegComision").attr('disabled',false);
		}

		$("#txtPorcentaje").val(porcentajen.toFixed(2));
		$("#txtMonto").val(monton.toFixed(2));

		$divisor = precion.toFixed(2) * porcentajen.toFixed(2)/100;

		$("#txtMonto").val(  $divisor.toFixed(2) );
		
		ActualizaCuotas();
	}

	function ActualizaMonto(porcentaje, monto, precio) {

		var porcentajen = parseFloat(porcentaje);
		var monton = parseFloat(monto);
		var precion = parseFloat(precio);

		if (porcentajen<0) {
			porcentajen = porcentajen * -1;
		}
		if (monton<0) {
			monton = monton * -1;
		}
		if (monton==0) {
			$("#btnRegComision").attr('disabled',true);
		} else {
			$("#btnRegComision").attr('disabled',false);
		}

		$("#txtPorcentaje").val(porcentajen.toFixed(2));
		$("#txtMonto").val(monton.toFixed(2));

		$divisor = monton.toFixed(2) *100 / precion.toFixed(2);

		$("#txtPorcentaje").val(  $divisor.toFixed(2) );

		ActualizaCuotas();
		
	}

	function ActualizaCuotas() {
		formadepago = $("#cboFormadePago").val();
		monton = parseFloat($("#txtMonto").val());

		if (formadepago==1) {
			$("#txtMonto1raCuota").val(monton.toFixed(2));
			$("#txtMonto2daCuota").val("0");
			$("#txtMonto3raCuota").val("0");
			$("#txtMonto4taCuota").val("0");
			$("#txtFecha2daCuota").val("");
			$("#txtFecha3raCuota").val("");
			$("#txtFecha4taCuota").val("");
			$("#txtFecha1raCuota").attr('disabled',false);
			$("#txtFecha2daCuota").attr('disabled',true);
			$("#txtFecha3raCuota").attr('disabled',true);
			$("#txtFecha4taCuota").attr('disabled',true);
		}
		if (formadepago==2) {
			monton = monton / 2
			$("#txtMonto1raCuota").val(monton.toFixed(2));
			$("#txtMonto2daCuota").val(monton.toFixed(2));
			$("#txtMonto3raCuota").val("0");
			$("#txtMonto4taCuota").val("0");
			$("#txtFecha3raCuota").val("");
			$("#txtFecha4taCuota").val("");
			$("#txtFecha1raCuota").attr('disabled',false);
			$("#txtFecha2daCuota").attr('disabled',false);
			$("#txtFecha3raCuota").attr('disabled',true);
			$("#txtFecha4taCuota").attr('disabled',true);
		}
		if (formadepago==3) {
			monton = monton / 3
			$("#txtMonto1raCuota").val(monton.toFixed(2));
			$("#txtMonto2daCuota").val(monton.toFixed(2));
			$("#txtMonto3raCuota").val(monton.toFixed(2));
			$("#txtMonto4taCuota").val("0");
			$("#txtFecha4taCuota").val("");
			$("#txtFecha1raCuota").attr('disabled',false);
			$("#txtFecha2daCuota").attr('disabled',false);
			$("#txtFecha3raCuota").attr('disabled',false);
			$("#txtFecha4taCuota").attr('disabled',true);
		}
		if (formadepago==4) {
			monton = monton / 4
			$("#txtMonto1raCuota").val(monton.toFixed(2));
			$("#txtMonto2daCuota").val(monton.toFixed(2));
			$("#txtMonto3raCuota").val(monton.toFixed(2));
			$("#txtMonto4taCuota").val(monton.toFixed(2));
			$("#txtFecha1raCuota").attr('disabled',false);
			$("#txtFecha2daCuota").attr('disabled',false);
			$("#txtFecha3raCuota").attr('disabled',false);
			$("#txtFecha4taCuota").attr('disabled',false);
		}
//		swal("Mensaje del Sistema", monto , "success");
	}