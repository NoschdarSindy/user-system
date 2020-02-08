<?php
mb_internal_encoding('UTF-8');
session_start();

#MySQL-Verbindung aufbauen
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'test';

$connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

#Autoloader registrieren
function autoload_class($className) {
	$file = "$className.class.php";
	if(file_exists($file)) {
		require $file;
	}
}

function autoload_sub_class($className) {
	$file = "class/$className.class.php";
	if(file_exists($file)) {
		require $file;
	}
}

function autoload_up_sub_class($className) {
	$file = "../class/$className.class.php";
	if(file_exists($file)) {
		require $file;
	}
}

spl_autoload_register('autoload_class');
spl_autoload_register('autoload_sub_class');
spl_autoload_register('autoload_up_sub_class');

#Grundfunktionen deklarieren
function loggedin() {
	return isset($_SESSION['username']);
}

function redirect($url) {
	header("Location: $url.php");
	exit;
}