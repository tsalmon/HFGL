<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

      <div id="welcome"><h3>Bienvenue</h3></div>
      <div class="content_big">
        <?php print_r($liste_cours); ?>

        <h2>Les suggestions de cours</h2>
        <?php
        foreach ($suggestions as $key => $value) {
        echo'
        <table>
          <tr><th>Nom du cours</th> <th>enseigant</th><th>Description rapide</th> <th></th></tr>
          <tr>
            <td>'.$value->title().'</td> 
            <td>TODO</td>
            <td>'.$value->description().'</td>
            <td><a class="bouton" href="'.URL.'Student/suggestion_ok/?id='.$value->courseID().'" name="name" >S\'inscrire</a></td>
          </tr>
        </table>';
        }
        ?>          
      </div>
    </div>

    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


