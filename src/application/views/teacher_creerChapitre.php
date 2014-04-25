<!-- pour l'enseignant peut créer la feuille d'exercice (TP ou examen) link to Chapitre et Feuille d'examen-->
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>

    <div id="site_content">

      <?php include("_templates/teacher_sidebar_left.php"); ?>
      

      <div class="content">

        <h1>Cours 1</h1>
        <h2>Partie 1</h2>

        <p><span>Titre de chapitre </span><input type="text" name="name" value="" /></p>

        <h2>Créer la feuille d'exercices</h2>

        <form action="#" method="post">
          <div class="form_settings">
            <p><span>Date limite: </span><input type="text" name="name" value="" /></p>
            <p><span>Nombre de question: </span><input type="text" name="name" value="" /></p>
          </div>
        </form>

        <div id = "add_question">
          <h3>Ajouter un question</h3>

          <form action="#" method="post">

            <div class="form_settings">

              <p>
                <span>Type de question</span>

                <select name="cars">
                  <option id = "qcm">Question à choix multiple</option>
                  <option id = "qrf">Question à réponse formater</option>
                  <option id = "p">Question à réponse est un programme</option>
                  <option id = "l">Question à réponse libre</option>
                </select>   
                </br>(Choisir une type de question au début)
              </p>

              <div id = "form_qcm">
                  <p><span> Sujet </span><textarea rows="10" cols="30">Sujet d'exercice.</textarea></p>
                  <p><span> Réponses </span><input type="text-area" name="name" value="" /></p>
              </div>

              <!-- <div id = "form_qrf">
                  <p><span> Sujet </span><textarea rows="10" cols="30">Sujet d'exercice.</textarea></p>
                  <p><span> Réponses </span><input type="text-area" name="name" value="" /></p>
              </div>

              <div id = "form_p">
                  <p><span> Sujet </span><textarea rows="10" cols="30">Sujet d'exercice.</textarea></p>
                  <p><span> Réponses </span><input type="text-area" name="name" value="" /></p>
              </div>

              <div id = "form_l">
                  <p><span> Sujet </span><textarea rows="10" cols="30">Sujet d'exercice.</textarea></p>
                  <p><span> Réponses </span><input type="text-area" name="name" value="" /></p>
              </div> -->

            </div>
          </form>
            <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
              <input class="bouton" type="submit" name="name" value="Ajouter ce question" /></p>
        </div>  <!-- end div add_question -->
          
          <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Importer les notes de chapitre" /></p>

          <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Avant-première" /></p>
          <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
              <input class="bouton" type="submit" name="name" value="Enregistrer" /></p>
          <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
          
          <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Publier ce chapitre" /></p>
      </div>
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>
