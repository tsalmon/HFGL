<script src="../public/js/exercice.js"></script>
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">

      <?php include("_templates/bienvenue_title.php"); ?>

      <div id="addQuestion" class="content_big">

        <?php
          $qt_nb = ((!isset($_POST["nb_qt"])) ? 0 : $_POST["nb_qt"])+1;
        ?>
        
        <?php //Controller::print_dbg($_POST); ?>

        <form name="qtform" method="POST" enctype="multipart/form-data" action="<?php echo URL.'Professor/AddQuestion'?>" onsubmit="return testQCM();">
          <fieldset>
            <legend><h2>Question №<?php echo $qt_nb; ?></h2></legend>
            <input type="hidden" name="nb_qt" value="<?php echo $qt_nb; ?>"/>
            <table>
              <tr>
                <td>
                  Question
                </td>
                <td>
                  <span id="laquestion"><input type="text" name="question" placeholder="Contenu d'une question" required/></span>
                </td>
              </tr>
              <tr>
                <td>
                  Conseil
                </td>
                <td>
                  <input type="text" name="tip" placeholder="Indication" required/></span>
                </td>
              </tr>
              <tr>
                <td>
                  Points
                </td>
                <td>
                  <input type="number" name="points" min="1" max="100" step="1" value="1" required/></span>
                </td>
              </tr>            
              <tr>
                <td>
                  Reponse
                  <select name="lareponse" id="lareponse" onchange="rep()">
                    <option value="libre">
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
            <tr id="student_corrector">
                <td>Correction par pairs :</td>
                <td><input type="checkbox" id="student_corrector_box" name="student_corrector" value="student_corrector" /></td>
            </tr>  
            </table>          
            <ul >
              <li><input class="bouton" type="submit" name = "addQuestionAction" value="Finir sans valider"/></li>
              <li><input class="bouton" type="submit" name = "addQuestionAction" value="Valider et finir"/></li>
              <li><input class="bouton" type="submit" name = "addQuestionAction" value="Valider et continuer"/></li>
            </ul>
          </fieldset>
        </form>
      </div>
      
    <div class="clearfooter"></div>

    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>

