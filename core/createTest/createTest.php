<?php 
session_start();

include_once '../../path.php';
include_once ROOT_PATH . '/repository/SharedRepository.php';

if (!isset($_SESSION['id']) && !isset($_SESSION['type'])){
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
		<link rel="stylesheet" href="../../style/main-styles.css">

        <title>Create test</title>
    </head>
        
    <body>
        <section class="create-test">
            <div class="wrapper">

                <div class="center-container">
                    <h1>New Test</h1>
                    <form action="saveTest.php" method="post" class="was-validated">
                        <div class="form-group">
                            <label for="name">Test name:</label>
                            <input type="text" id="name" class="form-control col-md-9" id="name" placeholder="Enter test name" name="name" required>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>

                        <div class="form-group">
                            <label for="key">Test key:</label>
                            <input type="text" id="key" class="form-control col-md-9" id="key" placeholder="Enter test key" name="key" required>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>

                        <div class="form-group">
                            <label for="time-limit">Time limit:</label>
                            <div class="row container">
                                <input type="number" id="time-limit" class="form-control col-md-4" id="time-limit"  placeholder="60" name="time-limit" required> 
                                <span>minutes</span>
                            </div>
                            <div class="invalid-feedback">Please fill out this field.</div>
                        </div>

                
                        <div class="question">
                            <h3>Create short answer question</h3>
                            <div class="form-group">
                                <label for="shortQuestion">Question</label>
                                <input type="text" id="shortQuestion" class="form-control" id="shortQuestion" placeholder="Enter question" name="shortQuestion" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="shortAnswer">Answer</label>
                                <input type="text" id="shortAnswer" class="form-control" id="shortAnswer" placeholder="Enter answer" name="shortAnswer" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="pointsShortAnswer">Points:</label>
                                <input type="number" id="pointsShortAnswer" class="form-control col-md-4" id="pointsShortAnswer"  placeholder="5" name="pointsShortAnswer" required> 
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        

                        <div class="question">
                            <h3>Create choice answer question</h3>
                            <div class="form-group">
                                <label for="choiceQuestion">Question</label>
                                <input type="text" id="choiceQuestion" class="form-control" id="choiceQuestion" placeholder="Enter question" name="choiceQuestion" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="correctChoiceAnswer">Correct answer</label>
                                <input type="text" id="correctChoiceAnswer" class="form-control" id="correctChoiceAnswer" placeholder="Enter correct answer" name="correctChoiceAnswer" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="incorrectChoiceAnswer1">Incorrect answer 1</label>
                                <input type="text" id="incorrectChoiceAnswer1" class="form-control" id="incorrectChoiceAnswer1" placeholder="Enter incorrect answer" name="incorrectChoiceAnswer1" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="incorrectChoiceAnswer2">Incorrect answer 2</label>
                                <input type="text" id="incorrectChoiceAnswer2" class="form-control" id="incorrectChoiceAnswer2" placeholder="Enter incorrect answer" name="incorrectChoiceAnswer2" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="incorrectChoiceAnswer3">Incorrect answer 3</label>
                                <input type="text" id="incorrectChoiceAnswer3" class="form-control" id="incorrectChoiceAnswer3" placeholder="Enter incorrect answer" name="incorrectChoiceAnswer3" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="pointsChoiceAnswer">Points:</label>
                                <input type="number" id="pointsChoiceAnswer" class="form-control col-md-4" id="pointsChoiceAnswer"  placeholder="5" name="pointsChoiceAnswer" required> 
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>

                        <div class="question">
                            <h3>Create pair answer question</h3>
                            <div class="form-group">
                                <label for="pairQuestion1">Question 1</label>
                                <input type="text" id="pairQuestion1" class="form-control pairQuestion" id="pairQuestion1" placeholder="Enter question" name="pairQuestion1" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="pairAnswer1">Answer 1</label>
                                <input type="text" id="pairAnswer1" class="form-control pairAnswer" id="pairAnswer1" placeholder="Enter answer" name="pairAnswer1" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="pointsPairAnswer1">Points:</label>
                                <input type="number" id="pointsPairAnswer1" class="form-control col-md-4" id="pointsPairAnswer1"  placeholder="5" name="pointsPairAnswer1" required> 
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <hr>
                            
                            <div class="form-group">
                                <label for="pairQuestion2">Question 2</label>
                                <input type="text" id="pairQuestion2" class="form-control pairQuestion" id="pairQuestion2" placeholder="Enter question" name="pairQuestion2" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="pairAnswer2">Answer 2</label>
                                <input type="text" id="pairAnswer2" class="form-control pairAnswer" id="pairAnswer2" placeholder="Enter answer" name="pairAnswer2" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="pointsPairAnswer2">Points:</label>
                                <input type="number" id="pointsPairAnswer2" class="form-control col-md-4" id="pointsPairAnswer2"  placeholder="5" name="pointsPairAnswer2" required> 
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            <hr>
                            
                            <div class="form-group">
                                <label for="pairQuestion3">Question 3</label>
                                <input type="text" id="pairQuestion3" class="form-control pairQuestion" id="pairQuestion3" placeholder="Enter question" name="pairQuestion3" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="pairAnswer3">Answer 3</label>
                                <input type="text" id="pairAnswer3" class="form-control pairAnswer" id="pairAnswer3" placeholder="Enter answer" name="pairAnswer3" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="pointsPairAnswer3">Points:</label>
                                <input type="number" id="pointsPairAnswer3" class="form-control col-md-4" id="pointsPairAnswer3"  placeholder="5" name="pointsPairAnswer3" required> 
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                            
                        </div>

                        <div class="question">
                            <h3>Create draw answer question</h3>
                            <div class="form-group">
                                <label for="drawQuestion">Question</label>
                                <input type="text" id="drawQuestion" class="form-control" id="drawQuestion" placeholder="Enter question" name="drawQuestion" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="pointsDrawQuestion">Points:</label>
                                <input type="number" id="pointsDrawQuestion" class="form-control col-md-4" id="pointsDrawQuestion"  placeholder="5" name="pointsDrawQuestion" required> 
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>

                        <div class="question">
                            <h3>Create math answer question</h3>
                            <div class="form-group">
                                <label for="mathQuestion">Question</label>
                                <input type="text" id="mathQuestion" class="form-control" id="mathQuestion" placeholder="Enter question" name="mathQuestion" required>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>

                            <div class="form-group">
                                <label for="pointsMathQuestion">Points:</label>
                                <input type="number" id="pointsMathQuestion" class="form-control col-md-4" id="pointsMathQuestion"  placeholder="5" name="pointsMathQuestion" required> 
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                    

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form> 
                </div>
            </div>
            
            
        </section>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>	
    </body>
</html>