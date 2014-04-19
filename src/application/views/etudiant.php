<!--index fichier d'etudiant-->

<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

      <?php include("_templates/student_sidebar_left.php"); ?>
      
      <div class="content">
      <?php
        foreach($liste_cours as $cours){
            echo "<p><h1>". $cours->title(). "</h1>";
            echo "<h3>". $cours->description() ."</h3>";
            echo "<h5>(TODO)Enseignant: </h5>";
            
            echo '
            <h2>Les travaux</h2>
            <table style="width:100%; border-spacing:0;">
              <tr><th>Matière</th> <th>Documents</th></tr>
              <tr><td>part</td><td>taff</td></tr>
            </table>
            <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Se désinscrit ce cours" />
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