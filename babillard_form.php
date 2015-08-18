<?php include("session.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Nouvel article de babillard</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Author" content="Amine Laghaout">
	<link type="text/css" href="style.css" rel="stylesheet">
</head>

<body onLoad="document.form.title.focus()">
<?php include("header.php"); ?>

<table width="50%" border="0" align="center" cellpadding="1" cellspacing="3" class="forms">
<form action="babillard_action.php" method="post" name="form">
  <tr align="center" valign="middle">
    <th colspan="2">Poster un article</th>
    </tr>
  <tr>
    <td valign="top">Titre</td>
    <td><input name="title" type="text" size="50" maxlength="80">
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
	<input type="submit" name="Submit" value="Poster" class="button">
    <input type="reset" name="Submit2" value="Annuler" onClick="location.href='babillard.php'"></td>
  </tr>
</form>
</table>
<?php include("footer.php"); ?>
</body>
</html>
