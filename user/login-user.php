<?php
require_once "../includes/gebruiker-class.php";

session_start();
// $db = new DB();
$user = new Gebruiker($db);

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // XSS bescherming
        $email = htmlspecialchars($_POST["email"]);
        $wachtwoord = htmlspecialchars($_POST["wachtwoord"]);

        $userData = $user->loginGebruiker($email);
        if ($userData && password_verify($wachtwoord, $userData["wachtwoord"])) {
            $_SESSION["login_status"] = true;
            $_SESSION["gebruikerID"] = $userData["gebruikerID"]; // Stel de gebruikerID in de sessie
            $_SESSION["voornaam"] = $userData["voornaam"];
            $_SESSION["achternaam"] = $userData["achternaam"];
            header("location: page 1.php");
        } else {
            echo "Ongeldige email of wachtwoord!";
            header("refresh:2; url=login-user.php");
            exit();
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/login.css">
    <title>Login</title>
</head>
<body>

<div class="login">
   <form method="post" action="login-user.php">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" id="wachtwoord" name="wachtwoord" required>

        <button type="submit">Inloggen</button><br>
        <a href="registratie-user.php">Aanmelden</a><br>
        <a href="Event managment.html">Terug</a>
    </form> 
</div>
    
</body>
</html>
