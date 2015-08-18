<?php include("session.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Aide</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Author" content="Amine Laghaout">
	<link type="text/css" href="style.css" rel="stylesheet">
</head>

<body onLoad="document.form.title.focus()">
<?php include("header.php"); ?>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#EEEEEF" style="font-weight: bold; font-size: 10pt; border: 2px #FFFFFF; border-bottom-style: solid; border-top-style: solid;">
  <tr align="center">
    <td width="25%"><a href="#babillard">Babillard</a></td>
    <td width="25%"><a href="#ressources">Ressources</a></td>
    <td width="25%"><a href="#manchettes">Manchettes de presse</a></td>
    <td><a href="#options">
	<?php if(strcmp("admin", $_SESSION['ID'])) echo "Mes options"; else echo "Administration";?>
	</a></td>
  </tr>
</table>
<BR>
<table width="80%" border="0" align="center" cellpadding="10" cellspacing="0" bgcolor="#EEEEEF" style="font-size: 10pt; border: 2px #FFFFFF; border-right-style: solid; border-left-style: solid;">
  <tr>
    <td><h3><a name="babillard"></a>Babillard</h3>
      <p><span class="lettrine">L</span>e babillard (<em>web forum</em>) permet
        aux usagers de r&eacute;diger des articles ou des commentaires, de
        poser des questions aux autres usagers, ou de partager des id&eacute;es.
        Les interventions des usagers sont post&eacute;es par ordre
        chronologique d&eacute;croissant et sont dispos&eacute;es
        sur une table avec :</p>      
      <ol>
        <li>Le titre de l'article (intervention) ;</li>
        <li>L'auteur de l'article avec un son lien courriel
        ainsi que l'heure et la date de sa publication ;</li>
        <li>Le nombre de r&eacute;ponses/commentaires
        que les autres usagers ont ajout&eacute; &agrave; cet article ;</li>
        <li>L'auteur
          de la r&eacute;ponse/du commentaire le plus r&eacute;cent &agrave; cet
        article.</li>
      </ol>
    <p>Seuls les articles les plus r&eacute;cents sont post&eacute;s sur
      la premi&egrave;re page. Pour acc&eacute;der &agrave; des interventions
    plus anciennes, cliquez sur <em>Page suivante</em> au bas de la page.</p>
    <p>Pour ajouter un message sur le babillard, cliquez sur <em>Ajouter
      un article</em> sur la barre de navigation. Vous serez dirig&eacute;s
      vers une page avec deux champs de textes  pour faire la saisie
      de votre texte. Notez que les champs de textes ne peuvent pas &ecirc;tre
      laiss&eacute;s vides.</p>
    <p> Pour commenter ou r&eacute;pondre &agrave; un article, cliquez sur le lien
      de son titre &agrave; partir du babillard. Juste en dessous de l'article
      principal, entrez votre commentaires &agrave; partir du formulaire intitul&eacute; <em>Poster
      un commentaire</em>. Une fois que votre commentaire a &eacute;t&eacute; saisi,
      cliquez sur le bouton <em>Poster</em>. Votre commentaire devrait alors
      appara&icirc;tre
      en t&ecirc;te des autres commentaires dans le tableau intitul&eacute; <em>R&eacute;ponses
      et commentaires</em> (ces derniers sont post&eacute;s par ordre chronologique
      d&eacute;croissant).</p></td>
  </tr>
  <tr>
    <td><h3><a name="ressources"></a>Ressources</h3>
    <p><span class="lettrine">C</span>ette section permet aux usagers de partager des documents (Word, Excel,
      PDF, images, etc.) entre eux. Chaque usager peut, &agrave; partir de son
      ordinateur personnel, t&eacute;l&eacute;charger en amont (<em>upload</em>) un fichier
      (<em>file</em>) qui pourra &ecirc;tre ensuite t&eacute;l&eacute;charg&eacute; en
      aval (<em>download</em>) par les autres usagers en cliquant simplement sur le
      titre du fichier.</p>
    <table width="95%" border="0" align="center" cellpadding="0" cellspacing="4" style="font-size: 10pt; border: 1px #990000; border-bottom-style: solid; border-top-style: solid;">
      <tr valign="top">
        <td nowrap><p><strong><font color="#990000">Important :</font></strong></p>
          </td>
        <td>Les capacit&eacute;s du serveur du <acronym title="Regroupement des intervenantes francophones en santé et en services sociaux de l'Ontario"><a href="../" target="_blank">RIFSSSO</a></acronym> limitent
          les t&eacute;l&eacute;chargements &agrave; <strong><font color="#990000">2000
          KB</font></strong> (soit environ <font color="#990000"><strong>1,9
          MB</strong></font>).
          &Agrave; titre comparatif, un document Word de 400 pages de texte <em>sans
          graphiques</em> p&egrave;se environ 2000 KB. Tout fichier d&eacute;passant
          2000 KB ne sera pas t&eacute;l&eacute;charg&eacute;.</td>
      </tr>
    </table>    
    <p> Pour ajouter un fichier. Cliquez sur <em>Ajouter un fichier</em> puis, &agrave; partir
      du formulaire, d&eacute;crivez votre fichier. Il est important de d&eacute;crire
      votre fichier de fa&ccedil;on pr&eacute;cise et concise pour &eacute;pargner
      aux autres usagers d'avoir &agrave; t&eacute;l&eacute;charger le document
      pour savoir de quoi il traite. Le champ du titre est  cependant facultatif.</p>
    <p>Pour identifier le fichier que vous voulez t&eacute;l&eacute;charger, cliquez sur [<strong>Browse...</strong>]
      (ou [<strong>Choose File</strong>] sous Apple/Macintoch). Le processus
      est ensuite le m&ecirc;me
      que pour n'importe quel fichier sous Windows via la fen&ecirc;tre intitul&eacute;e <em>Choose
      a file</em>.</p>
    <p>Pour finir, cliquez sur [<strong>T&eacute;l&eacute;charger</strong>]. Une p&eacute;riode
      d'attente devrait alors &ecirc;tre n&eacute;cessaire et pourrait &ecirc;tre
      plus au moins longue en fonction de la vitesse de votre connexion. Une
      fois de plus, assurez vous de ne pas t&eacute;l&eacute;charger des documents
      d&eacute;passant 2000 KB.</p>
    <p>Si un fichier devient obsol&egrave;te, l'usager qui l'a mis en ligne est
      alors responsable de le supprimer pour ne pas encombrer la section des
      ressources. Il lui suffira de cliquer sur le lien [<strong>Supprimer</strong>]      &agrave; la
      fin de la description du fichier.</p>
    <p>Seuls les fichiers les plus r&eacute;cents sont post&eacute;s sur
      la premi&egrave;re page. Pour acc&eacute;der &agrave; des documents
    plus anciens, cliquez <em>Page suivante</em> au bas de la page.</p></td>
  </tr>
  <tr>
    <td><h3><a name="manchettes"></a>Manchettes de presse</h3>
    <p>      <span class="lettrine">T</span>outes sortes de publications ne contenant
      que du texte (sans images), peuvent &ecirc;tre lues et ajout&eacute;es
      &agrave; cette section. Un exemple typique serait si vous trouvez un article
      sur un journal publi&eacute; en
      ligne qui pourrait int&eacute;resser les membres de l'intranet.</p>
    <p>Les articles sont dispos&eacute;s deux par deux par ordre chronologique
      d&eacute;croissant de leur date de publication. Le titre est en gras. La
      source est soulign&eacute;e et suivie de la date de publication (jour-mois-ann&eacute;e).
      Les deux ou trois premi&egrave;res lignes de l'article sont aussi visibles.
      Pour lire l'article en entier sous format imprimable, cliquez sur <em>Lire
      l'article</em>.</p>
    <p> Pour ajouter un article, cliquez sur <em>Ajouter un article</em> en
      dessous de <em>Manchettes</em>. Tous les champs du formulaire <em>Ajouter
      un article de presse</em> vers lequel vous serez men&eacute; sont obligatoires.
      T&acirc;chez s'il vous pla&icirc;t de bien mentionner la <strong>source</strong> et
      la
      <strong>date exacte de publication</strong> de l'article en question. La
      date de publication est format&eacute;e par jour-mois-ann&eacute;e. Il
      est &eacute;galement possible de sp&eacute;cifier l'adresse URL de la source si elle
      est disponible (facultatif). Avec le processus Copier-Coller, collez l'article
      que vous avez copi&eacute; dans
      le champ intitul&eacute; <em>Article</em>. Cliquez sur [<strong>Poster</strong>]
      pour finir.</p>
    <p>Tout comme pour les fichiers sur la section <em>Ressources</em>, il est
      recommand&eacute; &agrave; l'usager qui a ajout&eacute; un article de le
      supprimer une fois que ce dernier deviendra obsol&egrave;te en cliquant
      sur [<strong>Supprimer</strong>].</p>
    <p>Notez qu'&agrave; chaque article est associ&eacute; un num&eacute;ro unique
      pour r&eacute;f&eacute;rence rapide. Il suffit de s&eacute;lectionner le
      num&eacute;ro de l'article via la liste d&eacute;roulante &agrave; droite
      du moteur de recherche pour acc&eacute;der directement &agrave; un article particulier.</p>
    <p>Seulement les articles les plus r&eacute;cents sont post&eacute;s sur
      la premi&egrave;re page. Pour acc&eacute;der &agrave; des articles de presse
       plus anciens, cliquez <em>Page suivante</em> au bas de la
    page.</p></td>
  </tr>
  <tr>
    <td><a name="options"></a>
	
	<?php
	if(!strcmp("admin", $_SESSION['ID']))
	{
	?>
      <h3>Administration</h3>
      <p><span class="lettrine">E</span>n tant qu'administrateur, il vous est possible de g&eacute;rer les
        comptes de tous les autres usagers. Sous cette section,
      un tableau liste les informations relatives &agrave; chaque usager :</p>
      <ul>
        <li> Nom et pr&eacute;nom (ordre alphab&eacute;tique) ;</li>
        <li> Adresse courriel ;</li>
        <li> Heure et date de la connexion la plus r&eacute;cente &agrave; l'intranet
          ;</li>
        <li> Nombre total de connexions.</li>
      </ul>      
      <p>Une colonne, intitul&eacute;e <em>Actions</em>, permet &agrave; l'administrateur
        d'alterner le statut d'un usager entre <em>activ&eacute;</em> et <em>suspendu</em>.
        Les usagers <em>actifs</em> on droit d'acc&egrave;s &agrave; l'intranet.
        Les usagers <em>suspendus</em> garderont leur compte dans la banque
        de donn&eacute;es mais ne pourront plus se connecter &agrave; l'intranet.
        Cette option permet donc de g&eacute;rer
        les droits d'acc&egrave;s &agrave; l'intranet.</p>      
      <p>L'option la plus importante dont dispose l'administrateur lui permet
        d'<strong>ajouter des usagers</strong> (cf. le formulaire <em>Nouvel usager</em> en
        dessous de <em>Informations personnelles</em>). </p>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="4" style="font-size: 10pt; border: 1px #990000; border-bottom-style: solid; border-top-style: solid;">
        <tr valign="top">
          <td nowrap><p><strong><font color="#990000">Remarques :</font></strong></p>
          </td>
          <td><ol style="margin-bottom: 0px;">
            <li> Tous les champs sont obligatoires et le courriel doit &ecirc;tre
                  correct. Deux usagers ne peuvent avoir le m&ecirc;me nom d'usager.
              Il en va de m&ecirc;me pour le courriel. </li>
            <li> Le nom d'usager ne
                  doit contenir que des lettres minuscules (sans espaces, accents,
                  tr&eacute;mas, ou autres caract&egrave;res
                  sp&eacute;ciaux). La convention
      qui devrait &ecirc;tre utilis&eacute;e consiste de la premi&egrave;re lettre
      du pr&eacute;nom
      suivie du nom (ex: <font face="Courier New, Courier, mono">jtremblay</font> pour
      Jean Tremblay).</li>
          </ol>
          </td>
        </tr>
      </table>      
      <p>Cliquer sur [<strong>Ajouter usager</strong>] pour ex&eacute;cuter l'op&eacute;ration.
        Un message sera envoy&eacute; &agrave; l'usager par courriel o&ugrave; elle
        ou il recevra un mot de passe g&eacute;n&eacute;r&eacute; automatiquement
        (ce processus est invisible pour l'administrateur).</p>
      <p>Il est d&eacute;conseill&eacute; d'utiliser le compte
        d'administrateur pour faire des interventions sur le babillard ou poster
        des fichiers sur les ressources car les autres usagers ne pourront pas
        vous identifier (seul le nom <em>Administrateur</em> appara&icirc;tra).
        Il vous est cependant possible de modifier le mot de passe et l'adresse
        courriel de l'administrateur avec le formulaire <em>Information
        personnelles</em>.</p>      
	  <?php 
	  }
	  else
	  {
	  ?>
      <h3>Mes options</h3>
      <p><span class="lettrine">C</span>ette section vous permet de changer votre
        mot de passe ou votre adresse courriel. Il vous est &eacute;galement
        possible de corriger d'&eacute;ventuelles erreurs dans votre nom ou pr&eacute;nom.      </p>
      <p>Les quatre premiers champs (nom, pr&eacute;nom, courriel, mot de passe)
        sont obligatoires. Si vous d&eacute;sirez modifier votre mot de passe,
        r&eacute;p&eacute;tez votre nouveau mot de passe dans les deux derni&egrave;res
    cases. Cliquez sur <em>Modifier Infos</em> pour finir.</p>
      <?php 
	}
	?>
	</td>
  </tr>
</table>
<?php include("footer.php"); ?>
</body>
</html>
