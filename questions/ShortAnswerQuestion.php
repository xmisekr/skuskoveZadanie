<?php

	require_once("app/Database.php");
	class ShortAnswerQuestion {
		private $question;
		private $answer;
		private $testId;
		private $questionId;
		private $maxPoints;
		private $conn;
		private $answerId;

		public function getQuestion(){
			return $this->question;
			$conn = (new Database())->createConnectioon();

		}

		/**
		 * @param mixed $question
		 */
		public function setQuestion($question)
		{
			$this->question = $question;
		}

		/**
		 * @return mixed
		 */
		public function getAnswer()
		{
			return $this->answer;
		}

		/**
		 * @param mixed $answer
		 */
		public function setAnswer($answer)
		{
			$this->answer = $answer;
		}

		/**
		 * @return mixed
		 */
		public function getTestId()
		{
			return $this->testId;
		}

		/**
		 * @param mixed $testId
		 */
		public function setTestId($testId)
		{
			$this->testId = $testId;
		}

		/**
		 * @return mixed
		 */
		public function getQuestionId()
		{
			return $this->questionId;
		}

		/**
		 * @param mixed $questionId
		 */
		public function setQuestionId($questionId)
		{
			$this->questionId = $questionId;
		}

		/**
		 * @return mixed
		 */
		public function getMaxPoints()
		{
			return $this->maxPoints;
		}

		/**
		 * @param mixed $maxPoints
		 */
		public function setMaxPoints($maxPoints)
		{
			$this->maxPoints = $maxPoints;
		}

		/**
		 * @return mixed
		 */
		public function getConn()
		{
			return $this->conn;
		}

		/**
		 * @param mixed $conn
		 */
		public function setConn($conn)
		{
			$this->conn = $conn;
		}

		/**
		 * @return mixed
		 */
		public function getAnswerId()
		{
			return $this->answerId;
		}

		/**
		 * @param mixed $answerId
		 */
		public function setAnswerId($answerId)
		{
			$this->answerId = $answerId;
		}


		/**
		 * ChoiceQuestion constructor.
		 */
		public function __construct($testId){
			$this->testId=$testId;
		}

		public function addQuestionToDB(){
			if ($this->questionId== null){
				$stmQuestion= $this->conn->prepare("INSERT INTO question ( test_id, value, type, max_points) VALUES (:testId, :question, 'choice',:maxpoints)");
				$stmQuestion -> bindParam(':testId', $this->testId);
				$stmQuestion -> bindParam(':question', $this->question);
				$stmQuestion -> bindParam(':maxPoints', $this->maxPoints);
				$stmQuestion->execute();

				$stmQuestionId = $this->conn->prepare("SELECT id FROM question WHERE test_id = $this->testId & value = $this->question & type = 'choice' & max_points = $this->maxPoints");
				$stmQuestionId->execute();
				$a = $stmQuestionId->fetch(PDO::FETCH_ASSOC);
				$this->questionId = $a["id"];

				$stmAnswer= $this->conn->prepare("INSERT INTO answer ( question_id, value, correct, points) VALUES (:questionId, :answer, :correct,:points)");
				$stmAnswer -> bindParam(':questionId', $this->questionId);
				$stmAnswer -> bindParam(':answer', $this->answer);
				$stmAnswer -> bindParam(':correct', 'true');
				$stmAnswer -> bindParam(':maxPoints', $this->maxPoints);
				$stmAnswer->execute();

				$stmAnswerId= $this->conn->prepare("SELECT id FROM answer WHERE  question_id = $this->questionId & value = $this->answer & correct = 'true' & points= $this->maxPoints");
				$stmAnswerId->execute();
				$a = $stmAnswerId->fetch(PDO::FETCH_ASSOC);
				$this->questionId = $a["id"];
			}else{
				$stmQuestion= $this->conn->prepare("UPDATE question SET value = :question, max_points = :maxpoints WHERE id = $this->questionId");
				$stmQuestion -> bindParam(':question', $this->question);
				$stmQuestion -> bindParam(':maxPoints', $this->maxPoints);
				$stmQuestion->execute();

				$stmAnswer= $this->conn->prepare("UPDATE answer SET  value = :answer, points = :points WHERE id = $this->answerId");
				$stmAnswer -> bindParam(':answer', $this->answer);
				$stmAnswer -> bindParam(':maxPoints', $this->maxPoints);
				$stmAnswer->execute();
			}

		}
		public function deleteQuestion(){

		}

		public function addQuestionToForm(){

		}
		public function addOptionToForm(){

		}

		public function submitAnswers(){

		}


	}