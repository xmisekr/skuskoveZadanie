<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include_once '../../path.php';
include_once ROOT_PATH . '/repository/SharedRepository.php';

$repository = new SharedRepository();
$studentTest = $repository->selectOne("student_test", ["id" => $_SESSION['studentTestId']]);


if (!isset($_SESSION['username']) && !isset($_SESSION['type']) && !isset($_SESSION['studentTestId'])){
	header("location: ../../login.php");
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
		<link rel="stylesheet" href="../../style/main-styles.css">

        <title>Test completed</title>
    </head>
        
    <body>
        <section class="test-completed">
            <div class="center-container">
                <p class="score"> <?php echo "Your test score is: " . $studentTest['score'] . '.' ?></p>
                <p class="review">Please wait for your teacher to review the answers.</p>
            </div>
        </section>
    </body>
</html>