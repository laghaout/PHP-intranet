<?php include("session.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Ajouter un nouveau fichier</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Author" content="Amine Laghaout">
	<link type="text/css" href="style.css" rel="stylesheet">
</head>

<body onload="document.form.FIL_TITLE.focus()">
<?php include("header.php"); ?>

<table width="50%" border="0" align="center" cellpadding="1" cellspacing="3" class="forms">

<form action="ressources_action.php" method="post" ENCTYPE="multipart/form-data" name="form">
  <tr align="center" valign="middle">
    <th colspan="2">Ajouter un fichier</th>
    </tr>
  <tr bgcolor="#EEEEDF">
    <td valign="top">Titre</td>
    <td><input name="FIL_TITLE" type="text" id="FIL_TITLE" size="35" maxlength="35">
    </td>
  </tr>
  <tr>
    <td valign="top">Br&egrave;ve <br>
      description</td>
    <td><textarea name="FIL_DESC" cols="50" rows="4" wrap="hard" id="FIL_DESC"></textarea>
    </td>
  </tr>
  <tr bgcolor="#EEEEDF">
    <td>Fichier </td>
    <td><input name="FIL_NAME" type="file" id="FIL_NAME" size="30" maxlength="45">
      <font size="1">maximum: <blink><font color="#990000">2000</font></blink> KB</font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
	<input type="submit" name="Submit" value="Télécharger">
    <input type="reset" name="Submit2" value="Annuler" onClick="location.href='ressources.php'"></td>
  </tr>
</form>
</table>
<?php include("footer.php"); ?>
</body>
</html>