<?php
require 'config.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Overzicht</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            color: #588c7e;
            font-family: monospace;
            font-size: 25px;
            text-align: left;
        }

        th {
            background-color: #588c7e;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th>naam</th>
            <th>geslacht</th>
            <th>id</th>
            <th>intake</th>
            <th>opdracht</th>
            <th>beoordeeld</th>
            <th>score</th>
        </tr>
        <?php
        $sql = "SELECT CONCAT(p.Voornaam, ' ', p.`t.v.`, ' ', p.Achternaam) AS HeleNaam, p.Geslacht, p.StudentID, i.Naam AS IntakeNaam, o.Naam AS OpdrachtNaam, p.Gesprek_Software_Development_YN, s.Score
                FROM Persoon_inschrijving p
                JOIN Score s ON p.StudentID = s.StudentID
                JOIN Intake i ON s.Intake_rondeID = i.ID
                JOIN Opdracht o ON i.OpdrachtID = o.OpdrachtID";

        $result = $mysqli->query($sql);

        if (!$result) {
            echo "Error: " . $mysqli->error;
            // Handle the error appropriately
        }

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["HeleNaam"] . "</td><td>" . $row["Geslacht"] . "</td><td>"
                    . $row["StudentID"] . "</td><td>" . $row["IntakeNaam"] . "</td><td>" . $row["OpdrachtNaam"] . "</td><td>"
                    . $row["Gesprek_Software_Development_YN"] . "</td><td>" . $row["Score"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='7'>0 results</td></tr>";
        }
        $mysqli->close();
        ?>
    </table>
</body>

</html>
