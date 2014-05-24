<!-- pour l'enseignant peut créer la feuille d'exercice (TP ou examen) link to Chapitre et Feuille d'examen-->
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>

    <div id="site_content">  
      <?php include("_templates/bienvenue_title.php"); ?> 

      <div class="content_big">
        <h1>Cours 1</h1>
        <h2>Créer le projet de cours</h2>

        <form action="#" method="post">
          <div class="form_settings">
            <p><span>Date limite: </span><input type="text" name="name" value="" /></p>

            <span>Titre du projet </span>
            <input type="text" name="name" value="" /></br>

            <div>
              <h3>Contenu de projet</h3>
              <textarea id="project_body" rows="50" placeholder="Le sujet du projet..."></textarea>
            </div>

          </div>
        </form>
          
          <p class = "pbouton">
            <span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Importer les notes de projet" />
            <span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Publier ce projet" />
          </p>
      </div>
    <div class="clearfooter"></div>
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>
