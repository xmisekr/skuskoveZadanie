<?php
	include_once ("repository/SharedRepository.php");


	function addQuestionToDBCh($testId, $question, $questionId, $maxPoints, $choices, $choicesIds){//answers send as answer=> 1/0 where 12 is tru 0 is false
		$rep = new SharedRepository();
		if ($questionId== null){

			$a = $rep->insert("question", ["test_id"=>$testId, "value"=>$question, "type"=>"choice", "max_points"=>$maxPoints,"review_answer"=>"0"]);
			//var_dump($a);
			$questionId=$a->insert_id;
			$choicesIds = array();

			foreach($choices as $key => $value) {
				$a = $rep->insert("answer", ["question_id" => $questionId, "value" => $key, "correct" => $value, "points" => $maxPoints]);
				array_push($choicesIds, $a->insert_id);
			}


		}else{
			$rep->update("question", $questionId, ["test_id"=>$testId, "value"=>$question, "type"=>"choice", "max_points"=>$maxPoints,"review_answer"=>"1"]);



				if ($choicesIds=null || empty($choicesIds)){
					$choicesIds = array();
					foreach($choices as $key => $value) {
						$a = $rep->insert("answer", ["question_id" => $questionId, "value" => $key, "correct" => $value, "points" => $maxPoints]);
						array_push($choicesIds, $a->insert_id);
					}
				}else{
					$n=0;
					var_dump($choicesIds);//TODO why not going
					foreach($choices as $key => $value) {
						echo  $n." ".$choicesIds[$n];
						//$a = $rep->insert("answer", ["question_id" => $questionId, "value" => $answer, "correct" => "true", "points" => $maxPoints]);
						$rep->update("answer", $choicesIds[$n], ["question_id"=>$questionId, "value"=>$key, "correct"=>$value, "max_points"=>$maxPoints]);

						$n++;
					}
				}

		}
	}

	function getFromDBCh(){
		//todo
	}

	function deleteQuestionCh($answerId, $questionId){
		$rep = new SharedRepository();
		$rep->delete("answer", $answerId);

		foreach ($questionId as $item)
		$rep->delete("question", $item);

	}

	function addQuestionTeacherCh(){//todo
		echo "<input name='Question' placeholder='Question' type='text' ><input name='Answer' placeholder='Answer' type='text'>";
	}
	function addQuestionStudentCh($questionId){//todo
		$rep = new SharedRepository();
		$question = $rep->selectAll("question", ["id"=>$questionId]);

		echo "<label for='Answer' >".$question["value"]."</label><input name='Answer' placeholder='Answer' type='text'>";
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

