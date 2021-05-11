<?php
	include_once ("repository/SharedRepository.php");


	function addQuestionToDBSA($testId, $question, $questionId, $maxPoints, $answer, $answerId){
		$rep = new SharedRepository();
		if ($questionId== null){

		$a = $rep->insert("question", ["test_id"=>$testId, "value"=>$question, "type"=>"text", "max_points"=>$maxPoints,"review_answer"=>"1"]);
		//var_dump($a);
		$questionId=$a->insert_id;


		$a =$rep->insert("answer", ["question_id"=>$questionId, "value"=>$answer, "correct"=>"true", "points"=>$maxPoints]);

		$answerId=$a->insert_id;

	}else{
		$rep->update("question", $questionId, ["test_id"=>$testId, "value"=>$question, "type"=>"text", "max_points"=>$maxPoints,"review_answer"=>"1"]);


		if ($answerId==null){
			$rep->insert("answer", ["question_id"=>$questionId, "value"=>$answer, "correct"=>"true", "max_points"=>$maxPoints]);
		}else{
			$rep->update("answer", $answerId, ["question_id"=>$questionId, "value"=>$answer, "correct"=>"true", "max_points"=>$maxPoints]);
		}
	}
	}
	function getFromDBSa(){
		//todo
	}

	function deleteQuestionSA($answerId, $questionId){
		$rep = new SharedRepository();
		$rep->delete("answer", $answerId);
		$rep->delete("question", $questionId);

	}

	function addQuestionTeacherSA(){
		echo "<input name='Question' placeholder='Question' type='text' ><input name='Answer' placeholder='Answer' type='text'>";
	}
	function addQuestionStudentSA($questionId){
		$rep = new SharedRepository();
		$question = $rep->selectAll("question", ["id"=>$questionId]);

		echo "<label for='Answer' >".$question["value"]."</label><input name='Answer' placeholder='Answer' type='text'>";
	}

	function submitAnswersSA($studentTestId, $questionId, $answer){
		$rep = new SharedRepository();
		$a = $rep->selectOne("answer",  ["question_id"=>$questionId, "correct"=>"true"]);
		if (strcmp(trim(strtolower($a["value"])), trim(strtolower($answer)))==0){
			$points = $a["points"];
		}else{
			$points = 0;
		}

		$rep->insert("student_test_answer", ["question_id"=>$questionId, "student_test_id"=>$studentTestId, "student_answer"=>$answer, "points"=>$points]);

	}

