$(document).on("ready", init);// Inciamos el jquery

function init(){

    $('#tblTasaCambio').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoTasaCambio();// Ni bien carga la pagina que cargue el metodo

	$("#VerFormTC").hide();// Ocultamos el formulario

	$("form#frmTasaCambio").submit(SaveOrUpdateTC);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos

	$("#btnNuevoTC").click(VerFormTC);// evento click de jquery que llamamos al metodo VerForm





	function SaveOrUpdateTC(e){

		e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/TasaCambioAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            swal("Mensaje del Sistema", r, "success");

            LimpiarTC();

            ListadoTasaCambio();

            OcultarFormTC();

        });

	};



	function LimpiarTC(){

		// Limpiamos las cajas de texto

		$("#txtIdTasaCambio").val("");

	    $("#txtFechaVigencia").val("");

	    $("#txtMontoTC").val("");

	}



	function VerFormTC(){

		$("#VerFormTC").show();// Mostramos el formulario

		$("#btnNuevoTC").hide();// ocultamos el boton nuevo

		$("#VerListadoTC").hide();

	}



	function OcultarFormTC(){

		$("#VerFormTC").hide();// Mostramos el formulario

		$("#btnNuevoTC").show();// ocultamos el boton nuevo

		$("#VerListadoTC").show();

	}



}



function ListadoTasaCambio(){

        var tabla = $('#tblTasaCambio').dataTable(

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

                    {   "mDataProp": "4"}

            ],"ajax":

                {

                    url: './ajax/TasaCambioAjax.php?op=list',

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };



function eliminarTasaCambio(id){// funcion que llamamos del archivo ajax/CategoriaAjax.php?op=delete linea 53

    swal({
      title: "¿Esta Seguro de eliminar la Tasa de Cambio seleccionada?",
//    text: "Your will not be able to recover this imaginary file!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: true
    },
    function(){
        $.post("./ajax/TasaCambioAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

            swal("Mensaje del Sistema", e, "success");

            ListadoTasaCambio();

        });
    });

/*
	bootbox.confirm("¿Esta Seguro de eliminar la Tasa de Cambio seleccionada?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/TasaCambioAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

				swal("Mensaje del Sistema", e, "success");

				ListadoTasaCambio();

            });

		}
	})
*/
}


function cargarDataTasaCambio(id, fechavigencia, monto){// funcion que llamamos del archivo ajax/CategoriaAjax.php linea 52

		$("#VerFormTC").show();// mostramos el formulario

		$("#btnNuevoTC").hide();// ocultamos el boton nuevo

		$("#VerListadoTC").hide();

		$("#txtIdTasaCambio").val(id);// recibimos la variable id a la caja de texto

	    $("#txtFechaVigencia").val(fechavigencia);

	    $("#txtMontoTC").val(monto);// recibimos la variable nombre a la caja de texto txtNombre
 	}



