<?php

include 'config.php';
?>

<!DOCTYPE html>
<html>

<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
<link rel="stylesheet" href="../css/navbar.css">
<link rel="stylesheet" href="../css/navbar.scss">
<link rel="stylesheet" href="../css/studentenLijst/studentenLijst.css">
<link rel="stylesheet" href="../css/studentenLijst/studentenLijst.scss">
<title>Studenten Overzicht</title>
<body>
    <!-- NAVBAR BEGIN -->
    <div class="navbar">
        <div class="items itemsLogo">
            <div class="logo"><img src="../assets/icons/glrLogoTrans.png" alt="GLR logo" width="100%" height="100%">
            </div>
        </div>
        <div class="items itemsStudent">
            <div class="studenten"><img src="../assets/icons/studentenIcon.png" alt="student Icon" width="100%"
                    height="100%">
                <p>studenten</p>
            </div>
        </div>
        <div class="items itemsOpdracht">
            <div class="opdrachten"><img src="../assets/icons/opdrachtIcon.png" alt="opdrachten Icon" width="100%"
                    height="100%">
                <p>opdrachten</p>
            </div>
        </div>
        <div class="items itemsIntake">
            <div class="intake"><img src="../assets/icons/intakeIcon.png" alt="intake Icon" width="100%" height="100%">
                <p>intake</p>
            </div>
        </div>
        <hr class="navbarLine">
        <div class="items itemsLogout">
            <div class="logout"><img class="logoutImage" src="../assets/icons/logoutIcon.png" alt="logout Icon"
                    width="100%" height="100%">
                <p>log uit</p>
            </div>
        </div>
    </div>
    <!-- NAVBAR END -->
    <div id="main-content">
        <div id="tab-nav">
            <div id="tab-title">
                <p>Studenten</p>
            </div>
            <div id="tabs">
                <p id="current-page">Studenten lijst</p>
                <p><a href="studentenToevoegen.html">Toevoegen</a></p>
            </div>
        </div>
        <!-- STUDENTEN LIJST -->
        <div id="content">
            <div id="zoeken-en-filter">
            <input type="text" id="zoeken" name="search" placeholder="Zoeken...">
            <form method="GET" action="">
                <select name="filter" id="filter">
                    <option value="naam" <?php if(isset($_GET['filter']) && $_GET['filter']==='naam' ) echo ' selected'
                        ; ?>
                        Naam</option>
                    <option value="geslacht" <?php if(isset($_GET['filter']) && $_GET['filter']==='geslacht' )
                        echo ' selected' ; ?>Geslacht</option>
                    <option value="id" <?php if(isset($_GET['filter']) && $_GET['filter']==='id' ) echo ' selected' ; ?>
                        ID
                    </option>
                    <option value="intake" <?php if(isset($_GET['filter']) && $_GET['filter']==='intake' )
                        echo ' selected' ; ?>Intake</option>
                    <option value="opdracht" <?php if(isset($_GET['filter']) && $_GET['filter']==='opdracht' )
                        echo ' selected' ; ?>Opdracht</option>
                    <option value="beoordeeld" <?php if(isset($_GET['filter']) && $_GET['filter']==='beoordeeld' )
                        echo ' selected' ; ?>Beoordeeld</option>
                    <option value="score" <?php if(isset($_GET['filter']) && $_GET['filter']==='score' )
                        echo ' selected' ; ?>Score</option>
                </select>
                <input type="submit" value="Filter toevoegen" id="filter-submit">
            </form>
        </div>
            <br>
            <!-- <ul class="responsive-table"> -->
                <!-- <li class="table-header">
                  <div class="col col-1">naam</div>
                  <div class="col col-2">geslacht</div>
                  <div class="col col-3">id</div>
                  <div class="col col-4">intake</div>
                  <div class="col col-5">opdracht</div>
                  <div class="col col-6">beoordeeld</div>
                  <div class="col col-7">score</div>
                  <div class="col col-8">details</div>
                </li> -->
                </div>
            </div>
            <script src="../js/navbar.js"></script>
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
    echo "<ul>";
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<li><strong>Naam:</strong> " . $row["HeleNaam"] . "</li>"
            . "<li><strong>Geslacht:</strong> " . $row["Geslacht"] . "</li>"
            . "<li><strong>ID:</strong> " . $row["StudentID"] . "</li>"
            . "<li><strong>Intake:</strong> " . $row["IntakeNaam"] . "</li>"
            . "<li><strong>Opdracht:</strong> " . $row["OpdrachtNaam"] . "</li>"
            . "<li><strong>Beoordeeld:</strong> " . $row["Gesprek_Software_Development_YN"] . "</li>"
            . "<li><strong>Score:</strong> " . $row["Score"] . "</li>"
            . "<li><button class='userinfo' data-id='" . $row['StudentID'] . "'>Info</button></li>";
    }
    echo "</ul>";
} else {
    echo "<p>0 results</p>";
}
$mysqli->close();
?>
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