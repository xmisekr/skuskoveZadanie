<!DOCTYPE html>

<html lang="en">
<head>
	 <meta charset="UTF-8">
  	<title>Sign In</title>
	<link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
	      integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" rel="stylesheet">
	<link href="style/style.css" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

</head>
	<body class="text-center">
		<form action="login.php" method="post">
			<div class="col text-center" id="formDiv" style="max-width: 330px">
				<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();
	include_once ("repository/SharedRepository.php");

	require_once("app/Database.php");
	$conn = (new Database())->createConnectioon();
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//echo "post";
		//var_dump($_POST);
		if (isset($_POST["password"]) && isset($_POST["email"]) && !empty($_POST["password"])  && !empty($_POST["email"]) ){
			//teacher
			echo "teacher";
			$sql = "SELECT * FROM teacher WHERE email = ?";

			$stm = $conn->prepare($sql);
			$stm->execute([$_POST["email"]]);

			$user = $stm->fetch(PDO::FETCH_ASSOC);

			//var_dump($user);
			if (isset($user['password'])){
			if (password_verify($_POST['password'], $user['password'])){
				$_SESSION['username']=$_POST["email"];
				$_SESSION['type']= "teacher";
				$_SESSION['id']= $user['id'];
				$id = $user['id'];
				//echo "successfully";
				header("location: index.php");//TODO set page
			}else{
				echo "<p style='background-color: #ffcccb; font-size: 25px'>Wrong password</p>";
			}}else{
				echo "<p style='background-color: #ffcccb; font-size: 25px'>User does not exist</p>";
			}
		}elseif (isset($_POST["examCode"]) && isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["idNumber"])){
			//student

			$sql = "SELECT * FROM test WHERE shared_key = ?";

			$stm = $conn->prepare($sql);
			$stm->execute([$_POST["examCode"]]);

			$exam = $stm->fetch(PDO::FETCH_ASSOC);

			//var_dump($exam);
			if (isset($exam['id'])){
				//echo "successfully";
				//echo "student";
				$stmStudent= $conn->prepare("INSERT IGNORE INTO student (pid, name, surname) VALUES (:pid, :name, :surname)");
				$stmStudent -> bindParam(':pid', $_POST["idNumber"]);
				$stmStudent -> bindParam(':name', $_POST["firstName"]);
				$stmStudent -> bindParam(':surname', $_POST["lastName"]);
				$stmStudent->execute();


				$sql = $conn->prepare("SELECT * FROM student WHERE pid = :pid & name =:name & surname = :surname");
				$sql -> bindParam(':pid', $_POST["idNumber"]);
				$sql -> bindParam(':name', $_POST["firstName"]);
				$sql -> bindParam(':surname', $_POST["lastName"]);
				$sql->execute();
				$student = $sql->fetch(PDO::FETCH_ASSOC);
				//var_dump($exam);
				//todo make new timer due to test timer and add it to student_test
				$stmTestTimer = $conn->prepare("SELECT * FROM timer WHERE id = :timerId");
				$stmTestTimer->bindParam(':timerId', $exam["timer_id"]);
				$stmTestTimer->execute();
				$testTimer = $stmTestTimer->fetch(PDO::FETCH_ASSOC);
				//echo "student";
				$rep = new SharedRepository();
				/*
				$stmAddTimer= $conn->prepare("INSERT INTO timer (hours, minutes, seconds) VALUES (:hours, :minutes, :seconds)");
				$stmAddTimer -> bindParam(':hours', $testTimer["hours"]);
				$stmAddTimer -> bindParam(':minutes', $testTimer["minutes"]);
				$stmAddTimer -> bindParam(':seconds', $testTimer["seconds"]);
				$exec = $stmAddTimer->execute();
				var_dump($exec);*/

				$a = $rep->insert("timer", ["hours" => $testTimer["hours"], "minutes" => $testTimer["minutes"], "seconds" => $testTimer["seconds"]]);



				$timerId = $a->insert_id;
				$stmStudent= $conn->prepare("INSERT INTO student_test (student_id, test_id, completed, in_test, timer_id) VALUES (:studentId, :testId, 0,0, :timerId)");
				$stmStudent -> bindParam(':studentId', $student["id"]);
				$stmStudent -> bindParam(':testId', $exam["id"]);
				$stmStudent -> bindParam(':timerId', $timerId);
				//$stmStudent = $rep->insert("student_test", ["student_id" => $student["id"], "test_id" => $exam["id"], "timer_id" => $timerId, "completed"=>0, "in_test"=>0]);

				try {
					$stmStudent->execute();
				}catch (Exception $exception){
					echo "<p style='background-color: #ffcccb; font-size: 25px'>You have already logged into test. You cant do it again.</p>";
				}
				$stmStudent = $conn->prepare("SELECT * FROM student_test WHERE student_id = ".$student['id']." AND test_id = ".$exam["id"]."  ");
				$stmStudent ->execute();
				$student = $stmStudent->fetch(PDO::FETCH_ASSOC);
				$_SESSION['username']=$_POST["firstName"]." ".$_POST["lastName"];
				$_SESSION['type']= "student";
				$_SESSION['studentTestId']= $student["id"];

				header("location: core/test/test.php");
			}else{
				echo "<p style='background-color: #ffcccb; font-size: 25px'>Exam code does not exist</p>";
			}
		}
	}
