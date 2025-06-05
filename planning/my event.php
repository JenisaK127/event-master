<?php
require_once "../includes/evenement-class.php";

$evenement = new Evenement($db);

$evenement->selectEvenement();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    
<a href="../user/dashboard.php">Dashboard</a>
<table class="table table-bordered">
<thead>
                    <tr>
                        <th>Evenement</th>
                        <th>Projectnaam</th>
                        <th>Omschrijving</th>
                        <th>Foto</th>
                        <th>gasten</th>
                        <th>Locatie</th>
                        <th>Budget</th>
                        <th>Datum</th>
                        <th colspan="2">action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($evenement->selectEvenement() as $evenement): ?> 
                <tr> 
                <td><?php echo htmlspecialchars($evenement['ID']); ?></td> 
                <td><?php echo htmlspecialchars($evenement['projectnaam']); ?></td> 
                    <td><?php echo htmlspecialchars($evenement['omschrijving']); ?></td> 
                    <td><img src="<?php echo htmlspecialchars($evenement['foto']); ?>" alt="evenement afbeelding" width="200"></td>
                    <td><?php echo htmlspecialchars($evenement['gasten']); ?></td> 
                    <td><?php echo htmlspecialchars($evenement['locatie']); ?></td> 
                    <td><?php echo htmlspecialchars($evenement['budget']); ?></td> 
                    <td><?php echo htmlspecialchars($evenement['datum']); ?></td> 
                    
                    
                    <td><a href="update.php?ID=<?= htmlspecialchars($evenement['ID']); ?>">Bewerken</a>
                    <a href="delete.php?ID=<?= htmlspecialchars($evenement['ID']); ?>">Verwijder</a></td>            
            </tr> 
            <?php endforeach; ?>
            </tbody>
            </table>

</body>
</html>