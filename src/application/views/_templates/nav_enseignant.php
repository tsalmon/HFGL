<header>
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1>
            <a href="<?php echo URL; ?>Professor" id = "hfgl">Have fun - Good learning</a>
          </h1>
        </div>
      </div>

      <nav>
        <div id="menu_container">
          <ul class="sf-menu" id="toolbar">
              <li><a href="<?php echo URL; ?>Professor">Mes cours</a></li>
              <li><a href="<?php echo URL; ?>Professor/CreateCourse">Créer un cours</a></li>
              <li><a href="<?php echo URL; ?>Professor/Parametres">Parametrès du compte</a></li>
              <li><a href="<?php echo URL; ?>Professor/Deconnexion" onclick="return confirm('Êtes vous sûr de vous déconnecter?')">Déconnexion</a></li>
          </ul>
        </div>
      </nav>
</header>
