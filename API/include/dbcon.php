<?php

    $host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "hive_bd";
    $db_port = "3308";

    #se connecter à la base de donnée
    $connect = mysqli_connect($host, $db_username, $db_password, $db_name, $db_port);

    if (!$connect) {
        die("La connexion a échoué: "  . mysqli_connect_error());
    }
?>