<article id="middle">
	<form action="index.php" method="POST" id="middleform">
		<h1 id="hfgl">Bienvenue sur HFGL</h1>
		<p id="quote">Have Fun, Good Learning</p>
		<input type="hidden" value="inscription"/>
		<p>
			<input 	type="text" 
					placeholder="Entrez un pseudo" 
					name="inscr_name"
					required/>
		</p>
		<p>
			<input 	type="password" 
					placeholder="Mot de passe" 
					name="inscr_pwd"
					required/>
		</p>
		<p>
			<input 	type="password" 
					placeholder="Confirmez s'il vous plait" 
					name="inscr_pwd_confirm"
					required/>
		</p>
		<p>
			<input 	type="mail" 
					placeholder="adresse mail" 
					name="inscr_mail"
					required/>
		</p>
		<p>
			<input 	type="mail" 
					placeholder="Confirmez s'il vous plaît" 
					name="inscr_mail_confirm"
					required/>
		</p>		
		<input id="inscription" type="submit"/>
	</form>
</article>