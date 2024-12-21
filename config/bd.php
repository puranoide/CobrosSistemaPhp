<?php


$servername = "localhost";
$username = "u685818680_kipupayadmin";
$password = "41/fXsR[";
$database = "u685818680_kipupay"; //kipuPay

$con = new mysqli($servername, $username, $password, $database);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "kipuPay";

    $con = new mysqli($servername, $username, $password, $database);
    die("Connection failed: " . $con->connect_error);
}


/*creaciontablas

$servername = "localhost";
$username = "root";
$password = "";
$database = "kipuPay";

$servername = "localhost";
$username = "u685818680_kipupayadmin";
$password = "41/fXsR[";
$database = "u685818680_kipupay";



CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
)




*/
