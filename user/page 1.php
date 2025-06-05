<?php
session_start();
require_once "../includes/evenement-class.php";
require_once "../includes/gebruiker-class.php";

$evenement = new Evenement($db);
$gebruiker = new Gebruiker($db);

if (!isset($_SESSION["login_status"]) || $_SESSION["login_status"] !== true) {
    header("location: login-user.php");
    exit();
}

if (!isset($_SESSION["gebruikerID"])) {

    die("Error: gebruikerID is niet ingesteld in de sessie.");
}

$gebruikerID = $_SESSION["gebruikerID"];

$gebruikerData = $gebruiker->getGebruikerById($gebruikerID);


$evenementen = $evenement->selectEvenementByGebruikerID($gebruikerID);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/page1.css">
<title></title>
    <header>
<nav>
    <a href="Event managment.html">Home</a>
    <a href="uitloggen.php">Uitloggen</a>
</nav>
</header>

<main>
<h1>Welkom, <?= htmlspecialchars($gebruikerData["voornaam"]) ?? "Gebruiker"; ?></h1>
<h2>Overzicht Dashboard Gegevens</h2>

<a href="page 1add.php">Voeg een nieuw item toe</a> 

<div class="dashboard">
<table class="table table-bordered">
<thead>
    <tr>
        <!-- <th>Evenement</th> -->
        <th>Projectnaam</th>
        <th>Omschrijving</th>
        <th>Foto</th>
        <th>Gasten</th>
        <th>Locatie</th>
        <th>Budget</th>
        <th>Datum</th>
        <th colspan="3">Actie</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($evenementen as $evenement): ?> 
    <tr> 
        <!-- <td><?php echo htmlspecialchars($evenement['ID']); ?></td>  -->
        <td><?php echo htmlspecialchars($evenement['projectnaam']); ?></td> 
        <td><?php echo htmlspecialchars($evenement['omschrijving']); ?></td> 
        <td><img src="<?php echo htmlspecialchars($evenement['foto']); ?>" alt="evenement afbeelding" width="200"></td>
        <td><?php echo htmlspecialchars($evenement['gasten']); ?></td> 
        <td><?php echo htmlspecialchars($evenement['locatie']); ?></td> 
        <td><?php echo htmlspecialchars($evenement['budget']); ?></td> 
        <td><?php echo htmlspecialchars($evenement['datum']); ?></td> 
        <td>
            <a href="../planning/update.php?ID=<?= htmlspecialchars($evenement['ID']); ?>">Bewerken</a>  
            <a href="../planning/delete.php?ID=<?= htmlspecialchars($evenement['ID']); ?>">Verwijder</a>
            <a href="dashboard.php?ID=<?= htmlspecialchars($evenement['ID']); ?>">Evenement</a></td>   
          
    </tr> 
    <?php endforeach; ?>
</tbody>
</table>
</div>
</main>

</body>
</html>

