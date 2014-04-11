// index fichier d'etudiant

<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

      <?php include("student_sidebar_left.php"); ?>
      
      <div class="content">
        <h1>Cours 1</h1>
        <h2>Déscriptions</h2>
        <h5>Enseignant: </h5>
        <h5></h5>
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

        <a href="Student/NotesDeCours">
           <p style="padding-top: 15px; display: inline"><span>&nbsp;</span>
           	<input class="bouton" type="submit" name="name" value="Notes de cours" onclick="NotesDeCours"/>
           </p>
        </a>
      </div>
    </div>
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


