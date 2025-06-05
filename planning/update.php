<?php
require_once "../includes/db.php";
require_once "../includes/evenement-class.php";

$id = isset($_GET['ID']) ? $_GET['ID'] : null;

if (!$id) {
    die("Geen geldig evenement-ID opgegeven.");
}

$evenement = new Evenement($db);

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
                $fotoPath = ""; 
            }
        } else {
            $evenementData = $evenement->getEvenementById($id);
            $fotoPath = $evenementData['foto'];
        }

        if ($evenement->updateEvenement($id, $projectnaam, $omschrijving, $fotoPath, $gasten, $locatie, $budget, $datum)) {
            echo "Evenement succesvol bijgewerkt!";
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/bewerk.css">
    <title>Plan je event</title>
</head>
<body>
    
    <main>
        <h2>Plan je event</h2>

        <form method="post" enctype="multipart/form-data">
            <label for="event_naam">Event naam:</label>
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
