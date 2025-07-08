<?php
require_once "../includes/evenement-class.php";  
require_once "../includes/gasten-class.php"; 
require_once "../includes/taken-class.php"; 

$evenement = new Evenement($db);  
$gastenlijst = new Gastenlijst($db);  
$takenlijst = new Takenlijst($db);  
      
//my event
try {
    if (isset($_GET['ID'])) {
        $id = $_GET['ID'];
        $evenement->deleteEvenement($id); 
        header("Location:../user/page 1.php");  
        exit();
    }

//gasten
    if (isset($_GET["gastenID"])) {
        $gastenID = intval($_GET['gastenID']);  
        $gastenlijst->verwijderGast($gastenID);  
        $evenementID = isset($_GET['evenementID']) ? intval($_GET['evenementID']) : 0;
        if ($evenementID > 0) {
            header("Location: gasten.php?id=$evenementID");
        } else {
            header("Location: gasten.php");
        }
        exit();
    }
    
//taken
    if (isset($_GET["taakID"]) && is_numeric($_GET["taakID"])) {
        $taakID = intval($_GET["taakID"]);  
        $takenlijst->verwijderTaak($taakID);  
        header("Location: taken.php?id=$taakID");  
        exit();
    } else {
        echo "Ongeldige ID opgegeven.";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
