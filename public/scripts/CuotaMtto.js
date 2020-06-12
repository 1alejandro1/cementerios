$(document).on("ready", init);// Inciamos el jquery

function init(){

    $('#tblCuotaMtto').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });

	ListadoCuotaMtto();// Ni bien carga la pagina que cargue el metodo

	$("#btnNuevoCM").click(VerForm2);// evento click de jquery que llamamos al metodo VerForm





	function VerForm2() {


    swal({
      title: "¿Esta Seguro de Generar las Cuotas de Mantenimiento?",
//    text: "Your will not be able to recover this imaginary file!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: true
    },
    function(){
        $.post("./ajax/CuotaMttoAjax.php?op=create", ' ', function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

            swal("Mensaje del Sistema", e, "success");

            ListadoCuotaMtto();

        });
    });

    }




}



function ListadoCuotaMtto(){

        var tabla = $('#tblCuotaMtto').dataTable(

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

                    url: './ajax/CuotaMttoAjax.php?op=list',

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };



function eliminarCuotaMtto(id){// funcion que llamamos del archivo ajax/CategoriaAjax.php?op=delete linea 53

    swal({
      title: "¿Esta Seguro de eliminar la Cuota de Mantenimiento seleccionada?",
//    text: "Your will not be able to recover this imaginary file!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: true
    },
    function(){
        $.post("./ajax/CuotaMttoAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

            swal("Mensaje del Sistema", e, "success");

            ListadoCuotaMtto();

        });
    });

/*
	bootbox.confirm("¿Esta Seguro de eliminar la Cuota de Mantenimiento seleccionado?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/CuotaMttoAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

				swal("Mensaje del Sistema", e, "success");

				ListadoCuotaMtto();

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


function cargarDataCuotaMtto(id, idcementerio, nombre, observaciones, precioni, precionf){// funcion que llamamos del archivo ajax/CategoriaAjax.php linea 52

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



