<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
<<<<<<< HEAD

      <?php include("_templates/bienvenue_title.php"); ?>
=======
      <div id="welcome"><h3>Bienvenue</h3></div>

>>>>>>> f5b7b21adece7fa7f25cc0ecbd4b320f90ec6848
      <div class="content_big">
        
        <h1><?php echo $chp->title(); ?></h1>
        <h3><?php echo $cours->title()." - ".$part->title(); ?></h3>

          <?php
            if(null != $chp->description()){
              echo '<h2>Description</h2>
                    <p id="description_chapitre">';
              echo $chp->description();
              echo '</p>';
            }
          ?>

        <div>

          <a class="bouton" href="<?php echo URL.''.($chp->courseNotes()->getURL());?>" name="name">Cours</a>
          <?php 
            $id_exo = $chp->exercices()->getID(); 
            if($id_exo != null){ //if there is an exercice
              echo '<a class="bouton" href="'.URL.'Exercice/'.$id_exo.'" name="name">Exercice</a>';
            }
          ?>
        </div>
        
      </div>
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>
<?php
?>