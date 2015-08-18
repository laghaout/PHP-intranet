<?php
include("session.php");

// Directory where the files are to be uploaded
$uploaddir = 'files/';

include("connect_db.php");

// Add a document
if(!isset($_GET['remove']))
{
	// Sanitize the filename and extract the last three letters of its name
	$filename = stripslashes(strtr(strtolower($_FILES['FIL_NAME']['name']), "êéêèàâîïœô'`()!?,; \"\'\\", "eeeeaaiieo____________"));
	$filext = strtolower($filename[strlen($filename)-3] . $filename[strlen($filename)-2] . $filename[strlen($filename)-1]);

	// Make sure the file has been described
	if(!strlen($_POST['FIL_DESC']))
		die("Veuillez décrire votre fichier. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");
		
	// Make sure the files that is to be uploaded has been specified properly and recognized by the server
	elseif(!strlen($filename) || !file_exists($_FILES['FIL_NAME']['tmp_name']))
		die("Le fichier que vous tentez de télécharger a été mal spécifié. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");
	
	// Make sure nobody uploads files with unwanted extensions
	elseif(!strcmp($filext, "exe") || !strcmp($filext, "bat") || !strcmp($filext, "out") || !strcmp($filext, "php") || !strcmp($filext, "tml") || !strcmp($filext, "htm") || !strcmp($filext, "xml"))
		die("Les fichiers ayant l'extension <b>$filext</b> ne sont pas permis. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");		

	// Rename the file if a duplicate is detected
	for($i = 0; file_exists($uploaddir . $filename); $i++)
		$filename = str_replace('.', $i . '.', $filename);
	
	// Transfer the file from the temporary directory
	if (move_uploaded_file($_FILES['FIL_NAME']['tmp_name'], $uploaddir . $filename)) 
	{	
		if(strlen(trim($_POST['FIL_TITLE'])))
			$FIL_TITLE = strip_tags($_POST['FIL_TITLE']);
		else
			$FIL_TITLE = $_FILES['FIL_NAME']['name'];
		
		$FIL_DESC = strip_tags($_POST['FIL_DESC']);
		$FIL_USER = $_SESSION['ID'];
		
		$query = "
				INSERT INTO FILES (FIL_TITLE, FIL_NAME, FIL_DESC, FIL_USER)
				VALUES ('$FIL_TITLE', '$filename', '$FIL_DESC', '$FIL_USER')";
	} 
	
	// Other types of problems (e.g. oversized file)
	else 
	{
		echo "Il y a un problème de serveur avec le téléchargement de votre document. Notez que les fichiers de plus de 2000 KB ne peuvent pas être téléchargés.";
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";
		die("<BR><input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");	
	}
}

// Delete the document whose ID has been passed via the URL
else
{
	$fil_id = $_GET['remove'];
		
	// Double check the ID of the user who posted this file for only he/she
	// is allowed to delete it beside the administrator
	$query = "SELECT FIL_USER, FIL_NAME FROM FILES WHERE FIL_ID = $fil_id";
	$result = mysql_query($query, $link);
	echo mysql_error();
	$row = mysql_fetch_object($result);
	
	if(strcasecmp($row->FIL_USER, $_SESSION['ID']) && strcasecmp("admin", $_SESSION['ID']))
		die("Le fichier que vous essayez d'effacer n'existe pas. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");
	
	$query = "DELETE FROM FILES WHERE FIL_ID = $fil_id";
	
	// Delete the physical file
	unlink($uploaddir . $row->FIL_NAME);	
}

$result = mysql_query($query, $link);
echo mysql_error();

header("Location: ressources.php");
?>