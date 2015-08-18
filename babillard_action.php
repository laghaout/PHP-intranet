<?php
include("session.php"); 

$usager = $_SESSION['ID'];
$title = strip_tags(trim($_POST['title']));
$text = strip_tags($_POST['text']);
$primepost = $_POST['primary_post'];

// Form validation
if(strlen($title) < 1)
	die("Veuillez donner un titre à votre article. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

// Connect to database
include("connect_db.php");

// If this is a comment (i.e. if it is an answer to a primary post)
if(isset($primepost))
{	
	$query = "
		INSERT INTO POSTS (POS_USER, POS_TEXT, POS_DATE, POS_TITLE, POS_PRIMEPOST) 
		VALUES ('$usager', '$text', now(), '$title', '$primepost')";		

	mysql_query($query, $link);	
	echo mysql_error();

	// Determine the ID of the answer that has just been inserted.
	// It will be the ID of the latest post to the primary post to
	// which it is answering
	$getlastans = "
		SELECT MAX(POS_ID) AS latestans
		FROM POSTS
		WHERE POS_PRIMEPOST = $primepost";
	
	$result = mysql_query($getlastans, $link);	
	echo mysql_error();
	$row = mysql_fetch_object($result);

	// Update the ID of the last answer to the primary post
	// and the increment the number of answers to it
	$update_primepost = "
		UPDATE POSTS 
		SET POS_LASTANS = $row->latestans, POS_NBRANS = POS_NBRANS + 1
		WHERE POS_ID = $primepost";
	
	mysql_query($update_primepost, $link);
	echo mysql_error();
	
	// Since this was a comment, return to the display page of its primary post
	header("Location: babillard_disp.php?POS_ID=$primepost");
}

// If this is a primary post, just insert the specified values.
// Note that the ID of the primary post should be null by default.
else
{
	$query = "
	INSERT INTO POSTS (POS_USER, POS_TEXT, POS_DATE, POS_TITLE) 
	VALUES ('$usager', '$text', now(), '$title')";	

	mysql_query($query, $link);	
	echo mysql_error();

	$redirect = "babillard.php";
	header("Location: babillard.php");
}	
?>
