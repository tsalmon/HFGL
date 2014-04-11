<!-- pour consulter les memoires ou les notes d'un cours -->

<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
      
      <?php include("_templates/student_sidebar_left.php"); ?>

      <div class="content">
        
        <h1>Notes de Cours 1</h1>
        <h5>Enseignant: </h5>
        <div id="div_scroll">
            <p>
              <!-- echo Les Notes ou les memoire de cours-->
            </p>
        </div>

        <a href="Student">
          <p style="padding-top: 15px; display: inline">
            <span>&nbsp;</span>
            <input class="bouton"  name="name" value="Traveaux de cours" />
          </p>
        </a>

        <p style="padding-top: 15px; display: inline">
          <span>&nbsp;</span>
          <input class="bouton" type="submit" name="name" value="Enregistrer" />
        </p>
          
      </div>
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


