<?php

class Takenlijst {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    // Taak toevoegenz
    public function insertTaak(string $taaknaam, int $evenementID, string $benodigdheden, string $status = "Niet gestart") {
        return $this->pdo->run(
            "INSERT INTO takenlijst (taaknaam, evenementID, benodigdheden, status) 
            VALUES (:taaknaam, :evenementID, :benodigdheden, :status)",
            [
                ':taaknaam' => $taaknaam,
                ':evenementID' => $evenementID,
                ':benodigdheden' => $benodigdheden,
                ':status' => $status
            ]
        );
    }

    // Alle taken ophalen
    public function getAlleTaken($evenementID) {
        return $this->pdo->run("SELECT * FROM takenlijst WHERE evenementID = :evenementID", ["evenementID" => $evenementID])->fetchAll(PDO::FETCH_ASSOC);
    }

    // Taak verwijderen
    public function verwijderTaak(int $taakID) {
        $this->pdo->run("DELETE FROM takenlijst WHERE taakID = :taakID", [':taakID' => $taakID]);
    }

    // Taakstatus updaten
    public function updateStatus(int $taakID, string $nieuweStatus) {
        $this->pdo->run("UPDATE takenlijst SET status = :status WHERE taakID = :taakID", 
            [':status' => $nieuweStatus, ':taakID' => $taakID]);
    }
}
?>
