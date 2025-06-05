<?php
require_once "../includes/db.php"; 
require_once "../includes/taken-class.php";

$takenlijst = new Takenlijst($db);
$success = false;
$errorMessage = "";

$evenementID = isset($_GET['evenementID']) ? intval($_GET['evenementID']) : 1;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idEvenement = $_GET['id'];
    $taaknaam = trim($_POST["taaknaam"]);
    $benodigdheden = trim($_POST["benodigdheden"]);
    $status = isset($_POST["status"]) ? htmlspecialchars($_POST["status"]) : "Niet gestart";

    if ($taaknaam && $benodigdheden) {
        $success = $takenlijst->insertTaak($taaknaam, $_GET['id'], $benodigdheden, $status);
        if ($success) {
            header("Location: taken.php?id=$idEvenement");
            exit();
        } else {
            $errorMessage = "Er is iets misgegaan bij het toevoegen.";
        }
    } else {
        $errorMessage = "Ongeldige invoer, controleer alle velden.";
    }
}


try {
    $taken = $takenlijst->getAlleTaken($_GET['id']);
} catch (Exception $e) {
    $errorMessage = "Fout bij het ophalen van de gegevens: " . $e->getMessage();
    $taken = [];
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/taken.css">
    <title>Takenlijst</title>
</head>
<body>

<?php if ($success): ?>
    <div class="alert alert-success" role="alert">
        Taak succesvol toegevoegd!
    </div>
<?php elseif (!empty($errorMessage)): ?>
    <div class="alert alert-danger" role="alert">
        <?= htmlspecialchars($errorMessage); ?>
    </div>
<?php endif; ?>

<a href="../user/dashboard.php?ID">Terug</a>

<form method="post" class="mb-4">
    <div class="mb-3">
        <label for="taak_naam" class="form-label">Taak naam:</label>
        <input type="text" id="taak_naam" name="taaknaam" class="form-control" placeholder="Taak naam" required>
    </div>
    
    <div class="mb-3">
        <label for="benodigdheden" class="form-label">Benodigdheden:</label>
        <textarea id="benodigdheden" name="benodigdheden" class="form-control" placeholder="Benodigdheden" required></textarea>
    </div>
    
    <div class="mb-3">
        <label for="status" class="form-label">Status:</label>
        <select id="status" name="status" class="form-select" required>
            <option value="Niet gestart">Niet gestart</option>
            <option value="In uitvoering">In uitvoering</option>
            <option value="Voltooid">Voltooid</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Toevoegen</button>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Taak Naam</th>
            <th>Benodigdheden</th>
            <th>Status</th>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($taken as $taak): ?>
            <tr>
                <td><?= htmlspecialchars($taak['taaknaam']); ?></td>
                <td><?= htmlspecialchars($taak['benodigdheden']); ?></td>
                <td><?= htmlspecialchars($taak['status']); ?></td>
                <td>
                    <a href="updateTaken.php?taakID=<?= $taak['taakID']; ?>" class="btn btn-warning btn-sm">Bewerken</a>
                    <a href="delete.php?taakID=<?= $taak['taakID']; ?>" class="btn btn-danger btn-sm">Verwijderen</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
