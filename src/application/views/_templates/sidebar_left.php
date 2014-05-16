<div id="sidebar_container">
  <div class="sidebar">
      <h3>Vos Courses</h3>
      <ul>
      		<?php
            if(isset($cours_teaching)){
              $liste_cours = $cours_teaching;
              foreach($liste_cours as $cours){
                echo '<li><a href="'.URL.'Professor/index/?cours='.($cours->courseID()).'">'.($cours->title()).'</a></p>';
              }
            } else {
              foreach($liste_cours as $cours){
                echo '<li><a href="'.URL.'Student/index/?cours='.($cours->courseID()).'">'.($cours->title()).'</a></p>';
              }
            }
            
      		?>
		  </ul>
  </div>
</div>