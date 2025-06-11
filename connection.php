<?php

$host = "localhost";
$user = "root";
$pass = "";
$gym_db = "gym_db";

$con = mysqli_connect($host, $user, $pass, $gym_db);

if(mysqli_connect_errno()){
    echo "Failed to connect to the server: MYSQL " . mysqli_connect_error();
}
?>