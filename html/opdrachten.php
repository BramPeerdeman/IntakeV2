<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/navbar.scss">
    <script src="../js/navbar.js" defer></script>
    <title>Intake Opdrachten</title>
</head>

<div class="navbar">
        <div class="items itemsLogo">
            <div class="logo"><img src="../assets/icons/glrLogoTrans.png" alt="GLR logo" width="100%" height="100%">
            </div>
        </div>
        <div class="items itemsStudent">
            <div class="studenten"><img src="../assets/icons/studentenIcon.png" alt="student Icon" width="100%"
                    height="100%">
                <a href="../html/studentenLijst.php">
                    <p>studenten</p>
                </a>
            </div>
        </div>
        <div class="items itemsOpdracht">
            <div class="opdrachten"><img src="../assets/icons/opdrachtIcon.png" alt="opdrachten Icon" width="100%"
                    height="100%">
                <a href="#">
                    <p>opdrachten</p>
                </a>
            </div>
        </div>
        <div class="items itemsIntake">
            <div class="intake"><img src="../assets/icons/intakeIcon.png" alt="intake Icon" width="100%" height="100%">
                <a href="../php/logout.php">
                    <p>intake</p>
                </a>
            </div>
        </div>
        <hr class="navbarLine">
        <div class="items itemsLogout">
            <div class="logout"><a href="../php/logout.php"><img class="logoutImage"
                        src="../assets/icons/logoutIcon.png" alt="logout Icon" width="100%" height="100%"></a>
                <a href="../php/logout.php">
                    <p>log uit</p>
                </a>
            </div>
        </div>
    </div>


<?php
    session_start();

    include 'config.php';

    $query = "SELECT * FROM Opdracht";
    // $query = mysqli_query($connessione, $query_string);

    //Get results
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0)
    {
        // maak een tabel aan
        echo "<table border='1px' class='table table-striped custom-table'>";
    
        while ($item = mysqli_fetch_assoc($result))
    
        {
          ?>
          <tbody id="myTable">
            <?php
            // toon de gegevens van het item in een tabelrij
            echo "<tr>";
                 echo "<td>" . $item['Naam'] . "</td>";
            echo "</tr>";
            ?>
            </tbody>
            <?php
        }
    
        // sluit de tabel af
        echo "</table>";
    }
    
    $result = mysqli_query($mysqli, $query);
    
    if (!$result)
    // laat de records zien
    {
        echo "<p>FOUT!</p>";
        echo "<p>" . $query ."</p>";
        echo "<p>" . mysqli_error($mysqli) . "</p>";
        exit;
    }

?>

