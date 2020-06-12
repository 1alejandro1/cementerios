$(document).on("ready", init);// Inciamos el jquery



var objC = new init();



function init(){





	var tabla = $('#tblEstadoLotes').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	/*

		{

			"iDisplayLength": 2,

        "aLengthMenu": [10, 15, 20]

		}

	*/

	

	ListadoEstadoLotes();// Ni bien carga la pagina que cargue el metodo

	$("#VerForm").hide();// Ocultamos el formulario

	$("form#frmEstadoLotes").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos


	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm



	//$("#liCatRed").click(function(event) {

      //    $("#Cargar").load('view/EstadoLote.html');

        //  $.getScript("public/js/EstadoLote.js");

    //});



	function SaveOrUpdate(e){

		e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/EstadoLoteAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            

            Limpiar();

            //$.toaster({ priority : 'success', title : 'Mensaje', message : r});

            swal("Mensaje del Sistema", r, "success");

			  ListadoEstadoLotes();

			  OcultarForm();

	        

        });

	};



	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdEstadoLote").val("");

	    $("#txtNombre").val("");

	}



	function VerForm(){

		$("#VerForm").show();// Mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();// ocultamos el listado

	}



	function OcultarForm(){

		$("#VerForm").hide();// Mostramos el formulario

		$("#btnNuevo").show();// ocultamos el boton nuevo

		$("#VerListado").show();// ocultamos el listado

	}

	

}



function ListadoEstadoLotes(){ 

	var tabla = $('#tblEstadoLotes').dataTable(

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

        	     	{   "mDataProp": "id"},

                    {   "mDataProp": "1"},

                    {   "mDataProp": "2"}



        	],"ajax": 

	        	{

	        		url: './ajax/EstadoLoteAjax.php?op=list',

					type : "get",

					dataType : "json",

					

					error: function(e){

				   		console.log(e.responseText);	

					}

	        	},

	        "bDestroy": true



    	}).DataTable();



};





function eliminarEstadoLote(id){// funcion que llamamos del archivo ajax/EstadoLoteAjax.php?op=delete linea 53

	swal({
	  title: "¿Esta Seguro de eliminar el Estado del Lote seleccionado?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		$.post("./ajax/EstadoLoteAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id 

			swal("Mensaje del Sistema", e, "success");

			ListadoEstadoLotes();

        });
	});

/*
	bootbox.confirm("¿Esta Seguro de eliminar el Estado del Lote?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/EstadoLoteAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id 

				swal("Mensaje del Sistema", e, "success");

				ListadoEstadoLotes();

            });

		}

	})
*/
}



function cargarDataEstadoLote(id, nombre){// funcion que llamamos del archivo ajax/EstadoLoteAjax.php linea 52

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();



		$("#txtIdEstadoLote").val(id);// recibimos la variable id a la caja de texto txtIdEstadoLote

	    $("#txtNombre").val(nombre);// recibimos la variable nombre a la caja de texto txtNombre

}