<div id="main">

    <?php include("_templates/nav_admin.php"); ?>

    <div id="site_content">      
      <div class="content">
      	<?php
      		if($page == "liste_student"){
      			echo "<h1>Liste des étudiants</h1>";
      			echo "<table>";
      			foreach ($students as $key => $value) {
      				echo '<tr><td>'.$students[$key]["name"].'</td><td><a href="delete/?type=student&id='.$students[$key]["personID"].'">Supprimer</a></td></tr>';
      			}
      			echo "</table>";
      		} elseif($page == "liste_profs"){
      			echo "<h1>Liste des enseignents</h1>";
      			echo "<table>";
      			foreach ($profs as $key => $value) {
      				echo '<tr><td>'.$profs[$key]["name"].'</td><td><a href="delete/?type=prof&id='.$profs[$key]["personID"].'">Supprimer</a></td></tr>';
      			}
      			echo "</table>";
      		} elseif($page == "liste_courses"){
      			echo "<h1>Liste des Cours</h1>";
      			echo "<table>";
      			foreach ($courses as $key => $value) {
      				echo '<tr><td>'.$value.'</td><td><a href="delete/?type=cours&id='.$value.'">Supprimer</a></td></tr>';
      			}
      			echo "</table>";
      		} else {
      			echo "accueil";
      		}
      	?>
      </div>
    </div>
</div>  