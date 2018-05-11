<?php
require_once "../functions.php";
require_once "Profile.class.php";

$request = (object) array (
    "profileID" => $_GET['profileID']
);

$profile = new Profile();
$profile->deleteProfile($conn, $request);