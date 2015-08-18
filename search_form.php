<!-- SEARCH ENGINE -->
<table width="100" border="0" align="center" cellpadding="0" cellspacing="5" class="tablebox">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="margin: 0px;" name="keywordsearch">
  <tr valign="middle">
    <td nowrap style="font-size: 10pt;">
	<input type="text" name="keywords" value="<?php echo $keywords; ?>">
	&nbsp;
	<input type="submit" value="Chercher">
	</td>
    <td align="center" nowrap style="font-size: xx-small;" title="Recherche de la séquence exacte des mots-clés.">
	<input type="checkbox" name="exactsearch" <?php if($_POST['exactsearch']) echo "checked"; ?>>
	</td>
    <td nowrap style="font-size: xx-small;" title="Recherche de la séquence exacte des mots-clés.">Recherche<BR>rigide
	</td>
  </tr>
  </form>
</table>
<br>