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
$stmt = $pdo->prepare("SELECT user_id FROM sessions");
$stmt->execute();
$session = $stmt->fetch(PDO::FETCH_ASSOC);

if ($session) {
    $user_id = $session['user_id'];

    // Obține informațiile utilizatorului din tabelul `user`
    $stmt = $pdo->prepare("SELECT username, profile_picture, user_role FROM user WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $username = htmlspecialchars($user['username']);
        $profile_picture = htmlspecialchars($user['profile_picture']);
        $user_role = (int) $user['user_role'];  // Asigură-te că este un întreg
    } else {
        echo 'User not found';
        exit();
    }
} else {
    // Dacă nu există o sesiune activă, redirecționează utilizatorul la pagina de login
    header("Location: login.php");
    exit();
}

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
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        if (in_array($fileExtension, $allowedExtensions)) {
            // Calea către directorul unde vor fi stocate imaginile
            $uploadDir = '../assets/';
            $destPath = $uploadDir . basename($fileName);

            // Mutați fișierul în directorul dorit
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Actualizează baza de date cu noua imagine
                $query = "UPDATE user SET profile_picture = ? WHERE id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$fileName, $user_id]);

                if ($stmt->rowCount() > 0) {
                    echo 'Profilul a fost actualizat cu succes.';
                    // Actualizează variabila pentru imaginea de profil
                    $profile_picture = $fileName;
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
}

function generateGameCard($gameId) {
    global $pdo;  // Folosim conexiunea PDO definită global

    $sql = "SELECT game_color, game_link, game_logo FROM games WHERE game_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$gameId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $gameColor = htmlspecialchars($result["game_color"]);
        $gameLink = htmlspecialchars($result["game_link"]);
        $gameLogo = htmlspecialchars($result["game_logo"]);

        $html = '<div id="cards">';
        $html .= '<div class="card" data-color="' . $gameColor . '">';
        $html .= '<a href="' . $gameLink . '">';
        $html .= '<img class="card-front-image card-image" src="' . $gameLogo . '" />';
        $html .= '</a>';
        $html .= '<div class="card-faders">';
        
        for ($i = 0; $i < 8; $i++) {
            $html .= '<img class="card-fader card-image" src="' . $gameLogo . '" />';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    } else {
        return "<p>Jocul nu a fost găsit.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Joc</title>
    <link rel="stylesheet" href="../css/games.css">
</head>
<body>
    
<div class="container">
    <!-- Primul rând cu un singur element centrat -->
    <div class="row single">
        <div class="column">
            
            <div class="screen">  
                <div class="screen-image"></div>  
                    <div class="screen-overlay"></div>  
                        <div class="screen-content">
                            <!-- Verifică și afișează imaginea de profil -->
                            <img src="../assets/user_avatar/<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture">
                            <div class="screen-user">
                                <span class="name" data-value="<?php echo $username; ?>"><?php echo $username; ?></span>
                                <a class="link" onclick="document.getElementById('upload-form').style.display='block';">Change Profile Picture</a>
                                <!-- Formular pentru schimbarea imaginii de profil -->
                                <form id="upload-form" action="upload_profile_picture.php" method="POST" enctype="multipart/form-data" style="display: none;">
                                    <input type="file" name="profile_picture" accept="image/*" required>
                                    <button type="submit" class="link">Upload</button>
                                </form>
                                
                                <!-- Link către admin.php dacă user_role este 1 -->
                                <?php if ($user_role === 1): ?>
                                    <a class="link" href="admin.php">Admin Dashboard</a>
                                <?php endif; ?>

                                <a class="link" href="signout.php">Logout</a>
                        </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Al doilea rând cu trei coloane -->
    <div class="row">
        <div class="column">

            <?php echo generateGameCard(1); ?>

        </div>

        <div class="column">

            <?php echo generateGameCard(2); ?>

        </div>

        <div class="column">

            <?php echo generateGameCard(3); ?>

        </div>

    </div>

    <!-- Al treilea rând cu trei coloane -->
    <div class="row">
        <div class="column">

            <?php echo generateGameCard(4); ?>

        </div>

        <div class="column">

            <?php echo generateGameCard(5); ?>

        </div>

        <div class="column">

            <?php echo generateGameCard(6); ?>

        </div>

    </div>

    <!-- Al patrulea rând cu trei coloane -->
    <div class="row">
        <div class="column">

            <?php echo generateGameCard(7); ?>

        </div>

        <div class="column">

            <?php echo generateGameCard(8); ?>

        </div>

        <div class="column">

            <?php echo generateGameCard(9); ?>

        </div>

    </div>

</div>

<script src="../js/games.js"></script>
</body>
</html>
