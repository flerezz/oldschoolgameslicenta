<?php
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
    $email = $_POST['email'];
    $password = $_POST['password']; // Fără criptare

    // Pregătire și executare interogare pentru inserare utilizator
    $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "Înregistrare realizată cu succes!";
        header("Location: login.php"); // Redirecționare la pagina de login
        exit();
    } else {
        echo "Eroare la înregistrare: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
