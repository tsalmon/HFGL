<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">
      <?php include("_templates/bienvenue_title.php"); ?>
      <?php include("_templates/sidebar_left.php"); ?>

      <div class="content">

        <?php 
        if ($currentCourse){
          echo '<h1 id="'.$currentCourse->title().'">'.$currentCourse->title().'</h1>';
          echo '<p>'.$currentCourse->description().'</p>
                <h2>Les travaux</h2>';
          echo '
          <table>
            <tr><th>Partie<a href="#'.($currentCourse->title()).'" onclick=createPart('.$currentCourse->courseID().');>[+]</a></td></th> <th>Documents</th></tr>';
            foreach ($currentCourse->parts() as $part) {
                  echo '
                <tr>
                  <td><a href="#" onclick="deletePart('.$currentCourse->courseID().','.$part->partID().',\''.$part->title().'\',\''.$currentCourse->title().'\')";>[-]</a>'.$part->title().'</td>
                  <td>';
                  foreach($part->chapters() as $chapter){
                    echo '<a target="blank" href="'.URL.'Professor/AfficherCours/?cours='.strval($currentCourse->courseID()).'&part='.strval($part->partID()).'&chp='.strval($chapter->chapterID()).'">'.$chapter->title().'</a>';
                  }                 
                  echo '<a href="'.URL.'Professor/CreateChapter/?cours='.strval($currentCourse->courseID()).'&part='.strval($part->partID()).'">[+]</a></td>';
                }
          echo '
                <tr>
                  <td>Projet</td>
                  <td><a href='.URL.'Professor/CreateProjet>[+]</a></td>
                </tr>

                <tr>
                  <td>Examen</td> 
                  <td><a href='.URL.'Professor/CreateExamen/?cours='.strval($currentCourse->courseID()).'>[+]</a></td>
                </tr>
                <!-- <tr> si l`examen existe
                    <td>Examen</td> 
                    <td><a href='.URL.'Professor/Examen>Feuille de l`examen</a></td>
                    </tr> -->
          </table>
            <p class = "pbouton">
              <span>&nbsp;</span>
              <a href='.URL.'Professor/SupprimerCours/?cours='.$currentCourse->courseID().'" class="bouton">Supprimer ce cours</a>
              <span>&nbsp;</span>
              <a href='.URL.'Professor/ViewNotes class="bouton">Consulter les notes</a>
            </p>
            ';
        } else {
            $this->printQuestionValidate($id);
        }
        ?>
      </div>
    <div class="clearfooter"></div>
      
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>
