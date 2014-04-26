<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">
      <div class="content">
        <h3>Création d'exercice</h3>
        <p>Question n°</p>
        <form>
          <ul>
            <select>
              <option value="1">Texte</option>
              <option value="1">Radio</option>
              <option value="1">Check</option>
              <option value="1"></option>
            </select>
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

