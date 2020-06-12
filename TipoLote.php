<?php

	session_start();

	if(isset($_SESSION["idusuario"]) && $_SESSION["mnu_tipolote"] == 1){

//		if ($_SESSION["superadmin"] != "S") {

			include "view/header.html";

			include "view/TipoLote.html";

//		} else {

//			include "view/headeradmin.html";

//			include "view/TipoLote.html";

//		}



		include "view/footer.html";

	} else {

		header("Location:index.html");

	}

		



