$(document).on("ready", init);// Inciamos el jquery



function init(){



	$('#tblDifunto').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoDifunto();// Ni bien carga la pagina que cargue el metodo

	ComboTipoDocumento();

	$("#VerForm").hide();// Ocultamos el formulario

	$("form#frmDifunto").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos



	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm





	function SaveOrUpdate(e){

		e.preventDefault();
        var formData = new FormData($("#frmDifunto")[0]);
        $.ajax({
                url: "./ajax/DifuntoAjax.php?op=SaveOrUpdate",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(datos)
                {
					Limpiar();
					ListadoDifunto();
                    swal("Mensaje del Sistema", datos, "success");
					OcultarForm();
                }
            });

/*
		e.preventDefault();// para que no se recargue la pagina
        $.post("./ajax/DifuntoAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback
            Limpiar();
            ListadoDifunto();
            //$.toaster({ priority : 'success', title : 'Mensaje', message : r});
            swal("Mensaje del Sistema", r, "success");
            OcultarForm();
        });
*/
	};









	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdDifunto").val("");

	    $("#txtNombre").val("");

	    $("#txtNumDocumento").val("");

	    $("#txtDireccionDepartamento").val("");

	    $("#txtDireccionProvincia").val("");

	    $("#txtDireccionDistrito").val("");

	    $("#txtDireccionCalle").val("");

	    $("#txtTelefono").val("");

	    $("#txtEmail").val("");

	    $("#txtNumerocuenta").val("");

	}



	function ComboTipoDocumento() {



        $.get("./ajax/DifuntoAjax.php?op=listTipoDocumentoPersona", function(r) {

                $("#cboTipoDocumento").html(r);



        })

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



function ListadoDifunto(){

		var tabla = $('#tblDifunto').dataTable(

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

                    {   "mDataProp": "2"},

                    {   "mDataProp": "3"},

                    {   "mDataProp": "4"},

                  {   "mDataProp": "5"},



        	],"ajax":

	        	{

	        		url: './ajax/DifuntoAjax.php?op=list',

					type : "get",

					dataType : "json",



					error: function(e){

				   		console.log(e.responseText);

					}

	        	},

	        "bDestroy": true



    	}).DataTable();

    };



function eliminarDifunto(id){// funcion que llamamos del archivo ajax/CategoriaAjax.php?op=delete linea 53

	swal({
	  title: "¿Esta Seguro de eliminar el Difunto seleccionado?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		$.post("./ajax/DifuntoAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

			swal("Mensaje del Sistema", e, "success");

			ListadoDifunto();

        });
	});


/*
	bootbox.confirm("¿Esta Seguro de eliminar el Difunto seleccionado?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/DifuntoAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

				ListadoDifunto();

				swal("Mensaje del Sistema", e, "success");
            });
		}
	})
*/
}



function cargarDataDifunto(id, nombre,tipodocumento,numdocumento,direcciondepartamento,direccionprovincia,direcciondistrito,direccioncalle,telefono,email,numerocuenta,estado,imagen1,imagen2,imagen3){

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();



		$("#txtIdDifunto").val(id);// recibimos la variable id a la caja de texto

	    $("#txtNombre").val(nombre);// recibimos la variable nombre a la caja de texto txtNombre

	    $("#cboTipoDocumento").val(tipodocumento);

 		$("#txtNumDocumento").val(numdocumento);

	    $("#txtDireccionDepartamento").val(direcciondepartamento);

	    $("#txtDireccionProvincia").val(direccionprovincia);

	    $("#txtDireccionDistrito").val(direcciondistrito);

	    $("#txtDireccionCalle").val(direccioncalle);

	    $("#txtTelefono").val(telefono);

 		$("#txtEmail").val(email);

 		$("#txtNumeroCuenta").val(numerocuenta);

 		$("#txtRutaImg1").val(imagen1);

	    $("#txtRutaImg1").show();

 		$("#txtRutaImg2").val(imagen2);

	    $("#txtRutaImg2").show();

 		$("#txtRutaImg3").val(imagen3);

	    $("#txtRutaImg3").show();

 		$("#cboEstado").val(estado);

 	}

