<?php
class Exercicecontroller extends Controller{

    public function index()
    {
        require 'application/views/_templates/header.php';
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


}