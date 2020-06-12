$(document).on("ready", init);// Inciamos el jquery



var objC = new init();



function init(){





	var tabla = $('#tblEstadoCivil').dataTable({

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

	

	ListadoEstadoCivil();// Ni bien carga la pagina que cargue el metodo

	$("#VerForm").hide();// Ocultamos el formulario

	$("form#frmEstadoCivil").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos


	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm



	function SaveOrUpdate(e){

		e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/EstadoCivilAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            Limpiar();

            //$.toaster({ priority : 'success', title : 'Mensaje', message : r});

            swal("Mensaje del Sistema", r, "success");

			  ListadoEstadoCivil();

			  OcultarForm();

        });

	};



	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdEstadoCivil").val("");

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



function ListadoEstadoCivil(){ 

	var tabla = $('#tblEstadoCivil').dataTable(

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

	        		url: './ajax/EstadoCivilAjax.php?op=list',

					type : "get",

					dataType : "json",

					

					error: function(e){

				   		console.log(e.responseText);	

					}

	        	},

	        "bDestroy": true



    	}).DataTable();



};





function eliminarEstadoCivil(id) {

	swal({
	  title: "¿Esta Seguro de eliminar el Estado Civil seleccionado?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		$.post("./ajax/EstadoCivilAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id 

			swal("Mensaje del Sistema", e, "success");

			ListadoEstadoCivil();

        });
	});
/*

	bootbox.confirm("¿Esta Seguro de eliminar el Estado Civil seleccionado?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/EstadoCivilAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id 

				swal("Mensaje del Sistema", e, "success");

				ListadoEstadoCivil();

            });

		}

	})
*/
}



function cargarDataEstadoCivil(id, nombre) {

		$("#VerForm").show();

		$("#btnNuevo").hide();

		$("#VerListado").hide();


		$("#txtIdEstadoCivil").val(id);// recibimos la variable id a la caja de texto txtIdEstadoLote

	    $("#txtNombre").val(nombre);// recibimos la variable nombre a la caja de texto txtNombre

}
