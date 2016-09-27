<?php
$server = "localhost";
$user = "";
$pass = "";

function dbConnect() {
    $conn = new mysqli($server, $name, $pass);

    if ($conn -> connect_error) die("Connection to database failed: " $conn -> connect_error);

    return $conn;
}

?>