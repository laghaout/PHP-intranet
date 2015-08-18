<?php
include("session.php"); 

// Make sure a valid article ID has been passed via the URL
if(!isset($_GET['ART_ID']) || !is_numeric($_GET['ART_ID']))
	die("L'article que vous demandez n'existe pas (ID " . $_GET['ART_ID'] . ")");

include("connect_db.php");
$query = "SELECT * FROM ARTICLES WHERE ART_ID = " . $_GET['ART_ID'];
$result = mysql_query($query, $link);
echo mysql_error();
	
$row = mysql_fetch_object($result);

// Highlight keywods if any
if(isset($_GET['keywords']))
{
	$keyword_set = explode(' ', $keywords);
	foreach ($keyword_set as $keyword)
	{
		$row->ART_SOURCE = str_replace($keyword, "<em>" . $keyword . "</em>", $row->ART_SOURCE);
		$row->ART_TITLE = str_replace($keyword, "<em>" . $keyword . "</em>", $row->ART_TITLE);		
		$row->ART_TEXT = str_replace($keyword, "<em>" . $keyword . "</em>", $row->ART_TEXT);
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title><?php echo $row->ART_TITLE; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Author" content="Amine Laghaout">
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 0px;">
  <tr>
    <td><?php echo "<font size=\"1\">Article numéro $row->ART_ID</font>"; ?></td>
    <td align="right"><input name="button" type="button" onClick="window.print();" value="Imprimer" align="right"></td>
  </tr>
</table>
<?php
list($year, $month, $day, $hour, $minutes) = split('[- :]', $row->ART_DATE);
echo "<h2>$row->ART_TITLE</h2>"
	 . "Publié le <strong>$day-$month-$year</strong> sur ";

	if(strlen($row->ART_URL) > 9)
		echo "<U><a href=\"$row->ART_URL\" target=\"_blank\">$row->ART_SOURCE</a></U> ";
	else
		echo "<U>$row->ART_SOURCE</U> ";	 
		
echo ".<BR><BR>" . nl2br($row->ART_TEXT);	
?>
</body>
</html>