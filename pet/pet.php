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
        <fieldset>
            <legend>Pet Stats</legend>
            <p>Energy: <?php echo $petInfo['EnergyLevel'];?></p> 
            <button>Take a nap</button>
            <p>Hunger: <?php echo $petInfo['HungerLevel'];?></p>
            <button>Feed me</button>
            <p>Health: <?php echo $petInfo['HealthLevel'];?></p>
            <button>Take me for a walk</button>
        </fieldset>
    <section>
</body>