<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

      <?php include("_templates/bienvenue_title.php"); ?>
      <div class="content_big">
        <h3><?php echo "Projet de cours ".$course->title(); ?></h3>

        <?php
          echo '<h2>Sujet du projet:</h2><p>';
          echo '<h3>Date limite: '.$project->getDeadline().'</h3>';
          if(null != $project->getDescription()){
            echo $project->getDescription();
          } else {
            echo 'A project description could be here. If it wasn\'t null...';
          }
          echo '</p>';
        ?>


        <div class="form_settings">
        <?php echo '<form method="post" action="'.URL.'Student/LoadProject" enctype="multipart/form-data">'; ?>
            <fieldset>
              <legend>Sousmission:</legend>
              <?php 
              echo '<input type="hidden" name="courseID" value="'.$course->courseID().'">';
              if ($soumis) {
                echo 'Vous avez déjà fait le rendu de ce projet';
              } else {
                echo '
                <p>
                  <span>Fichier .zip avec le rendu</span>
                  <input type="file" name="report" enctype="multipart/form-data">
                </p>
                <p>
                  <span>&nbsp;</span>
                  <input class="bouton" name="soumissionProjet" type="submit" value="Envoyer">
                </p>
                ';
              }
              ?>
            </fieldset>
          </form>
        </div>
        
      </div>
    <div class="clearfooter"></div>
      
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>
