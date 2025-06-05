<!-- registreer/login -->
<?php
require "db.php";

class Gebruiker {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function registerGebruiker(string $voornaam, string $achternaam, string $email, string $wachtwoord, string $telefoonnummer, string $geboortedatum) {
        $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $stmt = $this->pdo->run("INSERT INTO gebruiker (voornaam, achternaam, email, wachtwoord, telefoonnummer, geboortedatum) VALUES (:voornaam, :achternaam, :email, :wachtwoord, :telefoonnummer, :geboortedatum)",
        [
            ':voornaam' => $voornaam,
            ':achternaam' => $achternaam,
            ':email' => $email,
            ':wachtwoord' => $hash,
            ':telefoonnummer' => $telefoonnummer,
            ':geboortedatum' => $geboortedatum
        ]);
    }

    public function loginGebruiker($email) {
        return $this->pdo->run("SELECT * FROM gebruiker WHERE email = :email",
        [':email' => $email])->fetch(PDO::FETCH_ASSOC);
    }

    public function getGebruikerById($gebruikerID) {
        return $this->pdo->run("SELECT * FROM gebruiker WHERE gebruikerID = :id", 
        [':id' => $gebruikerID])->fetch(PDO::FETCH_ASSOC);
    }

    public function getEvenementenByGebruiker($gebruikerID) {
        return $this->pdo->run("SELECT * FROM evenement WHERE gebruikerID = :id", 
        [':id' => $gebruikerID])->fetchAll(PDO::FETCH_ASSOC);
    }


}

?>