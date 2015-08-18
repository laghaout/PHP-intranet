<?php
include("session.php"); 

// This program toggles the privilege the user whose ID is passed via the URL 
// between active (greater or equal to 0) and disabled (-1).
// Only the administrator has the privilege to perform such actions.
if(strcmp("admin", $_SESSION['ID']))
	die("Vous n'êtes pas l'administrateur. Par conséquence vous nous pouvez pas executer cette opération. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

// User ID concerned by this action
$user_id = strip_tags(trim($_GET['user_id']));

// Determine whether the user is to be suspended or reactivated
include("connect_db.php");
$result = mysql_query("SELECT USR_TYPE FROM USERS WHERE USR_ID = '$user_id'", $link);
$row = mysql_fetch_object($result);
echo mysql_error();

// Toggle status (type) of the user
if($row->USR_TYPE >= 0)
	$query = "UPDATE USERS SET USR_TYPE = -1 WHERE USR_ID = '$user_id'";
else
	$query = "UPDATE USERS SET USR_TYPE = 0 WHERE USR_ID = '$user_id'";

mysql_query($query, $link);
echo mysql_error();

header("Location: options.php#$user_id");
?>