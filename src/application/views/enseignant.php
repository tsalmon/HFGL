<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">
      <?php include("_templates/bienvenue_title.php"); ?>
      <?php include("_templates/sidebar_left.php"); ?>

      <div class="content">

        <?php 
        foreach ($cours_teaching as $key => $cours) {
          echo '<h1 id="'.$cours->title().'">'.$cours->title().'</h1>';
          echo '<p>'.$cours->description().'</p>
                <h2>Les travaux</h2>';
          echo '
          <table>
            <tr><th>Matière<a href="#'.($cours->title()).'" onclick=createPart('.$cours->courseID().');>[+]</a></td></th> <th>Documents</th></tr>';
            foreach ($cours->parts() as $part) {
                  echo '
                <tr>
                  <td>'.$part->title().'</td>
                  <td>';
                  foreach($part->chapters() as $chapter){
                    echo '<a target="blank" href="'.URL.'Courses/?cours='.strval($cours->courseID()).'&part='.strval($part->partID()).'&chp='.strval($chapter->chapterID()).'">'.$chapter->title().'</a>';
                  }                 
                  echo '<a href="'.URL.'Professor/CreateChapter/?cours='.strval($cours->courseID()).'&part='.strval($part->partID()).'">[+]</a></td>';
                }
          echo '
                </tr>
                <tr>
                  <td><a href="#">&nbsp</a></td>
                  <td><a href='.URL.'Professor/CreateChapter/?cours='.strval($cours->courseID()).'&part='.null.'>[+]</a></td>
                </tr>

                <tr>
                  <td>Projet</td>
                  <td><a href='.URL.'Professor/CreateProjet>[+]</a></td>
                </tr>

                <tr>
                  <td>Examen</td> 
                  <td><a href='.URL.'Professor/CreateExamen>[+]</a></td>
                </tr>
                <!-- <tr> si l`examen existe
                    <td>Examen</td> 
                    <td><a href='.URL.'Professor/Examen>Feuille de l`examen</a></td>
                    </tr> -->
          </table>
            <p class = "pbouton">
              <span>&nbsp;</span>
              <a href='.URL.'Professor/SupprimerCours/?cours='.$cours->courseID().'" class="bouton">Supprimer ce cours</a>
              <span>&nbsp;</span>
              <a href='.URL.'Professor/ViewNotes class="bouton">Consulter les notes</a>
            </p>
            ';
        }
        ?>
      </div>
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>

