<?php
require_once("application/models/Question.php");
require_once("application/models/QuestionTypeManager.php");
require_once("application/models/Resource.php");

class PQuestion extends Question{
	private $resources;

	public function getResources(){
		return $this->resources;
	}

    public function writeToDB(){
   		echo "INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$this->assignment."',".$this->points.",".QCM.")<br>";
        PDOHelper::getInstance()->exec("INSERT INTO `Question`(`assignment`, `points`, `typeID`) VALUES ('".$this->assignment."',".$this->points.",".QuestionTypeManager::getInstance()->getQcmID().")");
        $this->questionID = PDOHelper::getInstance()->lastInsertID();
        echo "Inserted questionID:".$this->questionID."<br>";

        foreach ($this->resources as $resource)
        {
            $resource->writeToDBForQuestionID($this->questionID);
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
                $this->resources[] = new Resource($currentResourceRow['type'], $currentAnswerRow['content']);
            }
        }
    }

} 