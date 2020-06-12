$(document).on("ready", init);// Inciamos el jquery

function init() {


//    $("#tabplan").hide(500); Ocultar un Tab

    $('#tblContrato').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoContrato();// Ni bien carga la pagina que cargue el metodo

    $("#tabplan").click(CargarPlandePagos);


	$("#VerForm").hide();// Ocultamos el formulario
    $("#btnLimpiar").click(LimpiarPrecios);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos

	$("form#frmContrato").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos
	$("form#frmContrato2").submit(SaveOrUpdatePrecios);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos

	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm

    $('#cboSectorSelCto').change(function() {
        $("#txtIdSectorCto").val($("#cboSectorSelCto").val());
        ComboLoteSel();
    });

    $('#cboLoteSelCto').click(function() {
       	ActualizaFilaColumna($('#cboLoteSelCto').val());
    });

    $('#cboLoteSelCto').change(function() {
       	ActualizaFilaColumna($('#cboLoteSelCto').val());
    });
//    $('#cboLoteSelCto').click(function() {
//            swal("Mensaje del Click", "Click", "success");
//        ActualizaFilaColumna($('#cboLoteSelCto').val());
//    });


    $('#txtPrecio').change(function() {
        ActualizaCuotaMensual($('#txtPrecio').val(),$('#txtIncrementoPlazo').val(),$('#txtCuotaInicial').val(),$('#txtPlazoMeses').val());
    });
    $('#txtIncrementoPlazo').change(function() {
        ActualizaCuotaMensual($('#txtPrecio').val(),$('#txtIncrementoPlazo').val(),$('#txtCuotaInicial').val(),$('#txtPlazoMeses').val());
    });
    $('#txtCuotaInicial').change(function() {
        ActualizaCuotaMensual($('#txtPrecio').val(),$('#txtIncrementoPlazo').val(),$('#txtCuotaInicial').val(),$('#txtPlazoMeses').val());
    });
    $('#txtPlazoMeses').change(function() {
        ActualizaCuotaMensual($('#txtPrecio').val(),$('#txtIncrementoPlazo').val(),$('#txtCuotaInicial').val(),$('#txtPlazoMeses').val());
    });


    $('#cboTipoPrecio').change(function() {
        ComboPrecio($('#cboTipoPrecio').val(),$('#cboSectorSelCto').val());
    });

	$("#btnVerPlandePagos").click(function(e) {
		plandePagos($('#txtIdContrato').val(),$('#txtNroContrato').val());
	});

	$("#btnBuscarAdquirienteCto").click(AbrirModalAdquiriente);

	$("#btnBuscarEjecutivoVentaCto").click(AbrirModalEjecutivoVenta);


	$("#btnAgregarAdquirienteCto").click(function(e){

		e.preventDefault();


		var optAdquiriente = $("input[name=optAdquirienteBusqueda]:checked");
//		var opt = $("input[type=radio]:checked");

		$("#txtIdAdquiriente").val(optAdquiriente.val());

		$("#txtAdquiriente").val(optAdquiriente.attr("data-nombre"));

		$("#modalListadoAdquiriente").modal("hide");

	});

	$("#btnAgregarEjecutivoVentaCto").click(function(e){

		e.preventDefault();


		var optEjecutivoVenta = $("input[name=optEjecutivoVentaBusqueda]:checked");
//		var opt = $("input[type=radio]:checked");

		$("#txtIdEjecutivoVenta").val(optEjecutivoVenta.val());

		$("#txtEjecutivoVenta").val(optEjecutivoVenta.attr("data-nombre"));

		$("#modalListadoEjecutivoVenta").modal("hide");

	});


	function VerMensaje() {
		 swal("Mensaje del Sistema", "Holla", "success");
	}

	function SaveOrUpdate(e){

		e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/ContratoAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            swal("Mensaje del Sistema", r, "success");

//            Limpiar();

//            ListadoContrato();

//            OcultarForm();

        });

	};

	function SaveOrUpdatePrecios(e){

		e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/ContratoAjax.php?op=SaveOrUpdatePrecios", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

		    $("#tabplan").show(500);

            swal("Mensaje del Sistema", r, "success");

//            Limpiar();

//            ListadoContrato();

//            OcultarForm();

        });

	};


	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdContrato").val("");

		$("#txtNroContrato").val("");

		$("#cboCementerioLot").val("");

	    $("#cboSectorSelCto").val("");

	    $("#txtIdSectorCto").val("");

	    $("#cboLoteSelCto").val("");

	    $("#txtIdLoteCto").val("");

	    $("#txtIdAdquiriente").val("");

	    $("#txtAdquiriente").val("");

	    $("#txtIdEjecutivoVenta").val("");

	    $("#txtEjecutivoVenta").val("");

	    $("#txtObservaciones").val("");

	    $("#txtFechaContrato").val("");
	}

	function LimpiarPrecios(){

		// Limpiamos las cajas de texto

		$("#cboTipoPrecio").val("PNI");

		$("#txtPrecio").val("0");

		$("#txtIncrementoPlazo").val("0");

		$("#txtCuotaInicial").val("0");

	    $("#txtPlazoMeses").val("0");

	    $("#txtCuotaMensual").val("0");

	    $("#txtCuotaMensualh").val("0");

	    $("#txtFechaPago").val("");
	}


	function VerForm(){

		ComboSectorSel();

 		$("#VerForm").show();// Mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();

	   	$("#tabplan").hide(500);

	}



	function OcultarForm(){

		$("#VerForm").hide();// Mostramos el formulario

		$("#btnNuevo").show();// ocultamos el boton nuevo

		$("#VerListado").show();

	}



}



