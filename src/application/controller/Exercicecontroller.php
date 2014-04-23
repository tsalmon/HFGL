<?php
class Exercicecontroller extends Controller{
    private $exerciseSheetModel;

    public function index()
    {
        $this->exerciseSheetModel = $this->loadModel('ExerciceSheet');
        $this->exerciseSheetModel->loadByID(1);
        $questions = $this->exerciseSheetModel->getQuestions();
        require 'application/views/_templates/header.php';
        require 'application/views/student_exercice.php';
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

    public function Exercice_result()
    {
        // $page = "exercice";
        foreach ($_POST as $key => $value) {
            echo "<script type='text/javascript'>alert('".$key." => ".$value."');</script>";
        }
    }
}