?>


			<div class="row form-group" style="margin-left: 2px">
				<button class="btn btn-lg btn-info " id="studentBTN" onclick="student(); return false;" style="width: 48%; background-color: #2C606A" ;>Student</button>
				<button class="btn btn-lg btn-info" id="teacherBTN" onclick="teacher(); return false;" style="width: 48%">Teacher</button>
			</div>
			<div id="formContent">
				<div id="f1" class="form-group">
					<input type="text" id="code" class="form-control" placeholder="Exam code" name="examCode" required>
				</div>
				<div id="f2" class="form-group">
					<input type="text" id="firstName" class="form-control" placeholder="First name" name="firstName" required>
				</div>
				<div id="f3" class="form-group">
					<input type="text" id="lastName" class="form-control" placeholder="Last name" name="lastName" required>
				</div>
				<div id="f4" class="form-group">
					<input type="text" id="IDNumber" class="form-control" placeholder="ID number" name="idNumber" required>
				</div>
			</div>
				<button type="submit" class="btn btn-lg btn-info btn-block"  >Sign In</button>

			</div>
			<div class="container signin">
    		<p>Are you a teacher? Does not have an account? <a href="register.php">Register</a>.</p>
  		</div>
		</form>

		<script>
			function student() {
				document.getElementById("teacherBTN").style.backgroundColor = '#2DA2B8';
				var stbtn = document.getElementById("studentBTN");
				stbtn.style.backgroundColor= '#2C606A';

				var parent = document.getElementById("f1");
				while (parent.firstChild) {
					parent.removeChild(parent.firstChild);
				}
				var y = document.createElement("INPUT");
				y.setAttribute("type", "text");
				y.setAttribute("class", "form-control");
				y.setAttribute("id", "examCode");
				y.setAttribute("placeholder", "Exam code");
				y.setAttribute("name", "examCode");
				y.required = true;
				parent.appendChild(y);

				parent = document.getElementById("f2");
				while (parent.firstChild) {
					parent.removeChild(parent.firstChild);
				}
				var x = document.createElement("INPUT");
				x.setAttribute("type", "text");
				x.setAttribute("class", "form-control");
				x.setAttribute("id", "firstName");
				x.setAttribute("placeholder", "First name");
				x.setAttribute("name", "firstName");
				x.required = true;
				parent.appendChild(x);

				parent = document.getElementById("f3");
				while (parent.firstChild) {
					parent.removeChild(parent.firstChild);
				}
				var z = document.createElement("INPUT");
				z.setAttribute("type", "text");
				z.setAttribute("class", "form-control");
				z.setAttribute("id", "lastName");
				z.setAttribute("placeholder", "Last name");
				z.setAttribute("name", "lastName");
				z.required = true;
				parent.appendChild(z);

				parent = document.getElementById("f4");
				while (parent.firstChild) {
					parent.removeChild(parent.firstChild);
				}
				a = document.createElement("INPUT");
				a.setAttribute("type", "text");
				a.setAttribute("class", "form-control");
				a.setAttribute("id", "IDNumber");
				a.setAttribute("placeholder", "ID number");
				a.setAttribute("name", "idNumber");
				a.required = true;
				parent.appendChild(a);
			}
			function teacher() {
				document.getElementById("teacherBTN").style.backgroundColor = '#2C606A';
				document.getElementById("studentBTN").style.backgroundColor= '#2DA2B8';
				var parent = document.getElementById("f1");
				while (parent.firstChild) {
					parent.removeChild(parent.firstChild);
				}
				var y = document.createElement("INPUT");
				y.setAttribute("type", "email");
				y.setAttribute("class", "form-control");
				y.setAttribute("id", "email");
				y.setAttribute("placeholder", "Email address");
				y.setAttribute("name", "email");
				y.required = true;
				parent.appendChild(y);

				parent = document.getElementById("f2");
				while (parent.firstChild) {
					parent.removeChild(parent.firstChild);
				}
				var x = document.createElement("INPUT");
				x.setAttribute("type", "password");
				x.setAttribute("class", "form-control");
				x.setAttribute("id", "password");
				x.setAttribute("placeholder", "Password");
				x.setAttribute("name", "password");
				x.required = true;
				parent.appendChild(x);
				parent = document.getElementById("f3");
				while (parent.firstChild) {
					parent.removeChild(parent.firstChild);
				}
				parent = document.getElementById("f4");
				while (parent.firstChild) {
					parent.removeChild(parent.firstChild);
				}

			}


		</script>

	</body>
</html>
