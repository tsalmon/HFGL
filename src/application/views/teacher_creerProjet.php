<!-- pour l'enseignant peut créer la feuille d'exercice (TP ou examen) link to Chapitre et Feuille d'examen-->
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>

    <div id="site_content">     
<<<<<<< HEAD
      <?php include("_templates/bienvenue_title.php"); ?> 
=======
      <div id="welcome"><h3>Bienvenue</h3></div> 
>>>>>>> f5b7b21adece7fa7f25cc0ecbd4b320f90ec6848

      <div class="content_big">
        <h1>Cours 1</h1>
        <h2>Créer le projet de cours</h2>

        <form action="#" method="post">
          <div class="form_settings">
            <p><span>Date limite: </span><input type="text" name="name" value="" /></p>
            <p><span>Nombre de question </span><input type="text" name="name" value="" /></p>

            <span>Titre du projet </span>
            <input type="text" name="name" value="" />

            <span>Contenu de projet </span> </br>
            <textarea rows="20" cols="50"></textarea>

          </div>
        </form>
          
          <p class = "pbouton">
            <span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Importer les notes de projet" />
            <span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Publier ce projet" />
          </p>
      </div>
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>
