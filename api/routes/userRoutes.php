<?php

$app->get('/user/:id', function ($id)  use ($app, $dbo) {
	$result = new User();
	try {
		$stm = $dbo->prepare('SELECT id, name, avatar_id FROM user WHERE id = :id');
		
		$stm->setFetchMode(PDO::FETCH_INTO, $result);
		$stm->execute(array(':id' => $id));
		$result = $stm->fetch();

	} catch (PDOException $e) {
		print "Error: " . $e->getMessage() . "<br/>";
		die();
	}
	
	echo json_encode($result);
});
