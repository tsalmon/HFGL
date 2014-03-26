<?php

class Exercise extends Controller{

private $mysqli;

    public function connectdDB(){
        $mysqli = new mysqli("localhost", "root", "root", "hfgl");
        if ($mysqli->connect_errno) {
            printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
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
            $mysqli->query("INSERT INTO `Question`(`assignment`, `points`, `typeID`) (".$question->text.",2,1)");
            $qid = $mysqli->query("SELECT questionID FROM Question where assignment=".$question->text.")");
        }
    }


    public function showExercise(){
        $questions = array();
        /* Select запросы возвращают результирующий набор */
        if ($questionResult = $mysqli->query("SELECT * FROM Question")) {
            //printf("Select вернул %d строк.\n", $questionResult->num_rows);
            echo "<br />";
            while($qrow = $questionResult->fetch_array())
            {
                echo "<br />";

                $oanswers = array();
                if($answers = $mysqli->query("SELECT content, correct FROM Responses WHERE questionID=".$qrow['questionID']))
                {
                    while($row = $answers->fetch_array())
                    {
                        $oanswers[] = new QCMAnswer((bool)$row['correct'], $row['content']);
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
                echo '<input type="checkbox" name="sex" value="val">'.$answer->getContent().'<br>';
            }
            echo '</form>';
            echo '<br/>';

        }
    }



}