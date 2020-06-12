<?php



	session_start();



	if(isset($_SESSION["idusuario"]) && $_SESSION["mnu_contrato"] == 1){

	

//		if ($_SESSION["superadmin"] != "S") {

			include "view/header.html";
			include "view/Contrato.html";

//		} else {

//			include "view/headeradmin.html";

//			include "view/Contrato.html";

//		}



		include "view/footer.html";

	} else {

		header("Location:index.html");

	}

		