function ListadoContrato(){

        var tabla = $('#tblContrato').dataTable(

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

                    {   "mDataProp": "5"},

                    {   "mDataProp": "6"},

                    {   "mDataProp": "7"}

            ],"ajax":

                {

                    url: './ajax/ContratoAjax.php?op=list',

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };

function ListadoPlandePagos($idcontrato){

        var tabla = $('#tblPlandePago').dataTable(

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

                    {   "mDataProp": "3"}

            ],"ajax":

                {

                    url: './ajax/ContratoAjax.php?op=listPlandePagos?idcontrato=' + $idcontrato,

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };


function eliminarContrato(id, idlote){// funcion que llamamos del archivo ajax/CategoriaAjax.php?op=delete linea 53

	swal({
	  title: "¿Esta Seguro de eliminar el Contrato seleccionado?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		$.post("./ajax/ContratoAjax.php?op=delete", {id : id, idlote : idlote}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

			swal("Mensaje del Sistema", e, "success");

			ListadoContrato();

        });
	});

/*
	bootbox.confirm("¿Esta Seguro de eliminar el Contrato seleccionado?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/ContratoAjax.php?op=delete", {id : id, idlote : idlote}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

				swal("Mensaje del Sistema", e, "success");

				ListadoContrato();

            });
		}
	})
*/

}

function plandePagos(idcontrato,nrocontrato) {

	$.post("./ajax/ContratoAjax.php?op=PlandePagos", {idcontrato : idcontrato} );

	swal({
	  title: "¿Esta Seguro de ver el Plan de Pagos?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		verPlandePagos('Files/Pdf/Plan de Pagos. Contrato Nro. ' + nrocontrato + '.pdf');
	});

/*

	bootbox.confirm("¿Esta Seguro de generar el Plan de Pagos?" , function(result) { 
		if (result) {
			verPlandePagos('Files/Pdf/Plan de Pagos. Contrato Nro. ' + nrocontrato + '.pdf');
		}
	})
*/
}

