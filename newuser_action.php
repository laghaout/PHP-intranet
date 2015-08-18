<?php
include("session.php"); 

$user_id = strip_tags(trim($_POST['USR_ID'])); 
$fname = strip_tags(trim($_POST['USR_FNAME'])); 
$lname = strip_tags(trim($_POST['USR_LNAME']));
$email = strip_tags(trim($_POST['USR_EMAIL']));

include("connect_db.php");

// Form validation
if (!strlen($user_id))
	die("Vous devez spécifier le nom d'usager. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

elseif (!strlen($fname))
	die("Vous devez spécifier le prénom de la personne que vous voulez ajouter. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

elseif (!strlen($lname))
	die("Vous devez spécifier le nom de la personne que vous voulez ajouter. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

elseif (!strlen($lname))
	die("Vous devez spécifier un nom d'usager pour la personne que vous voulez ajouter. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

elseif (!strlen($email))
	die("Vous devez spécifier l'adresse courriel de la personne que vous voulez ajouter. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

elseif(!preg_match( "/^[-^!#$%&'*+\/=?`{|}~.\w]+@[-a-zA-Z0-9]+(\.[-a-zA-Z0-9]+)+$/", $email))
	die("<strong>$email</strong> n'est pas une adresse courriel. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

elseif(!preg_match("/^[a-z]+[-a-z0-9]{1,}$/", $user_id))
	die("<strong>$user_id</strong> n'est pas un nom d'usager valide (utilisez seulement des lettres minuscules, les accents et autres caractères sont interdits). <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

elseif(mysql_num_rows(mysql_query("SELECT USR_ID FROM USERS WHERE USR_ID = '$user_id'", $link)))	
	die("Le nom d'usager <strong>$user_id</strong> existe déjà. Trouvez en un autre pour <strong>$fname $lname</strong>. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

elseif(mysql_num_rows(mysql_query("SELECT USR_ID FROM USERS WHERE USR_EMAIL = '$email'", $link)))	
	die("L'adresse courriel <strong>$email</strong> appartient déjà à un des membres de l'intranet. Les adresses doivent êtres personnelles. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

// Generate a random password from a set of six alphas and digits
$charset = "abcdefghijklmnopqrstuvwxyz0123456789";
for ($i=0; $i < 6; $i++) 
	$password .= $charset[(mt_rand(0, (strlen($charset) - 1)))]; 

// Insert the new user
$query = "
	INSERT INTO USERS 
	(USR_ID, USR_FNAME, USR_LNAME, USR_PASSWD, USR_EMAIL)
	VALUES
	('$user_id', '$fname', '$lname', '$password', '$email')";
$result = mysql_query($query, $link);
echo mysql_error();

// ************************************************************* E-MAIL THE NEW USER

// Retrieve the e-mail of the administrator
$result = mysql_query("SELECT USR_EMAIL FROM USERS WHERE USR_ID = 'admin'", $link);
echo mysql_error();
if($row = mysql_fetch_object($result))
	$admin_email = $row->USR_EMAIL;
else
	$admin_email = "webmestre@rifssso.ca";

require("class.phpmailer.php");
	
$mail = new phpmailer();
$mail->From     = $admin_email;
$mail->FromName = "Intranet RIFSSSO.ca";
$mail->Host     = "localhost";
$mail->Mailer   = "smtp";
$mail->Subject  = "Inscription à l'intranet des consultants.";
$recipient      = $email;
	
$body = "
Vous avez été inscrit(e) à l'intranet des Consultants régionaux des services de santé en français.

Nom : $lname
Prénom : $fname
Courriel : $email
Nom d'usager : $user_id
Mot de passe : $password

Vous pouvez modifier votre mot de passe en-ligne.
http://www.rifssso.ca/consultants/

Si vous avez des questions, répondez à ce courriel ou contactez $admin_email.
";

$mail->Body = $body;
$mail->AddAddress($recipient);
if (!$mail->send())
	die($mail->ErrorInfo);
$mail->ClearAddresses();
$mail->ClearAttachments();

// Return to the admin page and confirm addition
header("Location: options.php?confirm=newuser");
?>