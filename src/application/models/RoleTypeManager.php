<?php
require_once "TypeManager.php";

define('admin', "admin");
define('tutor', "tutor");
define('student', "student");

class RoleTypeManager extends TypeManager{
    private static $sharedInstance = null;
    private $admin;
    private $tutor;
    private $student;

    //      Constructeur private : singleton
    //*********************************************

    private function __construct(){
        $this->typeTable = "Role";
        $this->idField = "roleID";
        $this->nameField = "name";
        $this->refresh();
    }

    public static function getInstance(){
        if(self::$sharedInstance==null){
            self::$sharedInstance=new self();
        }
        return self::$sharedInstance;
    }

    public function refresh()
    {
        $this->student = $this->getIdForTypeName(student);
        $this->admin = $this->getIdForTypeName(admin);
        $this->tutor = $this->getIdForTypeName(tutor);

    }

    public function getStudentID()
    {
        if(!$this->student)
        {
            $this->student = $this->getIdForTypeName(student);
        }
        return $this->student;
    }

    public function getAdminID()
    {
        if(!$this->admin)
        {
            $this->admin = $this->getIdForTypeName(admin);
        }
        return $this->admin;
    }

    public function getTutorID()
    {
        if(!$this->tutor)
        {
            $this->tutor = $this->getIdForTypeName(tutor);
        }
        return $this->tutor;
    }
} 