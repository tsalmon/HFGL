<div id="welcome"><h3>Bienvenue</h3></div>
<div id="sidebar_container">
  <div class="sidebar">
      <h3>Liste de cours</h3>
      <ul>
      		<?php
            foreach($liste_cours as $cours){
              echo "<li>" . ($cours->title()) . "</p>";
      			}
      		?>
		  </ul>
  </div>
</div>