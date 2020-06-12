$(document).on("ready", init);



function init(){

	

	$('#tblUsuarios').dataTable({

	        dom: 'Bfrtip',

	        buttons: [

	            'copyHtml5',

	            'excelHtml5',

	            'csvHtml5',

	            'pdfHtml5'

	        ]

	    });

	

	ListadoUsuarios();

	ComboCementerio();

	$("#VerForm").hide();

	$("#txtRutaImgArt").hide();

	$("form#frmUsuarios").submit(SaveOrUpdate);

	

	$("#btnNuevo").click(VerForm);

	$("#btnBuscarTrabajador").click(AbrirModalPersonal);



	$("#btnAgregarPersonal").click(function(e){

		e.preventDefault();



		var opt = $("input[type=radio]:checked");

		$("#txtIdPersonal").val(opt.val());

		$("#txtPersonal").val(opt.attr("data-nombre") + " " + opt.attr("data-apellidos"));

		$("#modalListadoPersonal").modal("hide");

	});



	function SaveOrUpdate(e){

		e.preventDefault();



		if ($("#txtIdPersonal").val() != "") {

	        $.post("./ajax/UsuarioAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){

	            swal("Mensaje del Sistema", r, "success");

	            Limpiar();

				ListadoUsuarios();

				OcultarForm();

	        });

	    } else {

	    	bootbox.alert("Debe elegir un trabajador");

	    }

	};



	function ComboCementerio(){

		$.post("./ajax/UsuarioAjax.php?op=listCementerio", function(r){

            $("#cboCementerio").html(r);

        });

	}



	function AbrirModalPersonal(){

		$("#modalListadoPersonal").modal("show");



		$.post("./ajax/UsuarioAjax.php?op=listPersonal", function(r){

            $("#Trabajador").html(r);

            $('#tblTrabajadores').DataTable();

        });

	}



	function Limpiar(){

		$("#txtIdUsuario").val("");

	    $("#txtNombre").val("");

	    $("#txtIdPersonal").val("");

	    $("#txtPersonal").val("");

	    $("#chkMnuCementerio").attr('checked', false);
	    $("#chkMnuSector").attr('checked', false);
	    $("#chkMnuLote").attr('checked', false);
	    $("#chkMnuTipoLote").attr('checked', false);
	    $("#chkMnuEstadoLote").attr('checked', false);
	    $("#chkMnuMantenimiento").attr('checked', false);
	    $("#chkMnuMontoCuota").attr('checked', false);
	    $("#chkMnuPlanimetria").attr('checked', false);

	    $("#chkMnuPersonal").attr('checked', false);
	    $("#chkMnuDifunto").attr('checked', false);
	    $("#chkMnuResponsable").attr('checked', false);
	    $("#chkMnuInhumacion").attr('checked', false);
	    $("#chkMnuExhumacion").attr('checked', false);

	    $("#chkMnuContrato").attr('checked', false);
	    $("#chkMnuCobranza").attr('checked', false);
	    $("#chkMnuAdquiriente").attr('checked', false);
	    $("#chkMnuEjecutivoVenta").attr('checked', false);
	    $("#chkMnuComision").attr('checked', false);
	}



	function VerForm(){

		$("#VerForm").show();

		$("#btnNuevo").hide();

		$("#VerListado").hide();

	}



	function OcultarForm(){

        $("#VerForm").hide();

        $("#btnNuevo").show();

        $("#VerListado").show();

        //Limpiar();

    }

    



}



function eliminarUsuario(id){

	swal({
	  title: "¿Esta Seguro de eliminar el Usuario seleccionado?",
//	  text: "Your will not be able to recover this imaginary file!",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-success",
	  confirmButtonText: "Si",
	  cancelButtonText: "No",
	  closeOnConfirm: true
	},
	function(){
		$.post("./ajax/UsuarioAjax.php?op=delete", {id : id}, function(e){

            swal("Mensaje del Sistema", e, "success");

			ListadoUsuarios();

			Limpiar();
        });
	});

/*
	bootbox.confirm("¿Esta Seguro de eliminar el Usuario?", function(result){

		if(result){

			$.post("./ajax/UsuarioAjax.php?op=delete", {id : id}, function(e){

                swal("Mensaje del Sistema", e, "success");

				ListadoUsuarios();

				Limpiar();
            });

		}
	})
*/
}



function ListadoUsuarios(){ 

        var tabla = $('#tblUsuarios').dataTable(

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

                    {   "mDataProp": "5"}



        	],"ajax": 

	        	{

	        		url: './ajax/UsuarioAjax.php?op=list',

					type : "get",

					dataType : "json",

					

					error: function(e){

				   		console.log(e.responseText);	

					}

	        	},

	        "bDestroy": true



    	}).DataTable();



};

