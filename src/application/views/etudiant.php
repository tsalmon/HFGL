<div id="main">
    <?php include("nav_etudiant.php"); ?>
    <div id="site_content">
      <div id="welcome"><h3>Bienvenue echo nom d'étudiant</h3></div>
      <div id="sidebar_container">
        <div class="sidebar">
          <h3>Liste de cours</h3>
          <ul>
			<?php
			foreach ($liste_matiere as $key => $value) {
				echo "<li> <a href='#''>".$value."</a></li>";
			}
			?>
		</ul>
          </ul>
        </div>
      </div>
      <div class="content">
        <h1>Cours 1</h1>
        <h2>Déscriptions</h2>
        <h5>Enseignant: echo nom d'enseignant</h5>
        <h5>echo le déscription de cours</h5>
        <h2>Les travaux</h2>
        <table style="width:100%; border-spacing:0;">
          <tr><th>Matière</th> <th>Documents</th></tr>
          <tr><td>Partie 1</td> <td><a href="#">Chapitre 1</a><a href="#">Chapitre 2</a></td></tr>
          <tr><td>Partie 2</td> <td><a href="#">Chapitre 1</a><a href="#">Chapitre 2</a></td></tr>
          <tr><td>Projet</td> <td><a href="#">Sujet de projet</a></td></tr>
          <tr><td>Examen</td> <td><a href="#">Feuille d'examen</a></td></tr>
        </table>

        <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
        	<input class="bouton" type="submit" name="name" value="Se désinscrit ce cours" />
        </p>

        <a href="#Etudiant_Notesdecours.html">
           <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
           	<input class="bouton" type="submit" name="name" value="Notes de cours" />
           </p>
        </a>
      </div>
    </div>
    <div id="scroll">
      <a title="Scroll to the top" class="top" href="#"><img src="images/top.png" alt="top" /></a>
    </div>
    <footer>
      <p>
        <a href="Student">Mes cours</a> | 
        <a href="Student/Notes">Mes notes</a> |
        <a href="index.php?page=suggestions">S'incrire à un cours</a> | 
        <a href="Student/Parametres">Parametrès du compte</a>| <a href="#">Déconnexion</a>
      </p>
      <p>Copyright &copy; HFGL| <a href="#">design from M1 Info Paris 7</a></p>
    </footer>
</div>


