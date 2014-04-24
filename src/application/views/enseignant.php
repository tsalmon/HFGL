<!-- l'acceuille d'enseigant -->
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>

    <div id="site_content">

      <?php include("_templates/student_sidebar_left.php"); ?>
      

      <div class="content">

        <?php 
        foreach ($cours_teaching as $key => $cours) {
          echo '<h1>'.$cours->title().'</h1>';
          echo '<p>'.$cours->description().'</p>
                <h2>Les travaux</h2>';
          echo '
          <table style="width:100%; border-spacing:0;">
            <tr><th>Matière</th> <th>Documents</th></tr>
            <tr><td>Partie 1</td> <td><a href="#">Chapitre 1</a><a href="#">Chapitre 2</a></td></tr>
            <tr><td>Partie 2</td> <td><a href="#">Chapitre 1</a><a href="#">Chapitre 2</a></td></tr>
            <tr><td>Projet</td> <td><a href="#">Sujet de projet</a></td></tr>
            <tr><td>Examen</td> <td><a href="#">Feuille d\'examen</a></td></tr>
          </table>
            <p style="padding-top: 15px; display: inline"><span>&nbsp;</span><input class="bouton" type="submit" name="name" value="Supprimer ce cours" /></p>
            <p style="padding-top: 15px; display: inline"><span>&nbsp;</span><input class="bouton" type="submit" name="name" value="Note de cours" /></p>';
        }
          //print_r($cours_teaching)        
        ?>
      </div>
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>

