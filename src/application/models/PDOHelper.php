<?php
    
    require_once("application/config/config.php");
    // MODIFIER LES ATTRIBUTS PARAM LORS D'UN REDEPLOIEMENT.

 class PDOHelper {
    
    //    attributs et infos pour PDO
    //************************************
        
        private static $pdo=null;
    
    //      Constructeur private : singleton
    //*********************************************
    
    private function __construct() {
        }
    
     //         Renvoie un PDO
     //********************************
    
    public static function getInstance(){
        if(PDOHelper::$pdo==null){
            PDOHelper::$pdo=new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        }
        return PDOHelper::$pdo;
    }
}

?>
