<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "licenta";

// Crearea conexiunii
$conn = new mysqli($servername, $username, $password, $database);

// Verificarea conexiunii
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}
?>
