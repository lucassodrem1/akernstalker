<?php
require_once '../../sql/connect.php';
require_once 'User.class.php';
$player = new User();
$player->getUserById($conn, 1);
?>