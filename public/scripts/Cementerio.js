$(document).on("ready", init);// Inciamos el jquery



function init(){



    $('#tblCementerio').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoCementerio();// Ni bien carga la pagina que cargue el metodo

	ComboTipoDocumento();

	$("#VerForm").hide();// Ocultamos el formulario

	$("form#frmCementerio").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos



	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm



	function SaveOrUpdate(e){

		e.preventDefault();



        var formData = new FormData($("#frmCementerio")[0]);



        $.ajax({



                url: "./ajax/CementerioAjax.php?op=SaveOrUpdate",



                type: "POST",



               data: formData,



                contentType: false,



                processData: false,



                success: function(datos)



                {



                    swal("Mensaje del Sistema", datos, "success");

					ListadoCementerio();

					OcultarForm();

                }



            });

	};



	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdCementerio").val("");

	    $("#txtRazonSocial").val("");

	    $("#txtNumDocumento").val("");

	    $("#txtDireccion").val("");

	    $("#txtTelefono").val("");

	    $("#txtEmail").val("");

	    $("#txtRepresentante").val("");

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



function ListadoCementerio(){

        var tabla = $('#tblCementerio').dataTable();

        $.ajax({

            url: './ajax/CementerioAjax.php?op=list',

            dataType: 'json',

            success: function(s){

            //console.log(s);

                    tabla.fnClearTable();

                        for(var i = 0; i < s.length; i++) {

                         tabla.fnAddData([

                                    s[i][0],

                                    s[i][1],

                                    s[i][2],

                                    s[i][3],

                                    s[i][4],

                                    s[i][5],

                                    s[i][6],

                                    s[i][7]

                                      ]);

                        } // End For



            },

            error: function(e){

               console.log(e.responseText);

            }

        });

    };



function eliminarCementerio(id){// funcion que llamamos del archivo ajax/CategoriaAjax.php?op=delete linea 53

    swal({
      title: "¿Esta Seguro de eliminar el Cementerio seleccionado?",
//    text: "Your will not be able to recover this imaginary file!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-success",
      confirmButtonText: "Si",
      cancelButtonText: "No",
      closeOnConfirm: true
    },
    function(){
        $.post("./ajax/CementerioAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

            swal("Mensaje del Sistema", e, "success");

            ListadoCementerio();
        });
    });
/*
	bootbox.confirm("¿Esta Seguro de eliminar el Cementerio?", function(result){ // confirmamos con una pregunta si queremos eliminar

		if(result){// si el result es true

			$.post("./ajax/CementerioAjax.php?op=delete", {id : id}, function(e){// llamamos la url de eliminar por post. y mandamos por parametro el id

                swal("Mensaje del Sistema", e, "success");

				ListadoCementerio();
            });
		}
	})
*/
}



function cargarDataCementerio(id, razonsocial,tipodocumento,numdocumento,direccion,telefono,email,representante,logo,estado){// funcion que llamamos del archivo ajax/CategoriaAjax.php linea 52

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();// ocultamos el listado



		$("#txtIdCementerio").val(id);// recibimos la variable id a la caja de texto txtIdCategoria

	    $("#txtRazonSocial").val(razonsocial);

 		$("#cboTipoDocumento").val(tipodocumento);

 		$("#txtNumDocumento").val(numdocumento);

 		$("#txtDireccion").val(direccion);

 		$("#txtTelefono").val(telefono);

 		$("#txtEmail").val(email);

 		$("#txtRepresentante").val(representante);

 		//$("#txtLogo").val(logo);

 		$("#txtRutaImgCem").val(logo);

	    $("#txtRutaImgCem").show();

 		$("#cboEstado").val(estado);






 	}





 	function ComboTipoDocumento() {



        $.get("./ajax/CementerioAjax.php?op=listTipoDocumentoPersona", function(r) {

                $("#cboTipoDocumento").html(r);



        })

    }

