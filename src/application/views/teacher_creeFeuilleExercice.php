<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">
      <div class="content">
        <h3>Création d'exercice</h3>
        <p>Question n°<?php if(!isset($_POST["nb_qt"])){ echo "1";}else{ echo (intval($_POST["nb_qt"])+1);}?></p>
        <form name="qtform" method="$_POST" action="<?php echo URL.'Professor/CreateExercice'?>">
          <input type="hidden" name="nb_qt" value="<?php if(!isset($_POST["nb_qt"])){ echo "1";}else{ echo (intval($_POST["nb_qt"])+1);}?>"/>
          <table>
            <tr>
              <td>
                Question
              </td>
              <td>
                <input type="text" name="question" required/>
              </td>
            </tr>
            <tr>
              <td>
                Reponse
                <select name="lareponse" id="lareponse" onchange="rep()">
                  <option value="text">
                    text
                  </option>
                  <option value="textarea">
                    textarea
                  </option>
                  <option value="checkbox">
                    checkbox
                  </option>
                  <option value="radio">
                    radio
                  </option>
                </select>
                <input type="hidden" id="reponsetype" name="reponsetype" value="text" />
              </td>
              <td id="thereponse">
                <input type="text" name="reponse" placeholder="ecrivez ici la réponse" required/>
              </td>
            </tr>
            <tr>
              <td><input type="submit"/></td>
              <td><input type="reset"/></td>
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

