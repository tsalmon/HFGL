<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

      <?php include("_templates/bienvenue_title.php"); ?>
      <div class="content_big">
        <h2>Les suggestions de cours</h2>
        <table>
          <tr><th>Nom du cours</th> <th>Enseigants</th><th>Description rapide</th> <th></th></tr>
        <?php
        foreach ($suggestions as $key => $value) {
        echo'
        
          <tr>
            <td>'.$value->title().'</td> 
            <td>';
            $profs = $value->getProfessors();
            foreach ($profs as $prof) {
              echo $prof->name();
            }
            echo '</td>
            <td>'.$value->description().'</td>
            <td><a class="bouton" href="'.URL.'Student/suggestion_ok/?cours='.strval($value->courseID()).'">S\'inscrire</a></td>
          </tr>';
        }
        ?>    

        </table>      
      </div>
      
    <div class="clearfooter"></div>

    </div>

    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