function consultarPlandePagos(nrocontrato) {

	swal({
	  title: "¿Esta Seguro de ver el Plan de Pagos?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		verPlandePagos('Files/Pdf/Plan de Pagos. Contrato Nro. ' + nrocontrato + '.pdf');
	});
/*
	bootbox.confirm("¿Esta Seguro de ver el Plan de Pagos?" , function(result){ 

		if(result) {
			verPlandePagos('Files/Pdf/Plan de Pagos. Contrato Nro. ' + nrocontrato + '.pdf');
		}

	})
*/
}

function verPlandePagos(url) {
	var a = document.createElement("a");
	a.target = "_blank";
	a.href = url;
	a.click();
}

	function ComboCementerio(){

		$.post("./ajax/ContratoAjax.php?op=listCementerio", function(r){

            $("#cboCementerioLot").html(r);

            ComboSectorSel();

        });

	}

	function ComboSectorSel(){

		habilitado = 0;
		idsector = $("#txtIdSectorCto").val();

		if ($("#txtNroContrato").val()=="") {
			habilitado = 1;
		};
		
		$.post("./ajax/ContratoAjax.php?op=listSector", {idsector: idsector, habilitado : habilitado}, function(r){

            $("#cboSectorSelCto").html(r);
            $("#txtIdSectorCto").val($("#cboSectorSelCto").val());

            ComboLoteSel();

//			swal("Mensaje del Sistema", $("#cboSectorSelCto").val(), "success");

        });

	}

    function ComboLoteSel() {

		idsector = $("#txtIdSectorCto").val();
		idlote = $("#txtIdLoteCto").val();

		habilitado = 0;
		if ($("#txtNroContrato").val()=="") {
			habilitado = 1;
		};

        $.post("./ajax/ContratoAjax.php?op=listLote", {idsector : idsector, idlote : idlote, habilitado : habilitado}, function(r) {
            $("#cboLoteSelCto").html(r);
            ActualizaFilaColumna($('#cboLoteSelCto').val());
	        ComboPrecio($('#cboTipoPrecio').val(),$('#cboSectorSelCto').val());
        });

    }

    function ComboPrecio(tipoprecio,idsector) {
        if (idsector.length > 0 ) {
        $.post("./ajax/ContratoAjax.php?op=listPrecioSector", {idsector : idsector}, function(r){
            precioni = r.substr(0,r.indexOf("-"));
            precionf = r.substr(r.indexOf("-") + 1);
            if (tipoprecio == 'PNI') {
            	$("#txtPrecio").val(precioni);
            } else {
            	$("#txtPrecio").val(precionf);
        	}
	        ActualizaCuotaMensual($('#txtPrecio').val(),$('#txtIncrementoPlazo').val(),$('#txtCuotaInicial').val(),$('#txtPlazoMeses').val());
        });
    	}

    }

    function ActualizaFilaColumna(idlote=0) {
    	if (idlote!=0) {
	        $.post("./ajax/ContratoAjax.php?op=listDetalleLote", {idlote : idlote}, function(r){
	        	if (r!=' ') {
		            fila = r.substr(0,r.indexOf("-"));
		            columna = r.substr(r.indexOf("-") + 1);
		            $("#txtFila").val(fila);
		            $("#txtColumna").val(columna);
	        	}
	        });
    	}

    }

function cargardetallelote(fila, columna) {
	$("#txtFila").val(fila);
	$("#txtColumna").val(columna);
}

function ActualizaCuotaMensual(precio, incrementoplazo, cuotainicial, plazomeses) {

	var precion = parseFloat(precio);
	var incrementoplazon = parseFloat(incrementoplazo);
	var cuotainicialn = parseFloat(cuotainicial);
	var plazomesesn = parseFloat(plazomeses);

	if (precion<0) {
		precion = precion * -1;
	}
	if (incrementoplazon<0) {
		incrementoplazon = incrementoplazon * -1;
	}
	if (cuotainicialn<0) {
		cuotainicialn = cuotainicialn * -1;
	}
	if (plazomesesn<0) {
		plazomesesn = plazomesesn * -1;
	}

	if ( plazomesesn>0) {
	$("#txtPrecio").val(precion.toFixed(2));
	$("#txtIncrementoPlazo").val(incrementoplazon.toFixed(2));
	$("#txtCuotaInicial").val(cuotainicialn.toFixed(2));
	$("#txtPlazoMeses").val(plazomesesn.toFixed(0));
	if ( ( precion>0) && (plazomesesn>0) ) {
		cuotamensual = ( (precion + incrementoplazon - cuotainicialn) / plazomesesn );
		$("#txtCuotaMensual").val( cuotamensual.toFixed(2) );
		$("#txtCuotaMensualh").val( cuotamensual.toFixed(2) );
	} else {
		$("#txtCuotaMensual").val(0.00);
		$("#txtCuotaMensualh").val(0.00);
	};
	}

 	
}

