<?php
session_start();

// Use a cookie to remind the SESSION of its own value.
// This is a fix to a bug inherent with the host server.
$_SESSION['ID'] = $_COOKIE['USER_ID'];

header("Cache-control: private"); // IE 6 fix

// Logout if session is dead
if (!isset($_SESSION['ID']))
	header("Location: index.php");
?>