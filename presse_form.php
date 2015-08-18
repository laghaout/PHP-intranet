<?php include("session.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Nouvelle manchette de presse</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Author" content="Amine Laghaout">
	<link type="text/css" href="style.css" rel="stylesheet">
</head>

<body onload="document.form.title.focus()">
<?php include("header.php"); ?>

<table border="0" align="center" cellpadding="1" cellspacing="3" class="forms">
<form action="presse_action.php" method="post" name="form">
  <tr>
    <th colspan="2" align="center" valign="middle" bgcolor="#EEEEDF">Ajouter un article de presse</th>
    </tr>
  <tr>
    <td>Titre</td>
    <td><input name="title" type="text" size="50" maxlength="80">
    </td>
  </tr>
  <tr bgcolor="#EEEEDF">
    <td nowrap>Publi&eacute; le</td>
    <td valign="middle">
		<select name="day_published">
		<?php
		for($day = 1; $day <= 31; $day++){
			if($day == date("d"))
				echo "<option value=\"" . $day . "\" selected>" . $day . "</option>";
			else
				echo "<option value=\"" . $day . "\">" . $day . "</option>";		
		}
		?>
		</select>
		<select name="month_published">
		<?php
		for($month = 1; $month <= 12; $month++){
			if($month == date("m"))
				echo "<option value=\"" . $month . "\" selected>" . $month . "</option>";
			else
				echo "<option value=\"" . $month . "\">" . $month . "</option>";		
		}
		?>
		</select>		
		<select name="year_published">
		<?php 
		for($year = date("Y"); $year >= date("Y") - 5; $year--){
			echo "<option value=\"" . $year . "\">" . $year . "</option>";		
		}
		?>
		</select>
	  <font size="1">[jour/mois/ann&eacute;e]</font>	</td>
  </tr>
  <tr>
    <td>Source</td>
    <td><input name="source" type="text" size="50" maxlength="50">
    </td>
  </tr>
  <tr bgcolor="#EEEEDF">
    <td>Adresse URL</td>
    <td><input name="source_url" type="text" id="source_url" value="http://" size="50">
      <font size="1">[facultatif]</font> </td>
  </tr>
  <tr>
    <td valign="top">Article</td>
    <td><textarea name="text" cols="50" rows="10"></textarea>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Poster">
      <input type="reset" name="Submit2" value="Annuler" onClick="location.href='presse.php'"></td>
  </tr>
</form>
</table>
<?php include("footer.php"); ?>
</body>
</html>