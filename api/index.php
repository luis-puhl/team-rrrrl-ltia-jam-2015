<?php
require 'Slim-2.6.2/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

class User {
	public $id;
	public $name;
	public $avatar_id;
}
class Comment {
	public $id;
	public $comment;
	public $question_id;
	public $awnser_id;
}
class Question {
	public $id;
	public $question;
	public $user_id;
}
class Awnser {
	public $id;
	public $question_id;
	public $awnser;
	public $order;
	public $counter;
	public $owner_prefered;
}

$app = new \Slim\Slim(array(
    'debug' => true,
    'user.user' => 'jamUser',
	'user.pass' => 'lepass',
	'mode' => 'development',
));

$app->response->headers->set('Content-Type', 'application/json');

$app->get('/', function () use ($app) {
	$app->response->headers->set('Content-Type', 'text/html');
	$app->render('index.html');
});

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

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


$app->get('/user/:id', function ($id)  use ($app) {
	$result = new User();
	try {
		$dbh = new PDO('mysql:host=localhost;dbname=jam', 
			$app->config('user.user'), 
			$app->config('user.pass')
		);
		
		$stm = $dbh->prepare('SELECT id, name, avatar_id FROM user WHERE id = :id');
		
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


$app->run();