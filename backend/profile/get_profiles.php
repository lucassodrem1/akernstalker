<?php
require_once "../functions.php";
require_once "Profile.class.php";

$profile = new Profile();
$data = $profile->getProfiles($conn);

echo json_encode($data);
