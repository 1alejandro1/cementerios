$(document).on("ready", init);// Inciamos el jquery


function valida(e){

tecla = (document.all) ? e.keyCode : e.which;



//Tecla de retroceso para borrar, siempre la permite

if (tecla==8){

return true;

}



// Patron de entrada, en este caso solo acepta numeros

patron =/[0-9-.]/;

tecla_final = String.fromCharCode(tecla);

return patron.test(tecla_final);

}




function init(){



	$('#tblEjecutivoVenta').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoEjecutivoVenta();// Ni bien carga la pagina que cargue el metodo

	ComboTipoDocumento();

	ComboEstadoCivil();

	$("#VerForm").hide();// Ocultamos el formulario

    $("#btnLimpiar").click(LimpiarGarante);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos
	$("form#frmEjecutivoVenta").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos
	$("form#frmEjecutivoVentaGarante").submit(SaveOrUpdateGarante);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos

	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm


	function SaveOrUpdate(e){

		e.preventDefault();

        var formData = new FormData($("#frmEjecutivoVenta")[0]);

        $.ajax({

                url: "./ajax/EjecutivoVentaAjax.php?op=SaveOrUpdate",

                type: "POST",

                data: formData,

                contentType: false,

                processData: false,

                success: function(datos)
                {

                    swal("Mensaje del Sistema", datos, "success");

//                    ListadoEjecutivoVenta();

//                    OcultarForm();

//                    Limpiar();

                }

            });
	};

	function SaveOrUpdateGarante(e){

		e.preventDefault();

        var formData = new FormData($("#frmEjecutivoVentaGarante")[0]);

		datosok = 0;
		if ( ($("#txtNombreGarante").val().length) && ($("#txtApellidosGarante").val().length) && ($("#txtNumDocumentoGarante").val().length) && ($("#txtDireccionGarante").val().length) && ($("#txtTelefonoGarante").val().length)) {
			datosok = 1;
		} else {
			if ( (!$("#txtNombreGarante").val().length) && (!$("#txtApellidosGarante").val().length) && (!$("#txtNumDocumentoGarante").val().length) && (!$("#txtDireccionGarante").val().length) && (!$("#txtTelefonoGarante").val().length)) {
				datosok = 1;
			}
		}

		if (datosok==0) {
			if ( !$("#txtApellidosGarante").val().length ) {
//				swal("Mensaje del Sistema", "Falta completar los Apellidos del Adjunto..." , "error");
				$("#txtApellidosGarante").focus();
        	return;
			};
			
			if ( !$("#txtNombreGarante").val().length ) {
//				swal("Mensaje del Sistema", "Falta completar el Nombre del Adjunto..." , "error");
				$("#txtNombreGarante").focus();
        	return;
			}
			if ( !$("#txtNumDocumentoGarante").val().length ) {
//				swal("Mensaje del Sistema", "Falta completar el Número de Documento del Adjunto ..." , "error");
				$("#txtNumDocumentoGarante").focus();
        	return;
			} 
			if ( !$("#txtDireccionGarante").val().length ) {
//				swal("Mensaje del Sistema", "Falta completar la Dirección del Adjunto..." , "error");
				$("#txtDireccionGarante").focus();
			}
			return;
			if ( !$("#txtTelefonoGarante").val().length ) {
				//				swal("Mensaje del Sistema", "Falta completar la Dirección del Adjunto..." , "error");
								$("#txtTelefonoGarante").focus();
							}
							return;

		}

        $.ajax({

                url: "./ajax/EjecutivoVentaAjax.php?op=SaveOrUpdateGarante",

                type: "POST",

                data: formData,

                contentType: false,

                processData: false,

                success: function(datos)
                {

                	if ( datos == "Error") {
                    	swal("Mensaje del Sistema", "La información del Garante no ha podido ser actualizada.", "error");
                	} else {
	                    swal("Mensaje del Sistema", datos, "success");
                	}


//                    ListadoAdquiriente();

//                    OcultarForm();

//                    LimpiarAdjunto();

                },

            });
	};

	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdEjecutivoVenta").val("");

	    $("#txtNombre").val("");

	    $("#txtApellidos").val("");

	    $("#txtNumDocumento").val("");

	    $("#txtDireccion").val("");

	    $("#txtZona").val("");

	    $("#txtCiudad").val("");

	    $("#txtTelefono").val("");

	    $("#txtCelular").val("");

	    $("#cboEstadoCivil").val("");

	    $("#txtEmail").val("");

	    $("#txtObservaciones").val("");

	    $("#txtFechaIngreso").val("");

	}

	function LimpiarGarante(){

	    $("#txtNombreGarante").val("");

	    $("#txtApellidosGarante").val("");

	    $("#txtNumDocumentoGarante").val("");

		$("#txtDireccionGarante").val("");
		
		$("#txtTelefonoGarante").val("");
	}


	function VerForm(){

		$("#VerForm").show();// Mostramos el formulario

		$("#btnNuevo").hide();

		$("#VerListado").hide();// ocultamos el listado

	}



	function OcultarForm(){

		$("#VerForm").hide();// Mostramos el formulario

		$("#btnNuevo").show();// ocultamos el boton nuevo

		$("#VerListado").show();

	}

}



