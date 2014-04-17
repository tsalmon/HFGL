<html>
<head>
</head>
<body>
<div id="wrapper">
	<?php include("_templates/nav_etudiant.php") ?>
	<div id="center">
		<article id="description">
			<h1>Nom du projet</h1>
			<p>présentation</p>
		</article>
		<form action="#" method="POST" id="envoyer">
			<div class="info" id="panneau_infos">
				<span class="info" id="date_finale">date finale<span>
				<span class="info" id="date_soutenance" >date soutenance</span>
				<span class="info" id="lieu_soutenance">lieu soutenance</span>
			</div>	
			<p>
				<label for="import_file">Importer zip/tar.gz</label>
				<input id="importe_file" type="file"/>
			</p>
			<textarea id="note_projet_memoire">Note concernant le projet ou la soutenance</textarea>
		</form>
	</div>
</div>
</body>
</html>