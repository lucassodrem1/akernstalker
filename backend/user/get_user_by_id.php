<?php
require_once "../functions.php";
require_once "User.class.php";

$request = (object) array (
    "userID" => $_GET['userID']
);

$user = new User();
$data = $user->getUserById($conn, $request);

echo json_encode($data);