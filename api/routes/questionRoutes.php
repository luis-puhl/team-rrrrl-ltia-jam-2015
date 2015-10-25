<?php

$app->get('/question/:id', function ($id) use ($app) {
	$result = new Question();
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=jam', 
			$app->config('user.user'), 
			$app->config('user.pass')
		);
		$stm = $dbh->prepare('SELECT * FROM question WHERE id = :id');

		$stm->setFetchMode(PDO::FETCH_INTO, $result);
		$stm->execute(array(':id' => $id));
		$result = $stm->fetch();

		$dbh = null;
	} catch (PDOException $e) {
		print "Error: " . $e->getMessage() . "<br/>";
		die();
	}
	
	echo json_encode($result);
});

