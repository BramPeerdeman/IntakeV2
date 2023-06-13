<?php

include 'config.php';
?>

<!DOCTYPE html>
<html>

<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
<title>Intake Overzicht</title>
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
    <style>
        /* CSS-styling hier */

        /* Modal stijlen */
        .modal {
            display: none; /* Verbergt de modal standaard */
            position: fixed; /* Zorgt ervoor dat de modal bovenop de pagina wordt weergegeven */
            z-index: 1; /* Zorgt ervoor dat de modal bovenop andere elementen wordt weergegeven */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Zorgt ervoor dat de modal kan worden gescrold als deze groter is dan het scherm */
            background-color: rgba(0, 0, 0, 0.4); /* Voegt een semi-transparante overlay toe */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* Plaatst de modal verticaal en horizontaal in het midden van het scherm */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <label for="search">Search:</label>
    <input type="text" id="search" name="search">
    <form method="GET" action="">
        <label for="filter">Filter By:</label>
        <select name="filter" id="filter">
            <option value="naam" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'naam')
                echo ' selected'; ?>>Naam
            </option>
            <option value="geslacht" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'geslacht')
                echo ' selected'; ?>>Geslacht</option>
            <option value="id" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'id')
                echo ' selected'; ?>>ID
            </option>
            <option value="intake" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'intake')
                echo ' selected'; ?>>
                Intake</option>
            <option value="opdracht" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'opdracht')
                echo ' selected'; ?>>Opdracht</option>
            <option value="beoordeeld" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'beoordeeld')
                echo ' selected'; ?>>Beoordeeld</option>
            <option value="score" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'score')
                echo ' selected'; ?>>
                Score</option>
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
            <th>View</th>
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
                    . $row["Gesprek_Software_Development_YN"] . "</td><td>" . $row["Score"] . "</td>" . "<td><button class='userinfo' data-id='" . $row['StudentID'] . "'>Info</button></td>                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>0 results</td></tr>";
        }
        $mysqli->close();
        ?>
    </table>
    <div class="modal fade" id="empModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">User Info</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- De modal -->
    <div id="empModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-body">
                <!-- Inhoud van de modale body hier -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Klikfunctie voor het openen van de modal
            $('table').on('click', 'button', function() {
                var rowData = $(this).closest('tr').children('td').map(function() {
                    return $(this).text();
                }).get();
                var html = "<h4>naam: " + rowData[0] + "</h4>" +
                    "<p>geslacht: " + rowData[1] + "</p>" +
                    "<p>id: " + rowData[2] + "</p>" +
                    "<p>intake: " + rowData[3] + "</p>" +
                    "<p>opdracht: " + rowData[4] + "</p>" +
                    "<p>beoordeeld: " + rowData[5] + "</p>" +
                    "<p>score: " + rowData[6] + "</p>";
                $('.modal-body').html(html);
                $('#empModal').css('display', 'block');
            });

            // Klikfunctie voor het sluiten van de modal
            $('.close').click(function() {
                $('#empModal').css('display', 'none');
            });

            // Klikfunctie voor het sluiten van de modal wanneer er buiten wordt geklikt
            $(window).click(function(event) {
                if (event.target == document.getElementById('empModal')) {
                    $('#empModal').css('display', 'none');
                }
            });

            // Zoekfunctionaliteit
            $('#search').on('input', function() {
                var filter = $(this).val().toUpperCase();
                var table = $('table');
                var rows = table.find('tr');

                for (var i = 1; i < rows.length; i++) {
                    var row = rows[i];
                    var cells = $(row).find('td');
                    var visible = false;

                    for (var j = 0; j < cells.length; j++) {
                        var cell = cells[j];
                        if ($(cell).text().toUpperCase().indexOf(filter) > -1) {
                            visible = true;
                            break;
                        }
                    }

                    row.style.display = visible ? '' : 'none';
                }
            });
        });
    </script>
</body>

</html>