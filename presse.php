<?php 
include("session.php"); 

// Cf. babillard.php for commented similar code

// ************************************************************* SEARCH QUERY

if(isset($_GET['keywords']))
	$keywords = strip_tags(trim($_GET['keywords']));
else
	$keywords = strip_tags(trim($_POST['keywords']));

$query = "
	SELECT *, USR_FNAME, USR_LNAME
	FROM ARTICLES	
	LEFT JOIN USERS
		ON ARTICLES.ART_USER = USERS.USR_ID
	WHERE (1 = 1)";

if(isset($keywords))
{	
	$keyword_set = explode(' ', $keywords);

	$query .= "
			AND (ART_TITLE LIKE '%$keywords%'
				OR ART_SOURCE LIKE '%$keywords%'
				OR ART_TEXT LIKE '%$keywords%'
				OR ART_ID = '$keywords'";

	foreach ($keyword_set as $keyword)
		if(strlen(trim($keyword)) > 1 && !$_POST['exactsearch'])
			$query .= "
					OR ART_TITLE LIKE '%$keyword%'
					OR ART_SOURCE LIKE '%$keyword%'
					OR ART_TEXT LIKE '%$keyword%'
					OR ART_ID = '$keyword'";
	
	$query .= ")";

	$keywords = stripslashes($keywords);
}
// ************************************************************* END SEARCH QUERY

// Maximum number of words to be displayed in the prevews of the articles
$maxwords = 40;

if(!isset($_GET['page']))
	$page = 1;
else
	$page = $_GET['page'];

$maxrows = 30;
$from = $maxrows * ($page - 1);

include("connect_db.php");
$result = mysql_query($query, $link);
echo mysql_error();
$numrows = mysql_num_rows($result);
$numpages = ceil($numrows / $maxrows);

$query .= " ORDER BY ART_DATE DESC LIMIT $from, $maxrows";
$result = mysql_query($query, $link);
echo mysql_error();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Manchettes de presse</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Author" content="Amine Laghaout">
	<link type="text/css" href="style.css" rel="stylesheet">
    <script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(window.open("presse_disp.php?ART_ID="+selObj.options[selObj.selectedIndex].value,"","toolbar=no,scrollbars=yes,width=700, height=420"));
  if (restore) selObj.selectedIndex=0;
}
//-->
    </script>
</head>

<body onload="document.keywordsearch.keywords.focus()">
<?php include("header.php"); ?>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="30%">&nbsp;	
	</td>
    <td align="center"><?php include("search_form.php"); ?></td>
    <!-- Display a particular article from its ID -->
	<td width="30%" align="right" valign="middle" style="font-size: 10pt;"> 
		<?php 
		$pulldown = mysql_query("SELECT ART_ID FROM ARTICLES ORDER BY ART_ID", $link);
		echo mysql_error();
		?>
		Article 		
		<select name="getarticle" onChange="MM_jumpMenu('parent',this,0)">
		<option>N&ordm;</option>
		<?php 
		while($pd_row = mysql_fetch_object($pulldown))
			echo "<option value=\"$pd_row->ART_ID\">$pd_row->ART_ID</option>";
		?>
		</select>
	</td>

  </tr>
</table>

<table width="90%" border="0" align="center" cellpadding="3" cellspacing="3" class="results" background="images/background.gif">
<?php

// Display the articles two by two with alternating background color

if(!$numrows && strlen($keywords))
	echo "<tr align=\"center\" bgcolor=\"#FFFFFF\"><td>Aucun résultat pour <strong>$keywords</strong>.</td></tr>";

$i = 0;
$k = 0;
while($row = mysql_fetch_object($result))
{
if(strlen($keywords))
{
	// Highlight search keywords
	$URLkeywords = "&keywords=" . urlencode($keywords);
	foreach ($keyword_set as $keyword)
	{
		$row->ART_SOURCE = str_replace($keyword, "<em>" . $keyword . "</em>", $row->ART_SOURCE);
		$row->ART_TITLE = str_replace($keyword, "<em>" . $keyword . "</em>", $row->ART_TITLE);
		$row->ART_TEXT = str_replace($keyword, "<em>" . $keyword . "</em>", $row->ART_TEXT);
	}
}

if($i % 2 == 0)
{
	echo "<tr valign=\"top\">";
	$k--;
}
?>
    <td width="50%" bgcolor="<?php if($k++ % 2) echo "#EEEEEE"; else echo "#EEEEE0"; ?>">
	<?php
	// Date of publication and name of the person who posted the press article
	list($year, $month, $day, $hour, $minutes) = split('[- :]', $row->ART_DATE);
	echo "<span style=\"font-size: xx-small;\">Article Nº $row->ART_ID. Posté par ";
	if(strcasecmp("admin", $row->ART_USER))
		echo strtoupper($row->USR_FNAME[0]) . ". $row->USR_LNAME";
	else
		echo "l'administrateur";
	echo "<BR></span>";

	// Title
	echo "<b>$row->ART_TITLE</b><BR>";
	
	// If the URL is specified (i.e. more enough characters in addition to the "http://")
	// then create a hyperlink on the source
	if(strlen($row->ART_URL) > 9)
		echo "<U><a href=\"$row->ART_URL\" target=\"_blank\">$row->ART_SOURCE</a></U> ";
	else
		echo "<U>$row->ART_SOURCE</U> ";
	echo "<span style=\"font-size: xx-small;\">le $day-$month-$year.</span>";

	// If the current user is the one who added the acticle
	// or is administrator, allow him/her to delete the article
	if(!strcasecmp($row->ART_USER, $_SESSION['ID']) || !strcasecmp("admin", $_SESSION['ID']))
		echo "&nbsp;<font size=\"1\">[<a href=\"presse_action.php?remove=$row->ART_ID\" onClick=\"return confirm('Supprimer [" . strtr(strip_tags(addslashes($row->ART_TITLE)), "\"\'\\", "   ") . "] ?')\">Supprimer</a>]</font>"; 	

	echo "<BR>";

	// Display a limited number of words from the article
	$text_preview = split(' ', $row->ART_TEXT);	
	for($j = 0; $j < $maxwords; $j++)
		if(strlen($text_preview[$j]) > 20)
			echo wordwrap($text_preview[$j], 20, " ", true);
		else
			echo "$text_preview[$j] ";
	
	// If the article has been truncated, add a link to the actual display page
	if(count($text_preview) > $maxwords)
		echo "<font size=\"1\"><nobr>[<a href=\"#\" onclick=\"window.open('presse_disp.php?ART_ID=$row->ART_ID$URLkeywords','','toolbar=no,resizable,scrollbars=yes,width=750, height=500');\">Lire l'article...</a>]</nobr></font>";
	?>
	</td>
<?php
if($i++ % 2 != 0) echo "</tr>";
}
?>
</table>

<table border="0" align="center" cellpadding="0" cellspacing="3" class="resultpages">
  <tr>
    <td align="center">
	<?php	
	// Display the numbered links to the result pages
	if($numpages > 1)
	{	
		// Previous page
		if($page > 1){
			$i = $page - 1;
			echo "<a href=\"".$_SERVER['PHP_SELF']."?page=$i$URLkeywords\">Page précédante</a>&nbsp;|";
		}
		
		// Intermediary and/or current page
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