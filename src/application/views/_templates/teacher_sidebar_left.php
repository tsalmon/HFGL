<!-- menu left pour l'enseigant -->

<div id="welcome"><h3>Bienvenue</h3></div>
<div id="sidebar_container">
  <div class="sidebar">
      <h3>Liste de cours</h3>
      <ul>
      		<?php
      			foreach ($liste_matiere as $key => $value) {
      				echo "<li> <a href='#''>".$value."</a></li>";
      			}
      		?>
		  </ul>
  </div>
</div>