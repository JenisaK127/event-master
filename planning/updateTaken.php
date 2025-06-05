<?php
require_once "../includes/db.php";
require_once "../includes/taken-class.php";

$takenlijst = new Takenlijst($db);
$errorMessage = "";
$success = false;

$taakID = isset($_GET['taakID']) ? intval($_GET['taakID']) : null;
if (!$taakID) {
    die("Geen geldig taakID opgegeven.");
}


$taak = $takenlijst->getTaakById($taakID);
if (!$taak) {
    die("Taak niet gevonden.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taaknaam = trim($_POST["taaknaam"]);
    $benodigdheden = trim($_POST["benodigdheden"]);
    $status = htmlspecialchars($_POST["status"]);

    if ($taaknaam && $benodigdheden) {
        $success = $takenlijst->updateTaak($taakID, $taaknaam, $benodigdheden, $status);
        if ($success) {
            header("Location: taken.php?id=" . $taak['evenementID']);
            exit();
        } else {
            $errorMessage = "Er is iets misgegaan bij het bijwerken van de taak.";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Taak bijwerken</title>
</head>
<body>

<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger"> <?= htmlspecialchars($errorMessage); ?> </div>
<?php endif; ?>

<a href="taken.php?id=<?= $taak['evenementID'] ?>">Terug</a>

<form method="post" class="mb-4">
    <div class="mb-3">
        <label for="taaknaam" class="form-label">Taak naam:</label>
        <input type="text" id="taaknaam" name="taaknaam" class="form-control" value="<?= htmlspecialchars($taak['taaknaam']); ?>" required>
    </div>
    
    <div class="mb-3">
        <label for="benodigdheden" class="form-label">Benodigdheden:</label>
        <textarea id="benodigdheden" name="benodigdheden" class="form-control" required><?= htmlspecialchars($taak['benodigdheden']); ?></textarea>
    </div>
    
    <div class="mb-3">
        <label for="status" class="form-label">Status:</label>
        <select id="status" name="status" class="form-select" required>
            <option value="Niet gestart" <?= $taak['status'] === "Niet gestart" ? 'selected' : ''; ?>>Niet gestart</option>
            <option value="In uitvoering" <?= $taak['status'] === "In uitvoering" ? 'selected' : ''; ?>>In uitvoering</option>
            <option value="Voltooid" <?= $taak['status'] === "Voltooid" ? 'selected' : ''; ?>>Voltooid</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Bijwerken</button>
</form>

</body>
</html>
