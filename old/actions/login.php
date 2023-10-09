<?php
include "../classses/User.php";

$user = new User;

$user->login($_POST)