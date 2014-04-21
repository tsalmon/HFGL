<!--index fichier d'etudiant-->

<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

      <?php include("_templates/student_sidebar_left.php"); ?>
      
      <div class="content">
      <?php
          foreach($liste_cours as $cours){

            echo "<p><h1>". $cours->title(). "</h1>";
            echo "<p>". $cours->description() ."</p>";
            echo "<h5>TODO: Enseignant: </h5>";
            foreach ($cours->parts() as $part) {
              echo '<h2>'.$part->title().'</h2>';
              echo '<h3><a href="">Examen</a></h3>';
              
              echo '
              <h2>Chapitres</h2>
              <table style="width:100%; border-spacing:0;">
              <tr><th>Matière</th> <th>Documents</th></tr>';

              foreach($part->chapters() as $chapter){
                echo '<tr><td>nom chapitre</td><td>???</td></tr>';
              }
              echo '
              </table>
              <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
              <input class="bouton" type="submit" name="name" value="Se desinscrire ce cours" />
              </p>
              <a href="Student/NotesDeCours">
              <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
              <input class="bouton" type="submit" name="name" value="Notes de cours"/>
              </p>
              </a>
              </p>'; 
            }            
        }
      ?>
      </div>
    </div>
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>  