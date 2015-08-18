<?php
include("session.php"); 

$user_id = $_SESSION['ID'];

include("connect_db.php");

// Insertion of a new press article
if(!isset($_GET['remove']))
{
	$date = $_POST['year_published'] . "-" . $_POST['month_published'] . "-" . $_POST['day_published'];
	$title = strip_tags(trim($_POST['title']));
	$source = strip_tags(trim($_POST['source']));
	$text = strip_tags(trim($_POST['text']));
	$source_url = strip_tags(trim($_POST['source_url']));

	// Form validation
	if(!checkdate($_POST['month_published'], $_POST['day_published'], $_POST['year_published']))
		die("Le " . $_POST['month_published'] . "-" . $_POST['day_published'] . "-" . $_POST['year_published'] . " n'est pas une date réelle. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");
	elseif(!strlen($title))
		die("Veuillez spécifier un titre. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");
	elseif(!strlen($source))
		die("Veuillez spécifier la source. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");
	elseif(!strlen($text))
		die("Vous avez oublié de copier l'article. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

	$query = "
			INSERT INTO ARTICLES (ART_TITLE, ART_SOURCE, ART_TEXT, ART_DATE, ART_USER, ART_URL) 
			VALUES ('$title', '$source', '$text', '$date', '$user_id', '$source_url')";
}			
// Deletion of a press article: ID of the article is passed via URL
else
{
	$article_id = $_GET['remove'];
		
	// Double check the ID of the user who posted this article 
	// The administrator is also allowed to perform deletions.
	$query = "SELECT ART_USER FROM ARTICLES WHERE ART_ID = $article_id";
	$result = mysql_query($query, $link);
	echo mysql_error();
	$row = mysql_fetch_object($result);
	
	if(strcasecmp($row->ART_USER, $_SESSION['ID']) && strcasecmp("admin", $_SESSION['ID']))
		die("Vous n'avez pas les droits suffisants pour supprimer l'article numéro $article_id. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");
		
	else
		$query = "DELETE FROM ARTICLES WHERE ART_ID = $article_id";	
}

// Execute query (insertion xor deletion)
$result = mysql_query($query, $link);
echo mysql_error();

header("Location: presse.php");
?>