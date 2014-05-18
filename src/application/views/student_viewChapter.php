<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

      <?php include("_templates/bienvenue_title.php"); ?>
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

         
          <?php 
            if (null !== ($chp->courseNotes())) {
              echo '<a class="bouton" href="'.URL.'Student/NotesDeCours'.$chp->courseNotes()->getURL().'">Cours</a>';
            }

            if (null !== ($chp->exercices())) {
              $id_exo = $chp->exercices()->getID(); 
              if($id_exo != null){ //if there is an exercice
                echo '<a class="bouton" href="'.URL.'Student/DoExercice/?chp='.$chp->chapterID().'&cours='.$cours->title().'&part='.$part->title().'&chptname='.$chp->title().'">Exercice</a>';
              }
            }
          ?>
        </div>
        
      </div>
    <div class="clearfooter"></div>
      
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>
