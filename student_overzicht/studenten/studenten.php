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
    <label for="search">Search:</label>
    <input type="text" id="search" name="search">
    <form method="GET" action="">
        <label for="filter">Filter By:</label>
        <select name="filter" id="filter">
            <option value="naam"<?php if(isset($_GET['filter']) && $_GET['filter'] === 'naam') echo ' selected'; ?>>Naam</option>
            <option value="geslacht"<?php if(isset($_GET['filter']) && $_GET['filter'] === 'geslacht') echo ' selected'; ?>>Geslacht</option>
            <option value="id"<?php if(isset($_GET['filter']) && $_GET['filter'] === 'id') echo ' selected'; ?>>ID</option>
            <option value="intake"<?php if(isset($_GET['filter']) && $_GET['filter'] === 'intake') echo ' selected'; ?>>Intake</option>
            <option value="opdracht"<?php if(isset($_GET['filter']) && $_GET['filter'] === 'opdracht') echo ' selected'; ?>>Opdracht</option>
            <option value="beoordeeld"<?php if(isset($_GET['filter']) && $_GET['filter'] === 'beoordeeld') echo ' selected'; ?>>Beoordeeld</option>
            <option value="score"<?php if(isset($_GET['filter']) && $_GET['filter'] === 'score') echo ' selected'; ?>>Score</option>
        </select>
        <input type="submit" value="Filter">
    </form>
    <br>
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

        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
            // Map the filter value to the corresponding column name
            $columnMap = [
                'naam' => 'HeleNaam',
                'geslacht' => 'Geslacht',
                'id' => 'StudentID',
                'intake' => 'IntakeNaam',
                'opdracht' => 'OpdrachtNaam',
                'beoordeeld' => 'Gesprek_Software_Development_YN',
                'score' => 'Score'
            ];
            if (isset($columnMap[$filter])) {
                $column = $columnMap[$filter];
                // Check if the filter is 'id' to determine the sorting order
                $sortOrder = $filter === 'id' && isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'DESC' : 'ASC';
                $sql .= " ORDER BY $column $sortOrder";
                // Set the sort parameter for the ID filter to toggle the sorting order
                $sortParam = $filter === 'id' && $sortOrder === 'ASC' ? 'desc' : 'asc';
                $filterUrl = $_SERVER['PHP_SELF'] . '?filter=' . $filter . '&sort=' . $sortParam;
                echo "<a href=\"$filterUrl\">Sort ID</a>";
            }
        }

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

    <script>
        document.getElementById('search').addEventListener('input', function() {
            var filter = this.value.toUpperCase();
            var table = document.getElementsByTagName('table')[0];
            var rows = table.getElementsByTagName('tr');

            for (var i = 1; i < rows.length; i++) {
                var row = rows[i];
                var cells = row.getElementsByTagName('td');
                var visible = false;

                for (var j = 0; j < cells.length; j++) {
                    var cell = cells[j];
                    if (cell.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        visible = true;
                        break;
                    }
                }

                row.style.display = visible ? '' : 'none';
            }
        });
    </script>
</body>

</html>
