<?php



	session_start();


	if(isset($_SESSION["idusuario"]) && $_SESSION["mnu_planimetria"] == 1){

//		if ($_SESSION["superadmin"] != "S") {

			include "view/header.html";

			include "view/Planimetria.html";

//		} else {

//			include "view/headeradmin.html";

//			include "view/TipoLote.html";

//		}



		include "view/footer.html";

	} else {

		header("Location:index.html");

	}

		



