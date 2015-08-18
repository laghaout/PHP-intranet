<?php
// Since the index page is by default a logout page, the session should be destroyed
// here, including the helper cookie
setcookie("USER_ID", " ", time() - 3600);
session_start();
session_destroy();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Intranet des Consultants r&eacute;gionaux des services de sant&eacute; en fran&ccedil;ais de l'Ontario</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Author" content="Amine Laghaout">
	<link type="text/css" href="style.css" rel="stylesheet">
</head>

<body onload="document.loginform.ID.focus()">
<?php 
// Feedback on possible error of identification
if(isset($_GET['errormsg']))
{
	$username = trim($_GET['username']);

	// The user exists but his user name if invalid
	if(!strcasecmp($_GET['errormsg'], "password"))
		$errormsg = "Votre mot de passe est incorrect";

	//  The user does not exist
	else
	{
		$errormsg = "Le nom d'usager <em>$username</em> n'existe pas";		
		$username = "";
	}

?>
<BR>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="5" class="errormsg">
  <tr>
    <td nowrap><strong><font color="#990000">Erreur</font></strong> : <?php echo $errormsg; ?>.</td>
  </tr>
</table>
<?php
}
?>
<BR>
<table width="300" height="125" border="0" align="center" cellpadding="0" cellspacing="0" background="images/identification.gif">
  <tr>
    <td><table width="300" height="125" border="0" align="center" cellpadding="0" cellspacing="5">
        <form action="login_action.php" method="post" name="loginform">
          <tr>
            <td height="25" align="right" style="font-size: 10pt; font-weight: bold; color: #FFFFFF;">&nbsp;</td>
            <td style="font-size: 10pt; font-weight: bold; color: #FFFFFF;"><p>&nbsp;</p>
            </td>
          </tr>
          <tr>
            <td align="right" nowrap><font color="#FFFFFF" size="2"><strong>Nom
                  d'usager</strong> :</font></td>
            <td>
              <input name="ID" type="text" id="ID" style="background-color: transparent; border: 1px #FFFFFF solid; color: #FFFFFF; font-weight: 600;  font-size: 10pt;" value="<?php echo $username; ?>" size="15" maxlength="15">
            </td>
          </tr>
          <tr>
            <td align="right" nowrap><font color="#FFFFFF" size="2"><strong>Mot
                  de passe</strong> :</font></td>
            <td><input name="PASSWD" type="password" id="PASSWD2" style="background-color: transparent; border: 1px #FFFFFF solid; color: #FFFFFF; font-weight: 600; font-size: 10pt;" size="15" maxlength="20">
            </td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td><input type="submit" name="Submit" value="Entrer" style="margin: 0px; border: 3px #00CCFF double; padding: 0px; background-color: #003366; color: #FFFFFF; font-size: 9pt; font-weight: bold;">
&nbsp;
              <input type="reset" name="Submit2" value="Effacer" style="margin: 0px; border: 3px #00CCFF double; padding: 0px; background-color: #003366; color: #FFFFFF; font-size: 9pt; font-weight: bold;">
            </td>
          </tr>
        </form>
      </table>
    </td>
  </tr>
</table>
<br>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="5" class="tablebox" style="font-size: xx-small;">
  <tr>
    <td align="right" valign="top"> <nobr>Oublié votre mot de passe ?</nobr><br>
      <nobr>Entrez votre courriel :</nobr> </td>
    <td width="10" valign="bottom">
      <form method="post" action="password_action.php" style="margin: 0px;">
        <input type="text" name="EMAIL" style="margin: 0px;">
      </form>
    </td>
  </tr>
</table>
<br>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="5" class="tablebox" style="font-size: xx-small;">
  <tr>
    <td><strong><font color="#990000">Remarque</font></strong> :
      Votre navigateur doit accepter les cookies et javascript.</td>
  </tr>
</table>
</body>
</html>
