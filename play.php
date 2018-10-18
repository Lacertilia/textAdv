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
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav id="navbar">
	<a href="index.php">Hem</a>
	<a class="active" href="play.php">Spela</a>
	<a href="edit.php">Redigera</a>
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

		if($_SESSION['page'] == 4 || $_SESSION['page'] == 2 || $_SESSION['page'] == 5 || $_SESSION['page'] == 8){
			$_SESSION['page'] = 1;
		}

		$stmt = $dbh->prepare("SELECT * FROM story WHERE id = :id");
		$stmt->bindParam(':id', $filteredPage);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		echo "<p>" . $row['text'] . "</p>";

		$stmt = $dbh->prepare("SELECT * FROM storylinks WHERE storyid = :id");
		$stmt->bindParam(':id', $filteredPage);
		$stmt->execute();

		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach($row as $val){
			echo "<a href=\"?page=" . $val['target'] .  "\">" . $val['text'] . "</a><br>";
		}

	} else if(isset($_SESSION['page'])) {

		$filteredPage = $_SESSION['page'];

		$stmt = $dbh->prepare("SELECT * FROM story WHERE id = :id");
		$stmt->bindParam(':id', $filteredPage);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		echo "<p>" . $row['text'] . "</p>";

		$stmt = $dbh->prepare("SELECT * FROM storylinks WHERE storyid = :id");
		$stmt->bindParam(':id', $filteredPage);
		$stmt->execute();

		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach($row as $val){
			echo "<a href=\"?page=" . $val['target'] . "\">" . $val['text'] . "</a><br>";
		}

	} else {
		
		$stmt = $dbh->prepare("SELECT * FROM story WHERE id = 1");
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		echo "<p>" . $row['text'] . "</p>";

		$stmt = $dbh->prepare("SELECT * FROM storylinks WHERE storyid = 1");
		$stmt->execute();

		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach($row as $val){
			echo "<a href=\"?page=" . $val['target'] .  "\">" . $val['text'] . "</a><br>";
		}

	}

?>
</section>
</main>
<script src="js/navbar.js"></script>
</body>
</html>