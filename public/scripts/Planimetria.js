$(document).on("ready", init);// Inciamos el jquery

function init(){

    $('#tblLotePlan').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });

    ListadoLotePlan();// Ni bien carga la pagina que cargue el metodo

    $("#VerFormReserva").hide();// Ocultamos el formulario

    $("form#frmReserva").submit(SaveOrUpdate);// Evento submit de jquery que llamamos al metodo SaveOrUpdate para poder registrar o modificar datos

    function SaveOrUpdate(e){

        e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/PlanimetriaAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            swal("Mensaje del Sistema", r, "success");

            ListadoLotePlan();

            OcultarFormReserva();

        });

    };

}


    function LimpiarReservacion(){

        // Limpiamos las cajas de texto

        $("#txtNombreReserva").val("");

        $("#txtMontoReserva").val("");

    }

    function VerFormReservacion(){

        $("#VerFormReserva").show();// Mostramos el formulario

        $("#VerListadoPlan").hide();

    }

    function OcultarFormReserva(){

        $("#VerFormReserva").hide();// Mostramos el formulario

        $("#VerListadoPlan").show();

    }

function ListadoLotePlan(){

        var tabla = $('#tblLotePlan').dataTable(

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

                    {   "mDataProp": "8"},

                    {   "mDataProp": "9"}

            ],"ajax":

                {

                    url: './ajax/PlanimetriaAjax.php?op=list',

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };

 
    function cargarDataPlan(id, nombrereserva, login, loginactualizo, idestadolote, montoreserva, tipomovimiento) {

        $("#txtIdLote").val(id);

        $("#txtIdEstadoLote").val(idestadolote);

        $("#txtNombreReserva").val(nombrereserva);// recibimos la variable nombre a la caja de texto txtNombre

        $("#txtLogin").val(login);// recibimos la variable nombre a la caja de texto txtNombre

        $("#txtLoginActualizo").val(loginactualizo);// recibimos la variable nombre a la caja de texto txtNombre

        $("#txtMontoReserva").val(montoreserva);// recibimos la variable nombre a la caja de texto txtNombre

        $("#txtTipoMovimiento").val(tipomovimiento);// recibimos la variable nombre a la caja de texto txtNombre

        if (tipomovimiento=='A') {
        if (idestadolote==7) {
            swal({
              title: ("¿Esta Seguro de eliminar reserva del Lote seleccionado?"),
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-success",
              confirmButtonText: "Si",
              cancelButtonText: "No",
              closeOnConfirm: true
            },
            function(){

                $.post("./ajax/PlanimetriaAjax.php?op=Update", {id:id, nombrereserva:nombrereserva, idestadolote:idestadolote, montoreserva:montoreserva}, function(r) {

                    swal("Mensaje del Sistema", r, "success");

                    ListadoLotePlan();

                    OcultarFormReserva();

                });
            });
        } else {

            $("#VerFormReserva").show();// mostramos el formulario

            $("#VerListadoPlan").hide();

            $("#txtIdLote").val(id);// recibimos la variable id a la caja de texto

        }
        } else {
            $("#VerFormReserva").show();// mostramos el formulario

            $("#VerListadoPlan").hide();

            $("#txtIdLote").val(id);// recibimos la variable id a la caja de texto

        }

    }

