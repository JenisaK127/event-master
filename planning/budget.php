<?php
session_start();
require_once "../includes/evenement-class.php";

if (!isset($_SESSION["gebruikerID"])) {
    die("Error: gebruikerID is niet ingesteld in de sessie.");
}

$gebruikerID = $_SESSION["gebruikerID"]; 
$evenement = new Evenement($db);
$evenementen = $evenement->selectEvenementByGebruikerID($gebruikerID); 
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/table.css">
    <title>Mijn Evenementen</title>
</head>
<body>
<a href="../user/dashboard.php?ID">Terug</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Projectnaam</th>
            <th>Budget</th>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($evenementen as $evenement): ?> 
            <tr> 
                <td><?php echo htmlspecialchars($evenement['projectnaam']); ?></td> 
                <td><?php echo htmlspecialchars($evenement['budget']); ?></td> 
                <td>
                    <a href="../user/page 1.php?ID=<?php echo urlencode($evenement['ID']); ?>">Beheer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
