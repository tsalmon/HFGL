<?php
class Welcomecontroller extends Controller
{
    public function index()
    {
        $page = "connexion";
        require 'application/views/_templates/header.php';
        require 'application/views/connexion.php';
        require 'application/views/_templates/footer.php';
    }

    public function Inscription()
    {
        $page = "inscription";
        require 'application/views/_templates/header.php';
        require 'application/views/inscription.php';
        require 'application/views/_templates/footer.php';
    }

    public function Inscription_result()
    {
        $page = "inscription";    
        $inscription_error = array();
        $inscription_model = $this->loadModel('WelcomeModel');

        //user errors
        if($inscription_model->user_exist($_POST["inscr_mail"])){ // user already exist (we check if the email address is already saved in the database)
            $inscription_error["usr"] = true;  
        }
        if(!preg_match('/^[A-Z][a-z]+$/', $_POST["inscr_firstname"])){ //math usr firstname invalid
            $inscription_error["usr_fn_regex"] = true;            
        }
        if(!preg_match('/^[A-Z][a-z]+$/', $_POST["inscr_surname"])){ //math usr surname invalid
            $inscription_error["usr_sn_regex"] = true;            
        }

        //password errors
        if($_POST["inscr_pwd"] !=  $_POST["inscr_pwd_confirm"]){ //pwd & confirm are differents
            $inscription_error["pwd_diff"] = true;
        }
        if(strlen($_POST["inscr_pwd"]) < 8){ // size too short
            $inscription_error["pwd_size"] = true;
        }
        if(!ctype_alnum($_POST["inscr_pwd"])){ // pwd isn't alphanum
            $inscription_error["pwd_regex"] = true;            
        }

        //email error
        // mail and confirm differents
        if($_POST["inscr_mail"] !=  $_POST["inscr_mail_confirm"]){
            $inscription_error["mail"] = true;
        }
        //mathc not a email valid
        $reg = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if(!preg_match($reg, $_POST["inscr_mail"])){ 
            $inscription_error["mail_regex"] = true;            
        }

        // if there is any errors in the formular
        if(count($inscription_error) > 0){
            header('location: ' . URL . 'Welcome/Inscription_failed');
        } else {
            $inscription_model->addPerson($_POST["inscr_firstname"],$_POST["inscr_surname"], $_POST["inscr_pwd"], $_POST["inscr_mail"]);
        }
        //require 'application/views/_templates/footer.php';
    }

    public function Inscription_ok(){
        $page = "inscription";
        require 'application/views/_templates/header.php';
        echo "<p>Inscription réussie</p>";
        require 'application/views/_templates/footer.php';
    }   

    public function Inscription_failed(){
        $page = "inscription";
        require 'application/views/_templates/header.php';
        echo "<p>Echec de l'inscription</p>";
        require 'application/views/_templates/footer.php';       
    }

    public function Connexion()
    {
        $log = $this->loadModel('WelcomeModel');
        
        $co = $log->connect($_POST["user"], $_POST["pwd"]);
        if($co == null){
            $page = "connexion";
            $incorrect = 1;
            require 'application/views/_templates/header.php';
            require 'application/views/connexion.php';
            require 'application/views/_templates/footer.php';       
        } else {
            header('location: ' . URL . 'Student');
            $_SESSION["role"] = "student";
            $_SESSION["email"] = $_POST["user"];
            echo "toto";
        }
    }
}
