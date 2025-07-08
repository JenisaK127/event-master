CREATE DATABASE planning;
USE planning;

CREATE TABLE gebruiker (
    gebruikerID INT AUTO_INCREMENT,
    voornaam VARCHAR(255),
    achternaam VARCHAR(255),
    email VARCHAR(255),
    wachtwoord VARCHAR(255),
    telefoonnummer INT,
    geboortedatum DATE,
    PRIMARY KEY (gebruikerID)
);

CREATE TABLE evenement(
    ID INT AUTO_INCREMENT,
    projectnaam VARCHAR(255),
    omschrijving TEXT,
    foto VARCHAR(255),
    gasten INT,
    locatie VARCHAR(255),
    budget DECIMAL(10,2),
    datum DATE,
    gebruikerID INT,
    PRIMARY KEY (ID),
    FOREIGN KEY (gebruikerID) REFERENCES gebruiker(gebruikerID)
);


CREATE TABLE takenlijst (
    taakID INT AUTO_INCREMENT,
    evenementID INT,
    taaknaam VARCHAR(255),
    benodigdheden TEXT,
    status ENUM('Niet gestart', 'In uitvoering', 'Afgerond') DEFAULT 'Niet gestart',
    PRIMARY KEY (taakID),
    FOREIGN KEY (evenementID) REFERENCES evenement(ID) 
);

CREATE TABLE gastenlijst (
    gastenID INT AUTO_INCREMENT,
    evenementID INT,
    voornaam VARCHAR(255),
    achternaam VARCHAR(255),
    leeftijd INT,
    email VARCHAR(255),
    telefoonnummer VARCHAR(20),
    PRIMARY KEY (gastenID),
    FOREIGN KEY (evenementID) REFERENCES evenement(ID)
);


SELECT * FROM gebruiker;

SELECT * FROM gastenlijst;

select * from takenlijst;

update gastenlijst set evenementID = 4 where gastenID = 13;