$(document).on("ready", init);// Inciamos el jquery

function init(){

    $('#tblInhumacion').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoInhumacion();// Ni bien carga la pagina que cargue el metodo

	$("#VerForm").hide();// Ocultamos el formulario

	$("form#frmInhumacion").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos

	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm


	$("#btnBuscarContratoInh").click(AbrirModalContrato);

	$("#btnBuscarDifunto").click(AbrirModalDifunto);

	$("#btnBuscarPersonal").click(AbrirModalPersonal);


	$("#btnAgregarContratoInh").click(function(e) {
		e.preventDefault();

		var opt = $("input[name=optContratoBusqueda]:checked");
//		var opt = $("input[type=radio]:checked");

  		$("#txtIdContrato").val(opt.val());

		$("#txtContrato").val(opt.attr("data-nombre"));

		$("#txtCementerio").val(opt.attr("data-cementerio"));

		$("#txtSector").val(opt.attr("data-sector"));

		$("#txtLote").val(opt.attr("data-lote"));

		$("#txtFila").val(opt.attr("data-fila"));

		$("#txtColumna").val(opt.attr("data-columna"));

		$("#txtFechaContrato").val(opt.attr("data-fechacontrato"));

		$("#modalListadoContratoInh").modal("hide");
	});

	$("#btnAgregarDifuntoInh").click(function(e) {

		e.preventDefault();
		var opt = $("input[name=optDifuntoBusqueda]:checked");
//		var opt = $("input[type=radio]:checked");

		$("#txtIdDifunto").val(opt.val());
		$("#txtDifunto").val(opt.attr("data-nombre"));
		$("#modalListadoDifunto").modal("hide");
	});

	$("#btnAgregarPersonalInh").click(function(e) {

		e.preventDefault();

		var optPersonal = $("input[name=optPersonalBusqueda]:checked");
//		var optPersonal = $("input[type=radio]:checked");

		$("#txtIdPersonal").val(optPersonal.val());
		$("#txtPersonal").val(optPersonal.attr("data-nombre"));
		$("#modalListadoPersonal").modal("hide");
	});



	function SaveOrUpdate(e){

		e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/InhumacionAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            swal("Mensaje del Sistema", r, "success");

            Limpiar();

            ListadoInhumacion();

            OcultarForm();

        });

	};


	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdInhumacion").val("");

		$("#txtIdContrato").val("");

		$("#txtIdDifunto").val("");

		$("#txtFechaFallecimiento").val("");

		$("#txtFechaInhumacion").val("");

		$("#txtFechaRegistro").val("");

	    $("#txtIdPersonal").val("");

		$("#txtObservaciones").val("");
		$("#txtCodigo").val("");

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



function ListadoInhumacion(){

        var tabla = $('#tblInhumacion').dataTable(

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

                    url: './ajax/InhumacionAjax.php?op=list',

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };



function eliminarInhumacion(id){

	swal({
	  title: "¿Esta Seguro de eliminar la Inhumación seleccionada?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		$.post("./ajax/InhumacionAjax.php?op=delete", {id : id}, function(e) {

			swal("Mensaje del Sistema", e, "success");

			ListadoInhumacion();

        });
	});

/*
	bootbox.confirm("¿Esta Seguro de eliminar la Inhumación seleccionada?", function(result){ 

		if(result){// si el result es true

			$.post("./ajax/InhumacionAjax.php?op=delete", {id : id}, function(e) {

				swal("Mensaje del Sistema", e, "success");

				ListadoInhumacion();

            });

		}

	})
*/
}

function verCertificadoObito(url) {
	var a = document.createElement("a");
	a.target = "_blank";
	a.href = url;
	a.click();
}

function certificadoObito(id,nrocontrato){

	$.post("./ajax/InhumacionAjax.php?op=CertificadoObito", {id : id} );

	swal({
	  title: "¿Esta Seguro de generar el Certificado de Óbito?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		verCertificadoObito('Files/Pdf/Certificado de Obito. Contrato ' + nrocontrato + '.pdf');
	});
/*
	bootbox.confirm("¿Esta Seguro de generar el Certificado de Óbito?" , function(result) { 
		if (result) {
			verCertificadoObito('Files/Pdf/Certificado de Obito. Contrato ' + nrocontrato + '.pdf');
		}
	})
*/
}


function cargarDataInhumacion(id, codigo, idcontrato,iddifunto,fechafallecimiento,fechainhumacion,fecharegistro,idpersonal,nivel,observaciones,nrocontrato,fechacontrato,difunto,personal,cementerio,sector,lote,fila,columna) {

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();


		$("#txtIdInhumacion").val(id);

		$("#txtCodigo").val(codigo);

		$("#txtIdContrato").val(idcontrato);

		$("#txtContrato").val(nrocontrato);

		$("#txtFechaContrato").val(fechacontrato);

		$("#txtCementerio").val(cementerio);

		$("#txtSector").val(sector);

		$("#txtLote").val(lote);

		$("#txtFila").val(fila);

		$("#txtColumna").val(columna);

		$("#txtIdDifunto").val(iddifunto);

		$("#txtDifunto").val(difunto);

		$("#txtFechaFallecimiento").val(fechafallecimiento);

		$("#txtFechaInhumacion").val(fechainhumacion);

		$("#txtFechaRegistro").val(fecharegistro);

		$("#txtIdPersonal").val(idpersonal);
		
		$("#txtNivel").val(nivel);

		$("#txtPersonal").val(personal);

	    $("#txtObservaciones").val(observaciones);

 	}

	function AbrirModalContrato(){

		$("#modalListadoContratoInh").modal("show");

		$.post("./ajax/InhumacionAjax.php?op=listContrato", function(r){

            $("#ContratoDetalle").html(r);

            $('#tblContratos').DataTable();

        });

	}

	function AbrirModalDifunto(){

		$("#modalListadoDifunto").modal("show");

		$.post("./ajax/InhumacionAjax.php?op=listDifunto", function(r){

            $("#DifuntoDetalle").html(r);

            $('#tblDifuntos').DataTable();

        });

	}

	function AbrirModalPersonal(){

		$("#modalListadoPersonal").modal("show");

		$.post("./ajax/InhumacionAjax.php?op=listPersonal", function(r){

            $("#PersonalDetalle").html(r);

            $('#tblPersonales').DataTable();

        });

	}

