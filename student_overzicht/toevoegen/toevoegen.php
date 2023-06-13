<?php
require 'config.php';

// $HeleNaam = $_POST['HeleNaam'];
// $birthDate = $_POST['Geb.datum'];
// $gender = $_POST['Geslacht'];
// $email = $_POST['E-mailadres'];

// // Insert data into the database
// $query = "INSERT INTO Persoon_inschrijving (CONCAT(Voornaam, ' ', 't.v.', ' ', Achternaam) AS HeleNaam, 'Geb.datum', Geslacht, 'E-mailadres') VALUES (?, ?, ?, ?)";
// $stmt = $mysqli->prepare($query);
// $stmt->bind_param("ssss", $HeleNaam, $birthDate, $gender, $email);

// if ($stmt->execute()) {
//     echo "Registration successfully...";
// } else {
//     echo "Error: " . $stmt->error;
// }

// $stmt->close();
// $mysqli->close();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head> 
		<meta charset="utf-8">
		<title>Student Importeren</title>
	</head>
	<body>
		<form class="" action="" method="post" enctype="multipart/form-data">
			<input type="file" name="excel" required value="">
			<button type="submit" name="import">Importeer</button>
		</form>
		<?php
if(isset($_POST["import"])){
    $fileName = $_FILES["excel"]["name"];
    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));
    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

    $targetDirectory = "uploads/" . $newFileName;
    move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

    error_reporting(0);
    ini_set('display_errors', 0);

    require 'excelReader/excel_reader2.php';
    require 'excelReader/SpreadsheetReader.php';

    $reader = new SpreadsheetReader($targetDirectory);

    // Skip the first row assuming it contains headers
    $skipFirstRow = true;

    foreach($reader as $key => $row){
        // Skip the first row if it contains headers
        if($skipFirstRow){
            $skipFirstRow = false;
            continue;
        }

        $StudentID = $row[0];
        $Voornaam = $row[1];
        $t_v = $row[2];
        $Achternaam = $row[3];
        $Geb_datum = $row[4];
        $E_mailadres = $row[5];
        $Geslacht = $row[6];
        $Datum = $row[7];
        $Gesprek_Software_Development_YN = $row[8];
        $Reden_Gesprek_SoftwareDevelopment = $row[9];
        $Gesprek_BOA_YN = $row[10];
        $Reden_Gesprek_BOA = $row[11];
        $Definitief_advies = $row[12];
        $Opmerkingen = $row[13];
        $Created = $row[14];
        $Update = $row[15];
        $Deleted = $row[16];
        $Created_By = $row[17];
        $Updated_By = $row[18];

        $query = "INSERT INTO Persoon_inschrijving (StudentID, Voornaam, `t.v.`, Achternaam, `Geb.datum`, `E-mailadres`, Geslacht, Datum, `Gesprek_Software_Development_YN`, `Reden_Gesprek_SoftwareDevelopment`, `Gesprek_BOA_YN`, `Reden_Gesprek_BOA`, Definitief_advies, Opmerkingen, Created, Update, Deleted, Created_By, Updated_By) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("sssssssssssssssssss", $StudentID, $Voornaam, $t_v, $Achternaam, $Geb_datum, $E_mailadres, $Geslacht, $Datum, $Gesprek_Software_Development_YN, $Reden_Gesprek_SoftwareDevelopment, $Gesprek_BOA_YN, $Reden_Gesprek_BOA, $Definitief_advies, $Opmerkingen, $Created, $Update, $Deleted, $Created_By, $Updated_By);

        if ($stmt->execute()) {
            echo "Record imported successfully<br>";
        } else {
            echo "Error importing record: " . $stmt->error . "<br>";
        }

        $stmt->close();
    }

    echo "<script>
        alert('Succesfully Imported');
        document.location.href = '';
        </script>";
}
?>
	</body>
</html>

