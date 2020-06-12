<?php



	session_start();



	if(isset($_SESSION["idusuario"]) && $_SESSION["mnu_cobranza"] == 1){

	

//		if ($_SESSION["superadmin"] != "S") {

			include "view/header.html";

			include "view/Cobranza.html";

//		} else {

//			include "view/headeradmin.html";

//			include "view/Cobranza.html";

//		}



		include "view/footer.html";

	} else {

		header("Location:index.html");

	}

		



