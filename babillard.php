<?php 
include("session.php"); 

// ************************************************************* SEARCH QUERIES

// The keywords used in the search can be passed via
// a) the search form
// b) the URL (i.e. from the numbered page results links)
if(isset($_GET['keywords']))
	$keywords = strip_tags(trim($_GET['keywords']));
else
	$keywords = strip_tags(trim($_POST['keywords']));

// Default search query (retrieves all entries)
$query = "
	SELECT *, USR_FNAME, USR_LNAME, USR_EMAIL
	FROM POSTS
	LEFT JOIN USERS
		ON POSTS.POS_USER = USERS.USR_ID
	WHERE POS_PRIMEPOST IS NULL ";

// If keywords have been specified...
if(isset($keywords))
{	
	// ... decompose the string into individual words...
	$keyword_set = explode(' ', $keywords);

	// ... and see if the *whole* string -in order-, is matched
	// (i.e. exact search)
	$query .= "
			AND (POS_TITLE LIKE '%$keywords%'
				OR POS_TEXT LIKE '%$keywords%'
				OR USR_FNAME = '$keywords'
				OR USR_LNAME = '$keywords'";

	// If the exact search has not be selected, look for the individual
	// words. Any word. Exclude one-letter words from the search
	foreach ($keyword_set as $keyword)
		if(strlen(trim($keyword)) > 1 && !$_POST['exactsearch'])
			$query .= "
					OR POS_TITLE LIKE '%$keyword%'
					OR POS_TEXT LIKE '%$keyword%'
					OR USR_FNAME = '$keyword'
					OR USR_LNAME = '$keyword'";
	
	$query .= ")";
			
	// Get rid of those slashes that sometimes appear in front of
	// special characters so that the keywords are re-displayed properly
	$keywords = stripslashes($keywords);
}
// ************************************************************* END OF SEARCH QUERIES

// Determine the number of the current result page (first page by default)
if(!isset($_GET['page']))
	$page = 1;
else
	$page = $_GET['page'];

// Determine the limitations on the number of results to be displayed
// per page as well as from what result to start the search query
$maxrows = 30;
$from = $maxrows * ($page - 1);

// Compute the total number of results and result pages
include("connect_db.php");
$result = mysql_query($query, $link);
echo mysql_error();

$numrows = mysql_num_rows($result);
$numpages = ceil($numrows / $maxrows);

// Execute the actual query to will be applied to the current page
$query .= " ORDER BY POS_DATE DESC LIMIT $from, $maxrows";
$result = mysql_query($query, $link);
echo mysql_error();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Babillard</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Author" content="Amine Laghaout">
	<link type="text/css" href="style.css" rel="stylesheet">
</head>

<body onload="document.keywordsearch.keywords.focus()">
<?php 
include("header.php"); 
include("search_form.php");
?>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" class="results">
<?php
// If there are results, display the header of the table:
if($numrows)
{
?>
  <tr>
    <th align="left">Titre de l'article</th>
    <th width="15%" align="center">Auteur</th>
    <th width="10%" align="center">R&eacute;ponses</th>
    <th width="15%" align="center" nowrap>Derni&egrave;re r&eacute;ponse</th>
  </tr>
<?php
}
// If there are no results and a string of keywords has been specified, let the user know:
elseif(strlen($keywords))
	echo "<tr align=\"center\"><td colspan=\"5\">Aucun résultat pour <strong>$keywords</strong>.</td></tr>";

// ************************************************************* DISPLAY SEARCH RESULTS
for($i = 0; $row = mysql_fetch_object($result); )
{
?>
  <tr valign="middle" bgcolor="<?php if($i++ % 2 == 0) echo "#EEEEEE"; else echo "#EEEEE0"; ?>">
  
    <!-- TITLE -->
	<td style="font-weight: bold;">
	<?php 
	// Italicize the search keywords in the results. Note that this is case sensitive.
	// Use stri_replace() with PHP 5 instead of just str_replace().
	foreach ($keyword_set as $keyword)
		$row->POS_TITLE = str_replace($keyword, "<em>" . $keyword . "</em>", $row->POS_TITLE);
	
	// The keywords are passed to the page displaying the article so that they will
	// be italicized there too.
	if(strlen($keywords))
		$URLkeywords = "&keywords=" . urlencode($keywords);
	
	// Display title of the post as a link to the display page
	echo "<a href=\"babillard_disp.php?POS_ID=$row->POS_ID$URLkeywords\">$row->POS_TITLE</a>";
	?>
	</td>
	
	<!-- AUTHOR AND DATE OF PUBLICATION -->
    <td align="center" nowrap>
	<?php 
	// Display the date in French format
	list($year, $month, $day, $hour, $minutes) = split('[- :]', $row->POS_DATE);
	echo "<a href=\"mailto:$row->USR_EMAIL\" title=\"$row->USR_EMAIL\">$row->USR_FNAME $row->USR_LNAME</a><BR>" .
		 "<font size=\"1\">$day-$month-$year à ". $hour . "h$minutes</font>";
	?>  	
	</td>
	
	<!-- NUMBER OF ANSWERS -->
    <td align="center">
	<?php echo $row->POS_NBRANS; ?>
	</td>
	
	<!-- AUTHOR AND DATE OF PUBLICATION OF THE LATEST ANSWER -->
    <td align="center" nowrap>
	<?php 
	// Join the ID of the last answer (if any) to find the name and e-mail of its 
	// author, as well as the date and time when it was published	
	if(isset($row->POS_LASTANS))
	{	
		$query_lastans = "
			SELECT POS_DATE, USR_FNAME, USR_LNAME, USR_EMAIL
			FROM POSTS
			LEFT JOIN USERS
				ON POSTS.POS_USER = USERS.USR_ID
			WHERE POS_ID = $row->POS_LASTANS";
			
		$result_lastans = mysql_query($query_lastans, $link);
		echo mysql_error();
		
		// This while() loop should normally execute either 0 or 1 times.
		// Equivalent to an if() statement.
		while($row_lastans = mysql_fetch_object($result_lastans))
		{
			list($year, $month, $day, $hour, $minutes) = split('[- :]', $row_lastans->POS_DATE);
			echo "<a href=\"mailto:$row_lastans->USR_EMAIL\" title=\"$row_lastans->USR_EMAIL\">$row_lastans->USR_FNAME $row_lastans->USR_LNAME</a><BR>" .
				 "<font size=\"1\">$day-$month-$year à ". $hour . "h$minutes</font>";				
		}
	}
	// No answer to the current post.
	else
		echo "&nbsp;";
	?>
	</td>
  </tr>
<?php
}
// ************************************************************* END OF DISPLAY SEARCH RESULTS
?>
</table>
<!-- CLICKABLE, NUMBERED, RESULT PAGES -->
<table border="0" align="center" cellpadding="0" cellspacing="3" class="resultpages">
  <tr>
    <td align="center"><?php
	if($numpages > 1)
	{	
		// Previous page
		if($page > 1){
			$i = $page - 1;
			// The string of keywords is passed to the next result pages to maintain the search criteria
			// and not have the next pages display all the exsiting records as if no keywords were entered
			echo "<a href=\"".$_SERVER['PHP_SELF']."?page=$i$URLkeywords\">Page précédante</a>&nbsp;|";
		}
		
		// Intermediary pages (with, possibly the current page with a disabled link)
		for($i = 1; $i <= $numpages; $i++)
			if($page == $i)
				echo "&nbsp;<strong>$i</strong>&nbsp;|";
			else
				echo "<a href=\"".$_SERVER['PHP_SELF']."?page=$i$URLkeywords\">&nbsp;$i&nbsp;</a>|";
		
		// Next page
		if($page < $numpages){
			$i = $page + 1;
			echo "&nbsp;<a href=\"".$_SERVER['PHP_SELF']."?page=$i$URLkeywords\">Page suivante</a>";
		}
	}
	?>
    </td>
  </tr>
</table>
<?php include("footer.php"); ?>
</body>
</html>