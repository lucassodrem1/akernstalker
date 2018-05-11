<?php
require_once "../functions.php";
require_once "User.class.php";

$request = json_decode(file_get_contents('php://input'));

$user = new User();
$data = $user->createUser($conn, $request);

echo(json_encode($data));