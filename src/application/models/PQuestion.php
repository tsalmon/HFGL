<?php
require_once("application/models/Question.php");
require_once("application/models/QuestionTypeManager.php");
require_once("application/models/Resource.php");
require_once("application/models/Test.php");

class PQuestion extends Question{
	private $resources;
    private $tests;

	public function getResources(){
		return $this->resources;
	}

    public function getTests(){
        return $this->tests;
    }

    public function addTest($test){
        $this->tests[] = $test;
    }

    public function addResource($res){
        $this->resources[] = $res;
    }

    public function __construct($assignment, $tip, $points)
    {
        parent::__construct($assignment, $tip, $points);
    }

    public function writeToDB(){
        if (is_null($this->questionID)) {
            //echo "INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$this->assignment."',".$this->points.",".QuestionTypeManager::getInstance()->getPID().")<br>";
            PDOHelper::getInstance()->exec("INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$this->assignment."',".$this->points.",".QuestionTypeManager::getInstance()->getPID().")");
            $this->questionID = PDOHelper::getInstance()->lastInsertID();
            //echo "Inserted questionID:".$this->questionID."<br>";
        }


        if (!is_null($this->resources)) {
            //echo "Insert resources";
            foreach ($this->resources as $resource)
            {
                $resource->writeToDBForQuestionID($this->questionID);
            }
        }

        if (!is_null($this->tests)) {
            //echo "Insert tests";
            foreach ($this->tests as $test)
            {
                $test->writeToDBForQuestionID($this->questionID);
            }
        }

        return $this->questionID;
    }

    public function loadByID($questionID){
    	$this->questionID = $questionID;

        //Getting resources for current question
        if($resourcesRequestResult = PDOHelper::getInstance()->query("SELECT * FROM Resource WHERE questionID=".$questionID))
        {
            //enumeration of resources
            while($currentResourceRow = $resourcesRequestResult->fetch(PDO::FETCH_ASSOC))
            {
                $this->resources[] = new Resource($currentResourceRow['type'], $currentResourceRow['content']);
            }
        }

        //Getting tests for current question
        if($testsRequestResult = PDOHelper::getInstance()->query("SELECT * FROM Test WHERE questionID=".$questionID))
        {
            //enumeration of tests
            while($currentTestRow = $testsRequestResult->fetch(PDO::FETCH_ASSOC))
            {
                $this->tests[] = new Test($currentTestRow['input'], $currentTestRow['output']);
            }
        }
    }

} 