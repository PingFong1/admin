<?php
$sname = 'localhost';
$uname= 'root';
$password = "";
$db_name = "IPT101";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

    if(!$conn){
        echo "Connection Failed";
    }else{
        "Connection Success!";
    }
