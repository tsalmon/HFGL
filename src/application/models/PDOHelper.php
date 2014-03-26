<?php
    
    require_once("/../config/config.php");
    // MODIFIER LES ATTRIBUTS PARAM LORS D'UN REDEPLOIEMENT.

 class PDOHelper {
    
    //    attributs et infos pour PDO
    //************************************
        
    
    private static $PARAM_host='localhost'; // le chemin vers le serveur
    private static $PARAM_dbname='glhf'; //base de donnée
    private static $PARAM_user='root'; //nom utilisateur
    private static $PARAM_pwd=''; //mot de passe //mot de passe
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
