<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

include_once '../../path.php';
include_once ROOT_PATH . '/core/timer/timer.php';
include_once ROOT_PATH . '/repository/SharedRepository.php';

$repository = new SharedRepository();

//$student_test = $repository->selectOne('student_test', ['id' => $_SESSION['student_test_id']]);
$test = $repository->selectOne('test', ['teacher_id' => 2]);
$questions = $repository->selectAll('question', ['test_id' => 1]);
$pairQuestions = $repository->selectAll('question', ['test_id' => 1, 'type' => 'pair']);


$seconds = getTimer(3);
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

            <div class="center-container">
                <!-- Timer -->
                <div class="timer">
                    <span class="time-remaining">Time remaining:</span>
                    <div class="countdown" data-seconds-left=<?php echo $seconds ?> ></div>
                    <div id="controls"></div>
                    <input id="timer_id" type="hidden" value="3">
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


                <div class="new-test">
                    <a href="" class="create-test">Submit</a>
                </div>
            </div>

        
        </section>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>	
        <script src="../timer/jquery-countdown-timer-control.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jsPlumb/2.15.5/js/jsplumb.min.js" integrity="sha512-PjminIGk9jefzK8KKri4U44KYMW4C4WZNTY/4dB33FwkoY5pSF7GL+ZIvz8t61QsY5h30gfWZ0IJ4h/yQVoRyA==" crossorigin="anonymous"></script>
        <script src="../timer/timer.js"></script>
        <script src="../tabVisibility/tabVisibility.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jsPlumb/2.15.5/js/jsplumb.js" integrity="sha512-lkxKhus5F/fCxeHtkqirS49sHpl/GJ5aRrLWuKDN4npFawaBiRv9UDiHoXka1ovN+jKR1TBs1XJXJvsBYc+MSg==" crossorigin="anonymous"></script>
        <script src="test.js"></script>

    </body>


</html>