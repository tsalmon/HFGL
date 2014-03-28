<div id="main">
    <?php include("nav_etudiant.php"); ?>
	</ul>
	</nav>
	<article id="matiere_selectionner">
		<h2><?php echo ($liste_matiere[0]); ?></h2>
		<?php
		foreach ($list_part as $value) {
		?>
		<p>
			<h3><span class="nom_partie"><?php echo ($value); ?><span> <span class="avancement_partie">Avancement Partie</span></h3>
			<ul>
				<li>q</li>
			</ul>
		</p>
		<?php
				echo "<li>".$value."</li>";
		}
		?>

	</article>
</div>
