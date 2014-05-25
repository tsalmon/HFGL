<!-- pour l'enseignant peut créer la feuille d'exercice (TP ou examen) link to Chapitre et Feuille d'examen-->
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>

    <div id="site_content">  
      <?php include("_templates/bienvenue_title.php"); ?> 

      <div class="content_big" style="margin-left:150px">
        <h1>Création le projet de cours <?php echo $courseTitle;?></h1>

        <form action="SaveProject" method="post">
          <div class="form_settings">
            <p class="project"><span>Date d'accés:</span><input type="text" name="dateAvailable"  placeholder="jj/mm/aaaa"/></p>
            <p class="project"><span>Date limite: </span><input type="text" name="dateDeadline" placeholder="jj/mm/aaaa" /></p>
            <input type="hidden" name="courseID" value="<?php echo $_GET["courseID"];?>" />
            <div class="project">
              <h3>Sujet du projet</h3>
              <textarea name="assignment" rows="100" placeholder="Saisissez le sujet ici..."></textarea>
            </div>

          </div>
          <p>
            <span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Publier ce projet" />
          </p>
        </form>
      </div>
    <div class="clearfooter"></div>
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>
