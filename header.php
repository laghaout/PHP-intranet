<table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/header.gif"
style="margin: 0px;">
  <tr>
    <td width="280"><strong><img src="images/ontario.gif" alt="Intranet des consultants r&eacute;gionnaux des services de sant&eacute; en fran&ccedil;ais" hspace="0" vspace="0" border="0" align="absmiddle"></strong></td>
    <td align="center"><table width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#EEEEEF"
style="
	border: 3px;
	font-size: 11px;
	text-decoration: none;
	border-color: #FFFFFF;
	border-bottom-style: double;
	border-top-style: double;
	border-left-style: double;
">
      <tr valign="top">
        <td width="20%" align="center" nowrap><a href="babillard.php" style="font-weight: bold;">Babillard</a><br>
      [<a href="babillard_form.php" style="font-weight: bold;">Ajouter un article</a>]</td>
        <td width="20%" align="center" nowrap><a href="ressources.php" style="font-weight: bold;">Ressources</a><br>
      [<a href="ressources_form.php" style="font-weight: bold;">Ajouter un fichier</a>]</td>
        <td width="20%" align="center" nowrap><a href="presse.php" style="font-weight: bold;">Manchettes</a><br>
      [<a href="presse_form.php" style="font-weight: bold;">Ajouter un article</a>]</td>
        <td width="15%" align="center" valign="middle"><a href="options.php" style="font-weight: bold;"> </a> <a href="options.php" style="font-weight: bold;">
          <?php 
		if(!strcasecmp("admin", $_SESSION['ID'])) 
			echo "Administration"; 
		else 
			echo "Options";
		?></a> </td>
        <td align="center" valign="middle"><a href="options.php" style="font-weight: bold;"> </a><a href="aide.php" style="font-weight: bold;">Aide</a></td>
        <td width="15%" align="center" valign="middle"><a href="index.php" style="font-weight: bold;" title="Fermer ma session">Quitter</a></td>
      </tr>
    </table>
</td>
  </tr>
</table>
<!---
<table width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#EEEEEF"
style="
	border: 3px;
	font-size: 12px;
	text-decoration: none;
	border-color: #FFFFFF;
	border-bottom-style: double;
	border-top-style: double;
">
<tr valign="top">
	    <td width="20%" align="center"><a href="babillard.php" style="font-weight: bold;">Babillard</a><br>
	    [<a href="babillard_form.php" style="font-weight: bold;">Ajouter un article</a>]</td>
	    <td width="20%" align="center"><a href="ressources.php" style="font-weight: bold;">Ressources</a><br>
	      [<a href="ressources_form.php" style="font-weight: bold;">Ajouter un fichier</a>]</td>
	    <td width="20%" align="center"><a href="presse.php" style="font-weight: bold;">Manchettes de presse</a><br>
		[<a href="presse_form.php" style="font-weight: bold;">Ajouter un article</a>]</td>
	    <td width="15%" align="center" valign="middle"><a href="options.php" style="font-weight: bold;">
	</a>    <a href="options.php" style="font-weight: bold;">
	<?php 
	/*
		if(!strcasecmp("admin", $_SESSION['ID'])) 
			echo "Administration"; 
		else 
			echo "Mes options";
			*/
		?></a>
		</td>
	    <td align="center" valign="middle"><a href="options.php" style="font-weight: bold;">
	    </a><a href="aide.php" title="Aide contextuelle" style="font-weight: bold;">Aide</a></td>
	    <td width="15%" align="center" valign="middle"><a href="index.php" style="font-weight: bold;" title="Fermer ma session">Quitter</a></td>
  </tr>
</table>
--->
<BR>