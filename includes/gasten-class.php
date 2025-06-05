<?php

class Gastenlijst {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    //Gast toevoegen met juiste typevalidatie
    public function insertGasten(string $voornaam, int $evenementID, string $achternaam, int $leeftijd, string $email, string $telefoonnummer) {
        if ($evenementID <= 0) {
            throw new Exception("Ongeldig evenement ID");
        }

        return $this->pdo->run(
            "INSERT INTO gastenlijst (voornaam, evenementID, achternaam, leeftijd, email, telefoonnummer) 
            VALUES (:voornaam, :evenementID, :achternaam, :leeftijd, :email, :telefoonnummer)",
            [
                ':voornaam' => $voornaam,
                ':evenementID' => $evenementID,
                ':achternaam' => $achternaam,
                ':leeftijd' => $leeftijd,
                ':email' => $email,
                ':telefoonnummer' => $telefoonnummer
            ]
        );
    }

    //Gasten ophalen voor een specifiek evenement
    public function getAlleGasten(int $evenementID) {
        if ($evenementID <= 0) {
            return []; 
        }
        return $this->pdo->run("SELECT * FROM gastenlijst WHERE evenementID = :evenementID", [':evenementID' => $evenementID])->fetchAll(PDO::FETCH_ASSOC);
    }

    //Gast verwijderen
    public function verwijderGast(int $gastenID) {
        $this->pdo->run("DELETE FROM gastenlijst WHERE gastenID = :gastenID", [':gastenID' => $gastenID]);
    }
}
?>
