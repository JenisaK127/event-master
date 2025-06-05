<!-- page 1/ dashboard-->
<?php
require "db.php"; 

class Evenement {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function insertEvenement($projectnaam, $omschrijving, $foto, $gasten, $locatie, $budget, $datum, $gebruikerID) {
        $this->pdo->run("INSERT INTO evenement (projectnaam, omschrijving, foto, gasten, locatie, budget, datum, gebruikerID) 
        VALUES (:projectnaam, :omschrijving, :foto, :gasten, :locatie, :budget, :datum, :gebruikerID)", [
            ':projectnaam' => $projectnaam,
            ':omschrijving' => $omschrijving,
            ':foto' => $foto,
            ':gasten' => $gasten,
            ':locatie' => $locatie,
            ':budget' => $budget,
            ':datum' => $datum,
            ':gebruikerID' => $gebruikerID
        ]);
    }

    public function selectEvenement() {
        return $this->pdo->run("SELECT * FROM evenement")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEvenementById($id) {
        return $this->pdo->run("SELECT * FROM evenement WHERE ID = :id", [':id' => $id])->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEvenement($id, $projectnaam, $omschrijving, $foto, $gasten, $locatie, $budget, $datum) {
        return $this->pdo->run("UPDATE evenement SET projectnaam = :projectnaam, omschrijving = :omschrijving, foto = :foto, gasten = :gasten, locatie = :locatie, budget = :budget, datum = :datum WHERE ID = :id", [
            ':id' => $id,
            ':projectnaam' => $projectnaam,
            ':omschrijving' => $omschrijving,
            ':foto' => $foto,
            ':gasten'=> $gasten,
            ':locatie'=> $locatie,
            ':budget' => $budget,
            ':datum' => $datum
        ]);
    }

    public function deleteEvenement($id) {
        return $this->pdo->run("DELETE FROM evenement WHERE ID = :id", [':id' => $id]);
    }

    public function selectEvenementByGebruikerID($gebruikerID) {
        return $this->pdo->run("SELECT * FROM evenement WHERE gebruikerID = :gebruikerID", [':gebruikerID' => $gebruikerID])->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
