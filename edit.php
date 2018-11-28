<?php
	session_start();
?>
<!doctype html>
<html lang="se">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">  
		<title>Soloäventyr - Redigera</title>
		<link href="https://fonts.googleapis.com/css?family=Merriweather%7cMerriweather+Sans" rel="stylesheet"> 
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	</head>
	<body style="background-color:grey; text-align:center;">
		<nav class="navbar navbar-extend-lg bg-dark sticky-top">
			<a href="index.php" class="btn btn-light">Hem</a>
			<a href="play.php" class="btn btn-light">Spela</a>
			<a href="edit.php" class="btn btn-danger">Redigera</a>
		</nav>
		<main class="content">
			<section>
				<h1>Redigera</h1>

				<?php
				
				include_once 'include/dbinfo.php';

				$_SESSION['loggedIn'] = true;

				
				if($_SESSION['loggedIn'] == true){

					echo '<form action="" method="POST">
						<textarea name="storyAdd" id="storyAdd" cols="30" rows="10"></textarea>
						<textarea name="placeAdd" id="placeAdd" cols="30" rows="1"></textarea>
						<input type="submit" name="submit" id="submit" Value="Lägg Till">
					</form>
					';
					
					$dbh = new PDO("mysql:host=" . $host . ";dbname=" . $db . ";charset=utf8mb4", $dbuser, $dbpass);

					if(isset($_POST['submit'])){
						$filteredText = filter_input(INPUT_POST, $_POST['storyAdd'], FILTER_SANITIZE_STRING);
						$filteredPlace = filter_input(INPUT_POST, $_POST['placeAdd'], FILTER_SANITIZE_STRING);
						$stmt = $dbh->prepare("INSERT INTO story (text, place) VALUES :text, :place)");
						$stmt->bindParam(':text', $filteredText);
						$stmt->bindParam(':place', $filteredPlace);
						$stmt->execute();
						header("Location: edit.php");
					}
				}else{	
					
					if(isset($_POST['username']) && isset($_POST['password'])){

						$filteredUsername = filter_input(INPUT_POST, $_POST['username'], FILTER_SANITIZE_STRING);
						$password = $_POST['password'];

						$dbh = new PDO("mysql:host=" . $host . ";dbname=" . $db2 . ";charset=utf8mb4", $dbuser, $dbpass);

						$stmt = $dbh->prepare("SELECT * FROM login WHERE username = :username");
						$stmt->bindParam(':username', $filteredUsername);
						$stmt->execute();

						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						var_dump($stmt);
						var_dump($password);
						var_dump($row);
						var_dump($row['password']);
						var_dump(password_verify($password, $row['password']));

						if(password_verify($password, $row['password'])){
							$_SESSION['loggedIn'] = true;
							header('Location: edit.php');
						}else{
							echo '<h1>Nu blev det fel</h1>';
						}

					}else{

						echo '
						<h1>Logga In</h1>
						<form action="" method="POST">
							<p>Användarnamn<input type="text" name="username" id="username"></p>
							<p>Lösenord<input type="password" name="password" id="password"></p>
							<input type="submit" name="submit" id="submit" value="Logga In!">
						</form>
					';
					}




				}
				// TODO protect with your login
				// add, edit, delete pages & events
				// skriv ut en lista över sidor
				
				

				?>
			</section>
		</main>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>