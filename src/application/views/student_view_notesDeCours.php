<!-- pour consulter les memoires ou les notes d'un cours -->

<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
      <?php include("_templates/bienvenue_title.php"); ?>

      <div class="content_big">
        
        <h1>Notes de Cours 1</h1>
        <h5>Enseignant: </h5>
        <div id="div_scroll">
            <p>
              <!-- echo Les Notes ou les memoire de cours-->
            </p>
        </div>

        <a href="<?php echo URL; ?>Student/">
          <p class = "pbouton">
            <span>&nbsp;</span>
            <input class="bouton" value="Traveaux de cours" />
          </p>
        </a>

        <p class = "pbouton">
          <span>&nbsp;</span>
          <input class="bouton" type="submit" value="Enregistrer" />
        </p>
          
      </div>
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


