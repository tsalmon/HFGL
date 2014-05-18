<script src="/src/public/js/exercice.js"></script>
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">

      <?php include("_templates/bienvenue_title.php"); ?>
      
<<<<<<< HEAD
      <div class="content_big">
        <h3>Création d'exercice</h3>
        <?php
          $qt_nb = (!isset($_POST["nb_qt"])) ? 1 : $_POST["nb_qt"] + 1;
        ?>
        <p>Question n°<?php echo $qt_nb; ?></p>
        <?php
          Controller::print_dbg($_POST);
        ?>
        <form name="qtform" method="POST" action="<?php echo URL.'Professor/CreateExercice'?>" onsubmit="return testQCM();">
          <input type="hidden" name="nb_qt" value="<?php echo $qt_nb; ?>"/>
          <table>
            <tr>
              <td>
                Question
              </td>
              <td>
                <span id="laquestion"><input type="text" name="question" required/></span>
              </td>
            </tr>
            <tr>
              <td>
                Conseil
              </td>
              <td>
                <input type="text" name="tip" required/></span>
              </td>
            </tr>
            <tr>
              <td>
                Points
              </td>
              <td>
                <input type="number" name="points" required/></span>
              </td>
            </tr>            
            <tr>
              <td>
                Reponse
                <select name="lareponse" id="lareponse" onchange="rep()">
                  <option value="free">
                    Réponse libre
                  </option>
                  <option value="checkbox">
                    QCM
                  </option>
                  <option value="lines">
                    QRF
                  </option>
                 <option value="code">
                    Programme
                  </option>
                </select>
                <input type="hidden" id="reponsenb" name="reponsenb" value="libre" />
              </td>
              <td name="thereponse" id="thereponse">
                <textarea disabled></textarea>
                <!--<input type="text" name="reponse" placeholder="ecrivez ici la réponse" required/>-->
              </td>
            </tr>
          </table>          
          <ul>
            <li><input type="submit" value="Valider et finir"/></li>
            <li><input type="submit" value="Valider et continuer"/></li>
            <?php
              if(false){ // todo
                echo '<li><input type="submit" value="Annuler la question et finir"/></li>';
              }
            ?>
          </ul>
=======
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
>>>>>>> 8038364d75adf69a86741c177b598c7d68e30be3
        </form>
      </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>

