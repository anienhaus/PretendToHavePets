<?php 
    //Updates the database based on the interaction with the pet
    include "../database_signin.php";
    date_default_timezone_set("America/Denver");
    $current_date = new DateTime('now');
    $current_time = date_format($current_date, "m-d-Y H:i:s");
    $basedir = "../";

    $newLevel = 100;
    $id = $_GET['petID'];

    //If pet is being set free, delete from database
    if($_GET['action'] == 'free'){
        $sqlDelete = "DELETE FROM Pets WHERE PetID='$id'";
        $conn->query($sqlDelete);
        return;
    }

    //Update other stats according to which interaction was chosen
    if($_GET['action'] == 'nap'){
        $sqlUpdate = $conn->prepare("UPDATE Pets SET EnergyLevel=?, LastNap=? WHERE PetID='$id'");
    }

    else if($_GET['action'] == 'feed'){
        $sqlUpdate = $conn->prepare("UPDATE Pets SET HungerLevel=?, LastFed=? WHERE PetID='$id'");
    }

    else if($_GET['action'] == 'walk') {
        $sqlUpdate = $conn->prepare("UPDATE Pets SET HealthLevel=?, LastWalked=? WHERE PetID='$id'");        
    }

    $sqlUpdate->bind_param("is", $newLevel, $current_time);
    $sqlUpdate->execute();
?>