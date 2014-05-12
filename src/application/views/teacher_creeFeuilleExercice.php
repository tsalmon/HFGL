<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">
<<<<<<< HEAD
      <?php include("_templates/bienvenue_title.php"); ?>
=======
      <div id="welcome"><h3>Bienvenue</h3></div>
>>>>>>> f5b7b21adece7fa7f25cc0ecbd4b320f90ec6848
      
      <div class="content_big">
        <h3>Création d'exercice</h3>
        <?php
          $qt_nb = 1;//(!isset($_POST["nb_qt"])) ? 1 : $_POST["nb_qt"];
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
        </form>
      </div>
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>

