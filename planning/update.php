<?php
require_once "../includes/db.php";
require_once "../includes/evenement-class.php";

$id = isset($_GET['ID']) ? $_GET['ID'] : null;

if (!$id) {
    die("Geen geldig evenement-ID opgegeven.");
}

$evenement = new Evenement($db);

// Haalt altijd de huidige gegevens op, ook na POST voor tonen
$evenementData = $evenement->getEvenementById($id);

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $projectnaam = htmlspecialchars($_POST["event_naam"]);
        $omschrijving = htmlspecialchars($_POST["omschrijving"]);
        $gasten = htmlspecialchars($_POST["aantal_gasten"]);
        $locatie = htmlspecialchars($_POST["locatie"]);
        $budget = htmlspecialchars($_POST["budget"]);
        $datum = htmlspecialchars($_POST["datum"]);

        if (!empty($_FILES['foto']['name'])) {
            $foto = $_FILES['foto']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($foto);

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                $fotoPath = $target_file;
            } else {
                echo "Fout bij uploaden van bestand.";
                $fotoPath = $evenementData['foto'];
            }
        } else {
            $fotoPath = $evenementData['foto'];
        }

        if ($evenement->updateEvenement($id, $projectnaam, $omschrijving, $fotoPath, $gasten, $locatie, $budget, $datum)) {
            echo "Evenement succesvol bijgewerkt!";
            // Haalt opnieuw de gegevens op na update
            $evenementData = $evenement->getEvenementById($id);
            header("refresh:1; url=../user/page 1.php");
            exit();
        } else {
            echo "Fout bij het bijwerken van het evenement.";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/bewerk.css">
    <title>Plan je event</title>
</head>
<body>
    <main>
        <h2>Plan je event</h2>

        <!-- Huidige gegevens tonen -->
        <div class="mb-4">
            <h4>Huidige gegevens</h4>
            <table class="table table-bordered">
                <tr><th>Projectnaam</th><td><?= htmlspecialchars($evenementData['projectnaam']) ?></td></tr>
                <tr><th>Omschrijving</th><td><?= htmlspecialchars($evenementData['omschrijving']) ?></td></tr>
                <tr><th>Afbeelding</th><td><?php if (!empty($evenementData['foto'])): ?><img src="<?= htmlspecialchars($evenementData['foto']) ?>" alt="evenement afbeelding" width="150"><?php else: ?>Geen afbeelding<?php endif; ?></td></tr>
                <tr><th>Gasten</th><td><?= htmlspecialchars($evenementData['gasten']) ?></td></tr>
                <tr><th>Locatie</th><td><?= htmlspecialchars($evenementData['locatie']) ?></td></tr>
                <tr><th>Budget</th><td><?= htmlspecialchars($evenementData['budget']) ?></td></tr>
                <tr><th>Datum</th><td><?= htmlspecialchars($evenementData['datum']) ?></td></tr>
            </table>
        </div>

        <form method="post" enctype="multipart/form-data">
            <label for="event_naam">Event naam:</label>
            <input type="text" id="event_naam" name="event_naam" placeholder="Event naam" required value="<?= htmlspecialchars($evenementData['projectnaam']) ?>"><br>
            
            <label for="omschrijving">Omschrijving:</label>
            <textarea id="omschrijving" name="omschrijving" placeholder="Omschrijving" required><?= htmlspecialchars($evenementData['omschrijving']) ?></textarea><br>
            
            <label for="foto">Afbeelding uploaden:</label>
            <input type="file" id="foto" name="foto" accept="image/*"><br>
            <?php if (!empty($evenementData['foto'])): ?>
                <small>Huidige afbeelding: <img src="<?= htmlspecialchars($evenementData['foto']) ?>" alt="evenement afbeelding" width="100"></small><br>
            <?php endif; ?>

            <label for="aantal_gasten">Aantal gasten:</label>
            <input type="number" id="aantal_gasten" name="aantal_gasten" placeholder="Aantal gasten" required value="<?= htmlspecialchars($evenementData['gasten']) ?>"><br>

            <label for="locatie">Locatie:</label>
            <input type="text" id="locatie" name="locatie" placeholder="locatie" required value="<?= htmlspecialchars($evenementData['locatie']) ?>"><br>
            
            <label for="budget">Budget (€):</label>
            <input type="number" id="budget" name="budget" placeholder="Budget" required value="<?= htmlspecialchars($evenementData['budget']) ?>"><br>
            
            <label for="datum">Datum:</label>
            <input type="date" id="datum" name="datum" required value="<?= htmlspecialchars($evenementData['datum']) ?>"><br>

            <button type="submit">Opslaan</button>
        </form>
    </main>
</body>
</html>
