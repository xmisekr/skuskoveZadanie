<?php
	include_once ("repository/SharedRepository.php");


	function addQuestionToDBCh($testId, $question, $questionId, $maxPoints, $choices, $choicesIds ){//answers send as answer=> 1/0 where 12 is tru 0 is false
		$rep = new SharedRepository();
		if ($questionId== null){
			$choicesIds = array();

			$a = $rep->insert("question", ["test_id"=>$testId, "value"=>$question, "type"=>"choice", "max_points"=>$maxPoints,"review_answer"=>"0"]);
			//var_dump($a);
			$questionId=$a->insert_id;


			foreach($choices as $key => $value) {
				if (strcmp($value, "true")){
					$a = $rep->insert("answer", ["question_id" => $questionId, "value" => $key, "correct" => $value, "points" => $maxPoints]);

				}else{
					$a = $rep->insert("answer", ["question_id" => $questionId, "value" => $key, "correct" => $value, "points" => "0"]);

				}
				array_push($choicesIds, $a->insert_id);
			}


		}else{
			$rep->update("question", $questionId, ["test_id"=>$testId, "value"=>$question, "type"=>"choice", "max_points"=>$maxPoints,"review_answer"=>"1"]);


				if ($choicesIds=null || empty($choicesIds)){
					$choicesIds = array();

					foreach($choices as $key => $value) {
						if (strcmp($value, "true")==0){
							$a = $rep->insert("answer", ["question_id" => $questionId, "value" => $key, "correct" => $value, "points" => $maxPoints]);

						}else{
							$a = $rep->insert("answer", ["question_id" => $questionId, "value" => $key, "correct" => $value, "points" => "0"]);

						}
						array_push($choicesIds, $a->insert_id);
					}
				}else{
					$answers = $rep->selectAll("answer", ["question_id"=>$questionId]);
					$n=0;
					foreach($choices as $key => $value) {
						if (strcmp($value, "true") == 0){
							$a = $rep->update("answer",$answers[$n]["id"], ["question_id" => $questionId, "value" => $key, "correct" => $value, "points" => $maxPoints]);
						}else{
							$a = $rep->update("answer",$answers[$n]["id"], ["question_id" => $questionId, "value" => $key, "correct" => $value, "points" => "0"]);
						}
						//echo  $n."t ".$choicesIds[$n];
						//$a = $rep->insert("answer", ["question_id" => $questionId, "value" => $answer, "correct" => "true", "points" => $maxPoints]);
						//$a = $rep->update("answer", $answers[$n]["id"], ["question_id" => $questionId, "value" => $key, "correct" => $value, "max_points" => $maxPoints]);
						var_dump($a);
						$n++;
					}
				}

		}
	}


	function deleteQuestionCh( $questionId){
		$rep = new SharedRepository();
		$answers = $rep->selectAll("answer", ["question_id"=>$questionId]);
		foreach ($answers as $answer){
			$rep->delete("answer", $answer["id"]);
		}

		$rep->delete("question", $questionId);

	}

	function addQuestionTeacherCh($questionId){

		if ($questionId == null){
			$name = "cq ".rand();
			echo "<input id='$name' name='$name' type='text' placeholder='Question' >";
			for ($i = 0; $i < 4; $i++){
				$name = "ca".$i." ".rand();
				echo "<input id='$name' name='$name' type='text' placeholder='Possible answer' >";
			}
			$name = "cs ".rand();
			echo "<br><label for='$name'>Correct answer:</label> <select id='$name' name='$name'>
  <option value='' selected disabled hidden>Choose here</option>
  <option value='0'>First option</option>
  <option value='1'>Second option</option>
  <option value='2'>Third option</option>
  <option value='3'>Fourth option</option>
</select>";
		}else {
			$rep = new SharedRepository();
			$question = $rep->selectOne("question", ["id" => $questionId]);
			$answers = $rep->selectAll("answer", ["question_id" => $questionId]);
			$name = $questionId." cq";
			echo "<input type='text' id='$name' name='$name' value='" . $question["value"] . "' >";
			$correctanswer ="";
			for ($i = 0; $i < 4; $i++) {
				$name = $questionId." ca".$i;
				echo "<input type='text' id='$name' name='$name' value='" . $answers[$i]["value"]. "'>";
				if (strcmp("true", $answers[$i]["correct"])==0){
					$correctanswer=$i;
				}
			}
			$name=$questionId."cs";
			echo "<br><label for='$name'>Correct answer:</label> <select name='$name' id='$name'>
   <option value='0'"; if (0 == $correctanswer) {echo"selected";} echo ">First option</option>
  <option value='1'"; if (1 == $correctanswer) {echo"selected";} echo ">Second option</option>
  <option value='2'"; if (2 == $correctanswer) {echo"selected";} echo ">Third option</option>
  <option value='3'"; if (3 == $correctanswer) {echo"selected";} echo ">Fourth option</option>
</select>";
		}
	}

	function addQuestionStudentCh($questionId){//todo
		$rep = new SharedRepository();
		$question = $rep->selectOne("question", ["id"=>$questionId]);
		$answers = $rep->selectAll("answer", ["question_id"=>$questionId]);

		echo "<p>".$question["value"]."</p>";
		foreach ($answers as $answer){
			if (!empty( $answer["value"])){
				echo " <input  type='radio' id='".$answer["value"]."' name='".$questionId."' value='".$answer["value"]."'>
  				<label for='".$answer["value"]."'>".$answer["value"]."</label><br>";
			}else{
				if ( strcmp($answer["correct"], "true")== 0){
					echo " <input class='form-control' type='radio' id='".$answer["correct"]."' name='".$questionId."' value=' '>
  				<label for='".$answer["correct"]."'>".$answer["value"]."</label><br>";
				}
			}
		}

	}

	function submitAnswersCh($studentTestId, $questionId, $answer){
		$rep = new SharedRepository();
		$a = $rep->selectOne("answer",  ["question_id"=>$questionId, "correct"=>"true"]);
		if (strcmp(trim(strtolower($a["value"])), trim(strtolower($answer)))==0){
			$points = $a["points"];
		}else{
			$points = 0;
		}
//echo $points;
		$A =$rep->insert("student_test_answer", ["question_id"=>$questionId, "student_test_id"=>$studentTestId, "student_answer"=>$answer, "points"=>$points]);
		var_dump($A);
	}

