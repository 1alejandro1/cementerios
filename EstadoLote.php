<?php

	session_start();

	if(isset($_SESSION["idusuario"]) && $_SESSION["mnu_estadolote"] == 1){

//		if ($_SESSION["superadmin"] != "S") {

			include "view/header.html";

			include "view/EstadoLote.html";

//		} else {

//			include "view/headeradmin.html";

//			include "view/EstadoLote.html";

//		}



		include "view/footer.html";

	} else {

		header("Location:index.html");

	}

		



