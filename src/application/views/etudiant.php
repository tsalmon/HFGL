<!-- toolbar -->
<?php include("navigation.php"); ?>
<div id="center">		
	<nav id="liste_matiere">
		<ul>
			<?php
			foreach ($liste_matiere as $key => $value) {
				echo "<li>".$value."</li>";
			}
			?>
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
