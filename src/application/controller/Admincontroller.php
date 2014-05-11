<?php
class Admincontroller extends Controller{
	public function index(){
		$page="index_admin";
        require 'application/views/_templates/header.php';
        require 'application/views/admin.php';
        require 'application/views/_templates/footer.php';
	}

	 public function Deconnexion(){
        if(session_destroy()){
            header('location: '.URL.'Welcome');
        } else {
            header('location: '.URL.'Professor');
        }
    }
}
?>