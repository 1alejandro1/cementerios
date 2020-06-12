<?php

//$conexion = new mysqli("localhost", "sistemai_root", "MXZ847vVK.Lr", "sistemai_bdcementerio");
//$conexion = new mysqli("localhost", "root_remoto", "masf10400894", "sistemai_bdcementerio");
//$conexion = new mysqli("localhost", "root", "masf10400894", "sistemai_bdcementerio");

// Local en servidor Levitico
// $conexion = new mysqli("localhost", "root", "masf10400894", "cementerio");

// Remoto en Servidor SistemaIEC.com directorio Cementerios
$conexion = new mysqli("localhost", "root", "", "bdcementerios");

// Local en servidor Exodo
// $conexion = new mysqli("localhost", "root", "", "cementerio");

	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
