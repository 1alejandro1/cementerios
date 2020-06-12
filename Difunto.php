<?php



	session_start();



	if(isset($_SESSION["idusuario"]) && $_SESSION["mnu_difunto"] == 1){

		

//		if ($_SESSION["superadmin"] != "S") {

			include "view/header.html";

			include "view/Difunto.html";

//		} else {

//			include "view/headeradmin.html";

//			include "view/Difunto.html";

//		}



		include "view/footer.html";

	} else {

		header("Location:index.html");

	}

		



