<?php
/* 
  memo:
  dans le tableaux de chapitres
  les documents ce sont les exercices (TP/Examens/Projets)
  et dans notes de cours: le cours de la matiere
*/
?>

<!--index fichier d'etudiant-->

<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
      <div id="welcome"><h3>Bienvenue</h3></div>

      <?php include("_templates/sidebar_left.php"); ?>
      
      <div class="content">
      <?php
          foreach($liste_cours as $cours){

            echo '<p><h1 id="'.$cours->title().'">'. $cours->title() .'</h1>';
            echo "<p>". $cours->description() ."</p>";
            echo "<h5>TODO: Enseignant: </h5>";
            echo "
              <h2>Les travaux</h2>
              <table style='width:100%; border-spacing:0;''>
                <tr><th>Matière</th> <th>Documents</th></tr>
            ";
                foreach ($cours->parts() as $part) {
                  echo '
                <tr>
                  <td>'.$part->title().'</td>
                  <td>';
                  foreach($part->chapters() as $chapter){
                    echo '<a target="blank" href="'.URL.'Courses/?cours='.strval($cours->courseID()).'&part='.strval($part->partID()).'&chp='.strval($chapter->chapterID()).'">'.$chapter->title().'</a>';
                  }
                 
                  echo '</td>';
                }
              echo '
                </tr>
                <tr><td>Projet</td> <td><a href="projet_memoire.html">Sujet de projet</a></td></tr>
                <tr><td>Examen</td> <td><a href="#">Feuille d examen</a></td></tr>
              </table>

              <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
              <a class="bouton" href="'.URL.'Courses/desinscription/?cours='.strval($cours->courseID()).'" name="name">Se desinscrire de ce cours</a>
              </p>

              <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
              </p>
              </p>'; 
            /*<input class="bouton" type="submit" name="name" value="Notes de cours"/>*/
            }
      ?>
      </div>
    </div>
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>  