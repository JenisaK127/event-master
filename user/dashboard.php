<?php
session_start();
require_once "../includes/evenement-class.php";

$evenement = new Evenement($db);
$success = false;

if (isset($_GET['ID'])) {
    $gebruikerID = $_GET['ID'];

    $selectevenement = $evenement->getEvenementById($gebruikerID);

} else {
    echo "Geen geldig id opgegeven.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/dashboard.css">
    <title>Dashboard</title>
</head>
<body>

<header>
<h1>EventMaster</h1>
    <nav>
    <a href="Event Managment.html">Home</a>
    <a href="Page 1.php">Terug</a>
    <a href="uitloggen.php">Uitloggen</a>
    
</nav>
</header>


<main>
    <section class="left">

        <div class="sections-toeslag" onclick="window.location.href='../planning/gasten.php?id=<?php echo urlencode($gebruikerID); ?>'"><h2>Gastenlijst</h2></div>
        <div class="sections-toeslag" onclick="window.location.href='../planning/budget.php?id=<?php echo urlencode($gebruikerID); ?>'"><h2>Budget</h2></div>
    </section>
    <aside class="right">
        <div class="gebruiker-gegevens" onclick="window.location.href='../planning/taken.php?id=<?php echo urlencode($gebruikerID); ?>'"><h2>Takenlijst</h2></div>
        <div class="gebruiker-gegevens" onclick="window.location.href='../planning/afbeeldingen.php?id=<?php echo urlencode($gebruikerID); ?>'"><h2>Afbeeldingen</h2></div>
        <div class="gebruiker-gegevens" onclick="window.location.href='../planning/uitnodiging.html?id=<?php echo urlencode($gebruikerID); ?>'"><h2>Stuur uitnodiging</h2></div>
    </aside>
</main>

</body>
</html>
