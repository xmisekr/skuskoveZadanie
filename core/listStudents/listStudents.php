<?php
include_once '../../path.php';
include_once ROOT_PATH . '/repository/SharedRepository.php';

session_start();

if (!isset($_SESSION['id']) && !isset($_SESSION['type'])){
	header("location: ../../login.php");
}

$repository = new SharedRepository();
$student_test = $repository->selectAll('student_test', ['test_id' => $_GET['test_id'], 'completed' => 1]);

?>

<!DOCTYPE html>
<html lang="sk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles.css" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../../style/main-styles.css">
        <title>Student scores</title>
    </head>

    <body>
        <input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo $_SESSION['id'] ?>">

        <section class="list-students">

            <div class="container">
                <div class="heading">
                    <a href="../dashboard/dashboard.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                    <div class="dropdown">
                        <a class="dropdown-toggle float-right mb-4" id="dropdown" type="button" data-toggle="dropdown">
                            <i class="fa fa-envelope"></i> <span class="badge badge-danger" id="notification-counter">0/span>
                        </a>

                        <ul class="dropdown-menu" id="dropdown-menu">
                        </ul>
                    </div>
                </div>
                

                <table class="table-tests table" cellspacing="0">
                    <thead class="tests-header ">
                        <tr class="row2 header">
                            <th class="student-name cell">Student name</th>
                            <th class="student-surname cell">Student surname</th>
                            <th class="student-score cell">Score</th>
                            <th class="student-edit cell">Edit points</th>
                        </tr>
                        
                    </thead>

                    <tbody class="tests-body">
                        <?php foreach($student_test as $studentTest): ?>
                            <?php $student = $repository->selectOne('student', ['id' => $studentTest['student_id']]); ?>

                            <tr class="student-row row2">
                                <td class="cell"><?php echo $student['name']?></td>
                                <td class="cell"><?php echo $student['surname']?></td>
                                <td class="cell"><?php echo $studentTest['score']?></td>
                                <td class="cell"><a href="<?php echo "../reviewAnswers/reviewAnswers.php?student_test_id=" . $studentTest['id'] ?>"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
            
        </section>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>	
        <script src="../notification/notification.js"></script>
    </body>

</html>