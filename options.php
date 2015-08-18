<?php include("session.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title><?php if(strcmp("admin", $_SESSION['ID'])) echo "Mes Options"; else echo "Administration"; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Author" content="Amine Laghaout">
	<link type="text/css" href="style.css" rel="stylesheet">
</head>

<body <?php if(strcmp("admin", $_SESSION['ID'])) echo "onload=\"document.form.old_password.focus()\""; ?>>
<?php include("header.php"); 

// Retreive the info about this user in order to prefill the form
include("connect_db.php");
$user_id = $_SESSION['ID'];
$result = mysql_query("SELECT * FROM USERS WHERE USR_ID = '$user_id'", $link);
echo mysql_error();
$row = mysql_fetch_object($result);

// Feedback
if(!strcmp("userupdate", $_GET['confirm']))
	echo "<table width=\"40%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\" class=\"results\"><tr align=\"center\"><td><strong>Vos informations ont été enregistrées avec succès.</strong></td></tr></table><BR>";

elseif(!strcmp("newuser", $_GET['confirm']))
	echo "<table width=\"40%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\" class=\"results\"><tr align=\"center\"><td><strong>Nouvel usager ajouté avec succès.</strong></td></tr></table><BR>";
?>

<table width="40%" border="0" align="center" cellpadding="1" cellspacing="3" class="forms">
  <form action="options_action.php" method="post" name="form">
  	<tr>
      <th colspan="2" align="center" valign="middle">Informations personnelles</th>
    </tr>
    <tr bgcolor="#EEEEDF">
      <td colspan="2" valign="top" style="font-weight: 100;">Les
        champs obligatoires sont marqu&eacute;s
          d'une
          &eacute;toile (<strong><font color="#FF0000" size="3">*</font></strong>).</td>
    </tr>
<?php 
// If this is not the administrator, allow to edit the name and last name
if(strcasecmp("admin", $_SESSION['ID']))
{
?>
    <tr>
      <td width="10">Pr&eacute;nom :</td>
      <td><input name="fname" type="text" id="fname" size="20" maxlength="25" value="<?php echo $row->USR_FNAME; ?>">
      <strong><font color="#FF0000" size="3">*</font></strong>      </td>
    </tr>
    <tr>
      <td>Nom :</td>
      <td>
	  <input name="lname" type="text" id="lname" size="20" maxlength="25" value="<?php echo $row->USR_LNAME; ?>">
      <strong><font color="#FF0000" size="3">*</font></strong>      </td>
    </tr>
<?php
}
// The administrator does not have a first/last name and isn't therefore allowed to modify if
else
{
?>
    <tr>
      <td>Nom :</td>
      <td>
	  <?php echo $row->USR_LNAME; ?>
	  <input name="lname" type="hidden" id="lname" value="<?php echo $row->USR_LNAME; ?>">
	  </td>
    </tr>
<?php
}
?>
    <tr>
      <td>Courriel :</td>
      <td><input name="email" type="text" id="email" size="20" maxlength="45" value="<?php echo $row->USR_EMAIL; ?>">
      <strong><font color="#FF0000" size="3">*</font></strong> </td>
    </tr>
    <tr>
      <td>Mot de passe :</td>
      <td><input name="old_password" type="password" id="old_password" size="20" maxlength="25">
      <strong><font color="#FF0000" size="3">*</font></strong>      </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#EEEEDF" style="font-weight: 100;">Pour changer votre mot de passe, entrez votre nouveau
          mot de passe dans les deux cases ci-dessous; sinon, laissez les vides.</td>
    </tr>
    <tr>
      <td nowrap>Nouveau mot de passe :</td>
      <td width="90%"><input name="new_password" type="password" id="new_password" size="20" maxlength="25">
      </td>
    </tr>
    <tr>
      <td>Nouveau mot de passe :</td>
      <td><input name="new_password2" type="password" id="new_password2" size="20" maxlength="25"> 
        [r&eacute;p&eacute;t&eacute;]
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td nowrap>
        <input type="submit" name="Submit" value="Modifier infos">
        <input type="reset" name="Submit2" value="Annuler">
      </td>
    </tr>
  </form>
</table>
<?php 


// The administrator has an additional form where he/she can 
// a) add new users
// b) view all the registered users
// c) ban/rehabilitate users
if(!strcasecmp("admin", $_SESSION['ID']))
{
	$result = mysql_query("SELECT * FROM USERS WHERE USR_ID != 'admin' ORDER BY USR_LNAME", $link);
	echo mysql_error();
?>
<BR>
<table border="0" align="center" cellpadding="1" cellspacing="2" class="forms">
  <!-- FORM FOR ADDING NEW USERS -->
  <form action="newuser_action.php" method="post">
    <tr>
      <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
          <th>Nouvel usager</th>
        </tr>
      </table>
      </td>
      <td align="right">&nbsp;</td>
      <td align="right">Nom d'usager :</td>
      <td><input name="USR_ID" type="text" id="USR_ID4" title="Ne doit contenir que des lettres minuscules (peut finir par un chiffre)." maxlength="20">
</td>
      <td align="right">Pr&eacute;nom :</td>
      <td width="10"><input name="USR_FNAME" type="text" id="USR_FNAME4">
</td>
    </tr>
    <tr>
      <td align="right"><input type="submit" name="Submit32" value="Ajouter usager"></td>
      <td align="right">&nbsp;</td>
      <td align="right">Courriel :</td>
      <td><input name="USR_EMAIL" type="text" id="USR_EMAIL4">
</td>
      <td align="right">Nom :</td>
      <td><input name="USR_LNAME" type="text" id="USR_LNAME4">
</td>
    </tr>
  </form>
</table>
<BR>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size: 10pt;">
  <tr>
    <td>Il y a pour l'instant <strong style="color: #003366;"><?php echo mysql_num_rows($result); ?></strong> usagers
d'inscrits.</td>
  </tr>
</table>
<BR>
<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1" class="results">
  <tr>
    <th nowrap>Nom, Pr&eacute;nom</th>
    <th align="center" nowrap>Actions</th>
    <th nowrap> Nom d'usager</th>
    <th nowrap>Courriel</th>
    <th align="center" nowrap>Derni&egrave;re connexion</th>
    <th align="center" nowrap>Connexions</th>
  </tr>
<?php
	// Display the users if any
	for($i = 0; $row = mysql_fetch_object($result); $i++)
	{
?>
  <tr bgcolor="<?php if($i % 2 == 0) echo "#EEEEEE"; else echo "#EEEEE0"; ?>">
    
	<!-- USER NAME -->
	<td>
	<?php 
	// Anchor to this user
	echo "<a name=\"$row->USR_ID\"></a>";
	
	// If the user has been banned, strike through his/her name
	if($row->USR_TYPE >= 0) 
		echo "$row->USR_LNAME, $row->USR_FNAME"; 
	else
		echo "<STRIKE>$row->USR_LNAME, $row->USR_FNAME</STRIKE>"; 
	?>
	</td>
	
	<!-- TOGGLE LINK: BAN/ALLOW USER -->
    <td align="center"><font size="1">
	<?php 
	if($row->USR_TYPE >= 0)
		echo "<a href=\"disableuser_action.php?user_id=$row->USR_ID\">suspendre</a>"; 
	else
		echo "[<a href=\"disableuser_action.php?user_id=$row->USR_ID\">réactiver</a>]"; 
	?></font>
    </td>
	
	<!-- USER LOGIN NAME -->
    <td><?php echo $row->USR_ID; ?></td>
	
	<!-- USER E-MAIL -->
	<td><?php echo "<a href=\"mailto:$row->USR_EMAIL\">$row->USR_EMAIL</a>"; ?></td>
	
	<!-- LAST LOGIN DATE/TIME -->
	<td align="center">
	<?php 
	if ($row->USR_LASTLOG != NULL) {
		list($year, $month, $day, $hour, $minutes) = split('[- :]', $row->USR_LASTLOG);
		if(checkdate($month, $day, $year))
			echo "$day-$month-$year à $hour" . "h$minutes";
	}
	?>
	</td>
	
	<!-- NUMBER OF TIME THE USER LOGGED IN -->
	<td align="center"><?php echo $row->USR_NBRLOG; ?></td>
  </tr>
<?php
	}
}
?>
</table>
<?php include("footer.php"); ?>
</body>
</html>
