<?php



	session_start();



	if(isset($_SESSION["idusuario"]) && $_SESSION["mnu_montocuota"] == 1){

	

//		if ($_SESSION["superadmin"] != "S") {

			include "view/header.html";

			include "view/MontoCuota.html";

//		} else {

//			include "view/headeradmin.html";

//			include "view/Sector.html";

//		}



		include "view/footer.html";

	} else {

		header("Location:index.html");

	}

		



