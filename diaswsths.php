<?php
  
    $db_server = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "projectdb";
    $conn = ""; 
    $port = 3306;

    //dhmiourgia sundeshs
    $conn = new mysqli($db_server, $db_user, $db_password, $db_name,$port);
    
    //elegxos sundeshs
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>