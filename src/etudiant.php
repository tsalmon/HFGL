<html>
<head>
</head>
<body>
<div id="wrapper">
	<? include("navigation.php"); ?>
	<div id="center">		
		<nav id="">
			<ul id="liste_matiere">
				<?php
					echo '<li><div><h3>Matiere 1</h3><span>avancement</span></div></li>';
				?>
			</ul>
		</nav>
		<article id="matiere_selectionner">
			<h2>Nom Matière</h2>
			<p>
				<h3><span class="nom_partie">Nom Partie<span><span class="avancement_partie">Avancement Partie</span></h3>
				<ul>
					<li>Exercice / Chapitre en cours</li>
					<li>Exercice / Chapitre précédent</li>
					<li>Exercice / Chapitre précédent</li>
					<li>Exercice / Chapitre précédent</li>
					<li>Exercice / Chapitre précédent</li>
				</ul>
			</p>
			<p>
				<h3><span class="nom_partie">Nom Partie a Faire	<span><span class="avancement_partie">Avancement Partie</span></h3>
			</p>
			<p>
				<h3><span class="nom_partie">Nom Partie a Faire	<span><span class="avancement_partie">Avancement Partie</span></h3>
			</p>
			<p>
				<h3><span class="nom_partie">Nom Partie finie<span><span class="avancement_partie">Avancement Partie</span></h3>
				<ul>
					<li><a href="index.php?page=projet_memoire&id=0">Projet a rendre</a></li>
					<li><Exercice / Chapitre terminé</li>	
					<li>Exercice / Chapitre terminé</li>
					<li>Exercice / Chapitre terminé</li>
				</ul>
			</p>

		</article>
	</div>
</div>
</body>
</html>