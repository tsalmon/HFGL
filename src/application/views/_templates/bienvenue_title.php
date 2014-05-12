<?php
    if(isset($prof)){
        $person = $prof;
        echo '<div id="welcome"><h3>Bienvenue professeur '.$person->name().'</h3></div>';
    } else {
    	$person = $student;
        echo '<div id="welcome"><h3>Bienvenue étudiant '.$person->name().'</h3></div>';
    }
?>
