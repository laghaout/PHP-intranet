<?php include("session.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Babillard [d&eacute;tails et commentaires]</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Author" content="Amine Laghaout">
	<link type="text/css" href="style.css" rel="stylesheet">
</head>

<body>
<?php include("header.php"); ?>
<table width="85%" border="0" align="center" cellpadding="5" cellspacing="5" 
style="border: 3px #003366 double; font-size: 10pt; background-color: #FFFFFF;">
  <tr>
    <td>
<?php
// If the user got here by clicking from a link after a search, the set
// of keywords is passed via the URL to that they will be highlighted
if(isset($_GET['keywords'])) {
	$keyword_set = explode(' ', $keywords);
} else {
	$keyword_set = array();
}

// Retreive the primary post and the name of its author
include("connect_db.php");
$query = "
	SELECT POSTS.*, USR_LNAME, USR_FNAME
	FROM POSTS
	LEFT JOIN USERS
		ON POSTS.POS_USER = USERS.USR_ID
	WHERE POS_ID = $POS_ID AND POS_PRIMEPOST IS NULL";
$result = mysql_query($query, $link);
echo mysql_error();	

// Check that this post exists and is primary
if(mysql_num_rows($result) <= 0)
	die("L'article numéro <b>$POS_ID</b> n'existe pas (ou n'est pas primaire).  <input type=\"button\" value=\"Retour\" onClick=\"history.back()\">");

// Display the primary post
$row = mysql_fetch_object($result);

// Highlight the keywords
foreach ($keyword_set as $keyword)
{
	$row->POS_TITLE = str_replace($keyword, "<em>" . $keyword . "</em>", $row->POS_TITLE);
	$row->POS_TEXT = str_replace($keyword, "<em>" . $keyword . "</em>", $row->POS_TEXT);
}

list($year, $month, $day, $hour, $minutes) = split('[- :]', $row->POS_DATE);

echo "
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"font-size: 10pt;\" bgcolor=\"#EEEEEF\">
  <tr valign=\"middle\">
    <td><h4 style=\"margin: 0px;\">$row->POS_TITLE";

// Allow the administrator to delete this article
if(!strcasecmp("admin", $_SESSION['ID']))
	echo "&nbsp;<font size=\"1\">[<a href=\"babillard_remove.php?remove=$row->POS_ID\" onClick=\"return confirm('Supprimer cet article et toutes ses réponses?')\">Supprimer</a>]</font>"; 
	
echo "	
	</h4></td>
    <td width=\"10%\" nowrap>par <strong>$row->USR_FNAME $row->USR_LNAME</strong> le <strong>$day-$month-$year</strong> à <strong>$hour" . "h$minutes</strong>.</td>
  </tr>
</table><BR>" . nl2br($row->POS_TEXT);

// ************************************************************* RETRIEVE COMMENTS

// Determine the number of the current result page (first page by default)
if(!isset($_GET['page']))
	$page = 1;
else
	$page = $_GET['page'];

// Search all the answers to this post
$query = "
	SELECT POS_ID, POS_TITLE, POS_DATE, POS_TEXT, POS_USER, USR_LNAME, USR_FNAME
	FROM POSTS
	LEFT JOIN USERS
		ON POSTS.POS_USER = USERS.USR_ID
	WHERE POS_PRIMEPOST = $POS_ID";
	
// Determine the limitations on the number of results to be displayed
// per page as well as from what result to start the search query
$maxrows = 25;
$from = $maxrows * ($page - 1);

// Compute the number of total number of results and result pages
$result_numrows = mysql_query($query, $link);
echo mysql_error();
$numrows = mysql_num_rows($result_numrows);
$numpages = ceil($numrows / $maxrows);	

// Execute actual search querty
$query .= " ORDER BY POS_DATE DESC LIMIT $from, $maxrows";
$result = mysql_query($query, $link);
echo mysql_error();	

// ************************************************************* END OF RETRIEVE COMMENTS
?>

    </td>
  </tr>
</table>
<BR>
<table width="50%" border="0" align="center" cellpadding="1" cellspacing="3" class="forms">
<form action="babillard_action.php" method="post">
  <tr align="center" valign="middle">
    <th colspan="2">Poster un commentaire</th>
    </tr>
  <tr>
    <td valign="top">Titre</td>
    <td><input name="title" type="text" size="50" maxlength="60" value="<?php echo "Re[" . ($numrows + 1) . "] : " . strip_tags($row->POS_TITLE); ?>">
    </td>
  </tr>
  <tr>
    <td valign="top">Texte</td>
    <td><textarea name="text" cols="50" rows="10"></textarea>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<input type="hidden" value="<?php echo $POS_ID; ?>" name="primary_post">
	<input type="submit" name="Submit" value="Poster">
    <input type="reset" name="Submit2" value="Annuler">
	</td>
  </tr>
</form>
</table>
<BR>
<?php
// Display comments if any
if(mysql_num_rows($result))
{
	echo "<table width=\"85%\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" class=\"results\"><tr><th>Réponses et commentaires</th></tr>";
	
	// Display comment iteratively
	for($i = 0; $row = mysql_fetch_object($result); )
	{
		// Format date and time
		list($year, $month, $day, $hour, $minutes) = split('[- :]', $row->POS_DATE);	
	
		echo "<tr bgcolor=\"";
		if($i++ % 2 == 0) 
			echo "#EEEEEF"; 
		else 
			echo "#EEEEE5";

		echo "\"><td><div style=\"margin: 4px;\">"
			 . "<strong class=\"strongcolor\">$row->POS_TITLE</strong>&nbsp;<font size=\"1.5\">par <strong>$row->USR_FNAME $row->USR_LNAME</strong> le <strong>$day-$month-$year</strong> à <strong>$hour" . "h$minutes</strong></font>";

		// Allow the administrator to delete this article
		if(!strcasecmp("admin", $_SESSION['ID']))
			echo "&nbsp;<font size=\"1\">[<a href=\"babillard_remove.php?remove=$row->POS_ID\" onClick=\"return confirm('Supprimer cette réponse ?')\">Supprimer</a>]</font>"; 
			 
		echo "<BR><BR>"
			 . nl2br($row->POS_TEXT) 
			 . "</div></td></tr>";
	}

	echo "</table>";
?>
<table border="0" align="center" cellpadding="0" cellspacing="3" class="resultpages">
  <tr>
    <td><?php
	// Display the numbered links to the result pages
	if($numpages > 1)
	{	
		// Previous page
		if($page > 1){
			$prev = $page - 1;
			echo "<a href=\"".$_SERVER['PHP_SELF']."?POS_ID=$POS_ID&page=$prev\">Page précédante</a>&nbsp;";
		}
		
		// Intermediary (with possibly the current page with not link)
		for($i = 1; $i <= $numpages; $i++)
			if($page == $i)
				echo "&nbsp;<strong>$i</strong>&nbsp;|";
			else
				echo "<a href=\"".$_SERVER['PHP_SELF']."?POS_ID=$POS_ID&page=$i\">&nbsp;$i&nbsp;</a>|";
		
		// Next page
		if($page < $numpages){
			$next = $page + 1;
			echo "&nbsp;<a href=\"".$_SERVER['PHP_SELF']."?POS_ID=$POS_ID&page=$next\">Page suivante</a>";
		}
	}
}
?>
    </td>
  </tr>
</table>
<?php include("footer.php"); ?>
</body>
</html>
