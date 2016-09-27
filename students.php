<?php
	include "MySQLHandler.php";
	$db = new MySQLHandler($db);
	$db -> init();

	include "controllers/controller.php";
	$Controller = new controller($db);

	$x = $Controller -> getStudents();

	echo json_encode($x);
?>