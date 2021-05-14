<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include_once '../../path.php';
include_once ROOT_PATH . '/repository/SharedRepository.php';

if(isset($_POST)){
    $repository = new SharedRepository();

    $timer['hours'] = 0;
    $timer['minutes'] = intval($_POST['time-limit']);
    $timer['seconds'] = 0;
    $repository->insert('timer', $timer);
    $dbTimer = $repository->selectOne('timer', ['hours' => $timer['hours'], 'minutes' => $timer['minutes'], 'seconds' => $timer['seconds']]);
   

    $test['timer_id'] = $dbTimer['id'];
    $test['teacher_id'] = $_SESSION['id'];
    $test['shared_key'] = $_POST['key'];
    $test['name'] = $_POST['name'];
    $test['active'] = 0;
    $repository->insert('test', $test);
    $testDb = $repository->selectOne('test', ['shared_key' => $test['shared_key']]);

    // short
    $shortQuestion['test_id'] = $testDb['id'];
    $shortQuestion['value'] = $_POST['shortQuestion'];
    $shortQuestion['type'] = 'text';
    $shortQuestion['max_points'] = intval($_POST['pointsShortAnswer']);
    $shortQuestion['review_answer'] = 1;
    $repository->insert('question', $shortQuestion);
    $shortDb = $repository->selectOne('question', ['test_id' => $testDb['id'], 'value' => $shortQuestion['value'], 'type' => $shortQuestion['type']]);

    $shortAnswer['question_id'] = $shortDb['id'];
    $shortAnswer['value'] = $_POST['shortAnswer'];  
    $shortAnswer['correct'] = 'true';
    $shortAnswer['points'] = intval($_POST['pointsShortAnswer']);
    $repository->insert('answer', $shortAnswer);



    //choice
    $choiceQuestion['test_id'] = $testDb['id'];
    $choiceQuestion['value'] = $_POST['choiceQuestion'];
    $choiceQuestion['type'] = 'choice';
    $choiceQuestion['max_points'] = intval($_POST['pointsChoiceAnswer']);
    $choiceQuestion['review_answer'] = 0;
    $repository->insert('question', $choiceQuestion);
    $choiceDb = $repository->selectOne('question', ['test_id' => $testDb['id'], 'value' => $choiceQuestion['value'], 'type' => $choiceQuestion['type']]);

    $correctChoiceAnswer['question_id'] = $choiceDb['id'];
    $correctChoiceAnswer['value'] = $_POST['correctChoiceAnswer'];  
    $correctChoiceAnswer['correct'] = 'true';
    $correctChoiceAnswer['points'] = intval($_POST['pointsChoiceAnswer']);
    $repository->insert('answer', $correctChoiceAnswer);

    $incorrectChoiceAnswer1['question_id'] = $choiceDb['id'];
    $incorrectChoiceAnswer1['value'] = $_POST['incorrectChoiceAnswer1'];  
    $incorrectChoiceAnswer1['correct'] = 'false';
    $incorrectChoiceAnswer1['points'] = 0;
    $repository->insert('answer', $incorrectChoiceAnswer1);

    $incorrectChoiceAnswer2['question_id'] = $choiceDb['id'];
    $incorrectChoiceAnswer2['value'] = $_POST['incorrectChoiceAnswer2'];  
    $incorrectChoiceAnswer2['correct'] = 'false';
    $incorrectChoiceAnswer2['points'] = 0;
    $repository->insert('answer', $incorrectChoiceAnswer2);

    $incorrectChoiceAnswer3['question_id'] = $choiceDb['id'];
    $incorrectChoiceAnswer3['value'] = $_POST['incorrectChoiceAnswer3'];  
    $incorrectChoiceAnswer3['correct'] = 'false';
    $incorrectChoiceAnswer3['points'] = 0;
    $repository->insert('answer', $incorrectChoiceAnswer3);

    //pair
    $pairQuestion1['test_id'] = $testDb['id'];
    $pairQuestion1['value'] = $_POST['pairQuestion1'];
    $pairQuestion1['type'] = 'pair';
    $pairQuestion1['max_points'] = intval($_POST['pointsPairAnswer1']);
    $pairQuestion1['review_answer'] = 0;
    $repository->insert('question', $pairQuestion1);
    $pairDb1 = $repository->selectOne('question', ['test_id' => $testDb['id'], 'value' => $pairQuestion1['value'], 'type' => $pairQuestion1['type']]);

    $pairAnswer1['question_id'] = $pairDb1['id'];
    $pairAnswer1['value'] = $_POST['pairAnswer1'];  
    $pairAnswer1['correct'] = 'true';
    $pairAnswer1['points'] = intval($_POST['pointsPairAnswer1']);
    $repository->insert('answer', $pairAnswer1);

    $pairQuestion2['test_id'] = $testDb['id'];
    $pairQuestion2['value'] = $_POST['pairQuestion2'];
    $pairQuestion2['type'] = 'pair';
    $pairQuestion2['max_points'] = intval($_POST['pointsPairAnswer2']);
    $pairQuestion2['review_answer'] = 0;
    $repository->insert('question', $pairQuestion2);
    $pairDb2 = $repository->selectOne('question', ['test_id' => $testDb['id'], 'value' => $pairQuestion2['value'], 'type' => $pairQuestion2['type']]);

    $pairAnswer2['question_id'] = $pairDb2['id'];
    $pairAnswer2['value'] = $_POST['pairAnswer2'];  
    $pairAnswer2['correct'] = 'true';
    $pairAnswer2['points'] = intval($_POST['pointsPairAnswer2']);
    $repository->insert('answer', $pairAnswer2);

    $pairQuestion3['test_id'] = $testDb['id'];
    $pairQuestion3['value'] = $_POST['pairQuestion3'];
    $pairQuestion3['type'] = 'pair';
    $pairQuestion3['max_points'] = intval($_POST['pointsPairAnswer3']);
    $pairQuestion3['review_answer'] = 0;
    $repository->insert('question', $pairQuestion3);
    $pairDb3 = $repository->selectOne('question', ['test_id' => $testDb['id'], 'value' => $pairQuestion3['value'], 'type' => $pairQuestion3['type']]);

    $pairAnswer3['question_id'] = $pairDb3['id'];
    $pairAnswer3['value'] = $_POST['pairAnswer3'];  
    $pairAnswer3['correct'] = 'true';
    $pairAnswer3['points'] = intval($_POST['pointsPairAnswer3']);
    $repository->insert('answer', $pairAnswer3);

    //draw
    $drawQuestion['test_id'] = $testDb['id'];
    $drawQuestion['value'] = $_POST['drawQuestion'];
    $drawQuestion['type'] = 'drawing';
    $drawQuestion['max_points'] = intval($_POST['pointsDrawQuestion']);
    $drawQuestion['review_answer'] = 1;
    $repository->insert('question', $drawQuestion);
    
    //math
    $mathQuestion['test_id'] = $testDb['id'];
    $mathQuestion['value'] = $_POST['mathQuestion'];
    $mathQuestion['type'] = 'math';
    $mathQuestion['max_points'] = intval($_POST['pointsMathQuestion']);
    $mathQuestion['review_answer'] = 1;
    $repository->insert('question', $mathQuestion);

    header("location: ../dashboard/dashboard.php");

}
?>