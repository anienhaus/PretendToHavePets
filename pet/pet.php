<!doctype html>
<html lang="en">

<head>

<?php
    $basedir = "../";
    $current = "pet";
    include "../check_session.php";
    include "../database_signin.php";
?>
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
            //This function will update the pet stats new new values
            function updateLevel($type, $amount, $id, $conn){
                if($type == 'energy'){
                    $sql = "UPDATE Pets SET EnergyLevel='$amount' WHERE PetID='$id'";
                }
                else if($type == 'health'){
                    $sql = "UPDATE Pets SET HealthLevel='$amount' WHERE PetID='$id'";
                }
                else if($type == 'hunger'){
                    $sql = "UPDATE Pets SET HungerLevel='$amount' WHERE PetID='$id'";                   
                }
                $conn->query($sql);
            }

            include '../navbar.php';

            $petID = $_GET['id'];
            $sql = "SELECT * FROM Pets WHERE PetID='$petID'";
            $pet = $conn->query($sql);
            $petInfo = mysqli_fetch_assoc($pet);
            if($pet->num_rows == 0){
                header("Location: /PretendToHavePets");
            }
            echo "<h2 class='page_title'>" . $petInfo['Name'] . "</h2>";

            //Calculate time since stats were increased by walking, feeding, or napping
            date_default_timezone_set("America/Denver");
            $current_time = new DateTime('now');
            $last_walked = new DateTime($petInfo['LastWalked']);
            $last_fed = new DateTime($petInfo['LastFed']);
            $last_nap = new DateTime($petInfo['LastNap']);

            $last_walked_diff = date_diff($current_time, $last_walked);
            $last_walked_mins = $last_walked_diff->format("%i");

            $last_fed_diff = date_diff($current_time, $last_fed);
            $last_fed_mins = $last_fed_diff->format("%i");

            $last_nap_diff = date_diff($current_time, $last_nap);
            $last_nap_mins = $last_nap_diff->format("%i");

            //Determine what decrement in stats should be based on time passed
            if($last_walked_mins >= 1){
                $new_health = $petInfo['HealthLevel'] - 5;

                if($last_walked_mins > 10 && $petInfo['HealthLevel'] > 10){
                    $new_health = $petInfo['HealthLevel'] - 10;
                }

                if($last_walked_mins > 60 && $petInfo['HealthLevel'] > 30){
                    $new_health = $petInfo['HealthLevel'] - 30;
                }

                if($last_walked_mins > 120 && $petInfo['HealthLevel'] > 60){
                    $new_health = $petInfo['HealthLevel'] - 60;
                }

                if($last_walked_mins > 300){
                    $new_health = $petInfo['HealthLevel'] - $petInfo['HealthLevel'];
                }

                updateLevel('health', $new_health, $petID, $conn);
            }

            if($last_fed_mins > 1 && $petInfo['HungerLevel'] > 4){
                $new_hunger = $petInfo['HungerLevel'] - 5;

                if($last_fed_mins > 10 && $petInfo['HungerLevel'] > 10){
                    $new_hunger = $petInfo['HungerLevel'] - 10;
                }

                if($last_fed_mins > 60 && $petInfo['HungerLevel'] > 30){
                    $new_hunger = $petInfo['HungerLevel'] - 30;
                }

                if($last_fed_mins > 120 && $petInfo['HungerLevel'] > 60){
                    $new_hunger = $petInfo['HungerLevel'] - 60;
                }

                if($last_fed_mins > 300) {
                    $new_hunger = $petInfo['HungerLevel'] - $petInfo['HungerLevel'];
                }

                updateLevel('hunger', $new_hunger, $petID, $conn);
            }

            if($last_nap_mins > 1 && $petInfo['EnergyLevel'] > 4){
                $new_energy = $petInfo['EnergyLevel'] - 5;

                if($last_nap_mins > 10 && $petInfo['EnergyLevel'] > 10){
                    $new_health = $petInfo['EnergyLevel'] - 10;
                }

                if($last_nap_mins > 60 && $petInfo['EnergyLevel'] > 30){
                    $new_health = $petInfo['EnergyLevel'] - 30;
                }

                if($last_nap_mins > 120 && $petInfo['EnergyLevel'] > 60){
                    $new_health = $petInfo['EnergyLevel'] - 60;
                }

                if($last_nap_mins > 300) {
                    $new_health = $petInfo['EnergyLevel'] - $petInfo['EnergyLevel'];                    
                }

                updateLevel('energy', $new_energy, $petID, $conn);
            }

            //Get new pet info since stats may have been decremented
            $sql = "SELECT * FROM Pets WHERE PetID='$petID'";
            $pet = $conn->query($sql);
            $petInfo = mysqli_fetch_assoc($pet);

            $species = $petInfo['Species'];
            $sql = "SELECT ImagePath FROM Species WHERE SpeciesID='$species'";
            $result = $conn->query($sql);
            $row = mysqli_fetch_assoc($result);
            $imagePath = $row['ImagePath'];
        ?>

        <span>
            <?php 
                //Show an urgent message if pet is in need
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
        <img alt="An image of the selected pet" src=<?php echo "../" . $imagePath;?>>
        <script>
            //Handles pet interaction clicks with an AJAX call to update the database
            function action(event){
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            //Update the info shown in pet stats or redirect if pet is set free
                            if(event == 'free'){
                                window.location.href = '/PretendToHavePets';
                            }
                            if(event == 'nap'){
                                $('#energy').html("Energy: 100");
                                $('span').html("");
                            }
                            if(event == 'feed'){
                                $('#hunger').html("Hunger: 100");
                                $('span').html("");
                            }
                            if(event == 'walk'){
                                $('#health').html("Health: 100");
                                $('span').html("");
                            }
                        }
                    }
                var petId = <?php echo json_encode($petInfo["PetID"]);?>;
                xhttp.open("GET", "petAction.php?action=" + event + "&petID=" + petId, true);
                xhttp.send();
            }
        </script>
        <div class="stats">
            <fieldset>
                <legend>Pet Stats</legend>
                <p id="energy">Energy: <?php echo $petInfo['EnergyLevel'];?></p> 
                <button onclick="action('nap');">Take a nap</button>
                <p id="hunger">Hunger: <?php echo $petInfo['HungerLevel'];?></p>
                <button onclick='action("feed");'>Feed me</button>
                <p id="health">Health: <?php echo $petInfo['HealthLevel'];?></p>
                <button onclick='action("walk");'>Take me for a walk</button>
            </fieldset>
            <button id="free" onclick='action("free");'>Release to wild</button>
        </div>
    </section>
</body>