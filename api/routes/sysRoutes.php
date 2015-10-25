<?php

$app->get('/', function () use ($app) {
	$app->response->headers->set('Content-Type', 'text/html');
	$app->render('documentation.html');
});

// this is login 
$app->post('/login', function ()  use ($app, $dbo) {
	// destroy previous
	logout();
	
	$userName = $app->request->post('name');
	$userPass = $app->request->post('pass');

	$result = new User();
	try {
		$stm = $dbo->prepare('SELECT id, name, avatar_id FROM user WHERE name = :name AND pass = :pass');
		
		$stm->setFetchMode(PDO::FETCH_INTO, $result);
		$stm->execute(array(':name' => $userName, ':pass' => $userPass));
		$result = $stm->fetch();

		if ($result && $result->id != null){
			// start new
			session_start();
			login($result->id);
		} else {
			$app->halt(403, '{"message":"Incorrect user info."}');
		}
	} catch (PDOException $e) {
		print "Error: " . $e->getMessage() . "<br/>";
		die();
	}

	echo json_encode($result);
});

$app->post('/logout', function(){
	logout();
	echo json_encode( new User() );
});

$app->hook('slim.before.dispatch', function () use ($app) {
	if ( !authenticate() ){
		$route = $app->router()->getCurrentRoute()->getPattern();
		if (!preg_match('/^\/login.*/', $route) && !preg_match('/^\/logout.*/', $route)){
			$app->halt(403, '{"message":"Stop the aliens from accessing!"}');
		}
	}
});