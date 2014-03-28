<?php
class Exercicecontroller extends Controller{
    private $exerciseSheetModel;

    public function index()
    {
        $exerciseSheetModel = $this->loadModel('ExerciseSheet');
        require 'application/views/_templates/header.php';
        $this->showExerciseSheet();
        require 'application/views/_templates/footer.php';
    }

	public function Liste(){
		require 'application/views/_templates/header.php';
        require 'application/views/_templates/footer.php';
	}
    public function Rendre($exercice_id){
        require 'application/views/_templates/header.php';
        require 'application/views/_templates/footer.php';
    }

	public function DoExercise($exercice_id){
		require 'application/views/_templates/header.php';
        require 'application/views/_templates/footer.php';
	}


    public function showExerciseSheet(){
        foreach($this->exerciseSheetModel->questions as $question) {
            echo $question->getAssignment().'<br/>';
            echo '<form action="">';
            $curanswers = $question->getAnswers();
            foreach($curanswers as $answer) {
                if($question instanceof QCMQuestion)
                {
                    echo '<input type="checkbox" name="checkboxanswer" value="val">'.$answer->getContent().'<br>';
                }
                else if($question instanceof QRFQuestion || $question instanceof LQuestion || $question instanceof PQuestion)
                {
                    echo '<input type="text" name="textanswer" placeholder="Your answer...">';
                }
                else
                {
                    throw new Exception("Undefined question type");
                }
            }
            echo '</form>';
            echo '<br/>';
        }
    }


}