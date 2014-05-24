<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

    <?php include("_templates/bienvenue_title.php"); ?>
      
      <div class="content_big">
        
        <h2>Les notes de tous les cours suivis</h2>
        <table>
          

          <tr>
            <th>Nom du cours</th> 
            <th>TPs</th> 
            <th>Projet</th>
            <th>Mémoire</th>
            <th>Examen</th>
            <th>Note finale</th>
          </tr>
          
            <?php
            foreach($results as $result){
             echo ' <tr>
                    <td>'.$result->course()->title().'</td>
                     <td>';
            foreach ($result->notes_tps() as $notes_tp) {
                      echo $notes_tp.", ";
                     };
                    echo '</td>
                     <td>'.$result->notes_projet().'</td>
                     <td>'.$result->notes_memoire().'</td>
                     <td>'.$result->notes_examen().'</td>
                    <td>'.$student->getMark($result->course()).'</td>
                 </tr>';
            }
          ?>
        </table>
          
      </div>
    <div class="clearfooter"></div>
      
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


