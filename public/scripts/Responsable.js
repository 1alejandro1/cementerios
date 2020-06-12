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



	$('#tblResponsable').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoResponsable();// Ni bien carga la pagina que cargue el metodo

	ComboTipoDocumento();

	$("#VerForm").hide();// Ocultamos el formulario

	$("form#frmResponsable").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos



	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm

	$("#btnBuscarDifuntoRes").click(AbrirModalDifuntoRes);


	$("#btnAgregarDifunto").click(function(e){

		e.preventDefault();


		var opt = $("input[type=radio]:checked");

		$("#txtIdDifunto").val(opt.val());

		$("#txtDifunto").val(opt.attr("data-nombre"));

		$("#modalListadoDifunto").modal("hide");

	});


	function SaveOrUpdate(e){

		e.preventDefault();

		if ($("#txtIdDifunto").val() != "") {

	        var formData = new FormData($("#frmResponsable")[0]);

	        $.ajax({

	                url: "./ajax/ResponsableAjax.php?op=SaveOrUpdate",

	                type: "POST",

	                data: formData,

	                contentType: false,

	                processData: false,

	                success: function(datos)
	                {

	                    swal("Mensaje del Sistema", datos, "success");

	                    ListadoResponsable();

	                    OcultarForm();

	                    Limpiar();

	                }

	            });
	    } else {

	    	bootbox.alert("Debe elegir un Difunto");

	    }
	};

	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdResponsable").val("");

	    $("#txtIdDifunto").val("");

	    $("#txtDifunto").val("");

	    $("#txtNombre").val("");

	    $("#txtApellidos").val("");

	    $("#txtNumDocumento").val("");

	    $("#txtDireccion").val("");

	    $("#txtTelefono").val("");

	    $("#txtCelular").val("");

	    $("#txtEmail").val("");

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



function ListadoResponsable(){

	var tabla = $('#tblResponsable').dataTable(

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

	        		url: './ajax/ResponsableAjax.php?op=list',

					type : "get",

					dataType : "json",

					error: function(e){

				   		console.log(e.responseText);

					}

	        	},

	        "bDestroy": true



    	}).DataTable();

    };



function eliminarResponsable(id){// funcion que llamamos del archivo ajax/CategoriaAjax.php?op=delete linea 53

	swal({
	  title: "¿Esta Seguro de eliminar el Responsable seleccionado?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		$.post("./ajax/ResponsableAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

            swal("Mensaje del Sistema", e, "success");

			ListadoResponsable();

        });
	});

/*
	bootbox.confirm("¿Esta Seguro de eliminar el Responsable seleccionado?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/ResponsableAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

                swal("Mensaje del Sistema", e, "success");

				ListadoResponsable();

            });

		}
	})
*/
}



function cargarDataResponsable(id,apellidos, nombre,tipodocumento,numdocumento,direccion,telefono,celular,email,estado,iddifunto,difunto){// funcion que llamamos del archivo ajax/CategoriaAjax.php linea 52

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();

		$("#VerListado").hide();// ocultamos el listado


		$("#txtIdDifunto").val(iddifunto);// recibimos la variable id a la caja de texto txtIdCategoria

		$("#txtDifunto").val(difunto);// recibimos la variable id a la caja de texto txtIdCategoria

		$("#txtIdResponsable").val(id);// recibimos la variable id a la caja de texto txtIdCategoria

	    $("#txtApellidos").val(apellidos);

	    $("#txtNombre").val(nombre);

 		$("#cboTipoDocumento").val(tipodocumento);

 		$("#txtNumDocumento").val(numdocumento);

 		$("#txtDireccion").val(direccion);

 		$("#txtTelefono").val(telefono);

 		$("#txtCelular").val(celular);

 		$("#txtEmail").val(email);

 		$("#cboEstado").val(estado);

 	}





 	function ComboTipoDocumento() {

        $.get("./ajax/ResponsableAjax.php?op=listTipoDocumentoPersona", function(r) {

                $("#cboTipoDocumento").html(r);

        })

    }

	function AbrirModalDifuntoRes(){

		$("#modalListadoDifunto").modal("show");

		$.post("./ajax/ResponsableAjax.php?op=listDifunto", function(r){

            $("#DifuntoRes").html(r);

            $('#tblDifuntosRes').DataTable();

        });

	}
