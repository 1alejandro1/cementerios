	$(document).on("ready", init);// Inciamos el jquery

function init(){

    $('#tblExhumacion').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoExhumacion();// Ni bien carga la pagina que cargue el metodo

	$("#VerForm").hide();// Ocultamos el formulario

	$("form#frmExhumacion").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos

	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm


	$("#btnBuscarContratoExh").click(AbrirModalContratoExh);

	$("#btnBuscarPersonal").click(AbrirModalPersonal);


	$("#btnAgregarContratoExh").click(function(e) {
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

		$("#txtDifunto").val(opt.attr("data-difunto"));

		$("#txtFechaFallecimiento").val(opt.attr("data-fechafallecimiento"));

		$("#txtFechaInhumacion").val(opt.attr("data-fechainhumacion"));

		$("#modalListadoContrato").modal("hide");
	});

	$("#btnAgregarPersonalExh").click(function(e) {

		e.preventDefault();

		var optPersonal = $("input[name=optPersonalBusqueda]:checked");

		$("#txtIdPersonal").val(optPersonal.val());
		$("#txtPersonal").val(optPersonal.attr("data-nombre"));
		$("#modalListadoPersonal").modal("hide");
	});



	function SaveOrUpdate(e){

		e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/ExhumacionAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            swal("Mensaje del Sistema", r, "success");

            Limpiar();

            ListadoExhumacion();

            OcultarForm();

        });

	};


	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdExhumacion").val("");

		$("#txtIdContrato").val("");

		$("#txtContrato").val("");

		$("#txtFechaContrato").val("");

		$("#txtCementerio").val("");

		$("#txtSector").val("");

		$("#txtLote").val("");

		$("#txtFila").val("");

		$("#txtColumna").val("");

		$("#txtDifunto").val("");

		$("#txtFechaFallecimiento").val("");

		$("#txtFechaInhumacion").val("");

		$("#txtFechaRegistro").val("");

		$("#txtTipo").val("");
		
		$("#txtFechaExhumacion").val("");

	    $("#txtIdPersonal").val("");

		$("#txtPersonal").val("");

	    $("#txtObservaciones").val("");

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



function ListadoExhumacion(){

        var tabla = $('#tblExhumacion').dataTable(

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

                    {   "mDataProp": "6"}

            ],"ajax":

                {

                    url: './ajax/ExhumacionAjax.php?op=list',

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };



function eliminarExhumacion(id){

	swal({
	  title: "¿Esta Seguro de eliminar la Exhumación seleccionada?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		$.post("./ajax/ExhumacionAjax.php?op=delete", {id : id}, function(e) {

			swal("Mensaje del Sistema", e, "success");

			ListadoExhumacion();

        });
	});

/*
	bootbox.confirm("¿Esta Seguro de eliminar la Exhumación seleccionada?", function(result){ 

		if(result){// si el result es true

			$.post("./ajax/ExhumacionAjax.php?op=delete", {id : id}, function(e) {

				swal("Mensaje del Sistema", e, "success");

				ListadoExhumacion();

            });

		}

	})
*/
}

function verCertificadoExhumacion(url) {
	var a = document.createElement("a");
	a.target = "_blank";
	a.href = url;
	a.click();
}

function certificadoExhumacion(id,nrocontrato){

	$.post("./ajax/ExhumacionAjax.php?op=CertificadoExhumacion", {id : id} );

	swal({
	  title: "¿Esta Seguro de generar el Certificado de Exhumación?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		verCertificadoExhumacion('Files/Pdf/Certificado de Exhumacion. Contrato ' + nrocontrato + '.pdf');
	});
/*
	bootbox.confirm("¿Esta Seguro de generar el Certificado de Exhumación?" , function(result) { 
		if (result) {
			verCertificadoExhumacion('Files/Pdf/Certificado de Exhumacion. Contrato ' + nrocontrato + '.pdf');
		}

	})
*/
}


function cargarDataExhumacion(id, idcontrato,fechaexhumacion,fecharegistro,tipo,idpersonal,observaciones,nrocontrato,fechacontrato,difunto,fechafallecimiento,fechainhumacion,personal,cementerio,sector,lote,fila,columna) {

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();


		$("#txtIdExhumacion").val(id);

		$("#txtIdContrato").val(idcontrato);

		$("#txtContrato").val(nrocontrato);

		$("#txtFechaContrato").val(fechacontrato);

		$("#txtCementerio").val(cementerio);

		$("#txtSector").val(sector);

		$("#txtLote").val(lote);

		$("#txtFila").val(fila);

		$("#txtColumna").val(columna);

		$("#txtDifunto").val(difunto);

		$("#txtFechaFallecimiento").val(fechafallecimiento);

		$("#txtFechaInhumacion").val(fechainhumacion);

		$("#txtFechaRegistro").val(fecharegistro);

		$("#txtTipo").val(tipo);
		
		$("#txtFechaExhumacion").val(fechaexhumacion);

	    $("#txtIdPersonal").val(idpersonal);

		$("#txtPersonal").val(personal);

	    $("#txtObservaciones").val(observaciones);

 	}

	function AbrirModalContratoExh(){

		$("#modalListadoContrato").modal("show");

		$.post("./ajax/ExhumacionAjax.php?op=listContrato", function(r){

            $("#ContratoDetalle").html(r);

            $('#tblContratos').DataTable();

        });

	}

	function AbrirModalPersonal(){

		$("#modalListadoPersonal").modal("show");

		$.post("./ajax/ExhumacionAjax.php?op=listPersonal", function(r){

            $("#PersonalDetalle").html(r);

            $('#tblPersonales').DataTable();

        });

	}

