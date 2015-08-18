<?php
$email = strip_tags(trim($_POST['EMAIL']));

// Double check that there is a user with this e-mail address among the members
include("connect_db.php");
$result = mysql_query("SELECT * FROM USERS WHERE USR_EMAIL = '$email' AND USR_TYPE >= 0", $link);
echo mysql_error();

// E-mail validation
if(!strlen($email))
	die("Vous n'avez pas entré d'adresse courriel. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

elseif(!preg_match( "/^[-^!#$%&'*+\/=?`{|}~.\w]+@[-a-zA-Z0-9]+(\.[-a-zA-Z0-9]+)+$/", $email))
	die("<strong>$email</strong> n'est pas une adresse courriel. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

elseif(!mysql_num_rows($result))
	die("L'adresse courriel <strong>$email</strong> n'appartient à aucun des usagers de l'intranet. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

// Everything is OK: send password reminder
else
{
	$row = mysql_fetch_object($result);
	
	require("class.phpmailer.php");
	
	// E-mail header and parameters	
	$mail = new phpmailer();
	$mail->From     = "webmestre@rifssso.ca";
	$mail->FromName = "Intranet RIFSSSO.ca";
	$mail->Host     = "localhost";
	$mail->Mailer   = "smtp";
	$mail->Subject  = "Rappel de mot de passe.";
	$recipient      = $row->USR_EMAIL;
	
$body = "
Rappel de votre information en tant que membre de l'intranet des Consultants régionaux des services de santé en français:

Nom : $row->USR_LNAME
Prénom : $row->USR_FNAME
Courriel : $row->USR_EMAIL
Nom d'usager : $row->USR_ID
Mot de passe : $row->USR_PASSWD
";

	// Send 
	$mail->Body = $body;
	$mail->AddAddress($recipient);
	if (!$mail->send())
		die($mail->ErrorInfo);
	$mail->ClearAddresses();
	$mail->ClearAttachments();

	// Confirmation message
	echo "Un rappel de votre mot de passe vient d'être envoyé à <strong>$email</strong> et devrait vous parvenir dans quelques minutes. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">";
}	
?>