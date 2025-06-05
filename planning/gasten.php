<?php
require_once "../includes/db.php";
require_once "../includes/gasten-class.php";

$gastenlijst = new Gastenlijst($db);
$success = false;
$errorMessage = "";

$evenementID = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voornaam = trim($_POST["voornaam"]);
    $achternaam = trim($_POST["achternaam"]);
    $leeftijd = filter_var($_POST["leeftijd"], FILTER_VALIDATE_INT);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $telefoonnummer = trim($_POST["telefoonnummer"]);

    if ($voornaam && $achternaam && $leeftijd !== false && $email && $telefoonnummer && $evenementID > 0) {
        $success = $gastenlijst->insertGasten($voornaam, $evenementID, $achternaam, $leeftijd, $email, $telefoonnummer);
        if ($success) {
            header("Location: gasten.php?id=$evenementID");
            exit();
        } else {
            $errorMessage = "Er is iets misgegaan bij het toevoegen.";
        }
    } else {
        $errorMessage = "Ongeldige invoer, controleer alle velden.";
    }
}

$gasten = [];
try {
    if ($evenementID > 0) {
        $gasten = $gastenlijst->getAlleGasten($evenementID);
    }
} catch (Exception $e) {
    $errorMessage = "Fout bij het ophalen van de gegevens: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/gasten.css">
    <title>Gastenlijst</title>
</head>
<body class="container mt-4">

<a href="../user/dashboard.php?ID">Terug</a>


    <?php if ($success): ?>
        <div class="alert alert-success">Gast succesvol toegevoegd!</div>
    <?php elseif (!empty($errorMessage)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>

    <form method="post" class="mb-4">
        <div class="mb-2">
            <label for="voornaam" class="form-label">Voornaam:</label>
            <input type="text" id="voornaam" name="voornaam" class="form-control" required>
        </div>
        <div class="mb-2">
            <label for="achternaam" class="form-label">Achternaam:</label>
            <input type="text" id="achternaam" name="achternaam" class="form-control" required>
        </div>
        <div class="mb-2">
            <label for="leeftijd" class="form-label">Leeftijd:</label>
            <input type="number" id="leeftijd" name="leeftijd" class="form-control" required>
        </div>
        <div class="mb-2">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="mb-2">
            <label for="telefoonnummer" class="form-label">Telefoonnummer:</label>
            <input type="text" id="telefoonnummer" name="telefoonnummer" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Gast toevoegen</button>
    </form>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Gast ID</th>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Leeftijd</th>
                <th>E-mail</th>
                <th>Telefoonnummer</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($gasten)): ?>
                <?php foreach ($gasten as $gast): ?>
                    <tr>
                        <td><?= htmlspecialchars($gast['gastenID']); ?></td>
                        <td><?= htmlspecialchars($gast['voornaam']); ?></td>
                        <td><?= htmlspecialchars($gast['achternaam']); ?></td>
                        <td><?= htmlspecialchars($gast['leeftijd']); ?></td>
                        <td><?= htmlspecialchars($gast['email']); ?></td>
                        <td><?= htmlspecialchars($gast['telefoonnummer']); ?></td>
                        <td>
                            <a href="delete.php?gastenID=<?= htmlspecialchars($gast['gastenID']); ?>" class="btn btn-danger btn-sm">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Geen gasten gevonden voor dit evenement.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
