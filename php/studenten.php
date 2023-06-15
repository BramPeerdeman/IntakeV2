<?php

include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IntakeV2</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/navbar.scss">
    <link rel="stylesheet" href="../css/studentenLijst/studentenLijst.css">
    <link rel="stylesheet" href="../css/studentenLijst/studentenLijst.scss">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
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
        <ul class="responsive-table">
            <li class="responsive-header">
                <div class="col col1">naam</div>
                <div class="col col2">geslacht</div>
                <div class="col col3">id</div>
                <div class="col col4">intake</div>
                <div class="col col5">opdracht</div>
                <div class="col col6">beoordeeld</div>
                <div class="col col7">score</div>
                <div class="col col8">details</div>
            </li>
            
    </ul>
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
                echo "<li><div class='col col-1'>" . $row["HeleNaam"] . "</div><div class='col col-2'>" . $row["Geslacht"] . "</div><div class='col col-3'>"
                    . $row["StudentID"] . "</div><div class='col col-4'>" . $row["IntakeNaam"] . "</div><div class='col col-5'>" . $row["OpdrachtNaam"] . "</div><div class='col col-6'>"
                    . $row["Gesprek_Software_Development_YN"] . "</div><div class='col col-7'>" . $row["Score"] . "</div>" . "<div class='col col-8'><button class='userinfo' data-id='" . $row['StudentID'] . "'>Info</button></div></li>";
            }
        } else {
            echo "<li><div colspan='7'>0 results</div></li>";
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