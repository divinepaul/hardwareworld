<?php

$servername = "localhost";
$username = "root";
$password = "root";

// Create connection
$db = new mysqli($servername, $username, $password);

// Check connection
if ($db->connect_error) {
    header("HTTP/1.0 500 Internal Server Error");
    die();
}
$db->select_db('test');
?>
