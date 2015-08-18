<?php
// Connect to database
$server_000 = "localhost";
$user_000 = "the_user";
$pass_000 = "the_password";
$database_000 = "the_database";

$link = mysql_connect($server_000, $user_000, $pass_000);
$db = mysql_select_db($database_000, $link);
?>