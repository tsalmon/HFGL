<div id="welcome"><h3>Bienvenue</h3></div>
<div id="sidebar_container">
  <div class="sidebar">
      <h3>Liste de cours</h3>
      <ul>
      		<?php
            if(isset($cours_teaching)){
              $liste_cours = $cours_teaching;
            }
            foreach($liste_cours as $cours){
              echo '<li><a href="#' . ($cours->title()) . '">'.($cours->title()).'</a></p>';
      			}
      		?>
		  </ul>
  </div>
</div>