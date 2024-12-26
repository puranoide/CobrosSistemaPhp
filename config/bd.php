<?php


$servername = "localhost";
$username = "u685818680_kipupayadmin";
$password = "41/fXsR[";
$database = "u685818680_kipupay";

$con = new mysqli($servername, $username, $password, $database);

if ($con->connect_error) {
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

CREATE TABLE kipuPay.clients (
	name varchar(100) NOT NULL,
	id INT auto_increment NOT NULL,
	email varchar(150) NOT NULL,
	debitPayment DOUBLE NOT NULL,
	nextPayment DATE NOT NULL,
	idUser INT NOT NULL,
	CONSTRAINT clients_pk PRIMARY KEY (id),
	CONSTRAINT clients_clients_FK FOREIGN KEY (idUser) REFERENCES kipuPay.users(id)
)


ALTER TABLE kipupay.clients ADD message TEXT NULL;


CREATE TABLE kipupay.mesagesSends (
	id INT auto_increment NOT NULL,
	clientsId INT NULL,
	message TEXT NULL,
	dateMessageSend DATE NULL,
	CONSTRAINT mesagesSends_pk PRIMARY KEY (id),
	CONSTRAINT mesagesSends_clients_FK FOREIGN KEY (clientsId) REFERENCES kipupay.clients(id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;





*/
