<?php
require_once "../functions.php";
require_once "User.class.php";

$request = (object) array (
    "userID" => $_GET['userID']
);

$user = new User();
$user->deleteUser($conn, $request);