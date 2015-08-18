<?php 
include("session.php"); 

// Cf. babillard.php for similar commented code

// ************************************************************* SEARCH QUERIES

if(isset($_GET['keywords']))
	$keywords = strip_tags(trim($_GET['keywords']));
else
	$keywords = strip_tags(trim($_POST['keywords']));

$query = "
	SELECT *, USR_FNAME, USR_LNAME, USR_ID
	FROM FILES
	LEFT JOIN USERS
		ON FILES.FIL_USER = USERS.USR_ID
	WHERE (1 = 1)";
			
if(strlen($keywords))
{	
	$keyword_set = explode(' ', $keywords);

	$query .= "
			AND (FIL_TITLE LIKE '%$keywords%'
				OR FIL_DESC LIKE '%$keywords%'
				OR FIL_NAME LIKE '%$keywords%'
				OR USR_FNAME = '$keywords'
				OR USR_LNAME = '$keywords'";

	foreach ($keyword_set as $keyword)
		if(strlen(trim($keyword)) > 1 && !$_POST['exactsearch'])
			$query .= "
					OR FIL_TITLE LIKE '%$keyword%'
					OR FIL_DESC LIKE '%$keyword%'
					OR FIL_NAME LIKE '%$keyword%'
					OR USR_FNAME = '$keyword'
					OR USR_LNAME = '$keyword'";
	
	$query .= ")";
			
	$keywords = stripslashes($keywords);
}
// ************************************************************* END SEARCH QUERIES

if(!isset($_GET['page']))
	$page = 1;
else
	$page = $_GET['page'];

$maxrows = 25;
$from = $maxrows * ($page - 1);

include("connect_db.php");
$result = mysql_query($query, $link);
echo mysql_error();
$numrows = mysql_num_rows($result);
$numpages = ceil($numrows / $maxrows);

$query .= " ORDER BY FIL_ID DESC LIMIT $from, $maxrows";
$result = mysql_query($query, $link);
echo mysql_error();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Ressources</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Author" content="Amine Laghaout">
	<link type="text/css" href="style.css" rel="stylesheet">
</head>

<body onload="document.keywordsearch.keywords.focus()">

<?php 
include("header.php"); 
include("search_form.php");
?>
<table width="90%" align="center" cellpadding="3" cellspacing="1" class="results">
<?php 
if($numrows)
{
?>
  <tr valign="bottom">
    <th width="15%">Titre</th>
    <th>Description</th>
    <th width="15%" align="center">Usager</th>
  <th width="5%" align="center">Taille  </tr>

<?php
}
elseif(strlen($keywords))
	echo "<tr align=\"center\"><td colspan=\"5\">Aucun résultat pour <strong>$keywords</strong>.</td></tr>";

// Directory for the uploaded files
$uploaddir = "files";

for($i = 0; $row = mysql_fetch_object($result); )
{
	$fil_size = round(filesize("$uploaddir/$row->FIL_NAME") / 1024);
?>
  <tr valign="top" bgcolor="<?php if($i++ % 2 == 0) echo "#EEEEEE"; else echo "#EEEEE0"; ?>">
    <td style="font-weight: bold;">
	<?php 
	foreach ((array)$keyword_set as $keyword)
		$row->FIL_TITLE = str_replace($keyword, "<em>" . $keyword . "</em>", $row->FIL_TITLE);	
	
	echo "<a href=\"$uploaddir/$row->FIL_NAME\" target=\"_blank\" title=\"$row->FIL_NAME [$fil_size KB]\">$row->FIL_TITLE</a>"; 
	?>	
    </td>
    <td>

    <?php 
	foreach ((array)$keyword_set as $keyword)
		$row->FIL_DESC = str_replace($keyword, "<em>" . $keyword . "</em>", $row->FIL_DESC);

	// Display a limited number of words from the article
	$file_desc = split(' ', $row->FIL_DESC);	
	for($j = 0; $j < 5; $j++)
		if(strlen($file_desc[$j]) > 20)
			echo wordwrap($file_desc[$j], 20, " ", true);
		else
			echo "$file_desc[$j] ";

	// Allow the administrator or the user who uploaded this document to delete it
	if(!strcasecmp($row->USR_ID, $_SESSION['ID']) || !strcasecmp("admin", $_SESSION['ID']))
		echo "&nbsp;<font size=\"1\">[<a href=\"ressources_action.php?remove=$row->FIL_ID\" onClick=\"return confirm('Supprimer [" . strtr(strip_tags(addslashes($row->FIL_TITLE)), "\"\'\\", "   ") . "] ?')\">Supprimer</a>]</font>"; 
	?>
	
    </td>
    <td align="center" nowrap>
	<?php
	echo "<a href=\"mailto:$row->USR_EMAIL\" title=\"$row->USR_EMAIL\">$row->USR_FNAME $row->USR_LNAME</a><BR>" .
		 "<font size=\"1\">" . date("d-m-Y à H\hi", filemtime("$uploaddir/$row->FIL_NAME")) . "</font>";
	?>	
    </td>
    <td align="right" nowrap>
	<?php echo "$fil_size <font size=\"1\">KB</font>"; ?>
	</td>
  </tr>
<?php
}
?>
</table>
<table border="0" align="center" cellpadding="0" cellspacing="3" class="resultpages">
  <tr>
    <td><?php
	if(strlen($keywords))
		$URLkeywords = "&keywords=" . urlencode($keywords);	

	if($numpages > 1)
	{	
		// Previous page
		if($page > 1){
			$i = $page - 1;
			echo "<a href=\"".$_SERVER['PHP_SELF']."?page=$i$URLkeywords\">Page précédante</a>&nbsp;|";
		}
		
		// Intermediary and/or current pages
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