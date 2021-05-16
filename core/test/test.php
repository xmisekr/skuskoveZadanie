<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include_once '../../path.php';
include_once ROOT_PATH . '/core/timer/timer.php';
include_once ROOT_PATH . '/repository/SharedRepository.php';
include_once ROOT_PATH . "/questions/ShortAnswerQuestion.php";
include_once ROOT_PATH . "/questions/ChoiceQuestion.php";
include_once ROOT_PATH . "/questions/math_question.php";
include_once ROOT_PATH . "/questions/drawing_question.php";

$repository = new SharedRepository();
$questions = $repository->selectAll('question', ['test_id' => 1]);
$studentTest = $repository->selectOne("student_test", ["id" => $_SESSION['studentTestId']]);
$test = $repository->selectOne("test", ["id" => $studentTest['test_id']]);
$questions = $repository->selectAll("question", ["test_id" => $studentTest["test_id"]]);
$pairQuestions = $repository->selectAll('question', ['test_id' => $studentTest["test_id"], 'type' => 'pair']);

$seconds = getTimer($studentTest["timer_id"]);

if (!isset($_SESSION['username']) && !isset($_SESSION['type']) && !isset($_SESSION['studentTestId'])){
	header("location: ../../login.php");
}

if (isset($_POST['arr'])){
    
	foreach ($_POST['arr'] as $questionId => $answer ){
		echo "<br>id ".$questionId." ans ".$answer;
		if (strcmp($questionId, "studentId")==0){
			//just id
		}else{
			$q = $repository->selectOne("question", ["id" => $questionId]);
			if (strcmp($q["type"], "text")==0){
				submitAnswersSA($_SESSION['studentTestId'], $questionId, $answer);
			}elseif (strcmp($q["type"], "choice")==0){
				submitAnswersCh($_SESSION['studentTestId'], $questionId, $answer);
            }elseif (strcmp($q["type"], "math")==0){
				submitAnswersMa($_SESSION['studentTestId'], $questionId, $answer);
			}elseif (strcmp($q["type"], "drawing")==0){
				submitAnswersDr($_SESSION['studentTestId'], $questionId, $answer);
			}
		}
	}

    //calculate test score
    $student_answers = $repository->selectAll('student_test_answer', ['student_test_id' => $studentTest['id']]);
    $score = 0;

    foreach($student_answers as $answer){
        $score = $score + $answer['points'];
    }

    $data['score'] = $score;
    $data['in_test'] = 0;
    $data['completed'] = 1;
    $repository->update('student_test', $studentTest['id'], $data);
}

	
?>
<!DOCTYPE html>
<html lang="sk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles.css?version=51" type="text/css"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsPlumb/2.15.5/css/jsplumbtoolkit-defaults.css" integrity="sha512-jd/fOFC21187laNAUa3jXsPbm9L25MSscoZ/v/t6fznpllp0KOgEDwBabuvRr/gNT7VlRfZz9ItshGbmAXMy8g==" crossorigin="anonymous" />

        <title>Test</title>
    </head>
        
    <body>

        <section class="test">
            <input type="hidden" name="student_name" id="student_name" value="<?php echo $_SESSION['username'] ?>">
            <input type="hidden" name="student_surname" id="student_surname" value="<?php echo $_SESSION['lastname'] ?>">
            <input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo $test['teacher_id'] ?>">
            <input type="hidden" name="student_test_id" id="student_test_id" value="<?php echo $_SESSION['studentTestId']?>">
            
            <h1>Welcome, <?php echo $_SESSION["username"] . " " . $_SESSION["lastname"] ?>. Your test name is <?php echo $test["name"]?> </h1>


            <div class="center-container">
                <!-- Timer -->
                <div class="timer">
                    <span class="time-remaining">Time remaining:</span>
                    <div class="countdown" data-seconds-left=<?php echo $seconds ?> ></div>
                    <div id="controls"></div>
                    <input id="timer_id" type="hidden" value="<?php echo $studentTest["timer_id"] ?>">
                </div>


                <!-- Pair Questions -->
                <?php if ($pairQuestions): ?>
                    <h3 class="question-header">Pair questions to answers</h3>
                    <div id="plumb"></div>
                    <div class="pair">
                        <?php $pairAnswers = []; ?>

                        <div class="pair-questions">

                            <?php $i = 0; ?>
                            <?php foreach($pairQuestions as $question): ?>
                                <?php $pairAnswers[$i] = $repository->selectOne('answer', ['question_id' => $question['id']]); ?>
                                <p id="<?php echo $question['value'] ?>" class="pairQuestion"><?php echo $question['value'] ?></p>

                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>

                        <div class="pair-answers">
                            <?php for($i = 0; $i < count($pairAnswers); $i++): ?>
                                <p id="<?php echo $pairAnswers[$i]['value'] ?>" class="pairAnswer"><?php echo $pairAnswers[$i]['value']?></p>
                            <?php endfor; ?>
                        </div>
                    </div>
                    
                <?php endif; ?>
              
              <!-- Choice and Short Questions -->
                <form action="test.php" method="post" class="ajax" enctype="multipart/form-data">
                    <input type="hidden" name="studentId" id="studentId" value="<?php echo $studentTest["student_id"] ?>">
                    <div class="col " id="formDiv">

                    <?php

                    foreach ($questions as $question){
                        echo "<div class='form-group'>";
                        if (strcmp($question["type"], "text")==0){
                        addQuestionStudentSA($question["id"]);
                        }elseif (strcmp($question["type"], "choice")==0){
                        addQuestionStudentCh($question["id"]);

                        }elseif (strcmp($question["type"], "math")==0){
						addQuestionStudentMa($question["id"]);
						}elseif (strcmp($question["type"], "drawing")==0){
						addQuestionStudentDr($question["id"]);
                        }
                        echo "</div>";
                    
                    }
                    ?>
					
					<!-- Math Equation Editor -->
					<div>
						<p>
						Use external editor to type out your math equation, then download it as .gif, rename it to yourname_anyfilename.gif, upload it and as answer, type in the name of the file.
						You can also write it on paper, scan, and upload the file with the same naming convention. Accepted formats are: .jpg, .jpeg, .png, .gif
						</p>
						<p><a href="javascript:OpenLatexEditor('testbox','html','')">
						Start external editor
						</a></p>
					</div>
					
					<!-- Drawing editor -->
					<p>
					Use drawing tool to draw simple solutions to drawing questions. Use save button do download your drawing, rename it following the naming convention of equation file upload, and then upload your answer.
					As an answer to the question, type in the file name. You can also draw on paper, scan, and upload the scan file. Accepted formats are: .jpg, .jpeg, .png, .gif
					</p>
					<a href='../paintEditor/paintEditor.php' target="_blank">Open drawing editor</a>
					
					
                    <!-- tento upload cez -->
					<!-- Multiple file -->
					
				
                    <button type="submit" id="submit" class="btn btn-lg btn-info btn-block"  >Submit test</button>
                
	            </form>

                <form method='post' action='saveFiles.php' enctype='multipart/form-data'>
 
                    <input type="file" name="file[]" id="file" multiple>
                    <input type='submit' name='fileUpload' value='Upload'>

                </form>

            </div>

        
        </section>


		<script type="text/javascript" src="https://latex.codecogs.com/editor3.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>	
        <script src="../timer/jquery-countdown-timer-control.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jsPlumb/2.15.5/js/jsplumb.min.js" integrity="sha512-PjminIGk9jefzK8KKri4U44KYMW4C4WZNTY/4dB33FwkoY5pSF7GL+ZIvz8t61QsY5h30gfWZ0IJ4h/yQVoRyA==" crossorigin="anonymous"></script>
        <script src="../timer/timer.js"></script>
        <script src="../tabVisibility/tabVisibility.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jsPlumb/2.15.5/js/jsplumb.js" integrity="sha512-lkxKhus5F/fCxeHtkqirS49sHpl/GJ5aRrLWuKDN4npFawaBiRv9UDiHoXka1ovN+jKR1TBs1XJXJvsBYc+MSg==" crossorigin="anonymous"></script>
        <script src="test.js"></script>
        <script>
            var pairQuestions = <?php echo json_encode($pairQuestions); ?>;
            var pairAnswers = <?php echo json_encode($pairAnswers); ?>;

        </script>
    </body>


</html>