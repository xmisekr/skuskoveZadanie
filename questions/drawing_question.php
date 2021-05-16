<?php
	include_once ("repository/SharedRepository.php");


	function addQuestionToDBDr($testId, $question, $questionId, $maxPoints, $answer, $answerId){
		$rep = new SharedRepository();
		if ($questionId== null){

		$a = $rep->insert("question", ["test_id"=>$testId, "value"=>$question, "type"=>"drawing", "max_points"=>$maxPoints,"review_answer"=>"1"]);
		//var_dump($a);
		$questionId=$a->insert_id;


		$a =$rep->insert("answer", ["question_id"=>$questionId, "value"=>$answer, "correct"=>"true", "points"=>$maxPoints]);

		$answerId=$a->insert_id;

	}else{
		$rep->update("question", $questionId, ["test_id"=>$testId, "value"=>$question, "type"=>"drawing", "max_points"=>$maxPoints,"review_answer"=>"1"]);


		if ($answerId==null){
			$rep->insert("answer", ["question_id"=>$questionId, "value"=>$answer, "correct"=>"true", "max_points"=>$maxPoints]);
		}else{
			$rep->update("answer", $answerId, ["question_id"=>$questionId, "value"=>$answer, "correct"=>"true", "max_points"=>$maxPoints]);
		}
	}
	}

	function deleteQuestionDr( $questionId){
		$rep = new SharedRepository();
		$answer = $rep->selectOne("answer", ["question_id"=>$questionId]);

		$rep->delete("answer", $answer["id"]);
		$rep->delete("question", $questionId);

	}

	function addQuestionTeacherDr($questionId){
		if ($questionId == null){
			$namea= "ma ".rand();;
			$nameq= "mq ".rand();
			echo "<input name='$nameq' placeholder='Question' type='drawing' ><input name='$namea' placeholder='Answer' type='drawing'>";
		} else{
			$namea= $questionId." da";;
			$nameq= $questionId." dq";
			$rep = new SharedRepository();
			$question = $rep->selectOne("question", ["id"=>$questionId]);
			$answer = $rep->selectOne("answer", ["question_id"=>$questionId]);
			echo "<input type='drawing' id='$nameq' name='$nameq' value='".$question["value"]."' > <input id='$namea' name='$namea' value='".$answer["value"]."' type='drawing'>";
		}

	}
	function addQuestionStudentDr($questionId){
		$rep = new SharedRepository();
		$question = $rep->selectOne("question", ["id"=>$questionId]);
		echo "<label for='".$questionId."' >".$question["value"]."</label><input id='".$questionId."' name='Answer' placeholder='Answer' type='drawing'>";
	}

	function submitAnswersDr($studentTestId, $questionId, $answer){
		$rep = new SharedRepository();
		$a = $rep->selectOne("answer",  ["question_id"=>$questionId, "correct"=>"true"]);
		if (strcmp(trim(strtolower($a["value"])), trim(strtolower($answer)))==0){
			$points = $a["points"];
		}else{
			$points = 0;
		}

		$rep->insert("student_test_answer", ["question_id"=>$questionId, "student_test_id"=>$studentTestId, "student_answer"=>$answer, "points"=>$points]);

	}