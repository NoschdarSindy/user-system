<?php
require 'cfg/config.php';
//if(loggedin()) redirect('dashboard');
require 'func/form.php';
require 'const/rules/email.const.php';
require 'const/rules/password.const.php';
require 'const/rules/username.const.php';
require 'const/rules/profile_info.const.php';

$pageTitle = 'Sign Up';
include 'html/header.inc.php'; ?>
<h3 id="h-main">Sign Up</h3>
<?php
if(isset($_POST['register'])) {
	$signup = new FormProcess;
	if(Token::verify($_POST['token'])) {
		list($email, $password, $username, $slogan, $description) = FormProcess::expect('email', 'password', 'username', 'slogan', 'description');
		
		if($signup->vStr([$username, $email], [UNAME, EMAIL])) {
			echo "YESSSSSSSSSSSSSSS";
			#Auf bereits registrierte Email-Adresse oder Nutzernamen prüfen
			if($stmt = $connect->prepare('SELECT email, username FROM users WHERE email=? OR username=?')) {
				$stmt->bind_param('ss', $email, $username);
				$stmt->execute();
				$stmt->bind_result($dbMail, $dbUsername);
				while($stmt->fetch()) {
					if($dbMail === $email) {
						$signup->addError('The email addres is already in use!');
					}
					if($dbUsername === $username) {
						$signup->addError('This username already exists!');
					}
				}
				$stmt->close();
			}
		}

		$signup->vStr([$password, $slogan, $description], [PWORD, SLOGN, DESCR]);
	} else {
		$signup->addError(Token::ERR);
	}
	
	if($signup->errors) {
		$signup->listErrors();
	} else {
		#Password-Hash erstellen, restliche Eingaben trimmen und den Nutzer registrieren und anmelden
		$password = password_hash($password, PASSWORD_DEFAULT);
		$slogan = trim($slogan);
		$description = trim($description);
		if($stmt = $connect->prepare('INSERT INTO users(email, password, username, slogan, description, registered) VALUES(?, ?, ?, ?, ?, CURDATE())')) {
			$stmt->bind_param('sssss', $email, $password, $username, $slogan, $description);
			$stmt->execute();
			$stmt->close();
			$_SESSION['username'] = $username;
			redirect('dashboard');
		} else {
			echo "Keine Datenbank vorhanden.";
		}
	}
}
?>
<form method="POST" accept-charset="UTF-8">
	<h4>Login Configuration</h4>
	<div class="info">
		This information will be visible for you only. Do not ever give out your email address and choose a strong password for your account.
	</div>
	<div>
		<p>
			Email:<br/>
			<input type="email" name="email" <?= getAttr(EMAIL) ?>>
		</p>
		<p>
			Password:<br/>
			<input type="password" name="password" <?= getAttr(PWORD) ?>>
		</p>
	</div>
	
	<h4>Profile Information</h4>
	<div class="info">
		The following will be made public on your profile page. Tell something interesting about yourself!
	</div>
	<div>
		<p>
			Username:<br/>
			<input name="username" <?= getAttr(UNAME) ?>>
		</p>
		<p>
			Slogan:<br/>
			<input name="slogan" <?= getAttr(SLOGN) ?>>
		</p>
		<p>
			Description:<br/>
			<textarea name="description" <?= getAttr(DESCR) ?>></textarea>
		</p>
	</div>
	
	<input type="submit" name="register" value="Register">
	
	<input type="hidden" name="token" value="<?= Token::generate(); ?>" />
</form>
<?php
include 'html/footer.inc.php';