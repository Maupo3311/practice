<?php
	require 'classes/NewUser.php';
	$id = $_COOKIE['userId'];
	$updateUser = new NewUser;
	$updateUser->userData = $fullDataMainUser;
	$url = strtok($_SERVER['REQUEST_URI'], '?');
	
	if(isset($_POST['updateLogin'])){
		$updateUser->setLogin($_POST['newLogin'], $_POST['currentLogin']);
		if(empty($updateUser->getErrors()['login'])){
			$query = "UPDATE users SET login = '$_POST[newLogin]' WHERE id = '$_COOKIE[userId]'";
			mysqli_query($link, $query) or die(mysqli_error($link));
			$_SESSION['alert'] = '<span style="color: green">Логин успешно изменен ✔</span>';
			header("Location: $url"); exit();
		} else {
			$_SESSION['alert']  = $updateUser->getErrors()['login'];
		}
	} else if(isset($_POST['updatePassword'])){
		$updateUser->setPassword($_POST['newPassword'], $_POST['confirmNewPassword'], $_POST['currentPassword']);
		if(empty($updateUser->getErrors()['password']) && empty($updateUser->getErrors()['confirm'])){
			$query = "UPDATE users SET password = '".md5($_POST[newPassword])."' WHERE id = '$_COOKIE[userId]'";
			mysqli_query($link, $query) or die(mysqli_error($link));
			$_SESSION['alert'] = '<span style="color: green">Пароль успешно изменен ✔</span>';
			header("Location: $url"); exit();
		} else {
			if(!empty($updateUser->getErrors()['password'])){
				$_SESSION['alert']  = $updateUser->getErrors()['password'];
			} else {
				$_SESSION['alert']  = $updateUser->getErrors()['confirm'];
			}
		}
	} else if(isset($_POST['updateName'])){
		$updateUser->setName($_POST['newName']);
		if(empty($updateUser->getErrors()['name'])){
			$query = "UPDATE users SET name = '$_POST[newName]' WHERE id = '$_COOKIE[userId]'";
			mysqli_query($link, $query) or die(mysqli_error($link));
			$_SESSION['alert'] = '<span style="color: green">Имя успешно изменено ✔</span>';
			header("Location: $url"); exit();
		} else {
			$_SESSION['alert']  = $updateUser->getErrors()['name'];
		}
	} else if(isset($_POST['updateSurname'])){
		$updateUser->setSurname($_POST['newSurname']);
		if(empty($updateUser->getErrors()['surname'])){
			$query = "UPDATE users SET surname = '$_POST[newSurname]' WHERE id = '$_COOKIE[userId]'";
			mysqli_query($link, $query) or die(mysqli_error($link));
			$_SESSION['alert'] = '<span style="color: green">Фамилия успешно изменена ✔</span>';
			header("Location: $url"); exit();
		} else {
			$_SESSION['alert']  = $updateUser->getErrors()['surname'];
		}
	} else if(isset($_POST['updateAge'])){
		$updateUser->setAge($_POST['newAge']);
		if(empty($updateUser->getErrors()['age'])){
			$query = "UPDATE users SET age = '$_POST[newAge]' WHERE id = '$_COOKIE[userId]'";
			mysqli_query($link, $query) or die(mysqli_error($link));
			$_SESSION['alert'] = '<span style="color: green">Возраст успешно изменен ✔</span>';
			header("Location: $url"); exit();
		} else {
			$_SESSION['alert'] = $updateUser->getErrors()['age'];
		}
	} else if(isset($_POST['updateCity'])){
		$updateUser->setCity($_POST['newCity']);
		if(empty($updateUser->getErrors()['city'])){
			$query = "UPDATE users SET city = '$_POST[newCity]' WHERE id = '$_COOKIE[userId]'";
			mysqli_query($link, $query) or die(mysqli_error($link));
			$_SESSION['alert'] = '<span style="color: green">Город успешно изменен ✔</span>';
			header("Location: $url"); exit();
		} else {
			$_SESSION['alert']  = $updateUser->getErrors()['city'];
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?= $globalArray['mainHtmlHead'] ?>
		<link href='data/styles/mainPage.css' rel='stylesheet'>
		<link href='data/styles/setting.css' rel='stylesheet'>
		<script type="text/javascript" src="scripts/mainFunctions.js"></script>
		<title>Друзья</title>
		<script>
			$(document).ready(function(){
				$("img").click(function(){ zoomImage(this, document.body) });
				pageFit('newsBlock', window.pageYOffset);
				$("#accordion").accordion();
			})
		</script>
	</head>
	<body>
		<div id='upperBand'>
			<div id='mainDivUpperBand'>
				<div id='userDataInUpperBand' onclick='menuInUpperBandOpenClose()'>
					<p id='userNameInUpperBand'><?= $fullDataMainUser['name'] ?></p>
					<div id='windowAvatarUserInUpperBand'>
						<img id='avatarUserInUpperBand' src='<?= autoAvatar($link, $fullDataMainUser) ?>'>
						<script> processingPhoto(<?= json_encode(processingPhoto(autoAvatar($link, $fullDataMainUser), 37))?>, 37, 'avatarUserInUpperBand', 'cropping') </script>
					</div>
					<div id='menuInUpperBand' data-checkMenu='closed'>
						<a href='?setting' class='aButton menuInUpperBandButton' id='settingButton'><p>Настройки</p></a>
						<a href='?exit' class='aButton menuInUpperBandButton' id='exitButton'><p>Выйти</p></a>
					</div>
				</div>
				
			</div>
		</div>
		<div id='window' style='height: 600px'>
			<div id='avatarWindow'><img id='avatar' src='<?= autoAvatar($link, $fullDataMainUser) ?>'></div>
			<script> processingPhoto(<?= json_encode(processingPhoto(autoAvatar($link, $fullDataMainUser), 250))?>, 250, 'avatar', 'cropping') </script>
			<div id='userMenu'>
				<a href='?mainPage' class='aButton'><div class='menuButton'>Моя страница</div></a>
				<a href='?friends' class='aButton'><div class='menuButton'>Друзья</div></a>
				<a href='?gallery' class='aButton'><div class='menuButton'>Фотографии</div></a>
			</div>
			<div id='settingWindow'>
				<div id="accordion">
					<h2><a href="#">Изменить логин</a></h2>
					<div>
						<form method='POST' class='formUpdate'>
							<p class='p'>Введите текущий логин  <input class='inputTextUpdate' type='text' name='currentLogin'></p>
							<p class='p'>Введите новый логин  <input class='inputTextUpdate' type='text' name='newLogin'></p>
							<p class='p'><input class='submitInputUpdate' type='submit' name='updateLogin' value='Изменить логин'></p>
						</form>
					</div>
					<h2><a href="#">Изменить пароль</a></h2>
					<div>
						<form method='POST' class='formUpdate'>
							<p class='p'>Введите текущий пароль  <input class='inputTextUpdate' type='password' name='currentPassword'></p>
							<p class='p'>Введите новый пароль  <input class='inputTextUpdate' type='password' name='newPassword'></p>
							<p class='p'>Повторите новый пароль  <input class='inputTextUpdate' type='password' name='confirmNewPassword'></p>
							<p class='p'><input class='submitInputUpdate' type='submit' name='updatePassword' value='Изменить пароль'></p>
						</form>
					</div>
					<h2><a href="#">Изменить имя</a></h2>
					<div>
						<form method='POST' class='formUpdate'>
							<p class='p' style='text-align: center'> Текущее имя - <?= $fullDataMainUser['name'] ?> </p>
							<p class='p'>Новое имя  <input class='inputTextUpdate' type='text' name='newName'></p>
							<p class='p'><input class='submitInputUpdate' type='submit' name='updateName' value='Изменить имя'></p>
						</form>
					</div>
					<h2><a href="#">Изменить фамилию</a></h2>
					<div>
						<form method='POST' class='formUpdate'>
							<p class='p' style='text-align: center'> Текущая фамилия - <?= $fullDataMainUser['surname'] ?> </p>
							<p class='p'>Новая фамилия  <input class='inputTextUpdate' type='text' name='newSurname'></p>
							<p class='p'><input class='submitInputUpdate' type='submit' name='updateSurname' value='Изменить фамилию'></p>
						</form>
					</div>
					<h2><a href="#">Изменить возраст</a></h2>
					<div>
						<form method='POST' class='formUpdate'>
							<p class='p' style='text-align: center'> Текущий возраст - <?= $fullDataMainUser['age'] ?> </p>
							<p class='p'>Новый возраст  <input class='inputTextUpdate' type='text' name='newAge'></p>
							<p class='p'><input class='submitInputUpdate' type='submit' name='updateAge' value='Изменить возраст'></p>
						</form>
					</div>
					<h2><a href="#">Изменить город</a></h2>
					<div>
						<form method='POST' class='formUpdate'>
							<p class='p' style='text-align: center'> Текущий город - <?= $fullDataMainUser['city'] ?> </p>
							<p class='p'>Новый город  <input class='inputTextUpdate' type='text' name='newCity'></p>
							<p class='p'><input class='submitInputUpdate' type='submit' name='updateCity' value='Изменить город'></p>
						</form>
					</div>
				</div>
				<p id='errorAlert'> <?php echo $_SESSION['alert'];  $_SESSION['alert'] = ''; ?> </p>
			</div>
		</div>
	</body>
</html>
