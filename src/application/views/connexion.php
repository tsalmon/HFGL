<div id="middle">
	
	<form action="<?php echo URL; ?>Welcome/Connexion" method="POST" id="middleform">
		<a href="<?php echo URL; ?>Welcome/"><h1 id="hfgl">Bienvenue sur HFGL</h1></a>
		<p id="quote">Have Fun, Good Learning</p>
		<a id="inscription" href="<?php echo URL; ?>Welcome/inscription">s'inscrire</a>
		<input type="mail" name="user" id="username" placeholder="Entrez votre adresse email" >
        <input type="password" name="pwd" id="pwd" placeholder="Mot de passe" >
        <input type="submit" value="Connexion">
        <?php
        	if(isset($incorrect)){
        		echo "<p>Soit le mot de passe incorrect, soit vous n'êtes pas enregistré avec cette adresse<p>";
        	}
        ?>
	</form>
</div>