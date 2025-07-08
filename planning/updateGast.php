<?php
require_once "../includes/db.php";
require_once "../includes/gasten-class.php";

$gastenlijst = new Gastenlijst($db);
$success = false;
$errorMessage = "";

$gastenID = isset($_GET['gastenID']) ? intval($_GET['gastenID']) : 0;
$evenementID = 0;

if ($gastenID > 0) {
    $gast = $gastenlijst->getGastById($gastenID);
    if ($gast) {
        $evenementID = $gast['evenementID'];
    } else {
        die("Gast niet gevonden.");
    }
} else {
    die("Geen geldig gastenID opgegeven.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voornaam = trim($_POST["voornaam"]);
    $achternaam = trim($_POST["achternaam"]);
    $leeftijd = filter_var($_POST["leeftijd"], FILTER_VALIDATE_INT);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $telefoonnummer = trim($_POST["telefoonnummer"]);

    if ($voornaam && $achternaam && $leeftijd !== false && $email && $telefoonnummer) {
        $success = $gastenlijst->updateGast($gastenID, $voornaam, $achternaam, $leeftijd, $email, $telefoonnummer);
        if ($success) {
            header("Location: gasten.php?id=$evenementID");
            exit();
        } else {
            $errorMessage = "Er is iets misgegaan bij het bijwerken.";
        }
    } else {
        $errorMessage = "Ongeldige invoer, controleer alle velden.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/gasten.css">
    <title>Gast bewerken</title>
</head>
<body class="container mt-4">
<a href="gasten.php?id=<?= $evenementID ?>">Terug</a>

<?php if ($success): ?>
    <div class="alert alert-success">Gast succesvol bijgewerkt!</div>
<?php elseif (!empty($errorMessage)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($errorMessage); ?></div>
<?php endif; ?>

<form method="post" class="mb-4">
    <div class="mb-2">
        <label for="voornaam" class="form-label">Voornaam:</label>
        <input type="text" id="voornaam" name="voornaam" class="form-control" required value="<?= htmlspecialchars($gast['voornaam']) ?>">
    </div>
    <div class="mb-2">
        <label for="achternaam" class="form-label">Achternaam:</label>
        <input type="text" id="achternaam" name="achternaam" class="form-control" required value="<?= htmlspecialchars($gast['achternaam']) ?>">
    </div>
    <div class="mb-2">
        <label for="leeftijd" class="form-label">Leeftijd:</label>
        <input type="number" id="leeftijd" name="leeftijd" class="form-control" required value="<?= htmlspecialchars($gast['leeftijd']) ?>">
    </div>
    <div class="mb-2">
        <label for="email" class="form-label">E-mail:</label>
        <input type="email" id="email" name="email" class="form-control" required value="<?= htmlspecialchars($gast['email']) ?>">
    </div>
    <div class="mb-2">
        <label for="telefoonnummer" class="form-label">Telefoonnummer:</label>
        <input type="text" id="telefoonnummer" name="telefoonnummer" class="form-control" required value="<?= htmlspecialchars($gast['telefoonnummer']) ?>">
    </div>
    <button type="submit" class="btn btn-success">Opslaan</button>
</form>
</body>
</html>
