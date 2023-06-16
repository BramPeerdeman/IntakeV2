<?php

include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IntakeV2</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/navbar.scss">
    <link rel="stylesheet" href="../css/studentenLijst/studentenLijst.css">
    <link rel="stylesheet" href="../css/studentenLijst/studentenLijst.scss">
</head>

<body>
    <style>
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
                <p id="current-page"><a href="../html/studentenLijst.php">Studenten lijst</a></p>
                <p><a href="../html/studentenToevoegen.html">Toevoegen</a></p>
            </div>
        </div>
        <!-- STUDENTEN LIJST -->
        <div id="content">
            <div id="zoeken-en-filter">
                <input type="text" id="zoeken" name="search" placeholder="Zoeken...">
                <form method="GET" action="">
                    <select name="filter" id="filter">
                        <option value="naam" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'naam')
                            echo ' selected'; ?> selected? ; ??>Naam</option>
                        <option value="geslacht" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'geslacht')
                            echo ' selected'; ?>>Geslacht</option>
                        <option value="id" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'id')
                            echo ' selected'; ?>?? ; ?? ID>ID</option>
                        <option value="intake" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'intake')
                            echo ' selected';?>> Intake</option>
                        <option value="opdracht" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'opdracht')
                            echo ' selected'; ?>>Opdracht</option>
                        <option value="beoordeeld" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'beoordeeld')
                            echo ' selected'; ?>>Beoordeeld</option>
                        <option value="score" <?php if (isset($_GET['filter']) && $_GET['filter'] === 'score')
                            echo ' selected'; ?>>Score</option>
                    </select>
                    <input type="submit" value="Filter toevoegen" id="filter-submit">
                </form>
            </div>
            <br>
            <ul class="responsive-table">
                <li class="table-header">
                    <div class="col col-1">naam</div>
                    <div class="col col-2">geslacht</div>
                    <div class="col col-3">id</div>
                    <div class="col col-4">intake</div>
                    <div class="col col-5">opdracht</div>
                    <div class="col col-6">beoordeeld</div>
                    <div class="col col-7">score</div>
                    <div class="col col-8">details</div>
                </li>
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
                echo "<li class='table-row'><div class='col col-1'>" . $row["HeleNaam"] . "</div><hr><div class='col col-2'>" . $row["Geslacht"] . "</div><hr><div class='col col-3'>"
                    . $row["StudentID"] . "</div><hr><div class='col col-4'>" . $row["IntakeNaam"] . "</div><hr><div class='col col-5'>" . $row["OpdrachtNaam"] . "</div><hr><div class='col col-6'>"
                    . $row["Gesprek_Software_Development_YN"] . "</div><hr><div class='col col-7'>" . $row["Score"] . "</div><hr><div class='col col-8'><button class='userinfo' data-id='" . $row['StudentID'] . "'>Info</button></div></li>";
            }
        } else {
            echo "<li><div colspan='7'>0 results</div></li>";
        }
        $mysqli->close();
        ?>
        </div>
    </div>

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

// INFO 
$(document).ready(function () {
            // Klikfunctie voor het openen van de modal
            $('ul.responsive-table').on('click', 'button.userinfo', function () {
                var rowData = $(this).closest('li').find('.col').map(function () {
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
            $('.close').click(function () {
                $('#empModal').css('display', 'none');
            });

            // Klikfunctie voor het sluiten van de modal wanneer er buiten wordt geklikt
            $(window).click(function (event) {
                if (event.target == document.getElementById('empModal')) {
                    $('#empModal').css('display', 'none');
                }
            });
        });




// ZOEKEN
    $(document).ready(function() {
        $('#zoeken').on('input', function() {
            var filter = $(this).val().toUpperCase();
            var rows = $('.table-row');

            rows.each(function() {
                var cells = $(this).find('.col');
                var visible = false;

                cells.each(function() {
                    if ($(this).text().toUpperCase().indexOf(filter) > -1) {
                        visible = true;
                        return false; // Break the loop
                    }
                });

                $(this).toggle(visible);
            });
        });
    });

</script>
    <script src="../js/navbar.js"></script>
</body>

</html>