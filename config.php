<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "alumni_parent_feedback";

$con = new mysqli($servername, $username, $password, '', 3307);


if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$result = $con->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'");


if ($result->num_rows == 0) {

    $sql_create_db = "CREATE DATABASE $dbname";
    if ($con->query($sql_create_db) === TRUE) {
   
        
       
        $con->close();
        $con = new mysqli($servername, $username, $password, $dbname, 3307);
        echo "database created";




    }}
    else{
      //  echo "databse already created";
    }
    $con = new mysqli($servername, $username, $password, $dbname, 3307);
?>