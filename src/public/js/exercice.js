
function setForm(){
	if(document.getElementById('xmlOrNot').checked){
      document.getElementById("fromXML").style.display='block';
    }
    else{
      document.getElementById("fromXML").style.display='none';
    }
}

function testQCM(){
	if(document.forms.qtform.lareponse.value != "checkbox"){
		return true;
	}
	var nb_checkbox = document.getElementById("reponsenb").value;
	var no_check = true;
	var responses = [];
	for(i = 0; i < nb_checkbox; i++){
		if(document.getElementById('c'+i).checked){
            no_check = false;
        }
        responses.push(document.getElementById('r'+i).value);
	}	
	if(no_check){
		alert("Vous devez cocher au moins une case");
		return false;
	}
	return uniqueResponse(responses);
}

function uniqueResponse(responses){
	responses.sort();
	for (var i = 0; i < responses.length - 1; i++) {
    	if (responses[i + 1] == responses[i]) {
    		alert("Il ne doit pas y avoir de doublons dans les réponses d'un QCM");
    		return false;
    	}
	}
	return true;
}

function url(selectUrl) {
	url=selectUrl.options[selectUrl.SelectedIndex].value ;
	getElementById( 'eval ').action=url ;
	getElementById( 'eval ').submit() ;
}

function rep(){
	if(document.getElementById('lareponse').value=="libre"){
		document.getElementById('laquestion').innerHTML='<input type="text" name="question" required/>';

		document.getElementById('thereponse').innerHTML='<textarea name="reponse" disabled></textarea>';
	}
	if(document.getElementById('lareponse').value=="checkbox"){
		document.getElementById('laquestion').innerHTML='<input type="text" name="question" required/>';

		document.getElementById('thereponse').innerHTML='<select name= "nombre" id= "nombre" onchange="combien(3)"><option value="null">selection</option>';
		for(i=2;i<=20;i++){
			document.forms.qtform.nombre.options[document.forms.qtform.nombre.options.length] = new Option(i,i); 
 		}
		document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+"</select>";
	}
	if(document.getElementById('lareponse').value=="lines"){
		document.getElementById('laquestion').innerHTML='<input type="text" name="question" required/>';

		document.getElementById('thereponse').innerHTML='<select name= "nombre" id= "nombre" onchange="combien(4)"><option value="null">selection</option>';
		for(i=1;i<=20;i++){
			document.forms.qtform.nombre.options[document.forms.qtform.nombre.options.length] = new Option(i,i); 			
		}
		document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+"</select>";
	}
	if(document.getElementById('lareponse').value=="code"){
		document.getElementById('laquestion').innerHTML='<textarea name="question" placeholder="ecrivez ici la question" required></textarea>';
		document.getElementById('thereponse').innerHTML='<p>Votre fichier make prend comme u<br>n parametre un source avec un tel nom<br> Nom de fichier source<br><input type="text-area" name="source"/></p>';
		document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+'<p>Votre fichier make produit un fichier executable avec un tel nom<br> Nom de fichier executable <br><input type="text-area" name="executable"/></p>';
		document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+'<p>Fichier make<br><br><input type="file" name="makefile" enctype="multipart/form-data"></p>';
		document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+'<p>Chaque test a un format:` "input", "output" ` <br> Fichier .csv de tests <br> <input type="file" name="tests" enctype="multipart/form-data"></p>';	
	}
}
function combien(string){
	var how = parseInt(document.getElementById('nombre').value);
	document.getElementById('thereponse').innerHTML='';
	for(i=0;i<how;i++){
		// si string = 3, c'est un checkbox , sinon c'est un radio
		if(string=="3"){
			document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+'<br /><input type= "text" placeholder="ecrivez la réponse possible" id="r'+i+'" name= "r[]" required/><input type="checkbox" id=c'+i+' name= "c'+i+'" />';
		}
		else{	
			document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+'<br /><input type= "text" placeholder="ecrivez la bonne réponse" id="r'+i+'" name="r[]" size="20" required/>';
		}
	}
	document.getElementById('reponsenb').value=how;
}	

window.onload = function viewWillLoad(){
	document.getElementById("createExercice").style.display='inline';
	document.getElementById("addQuestion").style.display='none';
	document.getElementById('xmlOrNot').checked = false;
    setForm();
};

