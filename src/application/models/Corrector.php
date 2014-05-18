<?php
interface Corrector{
    
    public function getQuestionsToCorrect();
    public function correctQuestion($questionID,$corrected_student_ID,$note);	
}

?>