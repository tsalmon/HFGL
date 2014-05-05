<?php
$errors_inscr = false;
if(isset($_POST)){
	$errors_inscr = $_POST;
}
?>
<article id="middle">
	<form action="<?php echo URL; ?>Welcome/Inscription_result" method="POST" id="middleform">
		<p>
			<a href="<?php echo URL; ?>Welcome/"><h1 id="hfgl">Bienvenue sur HFGL</h1></a>
			 <span id="quote"> Have Fun, Good Learning</span>
		</p>
		<input type="radio" id="radio1" name="role" value="student" checked>
		<label for="radio1">Etudient</label>
		<input type="radio" id="radio2" name="role" value="teacher">
		<label for="radio2">Enseignent</label>
		<p>
			<input 	type="text" 
					placeholder="Entrez votre nom" 
					name="inscr_surname"
					<?php if($errors_inscr){ echo 'value="'.$_POST["inscr_surname"].'"'; } ?>
					required/>
			<label>
				<?php
					if($errors_inscr && isset($errors_inscr["usr_sn_regex"])){
						echo "Votre nom n'est pas correct.";
					}
				?>
			</label>
		</p>
		<p>
			<input 	type="text" 
					placeholder="Entrez votre prénom" 
					name="inscr_firstname"
					<?php if($errors_inscr){ echo 'value="'.$_POST["inscr_firstname"].'"'; } ?>
					required/>
			<label>
				<?php
					if($errors_inscr && isset($errors_inscr["usr_fn_regex"])){
						echo "Votre prénom n'est pas correct.";
					}
				?>
			</label>
		</p>
		<p>
			<input 	type="password" 
					placeholder="Mot de passe" 
					name="inscr_pwd"
					required/>
			<label>
				<?php
					if($errors_inscr && isset($errors_inscr["pwd_regex"])){
						echo "Votre votre mot de passe n'est pas correct.";
					}
					else if($errors_inscr && isset($errors_inscr["pwd_size"])){
						echo "Votre votre mot de passe n'est pas assez long.";
					}
				?>
			</label>
		</p>
		<p>
			<input 	type="password" 
					placeholder="Confirmez s'il vous plait" 
					name="inscr_pwd_confirm"
					required/>
			<label>
				<?php
					if($errors_inscr && isset($errors_inscr["pwd_diff"])){
						echo "Votre mot de passe n'a pas été confirmé.";
					}
				?>
			</label>
		</p>
		<p>
			<input 	type="mail"
					placeholder="adresse mail" 
					name="inscr_mail"
					<?php if($errors_inscr){ echo 'value="'.$_POST["inscr_mail"].'"'; } ?>
					required/>
			<label>
				<?php
					if($errors_inscr && isset($errors_inscr["mail_regex"])){
						echo "Votre adresse email n'est pas correcte.";
					} else if($errors_inscr && $errors_inscr["usr"]){
						echo "Votre adresse est déjà utilisée.";
					}
				?>
			</label>
		</p>
		<p>
			<input 	type="mail" 
					placeholder="Confirmez s'il vous plaît" 
					name="inscr_mail_confirm"
					<?php if($errors_inscr){ echo 'value="'.$_POST["inscr_mail_confirm"].'"'; } ?>
					required/>
			<label>
				<?php
					if($errors_inscr && isset($errors_inscr["mail"] ) ) {
						echo "Votre adresse email n'a pas été confirmé.";
					}
				?>
			</label>
		</p>		
		<input id="inscription" type="submit"/>
	</form>
</article>