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



	$('#tblPersonal').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoPersonal();// Ni bien carga la pagina que cargue el metodo

	ComboTipoDocumento();

	$("#VerForm").hide();// Ocultamos el formulario

	$("#txtClaveOtro").hide();

	$("form#frmPersonal").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos



	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm



	function SaveOrUpdate(e){

		e.preventDefault();



        var formData = new FormData($("#frmPersonal")[0]);



        $.ajax({



                url: "./ajax/PersonalAjax.php?op=SaveOrUpdate",



                type: "POST",



               data: formData,



                contentType: false,



                processData: false,



                success: function(datos)



                {



                    swal("Mensaje del Sistema", datos, "success");

                    ListadoPersonal();

                    OcultarForm();

                    Limpiar();

                }



            });

	};



	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdPersonal").val("");

	    $("#txtNombre").val("");

	    $("#txtApellidos").val("");

	    $("#txtNumDocumento").val("");

	    $("#txtDireccion").val("");

	    $("#txtTelefono").val("");

	    $("#txtEmail").val("");

	    $("#txtRepresentante").val("");

	    $("#txtLogin").val("");

	    $("#txtClave").val("");

	    $("#txtClaveOtro").val("");

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



function ListadoPersonal(){

	var tabla = $('#tblPersonal').dataTable(

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

                    {   "mDataProp": "7"},

                    {   "mDataProp": "8"}



        	],"ajax":

	        	{

	        		url: './ajax/PersonalAjax.php?op=list',

					type : "get",

					dataType : "json",



					error: function(e){

				   		console.log(e.responseText);

					}

	        	},

	        "bDestroy": true



    	}).DataTable();

    };



function eliminarPersonal(id){// funcion que llamamos del archivo ajax/CategoriaAjax.php?op=delete linea 53

	swal({
	  title: "¿Esta Seguro de eliminar el Personal seleccionado?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		$.post("./ajax/PersonalAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

            swal("Mensaje del Sistema", e, "success");

			ListadoPersonal();
        });
	});

/*
	bootbox.confirm("¿Esta Seguro de eliminar el Personal?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/PersonalAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

                swal("Mensaje del Sistema", e, "success");

				ListadoPersonal();
            });

		}
	})
*/
}



function cargarDataPersonal(id,apellidos, nombre,tipodocumento,numdocumento,direccion,telefono,email,fechanacimiento,foto, login, clave,estado){// funcion que llamamos del archivo ajax/CategoriaAjax.php linea 52

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();

		$("#VerListado").hide();// ocultamos el listado



		$("#txtIdPersonal").val(id);// recibimos la variable id a la caja de texto txtIdCategoria

	    $("#txtApellidos").val(apellidos);

	    $("#txtNombre").val(nombre);

 		$("#cboTipoDocumento").val(tipodocumento);

 		$("#txtNumDocumento").val(numdocumento);

 		$("#txtDireccion").val(direccion);

 		$("#txtTelefono").val(telefono);

 		$("#txtEmail").val(email);

 		$("#txtFechaNacimiento").val(fechanacimiento);

 		//$("#txtLogo").val(logo);

 		$("#txtRutaImgPer").val(foto);

 		$("#txtLogin").val(login);

 		$("#txtClave").attr('required',false);
 		$("#textoClave").text("Clave :");

	    $("#txtRutaImgPer").show();

 		$("#cboEstado").val(estado);

 		$("#txtClaveOtro").val(clave);

 		//$("#txtClaveOtro").show();

 	}





 	function ComboTipoDocumento() {



        $.get("./ajax/PersonalAjax.php?op=listTipoDocumentoPersona", function(r) {

                $("#cboTipoDocumento").html(r);



        })

    }

