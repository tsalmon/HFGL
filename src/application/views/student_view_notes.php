<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
      
      <div class="content">
        
        <h2>Les notes de tous les cours suivis</h2>
        <table style="width:100%; border-spacing:0;">
          <tr><th>Nom du cours</th> <th>TP</th><th>Projet</th><th>Examen</th><th>Note finale</th></tr>
          
         
            <?php
            if(isset($cours_teaching)){
              $liste_cours = $cours_teaching;
            }
            foreach($liste_cours as $cours){
              echo ' <tr>
                      <td>'.($cours->title()).'</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>';
            }
          ?>

         
        </table>
          
      </div>
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


