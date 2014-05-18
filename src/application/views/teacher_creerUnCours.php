<div id="main">
  <?php include("_templates/nav_enseignant.php"); ?>
  <div id="site_content">
      <?php include("_templates/bienvenue_title.php"); ?>

    <div class="content_big">
      <h1>Créer un cours</h1>
      <?php 
        if(isset($page) && $page == "error"){
          echo "<p>Le nom du cours existe déjà</p>";
        } 
      ?>
      <form action="<?php echo URL.'Professor/newCourse'; ?>" method="post">
        <div class="form_settings">
          <p><span>Nom du cours</span><input type="text" name="course_title" required/></p>
          <p><span> Description</span><textarea name="course_description" rows="10" cols="30" required></textarea></p>
        </div>
        <p class = "pbouton">
          <input class="bouton" type="submit" value="Créer Cours" />
        </p>
      </form>            
    </div>
    <div class="clearfooter"></div>
  </div>
  <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>
