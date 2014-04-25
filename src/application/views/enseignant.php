<!-- l'acceuille d'enseigant -->
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>

    <div id="site_content">

      <?php include("_templates/sidebar_left.php"); ?>
      

      <div class="content">

        <?php 
        foreach ($cours_teaching as $key => $cours) {
          echo '<h1 id="'.$cours->title().'">'.$cours->title().'</h1>';
          echo '<p>'.$cours->description().'</p>
                <h2>Les travaux</h2>';
          echo '
          <table style="width:100%; border-spacing:0;">
            <tr><th>Matière</th> <th>Documents</th></tr>';
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
          echo '</table>
            <p style="padding-top: 15px; display: inline"><span>&nbsp;</span><a href='.URL.'Professor/SupprimerCours/?cours='.$cours->courseID().'" class="bouton" name="name">Supprimer ce cours</a></p>';
        }
        ?>
      </div>
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>

