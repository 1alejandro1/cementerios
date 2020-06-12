	$(document).on("ready", init);// Inciamos el jquery

var objinit = new init();

elementos = new Array();

function init(){

    $('#tblCobranza').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });



	ListadoCobranza();// Ni bien carga la pagina que cargue el metodo

	ObtenerTasa();

	$("#VerForm").hide();// Ocultamos el formulario

//	$("form#frmCobranza").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos

	$("#btnNuevo").click(VerForm);// evento click de jquery que llamamos al metodo VerForm


	$("#btnBuscarContratoCob").click(AbrirModalContratoCob);

	$("#btnBuscarCuota").click(AbrirModalCuotaCob);

	$("#btnPagarCuota").click(AbrirModalPagarCob);

    $("#btnGenerarCobro").click(GenerarCobro);

    $('#txtIncremento').change(function() {
        ActualizarMontos();
    });


    $('#reciboAutomatico').click(function() {
    	$('#txtNroRecibo').val("");
    	$('#txtNroRecibo').attr('disabled',true);
    });
    $('#reciboManual').click(function() {
    	$('#txtNroRecibo').attr('disabled',false);
    	$('#txtNroRecibo').select();
    });

    $('#monedaBolivianos').click(function() {
		$('#totalPagar').attr('style','height:45px; color:black; background:white;')
		$('#totalPagarBs').attr('style','height:45px; color:black; background:yellow;')
	});
    $('#monedaDolares').click(function() {
		$('#totalPagar').attr('style','height:45px; color:black; background:yellow;')
		$('#totalPagarBs').attr('style','height:45px; color:black; background:white;')
	});

	$('#monedaDolares').click();

	$("#btnAgregarContratoCob").click(function(e) {
		e.preventDefault();

		var opt = $("input[name=optContratoBusqueda]:checked");

  		$("#txtIdContrato").val(opt.val());

		$("#txtContrato").val(opt.attr("data-nombre"));

		$("#txtCementerio").val(opt.attr("data-cementerio"));

		$("#txtSector").val(opt.attr("data-sector"));

		$("#txtLote").val(opt.attr("data-lote"));

		$("#txtFila").val(opt.attr("data-fila"));

		$("#txtColumna").val(opt.attr("data-columna"));

		$("#txtFechaContrato").val(opt.attr("data-fechacontrato"));

		$("#modalListadoContrato").modal("hide");

	    $("#btnBuscarCuota").show();
	});



	function SaveOrUpdate(e){

		e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/CobranzaAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            swal("Mensaje del Sistema", r, "success");

            Limpiar();

            ListadoCobranza();

            OcultarForm();

        });

	};


	function Limpiar(){

		// Limpiamos las cajas de texto

		$("#txtIdCobranza").val("");

		$("#txtIdCobranza2").val("");

		$("#txtIdContrato").val("");

		$("#txtContrato").val("");

		$("#txtFechaContrato").val("");

		$("#txtCementerio").val("");

		$("#txtSector").val("");

		$("#txtLote").val("");

		$("#txtFila").val("");

		$("#txtColumna").val("");

	}

	function VerForm(){

		$("#VerForm").show();// Mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();

	    $('#reciboAutomatico').click();

	}



	function OcultarForm(){

		$("#VerForm").hide();// Mostramos el formulario

		$("#btnNuevo").show();// ocultamos el boton nuevo

		$("#VerListado").show();

	}


    function consultar() {
        return JSON.stringify(elementos);
    }

    this.consultar = function(){
        return JSON.stringify(elementos);
    };

    this.eliminar = function(pos){
        pos > -1 && elementos.splice(parseInt(pos),1);
        if (elementos.length==0) {
		    $("#btnPagarCuota").hide();
        }
    };

}



