<?php
require 'config.php';

$HeleNaam = $_POST['HeleNaam'];
$birthDate = $_POST['Geb.datum'];
$gender = $_POST['Geslacht'];
$email = $_POST['E-mailadres'];

// Insert data into the database
$query = "INSERT INTO Persoon_inschrijving (CONCAT(Voornaam, ' ', 't.v.', ' ', Achternaam) AS HeleNaam, 'Geb.datum', Geslacht, 'E-mailadres') VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssss", $HeleNaam, $birthDate, $gender, $email);

if ($stmt->execute()) {
    echo "Registration successfully...";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>