function cargarDataContrato(id, nrocontrato, idlote, idsector, idcementerio, observaciones, idadquiriente, adquiriente, idejecutivoventa, ejecutivoventa, fila, columna, tipoprecio, precio, cuotainicial, plazomeses, cuotamensual, incrementoplazo, fechacontrato, fechapago) {

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();

		$("#txtIdContrato").val(id);// recibimos la variable id a la caja de texto

		$("#txtIdContrato2").val(id);// recibimos la variable id a la caja de texto

	    $("#txtNroContrato").val(nrocontrato);

	    $("#txtIdSectorCto").val(idsector);

		ComboSectorSel();

	    $("#cboSectorSelCto").val(idsector);

	    $("#cboCementerioLot").val(idcementerio);

	    $("#txtIdLoteCto").val(idlote);

//        ComboLoteSel();

	    $("#cboLoteSelCto").val(idlote);

		$("#txtFila").val(fila);// recibimos la variable id a la caja de texto

		$("#txtColumna").val(columna);// recibimos la variable id a la caja de texto

	    $("#txtIdAdquiriente").val(idadquiriente);

	    $("#txtAdquiriente").val(adquiriente);

	    $("#txtIdEjecutivoVenta").val(idejecutivoventa);

	    $("#txtEjecutivoVenta").val(ejecutivoventa);

	    $("#txtFechaContrato").val(fechacontrato);

	    $("#txtObservaciones").val(observaciones);

		$("#cboTipoPrecio").val(tipoprecio);

		$("#txtPrecio").val(precio);

		$("#txtIncrementoPlazo").val(incrementoplazo);

		$("#txtCuotaInicial").val(cuotainicial);

	    $("#txtPlazoMeses").val(plazomeses);

	    $("#txtCuotaMensual").val(cuotamensual);

	    $("#txtCuotaMensualh").val(cuotamensual);

	    $("#txtFechaPago").val(fechapago);

	    if (cuotamensual>0) {
	    	$("#tabplan").show(500);
	    } else {
	    	$("#tabplan").hide(500);
	    }


	    $("#txtNroContrato").attr('disabled',true);
	    $("#cboCementerioLot").attr('disabled',true);
	    $("#cboSectorSelCto").attr('disabled',true);
	    $("#cboLoteSelCto").attr('disabled',true);


 	}

	function AbrirModalAdquiriente(){

		$("#modalListadoAdquiriente").modal("show");

		$.post("./ajax/ContratoAjax.php?op=listAdquiriente", function(r){

            $("#Adquiriente").html(r);

            $('#tblAdquiriente').DataTable();

        });

	}

	function AbrirModalEjecutivoVenta(){

		$("#modalListadoEjecutivoVenta").modal("show");

		$.post("./ajax/ContratoAjax.php?op=listEjecutivoVenta", function(r){

            $("#EjecutivoVenta").html(r);

            $('#tblEjecutivoVenta').DataTable();

        });

	}

	function CargarPlandePagos() {


		idcontrato = $("#txtIdContrato").val();

 		$.post("./ajax/ContratoAjax.php?op=listPlandePagos", {idcontrato : idcontrato}, function(r){

            $("#PlandePago").html(r);

            $('#tblPlandePago').DataTable();

        });

	}

