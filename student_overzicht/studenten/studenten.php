<?php
require 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Table with database</title>
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
        $sql = "SELECT p.Voornaam, p.Geslacht, p.StudentID, s.Intake_rondeID, o.Naam, s.Gesprek_Software_Development_YN, s.Score
                FROM Persoon_inschrijving p
                JOIN Score s ON p.StudentID = s.StudentID
                JOIN Opdracht o ON s.Opdracht_Id = o.OpdrachtID";
        $result = $mysqli->query($sql);
        if (!$result) {
            echo "Error: " . $mysqli->error;
            // Handle the error appropriately
        }
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["Voornaam"] . "</td><td>" . $row["Geslacht"] . "</td><td>"
                    . $row["StudentID"] . "</td><td>" . $row["Intake_rondeID"] . "</td><td>" . $row["Naam"] . "</td><td>"
                    . $row["Gesprek_Software_Development_YN"] . "</td><td>" . $row["Score"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        $mysqli->close();
        ?>
    </table>
</body>
</html>