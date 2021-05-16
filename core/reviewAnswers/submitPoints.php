<?php
include_once '../../path.php';
require_once ROOT_PATH . '/config.php';
require_once ROOT_PATH . '/repository/SharedRepository.php';


if(isset($_POST['arr'])){
    $repository = new SharedRepository();
    $data = $_POST['arr'];
    $student_test_answer = null;
   
    for($i = 0; $i < count($data); $i++){
        $arr = $data[$i];
        $student_test_answer_id = intval($arr['student_test_answer']);
        $points = intval($arr['points']);

        $student_test_answer = $repository->selectOne('student_test_answer', ['id' => $student_test_answer_id]);
        $question = $repository->selectOne('question', ['id' => $student_test_answer['question_id']]);
        
        if ($question['review_answer'] == 1){
            $update['points'] = $points;
            $repository->update('student_test_answer', $student_test_answer['id'], $update);
        }
        
    }

    // recalculate score
    $student_test = $repository->selectOne('student_test', ['id' => $student_test_answer['student_test_id']]);
    $allAnswers = $repository->selectAll('student_test_answer', ['student_test_id' => $student_test['id']]);
    $score = 0;

    foreach($allAnswers as $answer){
        $score = $score + $answer['points'];
    }

    $update2['score'] = $score;
    $repository->update('student_test', $student_test['id'], $update2);

}
?>