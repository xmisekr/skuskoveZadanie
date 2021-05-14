<?php
include_once '../../path.php';
require_once ROOT_PATH . '/config.php';
require_once ROOT_PATH . '/repository/SharedRepository.php';

if(isset($_POST['arr'])){
    $repository = new SharedRepository();
    $data = json_decode($_POST['arr']);
  
    for($i = 0; $i < count($data); $i++){
        $arr = $data[$i];
        $questionId = intval($arr->question_id);
        $student_test_id = intval($arr->student_test_id);

        $insert['student_test_id'] = $student_test_id;
        $insert['question_id'] = $questionId;
        $insert['student_answer'] = $arr->student_answer;
        $insert['points'] = 0;

        $question = $repository->selectOne('question', ['id' => $questionId]);
        
        if ($question['review_answer'] == 0){
            $correctAnswer = $repository->selectOne('answer', ['question_id' => $questionId, 'correct' => 'true']);

            if($arr->student_answer == $correctAnswer['value']){
                

                $insert['points'] = $correctAnswer['points'];
            }
        }

        $answer = $repository->insert('student_test_answer', $insert);

    }
}

?>