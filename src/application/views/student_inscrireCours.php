<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

      <div id="welcome"><h3>Bienvenue</h3></div>

      <div class="content">
        <h2>Les suggestions de cours</h2>
        <?php
        foreach ($suggestions as $key => $value) {
        echo'
        <table style="width:100%; border-spacing:0;">
          <tr><th>Nom du cours</th> <th>enseigant</th><th>Description rapide</th> <th></th></tr>
          <tr>
            <td>'.$value->title().'</td> 
            <td>TODO</td>
            <td>'.$value->description().'</td>
            <td><input class="bouton" type="submit" name="name" value="S\'inscrit"/></td>
          </tr>
        </table>';
        }
        ?>          
      </div>
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