function cargarDataUsuario(idUsuario, idCementerio, idpersonal, personal, tipo_usuario, mnu_cementerio, mnu_sector, mnu_lote,
	mnu_tipolote, mnu_estadolote, mnu_mantenimiento, mnu_montocuota, mnu_planimetria, mnu_personal, mnu_difunto, mnu_responsable, 
	mnu_inhumacion, mnu_exhumacion, mnu_contrato, mnu_cobranza, mnu_adquiriente, mnu_ejecutivoventa, mnu_comision) {

		$("#VerForm").show();

		$("#btnNuevo").hide();

		$("#VerListado").hide();



		$("#txtIdUsuario").val(idUsuario);

	    $("#cboCementerio").val(idCementerio);

	    $("#txtIdPersonal").val(idpersonal);

	    $("#txtPersonal").val(personal);

	    $("#cboTipoUsuario").val(tipo_usuario);



	    if (mnu_cementerio == 1) {
	    	$("#chkMnuCementerio").attr('checked', true);
	    } else {
	    	$("#chkMnuCementerio").attr('checked', false);
	    }
	    if (mnu_sector == 1) {
	    	$("#chkMnuSector").attr('checked', true);
	    } else {
	    	$("#chkMnuSector").attr('checked', false);
	    }
	    if (mnu_lote == 1) {
	    	$("#chkMnuLote").attr('checked', true);
	    } else {
	    	$("#chkMnuLote").attr('checked', false);
	    }
	    if (mnu_tipolote == 1) {

	    	$("#chkMnuTipoLote").attr('checked', true);

	    } else {

	    	$("#chkMnuTipoLote").attr('checked', false);

	    }
	    if (mnu_estadolote == 1) {
	    	$("#chkMnuEstadoLote").attr('checked', true);
	    } else {
	    	$("#chkMnuEstadoLote").attr('checked', false);
	    }
	    if (mnu_mantenimiento == 1) {

	    	$("#chkMnuMantenimiento").attr('checked', true);

	    } else {

	    	$("#chkMnuMantenimiento").attr('checked', false);

	    }
	    if (mnu_montocuota == 1) {

	    	$("#chkMnuMontoCuota").attr('checked', true);

	    } else {

	    	$("#chkMnuMontoCuota").attr('checked', false);

	    }
	    if (mnu_planimetria == 1) {
	    	$("#chkMnuPlanimetria").attr('checked', true);
	    } else {
	    	$("#chkMnuPlanimetria").attr('checked', false);
	    }


	    if (mnu_personal == 1) {
	    	$("#chkMnuPersonal").attr('checked', true);
	    } else {
	    	$("#chkMnuPersonal").attr('checked', false);
	    }
	    if (mnu_difunto == 1) {
	    	$("#chkMnuDifunto").attr('checked', true);
	    } else {
	    	$("#chkMnuDifunto").attr('checked', false);
	    }
	    if (mnu_responsable == 1) {
	    	$("#chkMnuResponsable").attr('checked', true);
	    } else {
	    	$("#chkMnuResponsable").attr('checked', false);
	    }
	    if (mnu_inhumacion == 1) {
	    	$("#chkMnuInhumacion").attr('checked', true);
	    } else {
	    	$("#chkMnuInhumacion").attr('checked', false);
	    }
	    if (mnu_exhumacion == 1) {
	    	$("#chkMnuExhumacion").attr('checked', true);
	    } else {
	    	$("#chkMnuExhumacion").attr('checked', false);
	    }

	    if (mnu_contrato == 1) {
	    	$("#chkMnuContrato").attr('checked', true);
	    } else {
	    	$("#chkMnuContrato").attr('checked', false);
	    }
	    if (mnu_cobranza == 1) {
	    	$("#chkMnuCobranza").attr('checked', true);
	    } else {
	    	$("#chkMnuCobranza").attr('checked', false);
	    }
	    if (mnu_adquiriente == 1) {
	    	$("#chkMnuAdquiriente").attr('checked', true);
	    } else {
	    	$("#chkMnuAdquiriente").attr('checked', false);
	    }
	    if (mnu_ejecutivoventa == 1) {
	    	$("#chkMnuEjecutivoVenta").attr('checked', true);
	    } else {
	    	$("#chkMnuEjecutivoVenta").attr('checked', false);
	    }
	    if (mnu_comision == 1) {
	    	$("#chkMnuComision").attr('checked', true);
	    } else {
	    	$("#chkMnuComision").attr('checked', false);
	    }

}