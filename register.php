
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
	<link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
		  integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" rel="stylesheet">
	<link href="style/style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<article>
	<?php
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		session_start();
		require_once("app/Database.php");
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if (isset($_POST["email"]) && isset($_POST["psw"]) && isset($_POST["psw-repeat"])){
				if (strcmp($_POST["psw"], $_POST["psw-repeat"])==0){
					try {
						$conn = (new Database())->createConnectioon();
						$stm = $conn->prepare("INSERT INTO teacher (email, password) VALUES (?,?)");
						$hash = password_hash($_POST["psw"], PASSWORD_DEFAULT);
						$stm->execute([$_POST["email"], $hash]);

						$query = $conn->prepare("SELECT id FROM teacher WHERE email = ?");
						 $query->execute([$_POST["email"]]);
						$id = $query->fetch();
						$_SESSION['username']=$_POST["email"];
						$_SESSION['type']= "teacher";
						$_SESSION['id']= $id['id'];
						header("location: index.php");//todo to teacher index
					}catch (Exception $e){
						echo "Connection failed: " . $e->getMessage();
					}
				}else{
					echo "<p class='text-center' style='background-color: #ffcccb; font-size: 25px'>Passpords are different</p>";
				}
			}
		}
	?>

	<form action="register.php" method="post">
		<div class="col text-center" id="formDiv" style="max-width: 330px">
  		<div class="container">
    		<h1>Register</h1>
    		<p>Please fill in this form to create an account.</p>
    		<br>
    		<input type="email" placeholder="Email address" name="email" id="email" required class="form-control">
			<br>
    		<input type="password" placeholder="Password" name="psw" id="psw" required class="form-control">
			<br>
    		<input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required class="form-control">
    		<br>

    		<p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
		    <script>
			    //TODO above href
		    </script>
    		<button type="submit" class="btn btn-lg btn-info btn-block">Register</button>
  		</div>

  		<div class="container signin">
    		<p>Already have an account? <a href="login.php">Sign in</a>.</p>
  		</div>
	</div>
	</form>
	</article>
</body>
</html>