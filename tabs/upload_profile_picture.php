<?php
session_start(); // Asigură-te că sesiunea este activă

// Detaliile de conectare la baza de date
$host = 'localhost';
$db = 'licenta';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}

// Verifică dacă utilizatorul este conectat
$user_id = null;

// Caută sesiunea activă
$stmt = $pdo->prepare("SELECT user_id FROM sessions LIMIT 1"); // Asigură-te că este doar o sesiune activă
$stmt->execute();
$session = $stmt->fetch(PDO::FETCH_ASSOC);

if ($session) {
    $user_id = $session['user_id'];

    // Verifică dacă utilizatorul este conectat
    $stmt = $pdo->prepare("SELECT username, profile_picture FROM user WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Procesare fișier de încărcare
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
            // Verifică dacă nu există erori
            if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                // Setează variabile pentru fișier
                $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
                $fileName = $_FILES['profile_picture']['name'];
                $fileSize = $_FILES['profile_picture']['size'];
                $fileType = $_FILES['profile_picture']['type'];

                // Verifică extensia fișierului
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                if (in_array($fileExtension, $allowedExtensions)) {
                    // Calea către directorul unde vor fi stocate imaginile
                    $uploadDir = '../assets/user_avatar/';
                    $destPath = $uploadDir . basename($fileName);

                    // Mutați fișierul în directorul dorit
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        // Actualizează baza de date cu noua imagine
                        $query = "UPDATE user SET profile_picture = ? WHERE id = ?";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute([$fileName, $user_id]);

                        if ($stmt->rowCount() > 0) {
                            echo 'Profilul a fost actualizat cu succes.';
                            // Redirecționează utilizatorul înapoi la pagina de jocuri
                            header("Location: games.php");
                            exit();
                        } else {
                            echo 'Eroare la actualizarea profilului.';
                        }
                    } else {
                        echo 'Eroare la încărcarea fișierului.';
                    }
                } else {
                    echo 'Tip de fișier nepermis. Acceptate: jpg, jpeg, png.';
                }
            } else {
                echo 'Eroare la încărcarea fișierului: ' . $_FILES['profile_picture']['error'];
            }
        } else {
            echo 'Nu a fost trimis niciun fișier.';
        }
    } else {
        echo 'User not found';
    }
} else {
    // Dacă nu există o sesiune activă, redirecționează utilizatorul la pagina de login
    header("Location: login.php");
    exit();
}
?>
