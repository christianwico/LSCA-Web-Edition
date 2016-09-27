<?php
	include "MySQLHandler.php";
	$db = new MySQLHandler($db);
	$db -> init();

	$email = $_POST["email"];
	$password = $_POST["password"];
	
	include "controllers/controller.php";
	$Controller = new controller($db);

	
	$x = $Controller -> login($email, $password);

	echo '<script>alert("result = $x"</script>';

	if ($x == "true") header('Location: dashboard.html');
	else echo '<script>alert("Incorrect E-MAIL or PASSWORD.</script>';

	die();	
?>