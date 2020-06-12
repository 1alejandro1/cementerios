$(document).on("ready", init);// Inciamos el jquery

function init(){

    $('#tblLote').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoLote();// Ni bien carga la pagina que cargue el metodo

	ComboCementerioLot();

//	ComboSectorLot();

	ComboTipoLote();

	ComboEstadoLote();

	$("#VerForm").hide();// Ocultamos el formulario

	$("form#frmLote").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos

	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm


    $('#cboCementerioLot').change(function() {
        $("#txtIdCementerioLot").val($("#cboCementerioLot").val());
        ComboSectorLot();
    });




	function SaveOrUpdate(e){

		e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/LoteAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            swal("Mensaje del Sistema", r, "success");

            Limpiar();

            ListadoLote();

            OcultarForm();

        });

	};



	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdLote").val("");

		$("#txtIdSector").val("");

		$("#cboCementerioLot").val("");

	    $("#cboTipoLote").val("");

	    $("#cboEstadoLote").val("");

	    $("#txtNumero").val("");

	    $("#txtFila").val("");

	    $("#txtColumna").val("");

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



function ListadoLote(){

        var tabla = $('#tblLote').dataTable(

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

                    url: './ajax/LoteAjax.php?op=list',

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };



function eliminarLote(id){// funcion que llamamos del archivo ajax/CategoriaAjax.php?op=delete linea 53

	swal({
	  title: "¿Esta Seguro de eliminar el Lote seleccionado?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		$.post("./ajax/LoteAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

			swal("Mensaje del Sistema", e, "success");

			ListadoLote();

        });
	});

/*
	bootbox.confirm("¿Esta Seguro de eliminar el Lote seleccionado?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/LoteAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

				swal("Mensaje del Sistema", e, "success");

				ListadoLote();

            });

		}
	})
*/

}

    function ComboSectorLot() {

		idcementerio = $("#txtIdCementerioLot").val();
		idsector = $("#txtIdSectorLot").val();

		habilitado = 1;
//		if ($("#txtNroContrato").val()=="") {
//			habilitado = 1;
//		};

        $.post("./ajax/LoteAjax.php?op=listSector", {idcementerio : idcementerio, idsector : idsector, habilitado : habilitado}, function(r) {
            $("#cboSectorLot").html(r);
        });

    }

	function ComboCementerioLot(){

		$.post("./ajax/LoteAjax.php?op=listCementerio", function(r){

            $("#cboCementerioLot").html(r);

            $("#txtIdCementerioLot").val($("#cboCementerioLot").val());


            ComboSectorLot();

        });

	}

	function ComboSector(){

		$.post("./ajax/LoteAjax.php?op=listSector", function(r){

            $("#cboSectorLot").html(r);

        });

	}

	function ComboTipoLote(){

		$.post("./ajax/LoteAjax.php?op=listTipoLote", function(r){

            $("#cboTipoLote").html(r);

        });

	}

	function ComboEstadoLote(){

		$.post("./ajax/LoteAjax.php?op=listEstadoLote", function(r){

            $("#cboEstadoLote").html(r);

        });

	}

function cargarDataLote(id, idsector, idcementerio, idtipolote, idestadolote, numero, fila, columna, observaciones) {// funcion que llamamos del archivo ajax/CategoriaAjax.php linea 52

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();


		$("#txtIdLote").val(id);// recibimos la variable id a la caja de texto

	    $("#cboSectorLot").val(idsector);

	    $("#cboCementerioLot").val(idcementerio);

	    $("#cboTipoLote").val(idtipolote);

	    $("#cboEstadoLote").val(idestadolote);

	    $("#txtNumero").val(numero);

	    $("#txtFila").val(fila);

	    $("#txtColumna").val(columna);

	    $("#txtObservaciones").val(observaciones);// recibimos la variable nombre a la caja de texto txtNombre

 	}



