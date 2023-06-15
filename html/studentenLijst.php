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
        @import url("https://fonts.googleapis.com/css2?family=Fira+Sans+Condensed:ital,wght@1,300&display=swap");
@font-face {
  font-family: face;
  src: url(../);
}
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  text-decoration: none;
  list-style: none;
  font-family: "Roboto", sans-serif;
  font-weight: 600;
}

html,
body {
  display: flex;
  width: 100%;
  height: 100%;
  background-color: #F5F7FA;
}

::-moz-selection {
  background: #85D109;
}

::selection {
  background: #85D109;
}

#main-content {
  display: flex;
  flex-grow: 2;
  flex-direction: column;
}

a {
  color: black;
}

#tab-nav {
  width: 100%;
  height: 140px;
}
#tab-nav #tab-title {
  width: 100%;
  height: 70px;
  padding: 0px 40px;
  display: flex;
  align-items: center;
  border-bottom: 1px solid lightgray;
}
#tab-nav #tab-title p {
  font-size: 25px;
}
#tab-nav #tabs {
  width: 100%;
  height: 70px;
  padding: 20px 40px;
  border-bottom: 2px solid lightgray;
  display: flex;
}
#tab-nav #tabs p {
  align-self: center;
  font-size: 18px;
  margin-right: 35px;
  font-weight: lighter;
}
#tab-nav #tabs #current-page {
  color: #85D109;
  font-weight: bold;
  position: relative;
}
#tab-nav #tabs #current-page::after {
  content: "";
  position: absolute;
  top: 43px;
  left: 0;
  width: 100%;
  height: auto;
  border-bottom: 3px solid #85D109;
}

#zoeken-en-filter {
  display: flex;
}

#zoeken {
  position: relative;
  margin: 30px 0 0 30px;
  text-align: center;
  border: none;
  width: 200px;
  height: 40px;
  border-radius: 8px;
  background-color: #ffffff;
  box-shadow: 0px 0px 10px rgba(152, 152, 152, 0.1450980392);
}

#filter,
#filter-submit {
  position: relative;
  height: 30px;
  margin: 35px 0 0 0;
  left: 30px;
  box-shadow: 0px 0px 10px rgba(152, 152, 152, 0.1450980392);
}

#filter {
  border: none;
  border-radius: 5px;
  padding: 0 10px;
}

#filter-submit {
  border: none;
  border-radius: 5px;
  left: 40px;
  width: 120px;
  background-color: #85D109;
}

.responsive-table {
  position: relative;
  margin: 10px 30px;
  text-align: center;
}
.responsive-table li {
  border-radius: 10px;
  padding: 20px;
  display: flex;
  justify-content: space-between;
  margin-bottom: 25px;
}
.responsive-table .table-header {
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 0.03em;
}
.responsive-table .table-row {
  background-color: #ffffff;
  box-shadow: 0px 0px 10px 0px rgba(152, 152, 152, 0.1450980392);
}
.responsive-table .col-1 {
  flex-basis: 20%;
}
.responsive-table .col-2 {
  flex-basis: 5%;
}
.responsive-table .col-3 {
  flex-basis: 15%;
}
.responsive-table .col-4 {
  flex-basis: 15%;
}
.responsive-table .col-5 {
  flex-basis: 20%;
}
.responsive-table .col-6 {
  flex-basis: 5%;
}
.responsive-table .col-7 {
  flex-basis: 10%;
}
.responsive-table .col-8 {
  flex-basis: 10%;
}
@media all and (max-width: 1000px) {
  .responsive-table .table-header {
    display: none;
  }
  .responsive-table li {
    display: block;
  }
  .responsive-table .col {
    flex-basis: 100%;
  }
  .responsive-table .col {
    display: flex;
    padding: 10px 0;
  }
  .responsive-table .col:before {
    color: #6C7A89;
    padding-right: 10px;
    content: attr(data-label);
    flex-basis: 50%;
    text-align: right;
  }
}/*# sourceMappingURL=studentenLijst.css.map */
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
                echo "<li><div class='col col-1'>" . $row["HeleNaam"] . "</div><div class='col col-2'>" . $row["Geslacht"] . "</div><div class='col col-3'>"
                    . $row["StudentID"] . "</div><div class='col col-4'>" . $row["IntakeNaam"] . "</div><div class='col col-5'>" . $row["OpdrachtNaam"] . "</div><div class='col col-6'>"
                    . $row["Gesprek_Software_Development_YN"] . "</div><div class='col col-7'>" . $row["Score"] . "</div>" . "<div class='col col-8'><button class='userinfo' data-id='" . $row['StudentID'] . "'>Info</button></div></li>";
            }
        } else {
            echo "<li><div colspan='7'>0 results</div></li>";
        }
        $mysqli->close();
        ?>
        </div>
    </div>
    <script src="../js/navbar.js"></script>
</body>

</html>