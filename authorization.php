<?php
	if(isset($_POST['authorizationSubmit'])){
		$login = $_POST['authorizationLogin'];
		$password = md5($_POST['authorizationPassword']);
		
		$query = "SELECT * FROM users WHERE login = '$login'";
		$result = mysqli_query($link, $query);
		for($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
		
		if(!empty($data)){
			if($data[0]['password'] == $password){
				setcookie('userId', $data[0]['id']);
				$url = strtok($_SERVER['REQUEST_URI'], '?');
				header("Location: $url"); exit();
			} else {
				$_SESSION['errorAuthorizationPassword'] = '◒ Неверный пароль';
			}
		} else {
			$_SESSION['errorAuthorizationLogin'] = '◒ Неверный логин';
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?= $globalArray['mainHtmlHead'] ?>
		<link href='data/styles/authorization.css' rel='stylesheet'>
		<title>Авторизация</title>
	</head>
	<body>
		<div id='upperBand'><div id='mainDivUpperBand'></div></div>
		<div id='window' style='height: 320px'>
			<h1 id='header'>Авторизация</h1>
			<div id='textForm'>
				<p>Логин</p>
				<p>Пароль</p>
			</div>
			<form method='POST' id='formAuthorization'>
				<input type='text' name='authorizationLogin' class='formAuthorizationInputText' id='authorizationLogin' value='<?php 
					if(isset($_SESSION['dataTransfer'])){
						echo $_SESSION['dataTransfer'][0];
					}
				?>'>
				<input type='password' name='authorizationPassword' class='formAuthorizationInputText' id='authorizationPassword' value='<?php 
					if(isset($_SESSION['dataTransfer'])){
						echo $_SESSION['dataTransfer'][1];
						unset($_SESSION['dataTransfer']);
					}
				?>'>
				<input type='submit' name='authorizationSubmit'class='submit' value='Войти'>
				<input type='submit' name='registrationSubmit' class='submit' value='Регистрация'>
			</form>
			<div id='textErrors'>
				<p><?php if(isset($_SESSION['errorAuthorizationLogin'])){
					echo $_SESSION['errorAuthorizationLogin'];
					unset($_SESSION['errorAuthorizationLogin']);
				}?></p>
				<p><?php if(isset($_SESSION['errorAuthorizationPassword'])){
					echo $_SESSION['errorAuthorizationPassword'];
					unset($_SESSION['errorAuthorizationPassword']);
				}?></p>
			</div>
		</div>
	</body>
</html>