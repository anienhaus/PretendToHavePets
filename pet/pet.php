<?php
    $basedir = "../";
    $current = "pet";
    include "../check_session.php";
    include "../database_signin.php";
?>

<!doctype html>

<html lang="en">

<head>
    <title>Pretend to Have Pets</title>
    <link rel="stylesheet" href="../pretendtohavepets.css">
    <link rel="stylesheet" href="pet.css">
    <meta charset="UTF-8">
    <meta name="assignment" content="CSCI 445: Final Project">
    <meta name="viewport" content="width=device-width">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <!--Include the navigation bar-->
    <section>
        <?php 
            include '../navbar.php';
            $petID = $_GET['id'];
            $sql = "SELECT * FROM Pets WHERE PetID='$petID'";
            $pet = $conn->query($sql);
            $petInfo = mysqli_fetch_assoc($pet);
            echo "<h2>" . $petInfo['Name'] . "</h2>";

            date("m/d/Y h:i");

            $species = $petInfo['Species'];
            $sql = "SELECT ImagePath FROM Species WHERE SpeciesID='$species'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $imagePath = $row['ImagePath'];
        ?>
        <span>
            <?php
                if($petInfo['EnergyLevel'] < 10) {
                    echo "I need a nap!";
                }
                else if($petInfo['HungerLevel'] < 10) {
                    echo "Feed me!";
                }
                else if($petInfo['HealthLevel'] < 10) {
                    echo "Can we go for a walk?";
                }
            ?>    
        </span>
        <img src=<?php echo "../" . $imagePath;?>>
        <script>
            function action(event){
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            console.log(this.responseText);
                        }
                    }
                var petId = <?php echo json_encode($petInfo["PetID"]);?>;
                xhttp.open("GET", "petAction.php?action=" + event + "&petID=" + petId, true);
                xhttp.send();
            }
        </script>
        <fieldset>
            <legend>Pet Stats</legend>
            <p id="energy">Energy: <?php echo $petInfo['EnergyLevel'];?></p> 
            <button onclick="action('nap');"">Take a nap</button>
            <p id="hunger">Hunger: <?php echo $petInfo['HungerLevel'];?></p>
            <button onclick='action("feed");'>Feed me</button>
            <p id="health">Health: <?php echo $petInfo['HealthLevel'];?></p>
            <button onclick='action("walk");'>Take me for a walk</button>
        </fieldset>
    <section>
</body>