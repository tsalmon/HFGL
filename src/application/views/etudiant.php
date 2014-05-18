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
      
      <?php include("_templates/bienvenue_title.php"); ?>

      <?php include("_templates/sidebar_left.php"); ?>
      
      <div class="content">

      <?php
          if ($currentCourse){

            echo '<fieldset>
        <legend><h1 id="'.$currentCourse->title().'">'. $currentCourse->title() .'</h1></legend>';
            echo "<p>". $currentCourse->description() ."</p>";
            $profs = $currentCourse->getProfessors();
            echo "<h5> Enseignant(s): ";
            foreach ($profs as $prof) {
              echo $prof->name();
            }
            echo "</h5>";
            echo "
              <h2>Les travaux</h2>
              <table>
                <tr><th>Partie</th> <th>Documents</th></tr>
            ";
                foreach ($currentCourse->parts() as $part) {
                  echo '
                <tr>
                  <td>'.$part->title().'</td>
                  <td>';
                  foreach($part->chapters() as $chapter){
                    echo '<a target="blank" href="'.URL.'Student/AfficherCours/?cours='.strval($currentCourse->courseID()).'&part='.strval($part->partID()).'&chp='.strval($chapter->chapterID()).'">'.$chapter->title().'</a>';
                  }
                 
                  echo '</td>';
                }
              echo '
                </tr>
                <tr><td>Projet</td> <td><a href="projet_memoire.html">Sujet de projet</a></td></tr>
                <tr><td>Examen</td> <td><a href="#">Feuille d examen</a></td></tr>
              </table>

              <p class = "pbouton"><span>&nbsp;</span>
              <a class="bouton" href="'.URL.'Student/desinscription/?cours='.strval($currentCourse->courseID()).'"">Se desinscrire de ce cours</a>
              </fieldset>'; 
            } else {
              echo 'write something in hear for student';
            }
      ?>
      </div>
    <div class="clearfooter"></div>
    </div>
    <?php include("_templates/nav_footer_etudiant.php"); ?>
    
</div>  