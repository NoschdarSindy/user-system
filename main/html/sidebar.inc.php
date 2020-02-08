</main>
<aside>
<?php if(loggedin()) { ?>
	Welcome back, <?= $_SESSION['username'] ?>!<br/>
	<a href="action/logout.php">Log Out</a>
<?php } else { ?>
	<h4>Log In</h4><hr/>
	<?= isset($error) ? "<div class='alert'>$error</div>" : '' ?>
	<form method="POST">
		<table>
			<tr>
				<td>Email:</td>
				<td><input type="email" name="email" required></td>
			</tr>
			<tr>
				<td>Passwort:</td>
				<td><input type="password" name="password" required></td>
			</tr>
			<?php if(isset($_SESSION['login_captcha'])) { ?>
				<tr>
					<td></td><td><img src="cpt/create.php?c=login_captcha"></td>
				</tr>
				<tr>
					<td>Captcha:</td><td><input type="text" name="login_captcha" required></td>
				</tr>
			<?php } ?>
			<tr>
				<td></td><td><input type="submit" name="login" value="Log In"> <input type="submit" formaction="register.php" value="Register"></td>
			</tr>
		</table>
		<input type="hidden" name="token" value="<?= Token::generate() ?>">
	</form>
<?php } ?>
</aside>