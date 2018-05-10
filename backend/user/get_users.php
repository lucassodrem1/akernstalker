<?php
require_once "../functions.php";
require_once "User.class.php";

$user = new User();
$data = $user->getUsers($conn);

echo json_encode($data);