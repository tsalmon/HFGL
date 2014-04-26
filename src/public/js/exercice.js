function url(selectUrl) {
	url=selectUrl.options[selectUrl.SelectedIndex].value ;
	getElementById( 'eval ').action=url ;
	getElementById( 'eval ').submit() ;
}

function rep(){
	if(document.getElementById('lareponse').value=="text"){
		document.getElementById('thereponse').innerHTML='<input type= "text " name= "reponse "/ placeholder="ecrivez ici la réponse" required>';
		document.getElementById('reponses').value="1";
	}
	if(document.getElementById('lareponse').value=="textarea"){
		document.getElementById('thereponse').innerHTML='<textarea name= "reponse " disabled></textarea>';
		document.getElementById('reponsetype').value="2";	
	}
	if(document.getElementById('lareponse').value=="checkbox"){
		document.getElementById('thereponse').innerHTML='<select name= "nombre" id= "nombre" onchange="combien(3)"><option value="null">selection</option>';
		for(i=2;i<6;i++){
			document.forms.qtform.nombre.options[document.forms.qtform.nombre.options.length] = new Option(i,i); 
 		}
		document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+"</select>";
	}
	if(document.getElementById('lareponse').value=="radio"){
		document.getElementById('thereponse').innerHTML='<select name= "nombre" id= "nombre" onchange="combien(4)"><option value="null">selection</option>';
		for(i=2;i<6;i++){
			document.forms.qtform.nombre.options[document.forms.qtform.nombre.options.length] = new Option(i,i); 			
		}
		document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+"</select>";
	}
}
function combien(string){
	var how = parseInt(document.getElementById('nombre').value);
	document.getElementById('thereponse').innerHTML='';
	for(i=0;i<how;i++){
		// si string = 3, c'est un checkbox , sinon c'est un radio
		if(string=="3"){
			document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+'<br /><input type= "text " name= "r"+i+" "/><input type="checkbox"  name= "c" required/>';
		}
		else{
			document.getElementById('thereponse').innerHTML=document.getElementById('thereponse').innerHTML+'<br /><input type= "text " name= "r"+i+" "/><input type="radio" name= "c" required/>';
		}
	}
	document.getElementById('reponsetype').value=string;
}	

