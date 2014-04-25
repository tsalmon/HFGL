  <!-- pour l'enseignant peut créer la feuille d'exercice (TP ou examen) link to Chapitre et Feuille d'examen-->
  <div id="main">
      <?php include("_templates/nav_enseignant.php"); ?>

      <div id="site_content">
        <div id="welcome"><h3>Bienvenue</h3></div>

        <div class="content">
          <h1>Créer un cours</h1>


          <form action="#" method="post">
            <div class="form_settings">
              <p><span> Nom du cours </span><input type="text-area" name="name" value="" /></p>
              <p><span> Date de début </span><input type="text-area" name="name" value="" /></p>
              <p><span> Date de fin </span><input type="text-area" name="name" value="" /></p>
              <p><span> Désription rapide </span><textarea rows="10" cols="30"></textarea></p>
              
          
            </div>
          </form>

            <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
              <input class="bouton" type="submit" name="name" value="Actualiser" /></p>
            <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
              <input class="bouton" type="submit" name="name" value="Créer Cours" /></p>
        </div>
      </div>

      <?php include("_templates/nav_footer_enseignant.php"); ?>
  </div>
