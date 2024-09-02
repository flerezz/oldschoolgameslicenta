<?php
session_start(); // Pornirea sesiunii

// Conectare la baza de date
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "licenta";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Pregătire și executare interogare
    $stmt = $conn->prepare("SELECT id, password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Verificare dacă utilizatorul există
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $stored_password);
        $stmt->fetch();

        // Verificare parola (fără criptare)
        if ($password === $stored_password) {
            // Generare token de sesiune
            $session_token = bin2hex(random_bytes(32));
            $expires_at = date("Y-m-d H:i:s", strtotime("+1 hour"));

            // Salvare sesiune în baza de date
            $insert_stmt = $conn->prepare("INSERT INTO sessions (user_id, session_token, expires_at) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("iss", $user_id, $session_token, $expires_at);
            $insert_stmt->execute();

            // Setare cookie cu token-ul sesiunii
            setcookie("session_token", $session_token, time() + 3600, "/", "", false, true);

            // Redirecționare către pagina de start
            header("Location: games.php");
            exit();
        } else {
            header("Location: login.php");
        }
    } else {
        header("Location: login.php");
    }

    $stmt->close();
}
$conn->close();
?>
