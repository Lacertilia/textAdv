<?php
	session_start();
?>
<!doctype html>
<html lang="se">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">  
	<title>Soloäventyr - Spela</title>
	<link href="https://fonts.googleapis.com/css?family=Merriweather|Merriweather+Sans" rel="stylesheet"> 
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
<!--
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit hic aliquid nostrum quibusdam veritatis? Eaque accusantium odit id deserunt, quae minima adipisci nesciunt illum ipsa ea placeat, earum laboriosam corrupti.</p>
		<footer class="gotopagelinks">
			<p>
				<a href="play.php?page=1">Nästa sida</a>
				<a href="play.php?page=2">Gå till sidan</a>
			</p>
		</footer>
-->
<?php
	include_once 'include/dbinfo.php';

	// PDO

	$dbh = new PDO('mysql:host=localhost;dbname=' . $db . ';charset=utf8mb4', $dbuser, $dbpass);

	if (isset($_GET['page'])) {
		// TODO load requested page from DB using GET
		// prio before session
		// set session to remember
		$filteredPage = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);

		$_SESSION['page'] = $filteredPage;

		if($_SESSION['page'] == 4 || $_SESSION['page'] == 2 || $_SESSION['page'] == 5){
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

		/*echo "<p>Requested page " . $filteredPage . "</p>";*/
	} else if(isset($_SESSION['page'])) {
		// TODO load page from db
		// use for returning player / cookie

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
			echo "<a href=\"?page=" . $val['target'] .  "\">" . $val['text'] . "</a><br>";
		}

	} else {
		// TODO load start of story from DB
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
</main>
<script src="js/navbar.js"></script>
</body>
</html>