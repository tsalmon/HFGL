<header>
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1>
            <a href="<?php echo URL; ?>Admin">Have fun&nbsp;<span class="logo_colour">- Good learning</span></a>
          </h1>
        </div>
      </div>

      <nav>
        <div id="menu_container">
          <ul class="sf-menu" id="toolbar">
              <li><a href="<?php echo URL; ?>Admin">Liste des étudiants</a></li>
              <li><a href="<?php echo URL; ?>Admin">Liste des professeurs</a></li>
              <li><a href="<?php echo URL; ?>Admin">Liste des cours</a></li>
              <li><a href="<?php echo URL; ?>Admin/Deconnexion" onclick="return confirm('Êtes vous sûr de vous déconnecter?')">Déconnexion</a></li>
          </ul>
        </div>
      </nav>
</header>
