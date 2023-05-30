<?php

require 'config.php';

?>

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Overzicht</title>

</head> 


<?php


$result = mysqli_query($mysqli, $query);

if (mysqli_num_rows($result) > 0)
{
    // maak een tabel aan
    echo "<table border='1px' class='table table-striped custom-table'>";

    // eerste de headers van de tabel
    echo "<tr>
    <th>naam</th>
    <th>geslacht</th>
    <th>id</th>
    <th>intake</th>
    <th>opdracht</th>
    <th>beoordeeld</th>
    <th>score</th>
    </tr>";

    while ($item = mysqli_fetch_assoc($result))

    {
      ?>
      <tbody id="myTable">
        <?php
        // toon de gegevens van het item in een tabelrij
        echo "<tr>";
             echo "<td>" . $item['Voornaam'] . "</td>";
             echo "<td>" . $item['Geslacht'] . "</td>";
             echo "<td>" . $item['StudentID'] . "</td>";
             echo "<td>" . $item['Intake_rondeID'] . "</td>";
             echo "<td>" . $item['Opmerking'] . "</td>";
             echo "<td>" . $item['Score'] . "</td>";
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

// else
// // als er geen records zijn
// {
//     echo "<p>Geen items gevonden!</p>";
    
// }

?>





