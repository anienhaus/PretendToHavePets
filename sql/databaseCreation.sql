-- Drop table, if it already exists --
DROP TABLE IF EXISTS Pets;
DROP TABLE IF EXISTS ResetCodes;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Species;
DROP TABLE IF EXISTS Activations;

-- Create tables --
CREATE TABLE Users (
    UserID int AUTO_INCREMENT,
    Username varchar(255),
    Password varchar(255),
    Name varchar(255),
    Email varchar(255),
    UNIQUE (Username),
    PRIMARY KEY (UserID)
);

CREATE TABLE Species (
    SpeciesID int AUTO_INCREMENT,
    Name varchar(255),
    ImagePath varchar(255),
    PRIMARY KEY (SpeciesID)
);

CREATE TABLE Pets (
    PetID int AUTO_INCREMENT,
    Owner int,
    Name varchar(255),
    Species int,
    HealthLevel int,
	LastWalked text, -- A time
	HungerLevel int,
	LastFed text, -- A time
	EnergyLevel int,
	LastNap text, -- A time
    PRIMARY KEY (PetID),
    FOREIGN KEY (Owner) REFERENCES Users(UserID) ON DELETE CASCADE,
    FOREIGN KEY (Species) REFERENCES Species(SpeciesID) ON DELETE CASCADE
);

CREATE TABLE ResetCodes (
    UserID int,
    Code varchar(255),
    PRIMARY KEY (UserID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID) ON DELETE CASCADE
);

CREATE TABLE Activations (
    Code varchar(255),
    Username varchar(255),
    Password varchar(255),
    Name varchar(255),
    Email varchar(255),
    PRIMARY KEY (CODE)
);

-- Populate species table --
INSERT INTO Species (Name, ImagePath) VALUES ("Cat", "images/cat.png"), ("Dog", "images/dog.jpg"), ("Hamster", "images/hamster.jpg"), ("Ferret", "images/ferret.png"),
    ("Bird", "images/bird.jpg"), ("Fish", "images/fish.png"), ("Chinchilla", "images/chinchilla.png"), ("Dragon", "images/dragon.png"), ("Wolf", "images/wolf.png"), 
    ("Flying Squirrel", "images/flyingsquirrel.png");
