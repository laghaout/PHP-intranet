<?php
session_start();

$id = trim($_POST['ID']);
$passwd = trim($_POST['PASSWD']);

// Check the identity of the user
include("connect_db.php");
$query = "
	SELECT USR_ID 
	FROM USERS
	WHERE USR_ID = '$id' AND USR_PASSWD = '$passwd' AND USR_TYPE >= 0";
$result = mysql_query($query, $link);
echo mysql_error();

// This while loop should be executed either 0 or 1 times
// and is (should) therefore be equivalent to an if()
while($row = mysql_fetch_object($result))
{
	// Upon successful login, take the user ID to be the session variable
	$_SESSION['ID'] = $row->USR_ID;

	// There is a bug with the server of the RIFSSSO which 
	// kills sessions after a few minutes only. This cookie
	// is used to "remind" the session scope of its own value
	// Cf. session.php
	setcookie("USER_ID", $row->USR_ID, time() + 36000);
}


if(isset($_SESSION['ID']))
{
	// Update the number of logins for this user as well
	// as the last date and time he/she logged in
	$user_id = $_SESSION['ID'];
	$query = "
		UPDATE USERS
		SET USR_NBRLOG = USR_NBRLOG + 1, USR_LASTLOG = now()
		WHERE USR_ID = '$user_id'";
	$result = mysql_query($query, $link);
	echo mysql_error();
	
	header("Location: babillard.php");
}

// If the identification failed, determine why to give the user a feedback
// Note that users who have been banned (negative type) will always fail
// the identification process as if they never existed
else
{
	$query = "
		SELECT USR_ID 
		FROM USERS
		WHERE USR_ID = '$id' AND USR_TYPE >= 0";
	$result = mysql_query($query, $link);
	echo mysql_error();
	
	// Wrong password
	if(mysql_num_rows($result))
		$errormsg = "password";
		
	// The user does not exist
	else
		$errormsg = "username";
	
	header("Location: index.php?errormsg=$errormsg&username=$id");
}
?>