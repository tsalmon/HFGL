<!-- pour consulter sujet du projet de cours -->

<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
<<<<<<< HEAD

      <?php include("_templates/bienvenue_title.php"); ?>
=======
      <div id="welcome"><h3>Bienvenue</h3></div>

>>>>>>> f5b7b21adece7fa7f25cc0ecbd4b320f90ec6848
      <div class="content_big">
        
        <h1>Projet / Mémoire</h1>
        <h5>Enseignant: </h5>
        <h4>Date finale: </h4>

        <a href="#">Sujet du projet</a>
        <a href="#">Note du mémoire</a>

        <p style="padding-top: 15px; display: inline">
            <input class="bouton" type="submit" name="name" value="importer zip/tar.gz" />
        </p>
        <h4>Des fichiers sont importé: </h4>
        <p>Nom du fichier1</p>

        <a href="#">
          <p class = "pbouton">
            <span>&nbsp;</span>
            <input class="bouton" value="Traveaux de cours" />
          </p>
        </a>

        //quand click sur le bouton Rendre projet, la dernière fichier qui est importé va être soumettre. 
        <p class = "pbouton">
          <span>&nbsp;</span>
          <input class="bouton" type="submit" value="Rendre projet" />
        </p>
          
      </div>
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


