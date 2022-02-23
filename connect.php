<?php
    // Includes database configration / connection paramenters.
    include("config.php");

    // connect to database
    $db = mysqli_connect($server, $dbuser, $dbpass,$dbname);    

    if (!$db) {
        echo "Error: Unable to connect to database." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
?>