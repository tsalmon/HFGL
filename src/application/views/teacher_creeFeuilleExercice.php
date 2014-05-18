<script src="/src/public/js/exercice.js"></script>
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">

      <?php include("_templates/bienvenue_title.php"); ?>
      
      <div id="createExercice" class="content_big">
        <form action="CreateExerciceFork" method="post" enctype="multipart/form-data">
          <fieldset>
            <legend><h2>Créer la nouvelle questionnaire</h2></legend>

            <div class="form_settings">
              <p><span>Description:</span>           
                <textarea name="description" placeholder="Description d'exercice" rows="10" cols="30"></textarea>
              </p>
              <p><span>Date d'accessibilité:</span>  
                <input type="text" name="dateaccess" placeholder="jj/mm/aaaa" value="" />
              </p>
              <p><span>Date limite:</span>           
                <input type="text" name="datelimite" placeholder="jj/mm/aaaa" value="" />
              </p>
              <p><span>Load from .xml</span>         
                <input type="checkbox" id="xmlOrNot" name="xmlOrNot" onclick="setForm();">
              </p>
            </div>

            <div id= "fromXML" class = "form_settings">
              <p><span>Fichier .xml contenant l'exercice</span>
                <input type="file" name="exerciceXML" enctype="multipart/form-data">
              </p>      
            </div>

            <p class = "pbouton"><span>&nbsp;</span>
              <input class="bouton" type="submit" name="name" value="Enregistrer" />
            </p>
          </fieldset>
        </form>
      </div>
      
    <div class="clearfooter"></div>

      </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>

