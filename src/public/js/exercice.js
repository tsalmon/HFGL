function url(selectUrl) {
	url=selectUrl.options[selectUrl.SelectedIndex].value ;
	getElementById( 'eval ').action=url ;
	getElementById( 'eval ').submit() ;
}

function rep(){
	/*if(document.getElementById('lareponse').value=="text"){
		document.getElementById('thereponse').innerHTML='<input type= "text " name= "reponse "/ placeholder="ecrivez ici la réponse" required>';
		document.getElementById('reponses').value="1";
	}*/
	if(document.getElementById('lareponse').value=="textarea"){
		document.getElementById('laquestion').innerHTML='<input type="text" name="question" required/>';

		document.getElementById('thereponse').innerHTML='<textarea name="reponse" disabled></textarea>';
		document.getElementById('reponsetype').value="2";	
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
		document.getElementById('thereponse').innerHTML="L'eleve devra entrer un programme ici";
	}
}
function combien(string){
	var how = parseInt(document.getElementById('nombre').value);
	document.getElementById('thereponse').innerHTML='';
	for(i=0;i<how;i++){
		// si string = 3, c'est un checkbox , sinon c'est un radio
		if(string=="3"){
			document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+'<br /><input type= "text" placeholder="ecrivez la réponse possible" name= "r[]" required/><input type="checkbox"  name= "c'+i+'" />';
		}
		else{
			document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+'<br /><input type= "text" placeholder="ecrivez la bonne réponse" name="r[]" size="20" required/>';
		}
	}
	document.getElementById('reponsetype').value=string;
}	

