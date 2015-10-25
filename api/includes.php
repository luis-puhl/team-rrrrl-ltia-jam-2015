<?php

// classes 
require 'class/User.php';
require 'class/Question.php';
require 'class/Awnser.php';
require 'class/Comment.php';

const SESSION_KEY = 'userId';

function authenticate(){
	if (isset($_SESSION[SESSION_KEY])) {
		return true;
	}
	return false;
}

function logout (){
	session_destroy();
	unset($_SESSION[SESSION_KEY]);
}

function login($id){
	$_SESSION[SESSION_KEY] = $id;
}