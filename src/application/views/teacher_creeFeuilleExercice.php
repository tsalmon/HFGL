<!-- pour l'enseignant peut créer la feuille d'exercice (TP ou examen) link to Chapitre et Feuille d'examen-->
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>

    <div id="site_content">      
      <div class="content">
        <h1>Cours 1</h1>
        <h2>Partie 1 - Chapitre 1</h2>
        <h2>Créer la feuille d'exercices</h2>

        <form action="#" method="post">
          <div class="form_settings">
            <p><span>Date limite: </span><input type="text" name="name" value="" /></p>
            <p><span>Nombre de question: </span><input type="text" name="name" value="" /></p>
          </div>
        </form>

        <h3>Ajouter un question</h3>


        <form action="#" method="post">
          <div class="form_settings">
            <p><span>Type de question</span>
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
    <div id = "form_qrf">
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
    </div>
          </div>
        </form>

          <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Supprimer ce cours" /></p>
          <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
            <input class="bouton" type="submit" name="name" value="Note de cours" /></p>
      </div>
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>
