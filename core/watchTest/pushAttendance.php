<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header("Connection: keep-alive");

include_once '../../path.php';
include_once ROOT_PATH . '/repository/SharedRepository.php';

while(true){
    $repository = new SharedRepository();
    $records = $repository->selectAll('student_test', ['test_id' => $_GET['test_id']]);
    $data = [];

    $i = 0;
    foreach($records as $record){
        $student = $repository->selectOne('student', ['id' => $record['student_id']]);
        
        $data[$i] = array(
            'name' => $student['name'],
            'surname' => $student['surname'],
            'in_test' => $record['in_test'],
            'completed' => $record['completed']
        );

        $i++;
    }

    echo 'event: message' . PHP_EOL;
    echo 'data: ' . json_encode($data) . PHP_EOL . PHP_EOL;
    ob_flush();
    flush();

    sleep(1);
}
?>