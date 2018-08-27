<?php

DEFINE ('DBUSER', 'root'); 
DEFINE ('DBPW', ''); 
DEFINE ('DBHOST', 'localhost'); 
DEFINE ('DBNAME', 'coop'); 
 
$conn = mysqli_connect(DBHOST,DBUSER,DBPW,DBNAME);
mysqli_query($conn, "SET NAMES UTF8");


if (!$conn) {
    die("Database connection failed: " . mysqli_error($conn));
    exit();
}


?>