<!-- pour teacher peut créer un examen d'un cours -->
<script type="text/javascript">
  window.onload = function defaultOpt(){
    if(document.getElementById('xmlOrNot').checked){
      document.getElementById("fromXML").style.display='block';
      document.getElementById("add_question").style.display='none';
    }
    else{
      document.getElementById("fromXML").style.display='none';
      document.getElementById("add_question").style.display='block';
    }
    document.getElementById("form_qcm").style.display='block';
    document.getElementById("form_qrf").style.display='none';
    document.getElementById("form_p").style.display='none';
    document.getElementById("form_l").style.display='none';
    document.getElementById("sujet").style.display='block';
  };

  function addTest(){
    alert("Add test!");
  };

  function changeOpt(){
    var typeSelect = document.getElementById("questionType");
    var optID = typeSelect.options[typeSelect.selectedIndex].id;
    if (optID == "qcm") {
      document.getElementById("form_qcm").style.display='block';
      document.getElementById("form_qrf").style.display='none';
      document.getElementById("form_p").style.display='none';
      document.getElementById("form_l").style.display='none';
      document.getElementById("sujet").style.display='block';
    } else 
    if (optID == "qrf") {
      document.getElementById("form_qcm").style.display='none';
      document.getElementById("form_qrf").style.display='block';
      document.getElementById("form_p").style.display='none';
      document.getElementById("form_l").style.display='none';
      document.getElementById("sujet").style.display='block';
    } else 
    if (optID == "p") {
      document.getElementById("form_qcm").style.display='none';
      document.getElementById("form_qrf").style.display='none';
      document.getElementById("form_p").style.display='block';
      document.getElementById("form_l").style.display='none';
      document.getElementById("sujet").style.display='block';
    } else 
    if (optID == "l") {
      document.getElementById("form_qcm").style.display='none';
      document.getElementById("form_qrf").style.display='none';
      document.getElementById("form_p").style.display='none';
      document.getElementById("form_l").style.display='block';
      document.getElementById("sujet").style.display='block';
  };
}
</script>

<div id="main">
  <?php include("_templates/nav_enseignant.php"); ?>

  <div id="site_content">

    <?php include("_templates/bienvenue_title.php"); ?>    

    <div class="content_big">
      <h1>Cours 1</h1>

      <form action="CreateExerciceWithXML" method="post" enctype="multipart/form-data">
      <fieldset>
        <legend><h2>Créer la feuille de l'examen</h2></legend>

        <input type="checkbox" id="xmlOrNot" onclick="setForm();">Load from .xml<br>

        <div class="form_settings">
          <p><span>Date limite: </span><input type="date" name="name" value="" /></p>
          <p><span>Nombre de question: </span><input type="text" name="name" value="" /></p>
        </div>

        <div id= "fromXML" class = "form_settings">
          <p><span>Fichier .xml contenant l'exercice</span>
            <input type="file" name="exerciceXML" enctype="multipart/form-data">
          </p>      
        </div>

        <p class = "pbouton"><span>&nbsp;</span>
          <input class="bouton" type="submit" name="name" value="Avant-première" />
          <input class="bouton" type="submit" name="name" value="Enregistrer" />
          <input class="bouton" type="submit" name="name" value="Publier cet examen" />
        </p>
      </fieldset>
      </form>

      <div id = "add_question">

            <form action="#" enctype="multipart/form-data" method="post">
              <fieldset>
                <legend><h3>Ajouter un question</h3></legend>
                <div class="form_settings">

                  <p>
                    <span>Type de question</span>

                    <select id="questionType" onChange="changeOpt()">
                      <option id = "qcm">Question à choix multiple</option>
                      <option id = "qrf">Question à réponse formater</option>
                      <option id = "p">Question à réponse est un programme</option>
                      <option id = "l">Question à réponse libre</option>
                    </select>   

                    </br>(Choisir une type de question au début)
                  </p>

                  <p id="sujet"><span> Sujet </span><textarea rows="10" cols="30">Sujet d'exercice.</textarea></p>

                  <div id = "form_qcm">
                    <p><span> Réponses </span><input type="text-area" name="name" value="" /></p>
                  </div>

                  <div id = "form_qrf">
                    <p><span> Réponses </span><input type="text-area" name="name" value="" /></p>
                  </div>

                  <div id = "form_p">
                    <p>
                      <p style="margin-left:3em;">Votre fichier make prend comme un parametre un source avec un tel nom</p>
                      <span>Nom de fichier source</span><input type="text-area" name="source" value="" />

                      <p style="margin-left:3em;">Votre fichier make produit un fichier executable avec un tel nom</p>
                      <span>Nom de fichier executable</span><input type="text-area" name="executable" value="" /><br/><br/>

                      <span>Fichier "make"</span><input type="file" id="makefile" enctype="multipart/form-data">
                      <p style="margin-left:3em;">Chaque test a un format:` "input", "output" `</p>
                      <span>Fichier .csv de tests</span><input type="file" id="tests" enctype="multipart/form-data">
                    </p>
                  </div>

                  <div id = "form_l">
                  </div>

                </div><!-- end div form_settings -->

                <p style="padding-top: 15px; display: inline" align="center"><span>&nbsp;</span>
                  <input class="bouton" type="submit" name="name" value="Ajouter ce question" align="right"/>
                </p>
              </fieldset>
            </form>

          </div>  <!-- end div add_question -->
    </div>
  </div>

  <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>
