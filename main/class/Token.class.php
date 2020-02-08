<?php
class Token {
	const ERR = 'Token mismatch';
	
	static function generate() {
		return $_SESSION['token'] = bin2hex(random_bytes(32));
	}
	
	static function verify($token) {
		if(isset($_SESSION['token']) && $token === $_SESSION['token']) {
			unset($_SESSION['token']);
			return true;
		}
		return false;
	}
}