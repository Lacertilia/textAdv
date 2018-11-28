<?php
	session_start();
?>
<!doctype html>
<html lang="se">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">  
	<title>Soloäventyr - Spela</title>
	<link href="https://fonts.googleapis.com/css?family=Merriweather%7cMerriweather+Sans" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body style="background-color:grey; text-align:center;">
<nav class="navbar navbar-extend-lg bg-dark sticky-top">
	<a href="index.php" class="btn btn-light">Hem</a>
	<a href="play.php" class="btn btn-danger">Spela</a>
	<a href="edit.php" class="btn btn-light">Redigera</a>
</nav>	
<main class="content">
	<section>
		<h1>Spela</h1>

<?php
	include_once 'include/dbinfo.php';

	// PDO

	$dbh = new PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8mb4', $dbuser, $dbpass);

	if (isset($_GET['page'])) {
		
		$filteredPage = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);

		if($filteredPage == 0){
			$filteredPage = 1;
		}

		$_SESSION['page'] = $filteredPage;

		if($_SESSION['page'] == 4 || $_SESSION['page'] == 2 || $_SESSION['page'] == 5 || $_SESSION['page'] == 8 || $_SESSION['page'] == 12){
			$_SESSION['page'] = 1;
		}

		$stmt = $dbh->prepare("SELECT * FROM story WHERE id = :id");
		$stmt->bindParam(':id', $filteredPage);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		echo "<p class=\"font-weight-bold\" style=\"font-size:1.2em;\">" . $row['text'] . "</p>";

		$stmt = $dbh->prepare("SELECT * FROM storylinks WHERE storyid = :id");
		$stmt->bindParam(':id', $filteredPage);
		$stmt->execute();

		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach($row as $val){
			echo "<a href=\"?page=" . $val['target'] .  "\" class=\"btn btn-dark mr-2\">" . $val['text'] . "</a>";
		}

	} else if(isset($_SESSION['page'])) {

		$filteredPage = $_SESSION['page'];

		$stmt = $dbh->prepare("SELECT * FROM story WHERE id = :id");
		$stmt->bindParam(':id', $filteredPage);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		echo "<p class=\"font-weight-bold\" style=\"font-size:1.2em;\">" . $row['text'] . "</p>";

		$stmt = $dbh->prepare("SELECT * FROM storylinks WHERE storyid = :id");
		$stmt->bindParam(':id', $filteredPage);
		$stmt->execute();

		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach($row as $val){
			echo "<a href=\"?page=" . $val['target'] . "\" class=\"btn btn-dark mr-2\">" . $val['text'] . "</a>";
		}

	} else {
		
		/*$stmt = $dbh->prepare("SELECT * FROM story WHERE id = 1");
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		echo "<p>" . $row['text'] . "</p>";

		$stmt = $dbh->prepare("SELECT * FROM storylinks WHERE storyid = 1");
		$stmt->execute();

		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach($row as $val){
			echo "<a href=\"?page=" . $val['target'] .  "\">" . $val['text'] . "</a><br>";
		}
*/
		$_SESSION['page'] = 1;
		header("Location: play.php");	
	}

?>
</section>
</main>
<script src="js/navbar.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>