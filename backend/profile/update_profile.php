<?php
require_once "../functions.php";
require_once "Profile.class.php";

$request = json_decode(file_get_contents('php://input'));

$profile = new Profile();
$data = $profile->updateProfile($conn, $request);

echo json_decode($data);