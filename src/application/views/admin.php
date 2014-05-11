<div id="main">

    <?php include("_templates/nav_admin.php"); ?>

    <div id="site_content">      
      <div class="content">
      	<?php
      		if($page == "liste_student"){
      			echo "etudients";
      		} elseif($page == "liste_profs"){
      			echo "profs";
      		} elseif($page == "liste_courses"){
      			echo "courses";	
      		} else {
      			echo "accueil";
      		}
      	?>
      </div>
    </div>
</div>  