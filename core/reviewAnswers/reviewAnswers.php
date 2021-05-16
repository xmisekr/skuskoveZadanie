<?php
include_once '../../path.php';
include_once ROOT_PATH . '/repository/SharedRepository.php';

session_start();


if (!isset($_SESSION['id']) && !isset($_SESSION['type'])){
	header("location: ../../login.php");
}

$repository = new SharedRepository();
$student_test = $repository->selectOne('student_test', ['id' => $_GET['student_test_id']]);
$test = $repository->selectOne('test', ['id' => $student_test['test_id']]);
$student_test_answers = $repository->selectAll('student_test_answer', ['student_test_id' => $student_test['id']]);

?>

<!DOCTYPE html>
<html lang="sk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles.css?version=51" type="text/css"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../../style/main-styles.css">

        <title>Review answers</title>
    </head>
        
    <body>
        <input type="hidden" id="test_id" value="<?php echo $test['id'] ?>">

        <section class="review-answer">
            <div class="wrapper">

                <div class="center-container">
                    <h1><?php echo $test['name'] ?></h1>
                    <form action="reviewAnswers.php" method="post" class="was-validated ajax">

                        <?php foreach($student_test_answers as $answer): ?>
                            <?php $question = $repository->selectOne('question', ['id' => $answer['question_id']]); ?>

                            <div class="form-group">
                                <div class="row container">
                                    <label class="col-form-label form-control-lg" for="question">Question: </label>
                                    <input type="text" value="<?php echo $question['value'] ?>" id="question" class="form-control-plaintext col-md-9 form-control-lg" id="question" name="question" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="answer">Answer</label>
                                <input type="text" value="<?php echo $answer['student_answer'] ?>" id="answer" class="form-control col-md-9" id="answer" name="answer" readonly>
                            </div>
                

                            <div class="form-group">
                                <label for="points">Points</label>

                                <?php if ($question['review_answer'] == 1): ?>
                                    <div class="row container">
                                        <input type="number" value="<?php echo $answer['points'] ?>" max="<?php echo $question['max_points'] ?>" id="<?php echo $answer['id'] ?>" class="form-control col-md-2 points" placeholder="<?php echo $answer['points'] ?>" name="<?php echo $answer['id'] ?>" required> 
                                        <input type="text" value="<?php echo '/ ' . $question['max_points'] ?>" id="maxPoints" class="form-control-plaintext col-md-9" id="maxPoints" name="maxPoints" readonly>
                                        <div class="valid-feedback"></div>
                                        <div class="invalid-feedback">Please fill out this field.</div>
                                    </div>
                                    
                                <?php else: ?>
                                    <div class="row container">
                                        <input type="number" value="<?php echo $answer['points'] ?>" id="<?php echo $answer['id'] ?>" class="form-control col-md-2" placeholder="<?php echo $answer['points'] ?>" name="<?php echo $answer['id'] ?>" readonly> 
                                        <input type="text" value="<?php echo '/ ' . $question['max_points'] ?>" id="maxPoints" class="form-control-plaintext col-md-9" id="maxPoints" name="maxPoints" readonly>
                                    </div>
                                    
                                <?php endif; ?>
                            </div>
                            <hr>

                        <?php endforeach; ?>

                     
                       <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </section>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>	
        <script src="reviewAnswers.js"></script>
    </body>
</html>
