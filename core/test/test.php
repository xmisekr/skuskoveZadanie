<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../path.php';
include_once ROOT_PATH . '/core/timer/timer.php';
include_once ROOT_PATH . '/repository/SharedRepository.php';

$repository = new SharedRepository();

$seconds = getTimer(3);
?>

<!DOCTYPE html>
<html lang="sk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles.css" type="text/css"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       

        <title>Test</title>
    </head>
        
    <body>
        <input type="hidden" name="student_name" id="student_name" value="<?php echo $_GET['a'] ?>">
        <input type="hidden" name="student_surname" id="student_surname" value="<?php echo $_GET['b'] ?>">
        <input type="hidden" name="teacher_id" id="teacher_id" value="1">

        <div class="timer">
            <div class="countdown" data-seconds-left=<?php echo $seconds ?> ></div>
            <div id="controls"></div>
            <input id="timer_id" type="hidden" value="3">
        </div>
        

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>	
        <script src="../timer/jquery-countdown-timer-control.js"></script>
        <script src="../timer/timer.js"></script>
        <script src="../tabVisibility/tabVisibility.js"></script>
    </body>


</html>