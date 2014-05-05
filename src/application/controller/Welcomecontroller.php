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
        $inscription_model = $this->loadModel('PersonFactory');

        $_POST["inscr_firstname"] = ucfirst($_POST["inscr_firstname"]);
        $_POST["inscr_surname"] = ucfirst($_POST["inscr_surname"]);


        //user errors
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
        if(!filter_var($_POST["inscr_mail"], FILTER_VALIDATE_EMAIL)) {
             $inscription_error["mail_regex"] = true;
        }
        
        //$reg = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        //if(!preg_match($reg, $_POST["inscr_mail"])){ 
        //    $inscription_error["mail_regex"] = true;            
        //}

        // if there is any errors in the formular
        if(count($inscription_error) > 0){
            foreach ($inscription_error as $key => $value) {
                $_POST[$key] = $value;
            }
            Welcomecontroller::inscription_failed();
            return ;
        }
        // user already exist (we check if the email address is already saved in the database

        if($_POST["role"] == "student"){
            try{
                $inscription_model->createStudent($_POST["inscr_mail"], $_POST["inscr_firstname"],$_POST["inscr_surname"],$_POST["inscr_pwd"],0);
            } catch(UnexpectedValueException $e){
                $inscription_error["usr"] = true;  
                Welcomecontroller::inscription_failed();
            }
        } elseif($_POST["role"] == "teacher"){
            try{
                $inscription_model->createProfessor($_POST["inscr_mail"], $_POST["inscr_firstname"],$_POST["inscr_surname"],$_POST["inscr_pwd"],0); 
            } catch(UnexpectedValueException $e){
                $inscription_error["usr"] = true;  
                Welcomecontroller::inscription_failed();
            }
        } elseif($_POST["role"] == "admin") {
            exit("lol fuck you :)");
        } else {
            exit("role not exist");
        }
        if(!isset($inscription_error["usr"])){
            header('location: ' . URL . 'Welcome/Inscription_ok');
        }   
    }

    public function inscription_failed(){
            $page = "inscription_failed";
            require 'application/views/_templates/header.php';
            require 'application/views/inscription.php';       
            require 'application/views/_templates/footer.php';        
    }

    public function Inscription_ok(){
        $page = "inscription_ok";
        require 'application/views/_templates/header.php';
        require 'application/views/connexion.php';
        require 'application/views/_templates/footer.php';
    }   

    public function Connexion()
    {
        $log = $this->loadModel('Welcomemodel'); 
        $co = $log->connect($_POST["user"], $_POST["pwd"]);
        
        if($co == null){ // error
            $page = "connexion";
            $incorrect = 1;
            require 'application/views/_templates/header.php';
            require 'application/views/connexion.php';
            require 'application/views/_templates/footer.php';       
        } else {
            $_SESSION["email"] = $_POST["user"];
            $_SESSION["personid"] = strval($co->personID());

            if(method_exists($co, "studentID")){
                $_SESSION["studentid"] = strval($co->studentID());
                $_SESSION["role"] = "student";
                header('location: '.URL.'Student');
            }
            else if(method_exists($co, "tutorID")){
                $_SESSION["tutorid"] = strval($co->tutorID());
                $_SESSION["role"] = "teacher";
                header('location: '.URL.'Professor');
            } 
            else if(method_exists($co, "AdminID")){
                $_SESSION["adminid"] = strval($co->AdminID());
                $_SESSION["role"] = "admin";
                header('location: '.URL.'Admin');
            } else {
                echo "erreur de connexion";
            }  
        }    
    }
}
