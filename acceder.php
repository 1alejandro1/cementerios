<?php
  session_start();
  if(isset($_SESSION["idusuario"])){
?>
<!DOCTYPE html>
<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Software Empresarial | Soluciones Tecnologicas Alfa</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="public/css/font-awesome.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="public/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="public/css/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <style>
  body{



  }

  </style>
    <body class="hold-transition login-page" style="  background: url('assets/img/backgrounds/f2.jpg') ;
    background-repeat: repeat;
    background-size: auto auto;
background-size: cover;
background-repeat: no-repeat;"  >
  <section class="content">
          <div class="row">
            <!-- left column -->
			 <div class="col-md-4"></div>
			  <div class="col-md-4"></div>
            <div class="col-md-4">

              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Datos del Empleado</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frmAcceder" name="frmAcceder">
                  <div class="box-body">




                  <div class="row">
                    <div class="col-xs-12">
                          <div class="box box-widget widget-user-2">
                          <!-- Add the bg color to the header using any of the bg-* classes -->
                          <div class="widget-user-header bg-yellow" style="background-color: #dd4b39 !important;">
                            <div class="widget-user-image">
                              <img class="img-circle" src="<?php echo $_SESSION["foto"]; ?>" alt="Usuario">
                            </div><!-- /.widget-user-image -->
                            <h3 class="widget-user-username"><?php echo $_SESSION["personal"]; ?></h3>
                            <h5 class="widget-user-desc"><?php echo $_SESSION["tipo_usuario"]; ?></h5>
                          </div>
                          <div class="box-footer no-padding">
                            <ul class="nav nav-stacked">
                              <li><a href="#"><strong>Documento:</strong>&nbsp; <?php echo $_SESSION["tipodocumento"]." ".$_SESSION["numdocumento"]; ?><span class="pull-right badge bg-red"><i class="fa fa-fw fa-book"></i></span></a></li>
                              <li><a href="#"><strong>Telefono:</strong>&nbsp; <?php echo $_SESSION["telefono"]?> <span class="pull-right badge bg-blue"><i class="fa fa-fw fa-mobile-phone"></i></span></a></li>
                              <li><a href="#"><strong>Direccion:</strong>&nbsp; <?php echo $_SESSION["direccion"]?> <span class="pull-right badge bg-aqua"><i class="fa fa-fw fa-taxi"></i></span></a></li>
                              <li><a href="#"><strong>Email:</strong>&nbsp; <?php echo $_SESSION["email"]?> <span class="pull-right badge bg-green"><i class="fa fa-fw fa-envelope"></i></span></a></li>
                              <li><a href="#"><strong>Usuario:</strong>&nbsp; <?php echo $_SESSION["login"]?> <span class="pull-right badge bg-aqua"><i class="fa fa-fw fa-user"></i></span></a></li>
                            </ul>
                          </div>
                        </div><!-- /.widget-user -->

                    </div>
                  </div>
				     <div class="box-footer">
                    <a type="button" href="ajax/UsuarioAjax.php?op=Salir" class="btn btn-danger">Cerrar Sesión</a>
                  </div>





              <!-- Horizontal Form -->
              <div class="box box-info">

                <!-- form start -->

                  <div class="box-body">
                  <div class="box">

                <div class="box-body no-padding">
                  <table class="table table-hover" id="tblCementerio">
                    <tr>
                      <th>Opcion</th>
                      <th>Cementerio</th>
                      <th>Logo</th>

                    </tr>

                    <tbody id="Cementerio">

                    </tbody>

                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- general form elements disabled -->
                          </div><!--/.col (right) -->
          </div>   <!-- /.row -->
				  </div>


                  </div><!-- /.box-body -->


                </form>
              </div><!-- /.box -->






            </div><!--/.col (left) -->


            <!-- right column -->



        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  <div class="row"  >

	  	 <div class="col-md-4"  ></div>

		   <div class="col-md-4"></div>



	  </div>






    <!-- jQuery 2.1.4 -->
    <script src="public/js/jquery.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="public/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="public/js/icheck.min.js"></script>

    <script type="text/javascript">
      $(document).on("ready", init);

      function init(){

        ListadoIngresos();

        function ListadoIngresos(){
          $.post("ajax/CementerioAjax.php?op=listCementerioPersonal", function(r){
                $("#Cementerio").html(r);
          });
        };


      }

      function Acceder(idusuario, idcementerio, idpersonal, personal, tipodocumento, tipo_usuario, numdocumento, direccion, telefono, foto, logo, email, login, razon_social, mnu_cementerio, mnu_sector, mnu_lote,   mnu_tipolote, mnu_estadolote, mnu_mantenimiento, mnu_montocuota, mnu_planimetria, mnu_personal, mnu_difunto, mnu_responsable, mnu_inhumacion, mnu_exhumacion, mnu_contrato, mnu_cobranza, mnu_adquiriente, mnu_ejecutivoventa, mnu_comision){
        var data = {
            idusuario : idusuario,
            idcementerio : idcementerio,
            idpersonal : idpersonal,
            personal : personal,
            tipodocumento : tipodocumento,
            tipo_usuario : tipo_usuario,
            numdocumento : numdocumento,
            direccion : direccion,
            telefono : telefono,
            foto : foto,
            logo : logo,
            email : email,
            login : login,
            razon_social : razon_social,

            mnu_cementerio : mnu_cementerio,
            mnu_sector : mnu_sector,
            mnu_lote : mnu_lote,
            mnu_tipolote : mnu_tipolote,
            mnu_estadolote : mnu_estadolote,
            mnu_mantenimiento : mnu_mantenimiento,
            mnu_montocuota : mnu_montocuota,
            mnu_planimetria : mnu_planimetria,
            mnu_personal : mnu_personal,
            mnu_difunto : mnu_difunto,
            mnu_responsable : mnu_responsable,
            mnu_inhumacion : mnu_inhumacion,
            mnu_exhumacion : mnu_exhumacion,
            mnu_contrato : mnu_contrato,
            mnu_cobranza : mnu_cobranza,
            mnu_adquiriente : mnu_adquiriente,
            mnu_ejecutivoventa : mnu_ejecutivoventa,
            mnu_comision : mnu_comision
        };
        $.post("ajax/UsuarioAjax.php?op=IngresarPanel", data, function(r){
                $(location).attr("href", "Escritorio.php");
          });
      }

      function AccederSuperAdmin(idpersonal, idusuario, idcementerio, estadoAdmin, personal, tipodocumento, direccion, telefono, foto, email, login, mnu_cementerio, mnu_sector, mnu_lote, mnu_tipolote, mnu_estadolote, mnu_mantenimiento, mnu_montocuota, mnu_planimetria, mnu_personal, mnu_difunto, mnu_responsable, mnu_inhumacion, mnu_exhumacion, mnu_contrato, mnu_cobranza, mnu_adquiriente, mnu_ejecutivoventa, mnu_comision, logo){
        var data = {
            idpersonal : idpersonal,
            idusuario : idusuario,
            idcementerio : idcementerio,
            estadoAdmin : estadoAdmin,
            personal : personal,
            tipodocumento : tipodocumento,
            direccion: direccion,
            telefono : telefono,
            foto : foto,
            email : email,
            login : login,
            mnu_cementerio : mnu_cementerio,
            mnu_sector : mnu_sector,
            mnu_lote : mnu_lote,
            mnu_tipolote : mnu_tipolote,
            mnu_estadolote : mnu_estadolote,
            mnu_mantenimiento : mnu_mantenimiento,
            mnu_montocuota : mnu_montocuota,
            mnu_planimetria : mnu_planimetria,
            mnu_personal : mnu_personal,
            mnu_difunto : mnu_difunto,
            mnu_responsable : mnu_responsable,
            mnu_inhumacion : mnu_inhumacion,
            mnu_exhumacion : mnu_exhumacion,
            mnu_contrato : mnu_contrato,
            mnu_cobranza : mnu_cobranza,
            mnu_adquiriente : mnu_adquiriente,
            mnu_ejecutivoventa : mnu_ejecutivoventa,
            mnu_comision : mnu_comision,
            logo: logo
        };
        $.post("ajax/UsuarioAjax.php?op=IngresarPanelSuperAdmin", data, function(r){
                $(location).attr("href", "Escritorio.php");
          });
      }

    </script>
  </body>
</html>
<?php

  } else {
    header("Location:index.html");
  }

?>
