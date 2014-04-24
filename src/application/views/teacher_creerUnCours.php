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
              <p><span> Date début </span><input type="text-area" name="name" value="" /></p>
              <p><span> Date limite </span><input type="text-area" name="name" value="" /></p>
              <p><span> Désription rapide </span><textarea rows="10" cols="30"></textarea></p>
              <p><span> Ajouter Partie </span>
                <input type="text-area" name="name" value="" />
                <input class="bouton" type="submit" name="name" value="Ajouter" />
              </p>

              <p><span>Partie 1</span>
                <select name="cars">
                  <option id = "qcm">Chapitre 1</option>
                  <option id = "qrf">Chapitre 2</option>
                </select>  

                <input type="text-area" name="name" value="" />
                <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
                  <input class="bouton" type="submit" name="name" value="Ajouter chapitre" />
                </p>

              </p>

              <p><span>Partie 2</span>
                <select name="cars">
                  <option id = "qcm">Chapitre 3</option>
                </select>   

                <input type="text-area" name="name" value="" />
                <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
                  <input class="bouton" type="submit" name="name" value="Ajouter chapitre" />
                </p>

              </p>
          
            </div>
          </form>

            <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
              <input class="bouton" type="submit" name="name" value="Actualiser" /></p>
            <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
              <input class="bouton" type="submit" name="name" value="Créer" /></p>
        </div>
      </div>

      <?php include("_templates/nav_footer_enseignant.php"); ?>
  </div>
