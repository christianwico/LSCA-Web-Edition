<?php
	include "MySQLHandler.php";
	$db = new MySQLHandler($db);
	$db -> init();

	include "controllers/controller.php";
	$Controller = new controller($db);

    $name = $_POST['name'];
    $studentNumber = $_POST['studentNumber'];
    $email = $_POST['email'];
    $levelId = $_POST['level'];
    $age = $_POST['age'];
    $classId = $_POST['class'];
    $guardian = $_POST['guardian'];
    $guardianTypeId = $_POST['guardianType'];
    $contact = $_POST['contact'];

	// $x = $Controller -> AddStudent($name, $studentNumber, $email, $levelId, $age, $classId, $guardian,
    //     $guardianTypeId, $contact);

    $x = $Controller -> AddStudent($name, $studentNumber, $email, $levelId, $age, $classId, $guardian,
        $guardianTypeId, $contact);
?>