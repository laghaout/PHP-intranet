<?php
/* This page deletes articles from the bulletin board. It gets the ID of an article via the URL and then
 * determines whether it's a primary post. If it is, it deletes it along with all its answers. If it is 
 * an answer (to a primary post), then it only deletes that answers and makes sure to update the latest
 * answer of the primary post when applicable (i.e. when it is the latest answer that is being deleted) as
 * well as the number of answers to the primary post.
 */
include("session.php"); 

$pos_id = $_GET['remove'];

if(strcasecmp("admin",  $_SESSION['ID']))
	die("Vous n'avez pas les privilèges suffisants pour effacer des articles de babillard. <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

// Connect to database
include("connect_db.php");

// Check to see if this is a primary post. The answer will be stored in $row->POS_PRIMARYPOST
$query = "SELECT POS_PRIMEPOST FROM POSTS WHERE POS_ID = $pos_id";
$result = mysql_query($query, $link);
echo mysql_error();
$row = mysql_fetch_object($result);

// Delete the post(s)
$query = "DELETE FROM POSTS WHERE (POS_ID = $pos_id) OR (POS_PRIMEPOST = $pos_id)";
mysql_query($query, $link);
echo mysql_error();

// Since this is an answer, update the POS_LASTANS and POS_NBRANS columns associated with it
if($row->POS_PRIMEPOST != NULL)
{
	// What was the latest answer before this one?
	$query = "
		SELECT MAX(POS_ID) AS latest_post 
		FROM POSTS 
		WHERE POS_PRIMEPOST = $row->POS_PRIMEPOST";
	$result = mysql_query($query, $link);
	echo mysql_error();
	
	// This makes sure that a values is returned (i.e. when the query above yeilds
	// no result -when no answers are left for the primary post-, then use NULL)
	if($latest = mysql_fetch_object($result))
		$latestPost = $latest->latest_post;
	else
		$latestPost = NULL;
	
	// Update primary post (POS_LASTANS and POS_NBRANS)
	$query = "
		UPDATE POSTS 
		SET POS_LASTANS = '$latestPost', POS_NBRANS = POS_NBRANS - 1
		WHERE POS_ID = $row->POS_PRIMEPOST";
	mysql_query($query, $link);
	echo mysql_error();
	
	// Go back to the display page of the primary post
	header("Location: babillard_disp.php?POS_ID=$row->POS_PRIMEPOST");
}
// This was a primary post, go back to the main page
else
	header("Location: babillard.php");
?>