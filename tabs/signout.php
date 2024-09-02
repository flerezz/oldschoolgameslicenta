<?php
session_start();

// Conectare la baza de date
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "licenta";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_COOKIE['session_token'])) {
    $session_token = $_COOKIE['session_token'];

    // Ștergere sesiune din baza de date
    $stmt = $conn->prepare("DELETE FROM sessions WHERE session_token = ?");
    $stmt->bind_param("s", $session_token);
    $stmt->execute();

    // Ștergere cookie
    setcookie("session_token", "", time() - 3600, "/", "", false, true);
}

$conn->close();

// Redirecționare la pagina de login
header("Location: home.php");
exit();
?>
