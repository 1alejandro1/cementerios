$(document).on("ready", init);// Inciamos el jquery

function init(){

    $('#tblMontoCuotaMtto').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoMontoCuotaMtto();// Ni bien carga la pagina que cargue el metodo

	$("#VerFormMC").hide();// Ocultamos el formulario

	$("form#frmMontoCuotaMtto").submit(SaveOrUpdateMC);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos

	$("#btnNuevoMC").click(VerFormMC);// evento click de jquery que llamamos al metodo VerForm





	function SaveOrUpdateMC(e){

		e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/MontoCuotaAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            swal("Mensaje del Sistema", r, "success");

            LimpiarMC();

            ListadoMontoCuotaMtto();

            OcultarFormMC();

        });

	};



	function LimpiarMC(){

		// Limpiamos las cajas de texto

		$("#txtIdCuotaMtto").val("");

	    $("#txtFechaVigencia").val("");

	    $("#txtMonto").val("");

	}



	function VerFormMC(){

		$("#VerFormMC").show();// Mostramos el formulario

		$("#btnNuevoMC").hide();// ocultamos el boton nuevo

		$("#VerListadoMC").hide();

	}



	function OcultarFormMC(){

		$("#VerFormMC").hide();// Mostramos el formulario

		$("#btnNuevoMC").show();// ocultamos el boton nuevo

		$("#VerListadoMC").show();

	}



}



function ListadoMontoCuotaMtto(){

        var tabla = $('#tblMontoCuotaMtto').dataTable(

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

                    url: './ajax/MontoCuotaAjax.php?op=list',

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };



function eliminarMontoCuotaMtto(id){// funcion que llamamos del archivo ajax/CategoriaAjax.php?op=delete linea 53

    swal({
      title: "¿Esta Seguro de eliminar el Monto de Cuota seleccionada?",
//    text: "Your will not be able to recover this imaginary file!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: true
    },
    function(){
        $.post("./ajax/MontoCuotaAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

            swal("Mensaje del Sistema", e, "success");

            ListadoMontoCuotaMtto();

        });
    });

/*
	bootbox.confirm("¿Esta Seguro de eliminar la Cuota de Mantenimiento seleccionada?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/MontoCuotaAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

				swal("Mensaje del Sistema", e, "success");

				ListadoMontoCuotaMtto();

            });

		}
	})
*/
}


function cargarDataMontoCuotaMtto(id, fechavigencia, monto){// funcion que llamamos del archivo ajax/CategoriaAjax.php linea 52

		$("#VerFormMC").show();// mostramos el formulario

		$("#btnNuevoMC").hide();// ocultamos el boton nuevo

		$("#VerListadoMC").hide();

		$("#txtIdCuotaMtto").val(id);// recibimos la variable id a la caja de texto

	    $("#txtFechaVigencia").val(fechavigencia);

	    $("#txtMonto").val(monto);// recibimos la variable nombre a la caja de texto txtNombre
 	}



