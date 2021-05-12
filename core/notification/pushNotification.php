<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header("Connection: keep-alive");

include_once '../../path.php';
include_once ROOT_PATH . '/repository/SharedRepository.php';

while(true){
    $repository = new SharedRepository();
    $records = $repository->selectAll('notification', ['teacher_id' => $_GET['teacher_id']]);
    $data = [];

    $i = 0;
    foreach($records as $record){
        $data[$i] = array(
            'message' => $record['message'],
        );

        $repository->delete('notification', $record['id']);
        $i++;
    }

    echo 'event: message' . PHP_EOL;
    echo 'data: ' . json_encode($data) . PHP_EOL . PHP_EOL;
    ob_flush();
    flush();

    sleep(1);
}
?>