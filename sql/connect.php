<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db = "projetoAker";

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
	die("Erro: " . $con->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS `".$db."`";
if ($conn->query($sql) === false) {
	echo "Erro: " . $con->error() . "<br>";
}

$conn->select_db($db);

$sql = "CREATE TABLE IF NOT EXISTS `users` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(12),
	`password` VARCHAR(18),
    `create_date` DATETIME NOT NULL DEFAULT NOW(),
	`last_access` DATETIME NOT NULL DEFAULT NOW(),
	`profile_id` INT NOT NULL,
	FOREIGN KEY (profile_id)
		REFERENCES profiles(id)
		ON UPDATE CASCADE
		ON DELETE SET NULL,
	PRIMARY KEY (id)
)";

if ($conn->query($sql) === false) {
	echo "Error: " . $conn->error . "<br>";
}

$sql = "CREATE TABLE IF NOT EXISTS `profiles` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(18),
	PRIMARY KEY (id)
)";

if ($conn->query($sql) === false) {
	echo "Error: " . $conn->error . "<br>";
}


