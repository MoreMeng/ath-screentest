<?php

include 'connect.php';

$name = mysqli_real_escape_string($conn, $_GET['name']);
$section = mysqli_real_escape_string($conn, $_GET['section']);
$monitor = mysqli_real_escape_string($conn, $_GET['monitor']);
$score = mysqli_real_escape_string($conn, $_GET['score']);

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$IP_Address = getUserIpAddr();

$date = date("Y-m-d");
// date_default_timezone_set("asia/bangkok");
// $time = date("H:i:s");

echo $IP_Address.'<br>'.$date.'<br>';

$sql = "INSERT INTO quiz (Name,Monitor,Section,IP_Address,Date,Score)
VALUES ('$name','$monitor','$section','$IP_Address', '$date','$score')";

if (mysqli_query($conn, $sql)) {
    echo "successfully";
} else {
    echo "Error";
}

mysqli_close($conn);
?>