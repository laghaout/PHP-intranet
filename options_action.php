<?php
include("session.php"); 

$user_id = $_SESSION['ID'];
$fname = strip_tags(trim($_POST['fname'])); 
$lname = strip_tags(trim($_POST['lname']));
$old_password = strip_tags(trim($_POST['old_password']));
$new_password = strip_tags(trim($_POST['new_password']));
$new_password2 = strip_tags(trim($_POST['new_password2']));
$email = strip_tags(trim($_POST['email']));

// Retreive the password of this user in order to confirm his/her identity
include("connect_db.php");
$result = mysql_query("SELECT USR_PASSWD FROM USERS WHERE USR_ID = '$user_id'", $link);
echo mysql_error();
$row = mysql_fetch_object($result);

// Form validation
if(!strlen($old_password))
	die("Veuillez spécifier votre mot de passe. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");
	
elseif ($old_password != $row->USR_PASSWD)
	die("Votre mot de passe (actuel) est incorrect. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");
	
elseif (!strlen($lname))
	die("Vous devez spécifier votre nom et votre prénom. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

elseif (!strlen($email))
	die("Vous devez spécifier votre adresse courriel. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

elseif(!preg_match( "/^[-^!#$%&'*+\/=?`{|}~.\w]+@[-a-zA-Z0-9]+(\.[-a-zA-Z0-9]+)+$/", $email))
	die("<strong>$email</strong> n'est pas une adresse courriel. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

// If everything is OK. Update the info the the user
if ($new_password == $new_password2)
{
	// If the user did not intend to modify his/her password, (i.e. if he/she
	// left the two boxes for the new password empty) take the old one
	if(!strlen($new_password))
		$new_password = $old_password;
		
	$query = "
		UPDATE USERS 
		SET USR_FNAME = '$fname', USR_LNAME = '$lname', USR_PASSWD = '$new_password', USR_EMAIL = '$email'
		WHERE USR_ID = '$user_id'";
	$result = mysql_query($query, $link);
	echo mysql_error();
	
	header("Location: options.php?confirm=userupdate");
}

// Error message if the new password has not been repeated correctly
else
	die("Le nouveau mot de passe que vous avez choisi n'a pas été répété correctement. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");
?>