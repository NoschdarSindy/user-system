<?php
require 'cfg/config.php';
if(loggedin()) redirect('dashboard');

if(isset($_POST['login'])) {
	if(Token::verify($_POST['token'])) {
		if(!empty($_POST['email']) && !empty($_POST['password'])) {
			if(Captcha::verify('login_captcha')) { #Captcha richtig oder gar nicht gefragt, Login erlauben
				if($stmt = $connect->prepare('SELECT username, password FROM users WHERE email=? LIMIT 1')) {
					$email = $_POST['email'];
					$stmt->bind_param('s', $email);
					$stmt->execute();
					$stmt->store_result();
					if($stmt->num_rows === 0) {
						$error = 'User does not exist!';
					} else {
						$password = $_POST['password'];
						$stmt->bind_result($username, $dbHash);
						$stmt->fetch();
						if(password_verify($password, $dbHash)) { #Login erfolgreich, Weiterleitung zum Dashboard
							$_SESSION['username'] = $username;
							redirect('dashboard');
						} else { #Nutzername/ Kennwort falsch, fordere Captcha-Eingabe
							Captcha::generate('login_captcha');
							$error = 'Wrong email or password!';
						}
					}
					$stmt->close();
				}
			} else {
				$error = Captcha::ERR;
			}
		} else {
			$error = 'Fill in all fields!';
		}
	} else {
		$error = Token::ERR;
	}
}

$pageTitle = 'Index';
include 'html/header.inc.php';
?>
Das ist die Indexseite mit dynamischem Inhalt.
<?php
include 'html/sidebar.inc.php';
include 'html/footer.inc.php';
?>