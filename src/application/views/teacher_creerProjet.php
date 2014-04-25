<!-- pour l'enseignant peut créer la feuille d'exercice (TP ou examen) link to Chapitre et Feuille d'examen-->
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>

    <div id="site_content">

      <?php include("_templates/teacher_sidebar_left.php"); ?>
      

      <div class="content">
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
          
          <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Importer les notes de projet" /></p>
          
          <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Publier ce projet" /></p>
      </div>
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>
