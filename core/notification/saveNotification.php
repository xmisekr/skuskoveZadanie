<?php
include_once '../../path.php';
include_once ROOT_PATH . '/repository/SharedRepository.php';

if (isset($_POST['teacher_id'], $_POST['student'])){
    $repository = new SharedRepository();
    $id = intval($_POST['teacher_id']);
    $data['teacher_id'] = $id;
    $data['message'] = $_POST['student'] . " has left the test tab";
    
    $repository->insert('notification', $data);
}