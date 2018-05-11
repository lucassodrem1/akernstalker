<?php
require_once "../functions.php";
require_once "User.class.php";

$request = (object) array (
    "username" => $_GET['username'],
    "password" => $_GET['password']
);

$user = new User();
$data = $user->userLogin($conn, $request);

echo json_encode($data);