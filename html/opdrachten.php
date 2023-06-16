<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/navbar.scss">
    <script src="../js/navbar.js" defer></script>
    <title>Intake Opdrachten</title>
</head>

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

