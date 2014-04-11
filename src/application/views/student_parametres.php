// Parametre du compte d'etudiant

<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
      <div id="welcome"><h3>Bienvenue</h3></div>
      <div class="content">
        <h1>Paramètre du compte</h1>
        <form action="#" method="post">
          <div class="form_settings">
            <p><span>Nom</span><input type="text" name="name" value="" /></p>
            <p><span>Prénom</span><input type="text" name="name" value="" /></p>
            <p><span>Email</span><input type="text" name="email" value="" /></p>
          </div>
        </form>

        <h3>Modifier le mot de passe</h3>
        <form action="#" method="post">
          <div class="form_settings">

            <p><span>Ancien mot de passe</span><input type="password" name="password" value="" /></p>
            <p><span>Nouveau mot de passe</span><input type="password" name="password" value="" /></p>
            <p><span>Confirmer nouveau mot de passe</span><input type="password" name="password" value="" /></p>
            
        
            <button type="button" class = "bouton">Modifier le mot de passe</button> 

          </div>
        </form>

        
      </div>
    </div>
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>