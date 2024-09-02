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



// CRUD pentru tabelul `user`
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_user'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $profile_picture = $_POST['profile_picture'] ?? '';
        $user_role = $_POST['user_role'] ?? 0;

        // Criptare parolă eliminată conform cerinței
        $stmt = $pdo->prepare("INSERT INTO user (username, password, profile_picture, user_role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $password, $profile_picture, $user_role]);
        echo 'User created successfully';
    } elseif (isset($_POST['update_user'])) {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'] ?? null;
        $profile_picture = $_POST['profile_picture'] ?? null;
        $user_role = $_POST['user_role'] ?? null;

        // Construiește interogarea dinamică
        $fields = [];
        $params = [];

        if ($username !== null && strlen($username) > 0) {
            $fields[] = 'username = ?';
            $params[] = $username;
        }
        if ($profile_picture !== null && strlen($profile_picture) > 0) {
            $fields[] = 'profile_picture = ?';
            $params[] = $profile_picture;
        }
        if ($user_role !== null) {
            $fields[] = 'user_role = ?';
            $params[] = $user_role;
        }
        $params[] = $user_id;

        if (!empty($fields)) {
            $sql = "UPDATE user SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            echo 'User updated successfully';
        } else {
            echo 'No fields to update';
        }
    } elseif (isset($_POST['delete_user'])) {
        $user_id = $_POST['user_id'];

        $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
        $stmt->execute([$user_id]);
        echo 'User deleted successfully';
    } elseif (isset($_POST['create_game'])) {
        $game_name = $_POST['game_name'];
        $game_link = $_POST['game_link'];
        $game_logo = $_POST['game_logo'];
        $game_color = $_POST['game_color'];

        $stmt = $pdo->prepare("INSERT INTO games (game_name, game_link, game_logo, game_color) VALUES (?, ?, ?, ?)");
        $stmt->execute([$game_name, $game_link, $game_logo, $game_color]);
        echo 'Game created successfully';
    } elseif (isset($_POST['update_game'])) {
        $game_id = $_POST['game_id'];
        $game_name = $_POST['game_name'] ?? null;
        $game_link = $_POST['game_link'] ?? null;
        $game_logo = $_POST['game_logo'] ?? null;
        $game_color = $_POST['game_color'] ?? null;

        // Construiește interogarea dinamică
        $fields = [];
        $params = [];

        if ($game_name !== null && strlen($game_name) > 0) {
            $fields[] = 'game_name = ?';
            $params[] = $game_name;
        }
        if ($game_link !== null && strlen($game_link) > 0) {
            $fields[] = 'game_link = ?';
            $params[] = $game_link;
        }
        if ($game_logo !== null && strlen($game_logo) > 0) {
            $fields[] = 'game_logo = ?';
            $params[] = $game_logo;
        }
        if ($game_color !== null && strlen($game_color) > 0) {
            $fields[] = 'game_color = ?';
            $params[] = $game_color;
        }
        $params[] = $game_id;

        if (!empty($fields)) {
            $sql = "UPDATE games SET " . implode(', ', $fields) . " WHERE game_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            echo 'Game updated successfully';
        } else {
            echo 'No fields to update';
        }
    } elseif (isset($_POST['delete_game'])) {
        $game_id = $_POST['game_id'];

        $stmt = $pdo->prepare("DELETE FROM games WHERE game_id = ?");
        $stmt->execute([$game_id]);
        echo 'Game deleted successfully';
    } elseif (isset($_POST['clear_sessions'])) {
        $stmt = $pdo->prepare("TRUNCATE TABLE sessions");
        $stmt->execute();
        echo 'All sessions cleared successfully';
    }
}

// Funcție pentru a obține utilizatorii
function getUsers() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM user");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Funcție pentru a obține jocurile
function getGames() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM games");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$users = getUsers();
$games = getGames();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="../tabs/games.php" class="logo-link">
                <img src="../assets/logo.png" alt="Logo" class="logo-img">
            </a>
        </div>
    </header>
    <h1>Admin Dashboard</h1>

    <!-- Secțiunea CRUD pentru utilizatori -->
    <h2>Users</h2>
    <form method="POST">
        <h3>Create User</h3>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="profile_picture" placeholder="Profile Picture URL">
        <select name="user_role" required>
            <option value="0">Regular User</option>
            <option value="1">Admin</option>
        </select>
        <button type="submit" name="create_user">Create User</button>
    </form>
    <form method="POST">
        <h3>Update User</h3>
        <input type="number" name="user_id" placeholder="User ID" required>
        <input type="text" name="username" placeholder="Username">
        <input type="text" name="profile_picture" placeholder="Profile Picture URL">
        <select name="user_role">
            <option value="">Select Role (Leave empty to keep current)</option>
            <option value="0">Regular User</option>
            <option value="1">Admin</option>
        </select>
        <button type="submit" name="update_user">Update User</button>
    </form>
    <form method="POST">
        <h3>Delete User</h3>
        <input type="number" name="user_id" placeholder="User ID" required>
        <button type="submit" name="delete_user">Delete User</button>
    </form>

    <h2>Current Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Profile Picture</th>
                <th>User Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['profile_picture']); ?></td>
                    <td><?php echo htmlspecialchars($user['user_role'] == 1 ? 'Admin' : 'Regular User'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Secțiunea CRUD pentru jocuri -->
    <h2>Games</h2>
    <form method="POST">
        <h3>Create Game</h3>
        <input type="text" name="game_name" placeholder="Game Name" required>
        <input type="text" name="game_link" placeholder="Game Link" required>
        <input type="text" name="game_logo" placeholder="Game Logo URL" required>
        <input type="text" name="game_color" placeholder="Game Color" required>
        <button type="submit" name="create_game">Create Game</button>
    </form>
    <form method="POST">
        <h3>Update Game</h3>
        <input type="number" name="game_id" placeholder="Game ID" required>
        <input type="text" name="game_name" placeholder="Game Name">
        <input type="text" name="game_link" placeholder="Game Link">
        <input type="text" name="game_logo" placeholder="Game Logo URL">
        <input type="text" name="game_color" placeholder="Game Color">
        <button type="submit" name="update_game">Update Game</button>
    </form>
    <form method="POST">
        <h3>Delete Game</h3>
        <input type="number" name="game_id" placeholder="Game ID" required>
        <button type="submit" name="delete_game">Delete Game</button>
    </form>

    <h2>Current Games</h2>
    <table>
        <thead>
            <tr>
                <th>Game ID</th>
                <th>Game Name</th>
                <th>Game Link</th>
                <th>Game Logo</th>
                <th>Game Color</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($games as $game): ?>
                <tr>
                    <td><?php echo htmlspecialchars($game['game_id']); ?></td>
                    <td><?php echo htmlspecialchars($game['game_name']); ?></td>
                    <td><?php echo htmlspecialchars($game['game_link']); ?></td>
                    <td><?php echo htmlspecialchars($game['game_logo']); ?></td>
                    <td><?php echo htmlspecialchars($game['game_color']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Ștergere sesiuni -->
    <h2>Clear Sessions</h2>
    <form method="POST">
        <button type="submit" name="clear_sessions">Clear All Sessions</button>
    </form>
</body>
</html>
