<?php
include ("Function_Backup.php");

echo backup_tables("localhost","sistemai_root","MXZ847vVK.Lr","cementerio");
$fecha=date("Y-m-d");
header("Content-disposition: attachment; filename=db-backup-".$fecha.".sql");
header("Content-type: MIME");
readfile("db-cementerio-".$fecha.".sql");
