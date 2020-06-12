<?php



	session_start();



	if(isset($_SESSION["idusuario"]) && $_SESSION["mnu_inhumacion"] == 1){

	

//		if ($_SESSION["superadmin"] != "S") {

			include "view/header.html";

			include "view/Inhumacion.html";

//		} else {

//			include "view/headeradmin.html";

//			include "view/Inhumacion.html";

//		}



		include "view/footer.html";

	} else {

		header("Location:index.html");

	}

		



