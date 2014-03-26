<?php
require_once("application/libs/controller.php");
require_once("application/models/Question.php");
require_once("application/models/QCMAnswer.php");
require_once("application/models/QRFAnswer.php");
require_once("application/models/LAnswer.php");

class Exercise extends Controller{

    private $mysqli;

    public function connectdDB(){
        $this->mysqli = new mysqli("localhost", "root", "root", "hfgl");
        if ($this->mysqli->connect_errno) {
            printf("Не удалось подключиться: %s\n", $this->mysqli->connect_error);
            exit();
        }
    }

    public function parseXML(){
        $questions = simplexml_load_file("application/models/exo.xml");
        foreach ($questions->question as $question) {
            echo $question->text;
            echo '<br/><br/>';
            foreach ($question->answers->answer as $ans){
                echo $ans->text.' | '.$ans['good'];
                echo '<br/>';
            }
            echo '<br/><br/>';
            $this->mysqli->query("INSERT INTO `Question`(`assignment`, `points`, `typeID`) (".$question->text.",2,1)");
            $qid = $this->mysqli->query("SELECT questionID FROM Question where assignment=".$question->text.")");
        }
    }


    public function showExercise(){
        $questions = array();
        /* Select запросы возвращают результирующий набор */
        if ($questionResult = $this->mysqli->query("SELECT * FROM Question")) {
            //printf("Select вернул %d строк.\n", $questionResult->num_rows);
            echo "<br />";
            while($qrow = $questionResult->fetch_array())
            {
                echo "<br />";

                $oanswers = array();
                if($answers = $this->mysqli->query("SELECT * FROM Responses WHERE questionID=".$qrow['questionID']))
                {
                    while($row = $answers->fetch_array())
                    {
                        //var_dump($qrow);
                        switch($qrow['typeID'])
                        {
                            case 1:
                            {
                                $oanswers[] = new QCMAnswer((bool)$row['correct'], $row['content']);
                            }
                            break;

                            case 2:
                            {
                                $oanswers[] = new QRFAnswer((bool)$row['correct'], $row['content']);
                            }
                            break;
                        }
                    }
                }
                $questions[] = new Question($qrow['assignment'], $oanswers, $qrow['points']);
            }
            /* очищаем результирующий набор */
            $questionResult->close();

        }

        foreach($questions as $question) {
            echo $question->getAssignment().'<br/>';
                echo '<form action="">';
                $curanswers = $question->getAnswers();
                foreach($curanswers as $answer) {
                    //var_dump($answer);
                    if($answer instanceof QCMAnswer)
                    {
                        echo '<input type="checkbox" name="checkboxanswer" value="val">'.$answer->getContent().'<br>';
                    } else {
                        echo '<input type="text" name="textanswer" placeholder="Your answer...">';
                    }
                }
                echo '</form>';
                echo '<br/>';
         }

    }



}