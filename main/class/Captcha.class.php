<?php
const ERR = 'Wrong captcha';

class Captcha {
	static function generate($name) {
		$_SESSION[$name] = rand(10000000, 99999999);
	}
	
	static function verify($name) {
		if(!isset($_SESSION[$name])) {
			return true;
		}
		if(isset($_POST[$name]) && (int)$_POST[$name] === $_SESSION[$name]) {
			unset($_SESSION[$name]);
			return true;
		}
		return false;
	}
}