$(document).on("ready", init);// Inciamos el jquery

function init(){

    $('#tblSector').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoSector();// Ni bien carga la pagina que cargue el metodo

	$("#VerForm").hide();// Ocultamos el formulario

	$("form#frmSector").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos

	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm





	function SaveOrUpdate(e){

		e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/SectorAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            swal("Mensaje del Sistema", r, "success");

            Limpiar();

            ListadoSector();

            OcultarForm();

        });

	};



	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdSector").val("");

	    $("#txtNombre").val("");

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



function ListadoSector(){

        var tabla = $('#tblSector').dataTable(

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

                    url: './ajax/SectorAjax.php?op=list',

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };



function eliminarSector(id){// funcion que llamamos del archivo ajax/CategoriaAjax.php?op=delete linea 53

    swal({
      title: "¿Esta Seguro de eliminar el Sector seleccionado?",
//    text: "Your will not be able to recover this imaginary file!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: true
    },
    function(){
        $.post("./ajax/SectorAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

            swal("Mensaje del Sistema", e, "success");

            ListadoSector();
        });
    });

/*
	bootbox.confirm("¿Esta Seguro de eliminar el Sector seleccionado?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/SectorAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

				swal("Mensaje del Sistema", e, "success");

				ListadoSector();
            });
		}
	})
*/

}

	function ComboCementerio(){

		$.post("./ajax/SectorAjax.php?op=listCementerio", function(r){

            $("#cboCementerio").html(r);

        });

	}


function cargarDataSector(id, idcementerio, nombre, observaciones, precioni, precionf){// funcion que llamamos del archivo ajax/CategoriaAjax.php linea 52

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();

		$("#txtIdSector").val(id);// recibimos la variable id a la caja de texto

	    $("#cboCementerio").val(idcementerio);

	    $("#txtNombre").val(nombre);// recibimos la variable nombre a la caja de texto txtNombre

	    $("#txtObservaciones").val(observaciones);// recibimos la variable nombre a la caja de texto txtNombre

	    $("#txtPrecioNI").val(precioni);// recibimos la variable nombre a la caja de texto txtNombre

	    $("#txtPrecioNF").val(precionf);// recibimos la variable nombre a la caja de texto txtNombre
 	}