function ListadoEjecutivoVenta(){

	var tabla = $('#tblEjecutivoVenta').dataTable(

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

	        		url: './ajax/EjecutivoVentaAjax.php?op=list',

					type : "get",

					dataType : "json",

					error: function(e){

				   		console.log(e.responseText);

					}

	        	},

	        "bDestroy": true



    	}).DataTable();

    };



function eliminarEjecutivoVenta(id){// funcion que llamamos del archivo ajax/CategoriaAjax.php?op=delete linea 53

	swal({
	  title: "¿Esta Seguro de eliminar el Ejecutivo de Venta seleccionado?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		$.post("./ajax/EjecutivoVentaAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

            swal("Mensaje del Sistema", e, "success");

			ListadoEjecutivoVenta();

        });
	});

/*
	bootbox.confirm("¿Esta Seguro de eliminar el Ejecutivo de Venta seleccionado?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/EjecutivoVentaAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

                swal("Mensaje del Sistema", e, "success");

				ListadoEjecutivoVenta();

            });

		}
	})
*/
}



function cargarDataEjecutivoVenta(id,apellidos, nombre,tipodocumento,numdocumento,direccion,telefono,celular,estadocivil,email,estado, zona,ciudad,observaciones,fechaingreso,apellidosgarante,nombregarante,numdocumentogarante,telefonogarante,direcciongarante,imagen1,imagen2) {

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();

		$("#VerListado").hide();// ocultamos el listado


		$("#txtIdEjecutivoVenta").val(id);// recibimos la variable id a la caja de texto txtIdCategoria

		$("#txtIdEjecutivoVenta2").val(id);// recibimos la variable id a la caja de texto txtIdCategoria

	    $("#txtApellidos").val(apellidos);

	    $("#txtNombre").val(nombre);

 		$("#cboTipoDocumento").val(tipodocumento);

 		$("#txtNumDocumento").val(numdocumento);

 		$("#txtDireccion").val(direccion);

	    $("#txtZona").val(zona);

	    $("#txtCiudad").val(ciudad);

 		$("#txtTelefono").val(telefono);

 		$("#txtCelular").val(celular);

	    $("#cboEstadoCivil").val(estadocivil);

 		$("#txtEmail").val(email);

 		$("#cboEstado").val(estado);

	    $("#txtObservaciones").val(observaciones);

	    $("#txtFechaIngreso").val(fechaingreso);

	    $("#txtNombreGarante").val(nombregarante);

	    $("#txtApellidosGarante").val(apellidosgarante);

		$("#txtNumDocumentoGarante").val(numdocumentogarante);
		
		$("#txtTelefonoGarante").val(telefonogarante);

	    $("#txtDireccionGarante").val(direcciongarante);

 		$("#txtRutaImg1").val(imagen1);

	    $("#txtRutaImg1").show();

 		$("#txtRutaImg2").val(imagen2);

	    $("#txtRutaImg2").show();
 	}





 	function ComboTipoDocumento() {

        $.get("./ajax/EjecutivoVentaAjax.php?op=listTipoDocumentoPersona", function(r) {

                $("#cboTipoDocumento").html(r);

        })

    }

 	function ComboEstadoCivil() {

        $.get("./ajax/EjecutivoVentaAjax.php?op=listEstadoCivil", function(r) {

                $("#cboEstadoCivil").html(r);

        })

    }
