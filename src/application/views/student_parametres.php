<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

      <div id="welcome"><h3>Bienvenue</h3></div>

      <div class="content">

        <h1>Paramètre du compte</h1>

         <?php echo '<form action="'.URL."Student/Parametres_result".'" method="POST">'; ?>
          <div class="form_settings">
            <p><span>Nom</span><input type="text" name="name" value=<?php echo("\"".$infos->name()."\""); ?> required/></p>
            <p><span>Prénom</span><input type="text" name="surname" value=<?php echo("\"".$infos->surname()."\""); ?> required/></p>
            <p><span>Email</span><input type="text" name="email" value=<?php echo("\"".$infos->email()."\""); ?> required/></p>
          </div>
          <p><input type="submit" class="bouton" value="changer parametre du compte"/></p>
        </form>

        <h3>Modifier le mot de passe</h3>
        
         <?php echo '<form action="'.URL."Student/ParametresPWD_result".'" method="POST">'; ?>
          <div class="form_settings">
            <p><span>Ancien mot de passe</span><input type="password" name="old_password" value="" /></p>
            <p><span>Nouveau mot de passe</span><input type="password" name="new_password" value="" /></p>
            <p><span>Confirmer nouveau mot de passe</span><input type="password" name="confirm_password" value="" /></p>          
          </div>
          <p><input type="submit" class="bouton" value="changer mot de passe"/></p>
        </form>

        
      </div>
    </div>
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>