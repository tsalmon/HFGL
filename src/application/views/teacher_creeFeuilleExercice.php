<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">
      <div class="content">
        <h3>Création d'exercice</h3>
        <p>Question n°<?php if(!isset($_POST["nb_qt"])){ echo "1";}else{ echo (intval($_POST["nb_qt"])+1);}?></p>
        <?php
        ?>
        <form name="qtform" method="POST" action="<?php echo URL.'Professor/CreateExercice'?>">
          <input type="hidden" name="nb_qt" value="<?php if(!isset($_POST["nb_qt"])){ echo "1";}else{ echo (intval($_POST["nb_qt"])+1);}?>"/>
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
                Reponse
                <select name="lareponse" id="lareponse" onchange="rep()">
                  <option value="textarea">
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
                <input type="hidden" id="reponsetype" name="reponsetype" value="textarea" />
              </td>
              <td id="thereponse">
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

