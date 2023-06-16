<?php
    session_start();

    include 'config.php';

    $id = $_SESSION['id'];

    $query_string = "SELECT * FROM Opdracht";
    $query = mysqli_query($connessione, $query_string);

    //Get results
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0)
    {
        // maak een tabel aan
        echo "<table border='1px' class='table table-striped custom-table'>";
    
        // eerste de headers van de tabel
        // echo "<tr>
        // <th>Onderwerp</th>
        // <th>Inhoud</th>
        // <th>Begindatum</th>
        // <th>Einddatum</th>
        // <th>Prioriteit</th>
        // <th>Status</th>
        // <th>CheckID</th>
        // <th>Verwijder</th>
        // <th>Pas Aan</th>
        // </tr>";
    
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
    

    //Make that into a JSON array
    $results = json_encode( $results );

    //Put those results in a file (create if file not exist)
    $fileName = 'backupfile' . time() . '.txt';
    $file = fopen( $fileName , 'a'  );
    fwrite( $file, $results );
    fclose( $file );

    // //Delete the rows that you just backed up
    // $query_delete = "DELETE FROM utenti ORDER BY id DESC LIMIT 50";
    // mysqli_query( $connessione, $query_delete );

?>