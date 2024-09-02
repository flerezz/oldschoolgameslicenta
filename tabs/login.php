<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://kit.fontawesome.com/39f42c82d4.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="container">
        <div class="tile"></div>
    </div>
    <div class="wrapper animated bounce">
        <h1>Authenticate</h1>
        <hr>
        <form action="signin.php" method="POST">
            <label id="icon" for="username"><i class="fa fa-user"></i></label>
            <input type="text" placeholder="Username" name="username" id="username" required>
            <label id="icon" for="password"><i class="fa fa-key"></i></label>
            <input type="password" placeholder="Password" name="password" id="password" required>
            <input type="submit" value="Sign In">
            <hr>
            <div class="crtacc"><a href="logup.php">Create Account</a></div>
        </form>
    </div>
    <script src="../js/login.js"></script>
</body>
</html>
