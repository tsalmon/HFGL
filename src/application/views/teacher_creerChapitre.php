<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">

      <?php include("_templates/bienvenue_title.php"); ?>
      <div class="content_big">
        <?php
        $create = 1;
        if($page == "CreateChapter"){
          echo '<h3>Création de chapitre</h3>';
        } else {
          $create = 0;
          echo '<h3>Modifier un chapitre</h3>';
        }
        ?>
        <p>Pour le cours "<?php echo $cours->title(); ?>" - partie "<?php echo $part->title();  ?>"</p>
        <?php
          //Controller::print_dbg($chp);
        ?>
        <form name="chpform" method="post" 
              action="<?php echo URL.'Professor/CreateChapter_ok?cours='.$_GET["cours"].'&part='.$_GET["part"]; ?>" 
              onsubmit="return chpValid();"
              enctype="multipart/form-data">
          <p>
          <input type="text" name="chp_name" placeholder="nom du chapitre" value="<?php if(!$create){ echo $chp->title(); }?>" required/>
          <div>
            <textarea name="chp_descr" placeholder="description"><?php /*TODO echo $chp->description(); */ ?></textarea>
          </div>
          <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
          <label for="upload">Leçon :</label> <input type="file" id="upload" name="chp_file_lesson"/>
        </p>
          <p>
          <label>A faire a partir du : </label>
            <select name="avalable_year" onchange="year(0);"></select>
           <select name="avalable_month" onchange="month(0);"></select>    
           <select name="avalable_day"></select>          
          </p>

          <p>
          <label>Jusq'au : </label>
            <select name="deadline_year" onchange="year(1);"></select>
           <select name="deadline_month" onchange="month(1);"></select>    
           <select name="deadline_day"></select>          
          </p>

           <p>
            <input type="submit"/>
          </p>
        </form>
      </div>
    
    <div class="clearfooter"></div>
      
    </div>
    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>

<script src="<?php echo URL.'public/js/ChapterForm.js' ?>"></script>

<?php 
/*
Chapter Object
(
    [chapterID:protected] => 1
    [chapterNumber:protected] => 1
    [exercices:protected] => ExerciceSheet Object
        (
            [deadline:ExerciceSheet:private] => 2015-01-01
            [available:ExerciceSheet:private] => 2014-04-24
            [questionnaireID:ExerciceSheet:private] => 1
            [questionnaireType:ExerciceSheet:private] => 
            [questions:ExerciceSheet:private] => Array
                (
                    [0] => QCMQuestion Object
                        (
                            [answers:QCMQuestion:private] => Array
                                (
                                    [0] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => here()
                                        )

                                    [1] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 1
                                            [content:Answer:private] => main()
                                        )

                                    [2] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => start()
                                        )

                                    [3] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => begin()
                                        )

                                )

                            [assignment:protected] => C/C++ program starts executing from
                            [tip:protected] => 
                            [points:protected] => 2
                            [questionID:protected] => 1
                        )

                    [1] => QCMQuestion Object
                        (
                            [answers:QCMQuestion:private] => Array
                                (
                                    [0] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 1
                                            [content:Answer:private] => Increment
                                        )

                                    [1] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Decrement
                                        )

                                    [2] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Assigning
                                        )

                                    [3] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Overloading
                                        )

                                )

                            [assignment:protected] => In CPP Programming ++ is ________ operator
                            [tip:protected] => 
                            [points:protected] => 2
                            [questionID:protected] => 2
                        )

                    [2] => QCMQuestion Object
                        (
                            [answers:QCMQuestion:private] => Array
                                (
                                    [0] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Value of anther Value
                                        )

                                    [1] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Value of anther variable
                                        )

                                    [2] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Address of another value
                                        )

                                    [3] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 1
                                            [content:Answer:private] => Address of another variable
                                        )

                                )

                            [assignment:protected] => In C++ Programming a pointer variable stores ________
                            [tip:protected] => 
                            [points:protected] => 2
                            [questionID:protected] => 3
                        )

                    [3] => QCMQuestion Object
                        (
                            [answers:QCMQuestion:private] => Array
                                (
                                    [0] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Single Dimensional
                                        )

                                    [1] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Multi Dimensional
                                        )

                                    [2] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Non Dimensional
                                        )

                                    [3] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 1
                                            [content:Answer:private] => A & B
                                        )

                                )

                            [assignment:protected] => In C/CPP Programming array can be _________
                            [tip:protected] => 
                            [points:protected] => 2
                            [questionID:protected] => 4
                        )

                    [4] => QCMQuestion Object

                        (
                            [answers:QCMQuestion:private] => Array
                                (
                                    [0] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Null value
                                        )

                                    [1] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Null String
                                        )

                                    [2] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 1
                                            [content:Answer:private] => Garbage value
                                        )

                                    [3] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => zero value
                                        )

                                )

                            [assignment:protected] => In C/CPP Programming an uninitialized variable may have
                            [tip:protected] => 
                            [points:protected] => 2
                            [questionID:protected] => 5
                        )

                    [5] => QCMQuestion Object
                        (
                            [answers:QCMQuestion:private] => Array
                                (
                                    [0] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => fprintf()
                                        )

                                    [1] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 1
                                            [content:Answer:private] => printf()
                                        )

                                    [2] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => fclose()
                                        )

                                    [3] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => fopen()
                                        )

                                )

                            [assignment:protected] => In C/CPP Programming which function is not related to file handling
                            [tip:protected] => 
                            [points:protected] => 2
                            [questionID:protected] => 6
                        )

                    [6] => QCMQuestion Object
                        (
                            [answers:QCMQuestion:private] => Array
                                (
                                    [0] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => No operand
                                        )

                                    [1] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => One operand
                                        )

                                    [2] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 1
                                            [content:Answer:private] => Two operand
                                        )

                                    [3] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Three operand
                                        )

                                )

                            [assignment:protected] => In C/CPP Programming binary operator needs _______ operand.
                            [tip:protected] => 
                            [points:protected] => 2
                            [questionID:protected] => 7
                        )

                    [7] => QCMQuestion Object
                        (
                            [answers:QCMQuestion:private] => Array
                                (
                                    [0] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Friend Function
                                        )

                                    [1] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Virtual Function
                                        )

                                    [2] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 1
                                            [content:Answer:private] => Recursive Function
                                        )

                                    [3] => Answer Object
                                        (
                                            [isCorrect:Answer:private] => 0
                                            [content:Answer:private] => Overloading Function
                                        )

                                )

                            [assignment:protected] => A function which invokes itself repeatedly until some condition is satisfied is called ___________
                            [tip:protected] => 
                            [points:protected] => 2
                            [questionID:protected] => 8
                        )

                )

            [db:ExerciceSheet:private] => PDO Object
                (
                )

        )

    [title:protected] => Introduction to C++
    [courseNotes:protected] => CourseNote Object
        (
            [URL:CourseNote:private] => 
            [title:CourseNote:private] => 
            [description:CourseNote:private] => 
        )

    [db:protected] => PDO Object
        (
        )

)

*/