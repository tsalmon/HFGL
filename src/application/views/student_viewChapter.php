<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

      <?php include("_templates/bienvenue_title.php"); ?>
      <div class="content_big">
        <h1><?php echo $chp->title(); ?></h1>
        <h3><?php echo $cours->title()." - ".$part->title(); ?></h3>

        <?php
          var_dump($chp->courseNotes());
          echo '<h2>Description</h2><p id="description_chapitre">';
          if(null != $chp->description()){
            echo $chp->description();
          } else {
            echo 'A chapter description could be here. If it wasn\'t null...';
          }
          echo '</p>';
          //echo '<iframe src="'.$chp->courseNotes()->getURL().'" height="1000" seamless/>';
          //echo 'Votre navigateur ne supporte pas des iframes. Pensez de le changer!';
          //echo '</iframe>';
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
