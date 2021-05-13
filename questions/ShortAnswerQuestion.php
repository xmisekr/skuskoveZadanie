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

	function deleteQuestionSA( $questionId){
		$rep = new SharedRepository();
		$answer = $rep->selectOne("answer", ["question_id"=>$questionId]);

		$rep->delete("answer", $answer["id"]);
		$rep->delete("question", $questionId);//todo not working check

	}

	function addQuestionTeacherSA($questionId){
		if ($questionId == null){
			$namea= "sa ".rand();;
			$nameq= "sq ".rand();
			echo "<input name='$nameq' placeholder='Question' type='text' ><input name='$namea' placeholder='Answer' type='text'>";
		} else{
			$namea= $questionId." sa";;
			$nameq= $questionId." sq";
			$rep = new SharedRepository();
			$question = $rep->selectOne("question", ["id"=>$questionId]);
			$answer = $rep->selectOne("answer", ["question_id"=>$questionId]);
			echo "<input type='text' id='$nameq' name='$nameq' value='".$question["value"]."' > <input id='$namea' name='$namea' value='".$answer["value"]."' type='text'>";
		}

	}
	function addQuestionStudentSA($questionId){
		$rep = new SharedRepository();
		$question = $rep->selectOne("question", ["id"=>$questionId]);
		echo "<label for='".$questionId."' >".$question["value"]."</label><input class='form-control' id='".$questionId."' name='Answer' placeholder='Answer' type='text'>";
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

