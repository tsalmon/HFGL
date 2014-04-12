// feuille d'exercise -- finish
<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
      
      <?php include("_templates/student_sidebar_left.php"); ?>

      <div class="content">
        
        <h5>Enseignant: </h5>
        <div id="div_scroll">
        	<h1>Feuille d'exercise</h1>
          <h4>Date limite: </h4>

            <p>
              //consulter les exercises de chaptrire
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

        <p style="padding-top: 15px; display: inline">
          <span>&nbsp;</span>
          <input class="bouton" type="submit" name="name" value="Soumettre" />
        </p>
          
      </div>
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


