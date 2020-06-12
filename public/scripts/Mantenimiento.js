$(document).on("ready", init);// Inciamos el jquery

function init(){

    $('#tblMantenimiento').dataTable({

        dom: 'Bfrtip',

        buttons: [

            'copyHtml5',

            'excelHtml5',

            'csvHtml5',

            'pdfHtml5'

        ]

    });


	ListadoMantenimiento();// Ni bien carga la pagina que cargue el metodo

    $("#btnNuevo2").click(VerForm2);// evento click de jquery que llamamos al metodo VerForm


	function SaveOrUpdate(e){

		e.preventDefault();// para que no se recargue la pagina

        $.post("./ajax/MantenimientoAjax.php?op=SaveOrUpdate", $(this).serialize(), function(r){// llamamos la url por post. function(r). r-> llamada del callback

            swal("Mensaje del Sistema", r, "success");

            ListadoMantenimiento();

        });

	};

    function VerForm2(){

        swal({
          title: "¿Crear Cuotas de Mantenimiento?",
          text: "¡Se crearan las cuotas de mantenimiento a todos los contratos!",
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "No",
          confirmButtonClass: "btn-success",
          confirmButtonText: "Si",
          closeOnConfirm: false
        },
        function(isConfirm){
            if (isConfirm) {
                swal("Cuotas de Mantenimiento Creadas!", "Se actualizaron todos los contratos.", "success");
            }
        });
    }

}



function ListadoMantenimiento(){

        var tabla = $('#tblMantenimiento').dataTable(

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

                    url: './ajax/MantenimientoAjax.php?op=list',

                    type : "get",

                    dataType : "json",

                    error: function(e){

                        console.log(e.responseText);

                    }

                },

            "bDestroy": true



        }).DataTable();

    };