function ListadoCobranza(){

        var tabla = $('#tblCobranza').dataTable(

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

                    {   "mDataProp": "6"}

            ],"ajax":

                {

                    url: './ajax/CobranzaAjax.php?op=list',

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };



	function eliminarCobranza(id){

		swal({
		  title: "¿Esta Seguro de eliminar la Cobranza seleccionada?",
	//	  text: "Your will not be able to recover this imaginary file!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-success",
		  confirmButtonText: "Si",
		  cancelButtonText: "No",
		  closeOnConfirm: true
		},
		function(){
			$.post("./ajax/CobranzaAjax.php?op=delete", {id : id}, function(e) {

				swal("Mensaje del Sistema", e, "success");

				ListadoCobranza();

            });
		});
/*
		bootbox.confirm("¿Esta Seguro de eliminar la Cobranza seleccionada?", function(result){ 

			if(result){// si el result es true

				$.post("./ajax/CobranzaAjax.php?op=delete", {id : id}, function(e) {

					swal("Mensaje del Sistema", e, "success");

					ListadoCobranza();

	            });

			}

		})
*/
	}


	function cargarDataCobranza(id, idcontrato,fechacobranza,nrocontrato,fechacontrato,adquiriente,cementerio,sector,lote,fila,columna,monto,tiporecibo,tasacambio) {

		$("#VerForm").show();// mostramos el formulario

		$("#btnNuevo").hide();// ocultamos el boton nuevo

		$("#VerListado").hide();


		$("#txtIdCobranza").val(id);

		$("#txtIdCobranza2").val(id);

		$("#txtIdContrato").val(idcontrato);

		$("#txtContrato").val(nrocontrato);

		$("#txtFechaContrato").val(fechacontrato);

		$("#txtCementerio").val(cementerio);

		$("#txtSector").val(sector);

		$("#txtLote").val(lote);

		$("#txtFila").val(fila);

		$("#txtColumna").val(columna);

		if (tiporecibo=='A') {
			$("#reciboAutomatico").val(true);
			$("#reciboManual").val(false);
		} else {
			$("#reciboManual").val(true);
			$("#reciboAutomatico").val(false);
		}

        suma = parseFloat(monto);

        $("#txtTotalPed").val(suma.toFixed(2));

//        tasa = parseFloat(tasacambio);

//        $("#txtTasa").val(tasa.toFixed(4));

		$("#txtContrato").attr('disabled',true);

		$("#btnBuscarContratoCob").attr('disabled',true);

		VerCuotasPagadas();

 	}

	function AbrirModalContratoCob(){

//	    $("#btnBuscarCuota").attr('disabled',true);

		$("#modalListadoContrato").modal("show");

		$.post("./ajax/CobranzaAjax.php?op=listContrato", function(r){

            $("#ContratoDetalle").html(r);

            $('#tblContratos').DataTable();

        });

	}

	function AbrirModalCuotaCob(){

		$("#modalListadoCuota").modal("show");

		idcontrato = $("#txtIdContrato").val();

		$.post("./ajax/CobranzaAjax.php?op=listCuota", {idcontrato : idcontrato}, function(r) {

            $("#CuotaDetalle").html(r);

            $('#tblCuotas').DataTable();

        });

	}


	function ObtenerTasa() {

		$.post("./ajax/CobranzaAjax.php?op=verTasa", '{ }', function(r) {

            $("#txtTasa").val(r);

        });

	}


	function VerCuotasPagadas(){

//		$("#modalListadoCuota").modal("show");

		idcontrato = $("#txtIdContrato").val();
		idcobranza = $("#txtIdCobranza").val();

		$.post("./ajax/CobranzaAjax.php?op=verCuota", {idcobranza : idcobranza, idcontrato : idcontrato}, function(r) {

            $("#VerCuotas").html(r);

            $('#tblDetalleCuota').DataTable();

        });

	}

	function GetTodayDate() {
	   var tdate = new Date();
	   var dd = tdate.getDate(); //yields day
	   if (dd<10) {
	   	  dd = '0' + dd;
	   }
	   var MM = tdate.getMonth()+1; //yields month
	   if (MM<10) {
	   	  MM = '0' + MM;
	   }
	   var yyyy = tdate.getFullYear(); //yields year

	   var currentDate= yyyy + "-" + MM + "-" + dd;
	   console.log (currentDate);
//	   var currentDate=  dd + "-" + MM + "-" + yyyy;

	   return currentDate;
	}

	function ActualizaMontoaPagar(incremento,totalapagar) {

		var incrementon = parseFloat(incremento);
		var totalapagarn = parseFloat(totalapagar);
		if (incrementon<0) {
			incrementon = incrementon * -1;
		}

		$("#txtIncremento").val(incrementon.toFixed(2));
		if (incrementon>0) {
			totalapagarn = totalapagarn + incrementon;
			$("#totalPagar").val( totalapagarn.toFixed(2) );
		};

	 	
	}


	function ActualizarMontos() {

		var tasacambion = parseFloat($("#txtTasa").val());
		var monton = parseFloat($("#txtTotalPed").val());
		var incrementon = parseFloat($("#txtIncremento").val());

		if (tasacambion<0) {
			tasacambion = tasacambion * -1;
		}
		if (monton<0) {
			monton = monton * -1;
		}
		if (incrementon<0) {
			incrementon = incrementon * -1;
		}



		var totalapagarn = parseFloat(monton);

		$("#txtIncremento").val(incrementon.toFixed(2));

		totalapagarn = totalapagarn + incrementon;
		monton = totalapagarn;

		$("#totalPagar").val( totalapagarn.toFixed(2) );
        $("#tasaCambio").val(tasacambion.toFixed(4));

        montobs = monton * tasacambion;

        $("#totalPagarBs").val( montobs.toFixed(2) );

//		$("#totalPagar").val(monton.toFixed(2));

	}

	function AbrirModalPagarCob(){
		if ($("#txtFechaCobranza").val().length==0) {
		    $("#txtFechaCobranza").val(GetTodayDate());
		}

		ActualizarMontos();

		$("#modalListadoPagar").modal("show");
	}




    function AgregarPedCarrito(idcuota, nrocuota, tipocuota, fechalimite, monto, estado){
        var existe = 0;
        var data = JSON.parse(objinit.consultar());
        for (var pos in data) {
            if (data[pos][0]==idcuota) {
            	existe = 1;
            }
        }
        if (existe==0) {
	        var detalles = new Array(idcuota, nrocuota, tipocuota, fechalimite, monto, estado);
	        elementos.push(detalles);
	        ConsultarDetallesPed();
    	}
	    $("#btnPagarCuota").show();
    }

    function VerDetalle(idcuota, nrocuota, tipocuota, fechalimite, monto, estado){
        var existe = 0;
        var data = JSON.parse(objinit.consultar());
        for (var pos in data) {
            if (data[pos][0]==idcuota) {
            	existe = 1;
            }
        }
        if (existe==0) {
	        var detalles = new Array(idcuota, nrocuota, tipocuota, fechalimite, monto, estado);
	        elementos.push(detalles);
	        ConsultarDetallesPed();
    	}
	    $("#btnPagarCuota").show();
    }

	function ConsultarDetallesPed() {
        $("table#tblDetalleCuota tbody").html("");
        var data = JSON.parse(objinit.consultar());

        for (var pos in data) {
            $("table#tblDetalleCuota").append(
            	"<tr><td>" + data[pos][0] + 
            	" <input class='form-control' type='hidden' name='txtIdCuota' id='txtIdCuota[]' value='" + data[pos][0] + 
            	"' /></td><td> " + data[pos][1] + "</td><td> " + (data[pos][2] == 'C' ? 'CONTRATO' : 'MANTENIMIENTO ANUAL') + "</td><td> " + data[pos][3] + "</td><td>" + data[pos][4].toFixed(2) + "</td><td>" + (data[pos][5]=='P' ? 'PENDIENTE' : (data[pos][5]=='V' ? 'VENCIDA' : 'NO DETERMINADO') ) + 
				" </td><td><button type='button' onclick='eliminarDetallePed(" + pos + ")' class='btn btn-danger'><i class='fa fa-remove' ></i> </button></td></tr>");
        }
//        calcularIgvPed();
//        calcularSubTotalPed();
        calcularTotalPed();
    }


	function eliminarDetallePed(ele){
        console.log(ele);
        objinit.eliminar(ele);
        ConsultarDetallesPed();
    }

    function calcularTotalPed(posi){
        if(posi != null){
          ModificarPed(posi);
        }
        var suma = 0;
        var data = JSON.parse(objinit.consultar());
        for (var pos in data) {
            suma += parseFloat(data[pos][4]);
        }
        $("#txtTotalPed").val(suma.toFixed(2));
//        $("#txtTotalPed").val(Math.round(suma.toFixed(2)*100)/100);

    }


function verReciboPago(url) {
	var a = document.createElement("a");
	a.target = "_blank";
	a.href = url;
	a.click();
}

function reciboPago(id,nrocontrato){
	$.post("./ajax/CobranzaAjax.php?op=crearReciboPago", {id : id});

	swal({
	  title: "¿Esta Seguro de ver el Recibo de Pago?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		verReciboPago('Files/Pdf/Recibo de Pago. Cobranza ' + id + '.pdf');
	});

/*
	bootbox.confirm("¿Esta Seguro de ver el Recibo de Pago?" , function(result){ 
		if (result) {
			verReciboPago('Files/Pdf/Recibo de Pago. Cobranza ' + id + '.pdf');
		}
	})
*/
}



    function GenerarCobro(e){

		e.preventDefault();

	    if ( $('input[name=radTipoRecibo]:checked').val() == "M" ) {
		    if (elementos.length > 0 & $("#txtNroRecibo").val() == "" ) {
		        $("#txtNroRecibo").select();
		        return;
		    }
		}
		incremento = Number($("#txtIncremento").val());

	    if (elementos.length > 0 & ( incremento > 0 & $("#txtObjetoIncremento").val() == "") ) {
	        $("#txtObjetoIncremento").select();
	        return;
	    }
	    if (elementos.length > 0 & ( incremento == 0 & $("#txtObjetoIncremento").val() != "") ) {
	        $("#txtIncremento").select();
	        return;
	    }
	    if (elementos.length > 0 & $("#txtConcepto").val() == "" ) {
	        $("#txtConcepto").select();
	        return;
	    }
	    if (elementos.length > 0 ) {
	    	var detalle =  JSON.parse(objinit.consultar());

	        var data = {
	        	idcontrato : $("#txtIdContrato").val(),
	        	nrorecibo : $("#txtNroRecibo").val(),
	        	tipopago : $("#cboTipoPago").val(),
	        	incremento : $("#txtIncremento").val(),
	        	objetoincremento : $("#txtObjetoIncremento").val(),
	        	concepto : $("#txtConcepto").val(),
	        	observaciones : $("#txtObservaciones").val(),
	        	nombre : $("#txtNombre").val(),
	        	fechacobranza : $("#txtFechaCobranza").val(),
               	detalle : detalle,
               	monto : $("#totalPagar").val(),
               	tiporecibo : $('input[name=radTipoRecibo]:checked').val(),
               	emiterecibo : $('input[name=radEmiteRecibo]:checked').val(),
	        	montobs : $("#totalPagarBs").val(),
	        	tasacambio : $("#tasaCambio").val(),
			};
//			console.log (data);

			$.post("./ajax/CobranzaAjax.php?op=SaveFactura", data, function(r) {
//				location.href ="../solventas/Pedido.php";
//				var es = String(r);
//				window.open('./Reportes/exVenta.php?id='+es, 'target', ' toolbar=0 , location=1 , status=0 , menubar=1 , scrollbars=0 , resizable=1 ,left=600pt,top=90pt, width=380px,height=880px');
		        bootbox.alert(r);

				$("#modalListadoPagar").modal("hide");

				$("#VerForm").hide();// Mostramos el formulario

				$("#VerForm").hide();// Mostramos el formulario

				$("#btnNuevo").show();// ocultamos el boton nuevo

				$("#VerListado").show();

				ListadoCobranza();

	         });
	      } else {
	        bootbox.alert(" Debe indicar las Cuotas a Pagar ...");
	     }


}// fimn funcion generar venta
