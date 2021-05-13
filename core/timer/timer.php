<?php
include_once '../../path.php';
require_once ROOT_PATH . '/config.php';
require_once ROOT_PATH . '/repository/SharedRepository.php';



if (isset($_POST['id'], $_POST['hours'], $_POST['minutes'], $_POST['seconds'])){
    $repository = new SharedRepository();
    $id = intval($_POST['id']);
    $data['hours'] = intval($_POST['hours']);
    $data['minutes'] = intval($_POST['minutes']);
    $data['seconds'] = intval($_POST['seconds']);

    $repository->update('timer', $id, $data);
}

function getTimer($id){
    $repository = new SharedRepository();
    $timer = $repository->selectOne('timer', ['id' => $id]);

    $seconds = (($timer['hours'] * 60) * (60) ) + ($timer['minutes'] * 60) + ($timer['seconds']);

    return $seconds;
}


?>