<?php
require_once "../includes/evenement-class.php";

$evenement = new Evenement($db);

$success = false;

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $projectnaam = htmlspecialchars($_POST["event_naam"]);
        $omschrijving = htmlspecialchars($_POST["omschrijving"]);
        $gasten = htmlspecialchars($_POST["aantal_gasten"]);
        $locatie = htmlspecialchars($_POST["locatie"]);
        $budget = htmlspecialchars($_POST["budget"]);
        $datum = htmlspecialchars($_POST["datum"]);
        

        $foto = $_FILES['foto']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($foto);

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            if ($evenement->insertEvenement($projectnaam, $omschrijving, $target_file, $gasten, $locatie, $budget, $datum, $_SESSION['gebruikerID'])) {
                $success = true;
                
            } else {
                echo "Evenement toegevoegd!";
                header("refresh:1; url=my event.php");
            }

        } else {
            echo "Sorry, er was een fout bij het uploaden van uw bestand.";
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Plan je 'feestdag'</title>
</head>
<body>
    <header>
    <a href="../user/dashboard.php">Dashboard</a>
    </header>
    
    <main>
        <h2>Plan je event</h2>
        <?php if ($success): ?>
            <div class="alert-success">Event succesvol toegevoegd!</div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <label for="event_naam">Evenement naam:</label>
            <input type="text" id="event_naam" name="event_naam" placeholder="Event naam" required><br>
            
            <label for="omschrijving">Omschrijving:</label>
            <textarea id="omschrijving" name="omschrijving" placeholder="Omschrijving" required></textarea><br>
            
            <label for="foto">Afbeelding uploaden:</label>
            <input type="file" id="foto" name="foto" accept="image/*"><br>

            <label for="aantal_gasten">Aantal gasten:</label>
            <input type="number" id="aantal_gasten" name="aantal_gasten" placeholder="Aantal gasten" required><br>

            <label for="locatie">Locatie:</label>
            <input type="text" id="locatie" name="locatie" placeholder="locatie" required><br>

            <label for="budget">Budget (€):</label>
            <input type="number" id="budget" name="budget" placeholder="Budget" required><br>
            
            <label for="datum">Datum:</label>
            <input type="date" id="datum" name="datum" required><br>
            
            <button type="submit">Toevoegen</button>
        </form>
    </main>

</body>
</html>
