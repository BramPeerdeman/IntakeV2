<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// database log-in gegevens
$db_hostname = 'localhost';
$db_username = 'intakev2';
$db_password = 'intakev2_ww';
$db_database = 'intakev2';

// maak de database verbinding
$mysqli = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

// als de verbinding niet gemaakt kan worden: geef een melding
if (!$mysqli) {
    echo "FOUT: geen connectie naar database. <br>";
    echo "Error: " . mysqli_connect_error() . "<br/>";
    exit;
}

?>