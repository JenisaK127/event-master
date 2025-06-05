<?php
require_once "../includes/db.php";
require_once "../includes/gebruiker-class.php";

// $db = new DB();
$user = new Gebruiker($db);

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // XSS bescherming
        $voornaam = htmlspecialchars($_POST["voornaam"]);
        $achternaam = htmlspecialchars($_POST["achternaam"]);
        $email = htmlspecialchars($_POST["email"]);
        $wachtwoord = htmlspecialchars($_POST["wachtwoord"]);
        $telefoonnummer = htmlspecialchars($_POST["telefoonnummer"]);
        $geboortedatum = htmlspecialchars($_POST["geboortedatum"]);

        $user->registerGebruiker($voornaam, $achternaam, $email, $wachtwoord, $telefoonnummer, $geboortedatum);
        echo "Registratie gelukt!";
        header("refresh:2; url=login-user.php");
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
    <link rel="stylesheet" href="../Css/registratie.css">
    <title>Registreren</title>
</head>
<body>
    
    <div class="registratie">
    <h2>Registreren</h2>
    <form method="post" action="registratie-user.php">
        <label for="voornaam">Voornaam:</label>
        <input type="text" id="voornaam" name="voornaam" required>
        
        <label for="achternaam">Achternaam:</label>
        <input type="text" id="achternaam" name="achternaam" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="wachtwoord">Wachtwoord:</label>
        <input type="password" id="wachtwoord" name="wachtwoord" required>

        <label for="telefoonnummer">Telefoonnummer:</label>
        <input type="text" id="telefoonnummer" name="telefoonnummer" required>

        <label for="geboortedatum">Geboortedatum:</label>
        <input type="date" id="geboortedatum" name="geboortedatum" required>

        <button type="submit">Registreer</button><br>
        <a href="login-user.php">Login</a><br>
        <a href="Event managment.html">Terug</a>
    </form>
</div>

</body>
</html>
