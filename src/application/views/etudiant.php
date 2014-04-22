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
                  echo '                   
                      <a target="blank" href="'.URL.'Courses/?cours='.strval($cours->courseID()).'&part='.strval($part->partID()).'&chp='.strval($chapter->chapterID()).'">'.$chapter->title().'</a>
                  ';
                  }
                 
                  echo '</td>';
                }
              echo '
                </tr>
                <tr><td>Projet</td> <td><a href="projet_memoire.html">Sujet de projet</a></td></tr>
                <tr><td>Examen</td> <td><a href="#">Feuille d examen</a></td></tr>
              </table>
              ';
             
              echo '
              <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
              <input class="bouton" type="submit" name="name" value="Se desinscrire de ce cours" />
              </p>
              <a href="Student/NotesDeCours">
              <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
              <input class="bouton" type="submit" name="name" value="Notes de cours"/>
              </p>
              </a>
              </p>'; 
            }            
      ?>
      </div>
    </div>
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>  