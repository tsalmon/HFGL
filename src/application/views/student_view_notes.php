<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

    <?php include("_templates/bienvenue_title.php"); ?>
      
      <div class="content_big">
        
        <h2>Les notes de tous les cours suivis</h2>
        <table>
          <tr><th>Nom du cours</th> <th>Note finale</th></tr>
          
         
            <?php
            if(isset($cours_teaching)){
              $liste_cours = $cours_teaching;
            }
            foreach($liste_cours as $cours){
              echo ' <tr>
                      <td>'.($cours->title()).'</td>
                      <td>'.$student->getMark($cours).'</td>
                    </tr>';
            }
          ?>

         
        </table>
          
      </div>
    <div class="clearfooter"></div>
      
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


