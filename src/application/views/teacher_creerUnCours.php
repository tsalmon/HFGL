  <!-- pour l'enseignant peut créer la feuille d'exercice (TP ou examen) link to Chapitre et Feuille d'examen-->
  <div id="main">
      <?php include("_templates/nav_enseignant.php"); ?>

      <div id="site_content">
        <div class="content">
          <h1>Créer un cours</h1>
          <form action="<?php echo URL.'Courses/newCourse'; ?>" method="post">
            <div class="form_settings">
              <p><span>Nom du cours</span><input type="text" name="course_title" required/></p>
              <p><span> Description</span><textarea name="course_description" rows="10" cols="30" required></textarea></p>
            </div>
            <p style="padding-top: 15px; display: inline">
              <input class="bouton" type="submit" value="Créer Cours" /></p>
          </form>            
        </div>
      </div>
      <?php include("_templates/nav_footer_enseignant.php"); ?>
  </div>
