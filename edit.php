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
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<nav id="navbar">
			<a href="index.php">Hem</a>
			<a href="play.php">Spela</a>
			<a class="active" href="edit.php">Redigera</a>
		</nav>	
		<main class="content">
			<section>
				<h1>Redigera</h1>

				<?php
				
				include_once 'include/dbinfo.php';

				$_SESSION['loggedIn'] = false;

				
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
						$stmt = $dbh->prepare("INSERT INTO story (text, place) VALUES :text, :place");
						$stmt->bindParam(':text', $filteredText);
						$stmt->bindParam(':place', $filteredPlace);
						$stmt->execute();
						header("location: edit.php");
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
							header('location: edit.php');
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
		<script src="js/navbar.js"></script>
	</body>
</html>