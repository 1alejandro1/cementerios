<?php



	session_start();



	if(isset($_SESSION["idusuario"]) && $_SESSION["mnu_comision"] == 1){

	

//		if ($_SESSION["superadmin"] != "S") {

			include "view/header.html";

			include "view/Comision.html";

//		} else {

//			include "view/headeradmin.html";

//			include "view/Comision.html";

//		}



		include "view/footer.html";

	} else {

		header("Location:index.html");

	}

		



