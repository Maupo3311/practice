<?php
	if(isset($_POST['deregistration'])){
		$_SESSION['page'] = '';
		header("Location: ".$_SERVER['REQUEST_URI']);; exit();
	} else if(isset($_POST['completionOfRegistration'])){
		
		$login = $_POST['registrationLogin'];
		$password = $_POST['registrationPassword'];
		$confirm = $_POST['registrationConfirm'];
		$name = $_POST['registrationName'];
		$surname = $_POST['registrationSurname'];
		$age = $_POST['registrationAge'];
		$city = $_POST['registrationCity'];
		$sex = $_POST['registrationSex'];
		
		require 'classes/NewUser.php';
		$user = new NewUser($login, $password, $confirm, $name, $surname, $age, $city, $sex, time());
		
		if(empty($user->getErrors())){
			$data = $user->getEverything();
			$_SESSION['dataTransfer'] = [$data[0], $data[1]];
			$cache = md5($data[1]);
			
			$query = "INSERT INTO users (login, password, name, surname, age, city, sex, registrationDate) VALUES ('$data[0]', '$cache', '$data[3]', '$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]')";
			mysqli_query($link, $query) or die(mysqli_error($link));
			
			$_SESSION['page'] = '';
			header("Location: ".$_SERVER['REQUEST_URI']);; exit();
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?= $globalArray['mainHtmlHead'] ?>
		<link href='data/styles/registration.css' rel='stylesheet'>
		<title>Регистрация</title>
		<script>
			$(document).ready(function(){
				var errors = <?php
					if(isset($_POST['completionOfRegistration'])){
						if(!empty($user->getErrors())){
							$errorsArray = $user->getErrors();
							echo json_encode($errorsArray);
						} 
					} else {
						echo 0;
					}
				?>;
				if(errors != 0){
					$('#loginNotification').html(errors['login']);
					$('#passwordNotification').html(errors['password']);
					$('#confirmNotification').html(errors['confirm']);
					$('#nameNotification').html(errors['name']);
					$('#surnameNotification').html(errors['surname']);
					$('#ageNotification').html(errors['age']);
					$('#cityNotification').html(errors['city']);
					$('#sexNotification').html(errors['sex']);
					
					var arrayEverything = <?php if(isset($_POST['completionOfRegistration'])){
						echo json_encode($user->getEverything());
					} else {
						echo 0;
					}?>;
					
					$("[name='registrationLogin']").attr('value', arrayEverything[0]);
					$("[name='registrationPassword']").attr('value', arrayEverything[1]);
					$("[name='registrationConfirm']").attr('value', arrayEverything[2]);
					$("[name='registrationName']").attr('value', arrayEverything[3]);
					$("[name='registrationSurname']").attr('value', arrayEverything[4]);
					$("[name='registrationAge']").attr('value', arrayEverything[5]);
					$("[name='registrationCity']").attr('value', arrayEverything[6]);
					
				}
				
				$("[name='registrationLogin']").change(function(){
					var text = $("[name='registrationLogin']").attr('value');
					$('#loginNotification').load('ajax/registration/loginVerifacation.php', 'login='+text);
				})
				$("[name='registrationPassword']").change(function(){
					var text = $("[name='registrationPassword']").attr('value');
					$('#passwordNotification').load('ajax/registration/passwordVerifacation.php', 'password='+text);
				})
				$("[name='registrationConfirm']").change(function(){
					var conf = $("[name='registrationConfirm']").attr('value');
					var password = $("[name='registrationPassword']").attr('value');
					$('#confirmNotification').load('ajax/registration/confirmVerifacation.php', 'password='+password+'&confirm='+conf);
				})
				$("[name='registrationName']").change(function(){
					var text = $("[name='registrationName']").attr('value');
					$('#nameNotification').load('ajax/registration/nameAndSurnameVerifacation.php', 'nameOrSurname='+text);
				})
				$("[name='registrationSurname']").change(function(){
					var text = $("[name='registrationSurname']").attr('value');
					$('#surnameNotification').load('ajax/registration/nameAndSurnameVerifacation.php', 'nameOrSurname='+text);
				})
				$("[name='registrationAge']").change(function(){
					var text = $("[name='registrationAge']").attr('value');
					$('#ageNotification').load('ajax/registration/ageVerifacation.php', 'age='+text);
				})
				$("[name='registrationCity']").change(function(){
					var text = $("[name='registrationCity']").attr('value');
					$('#cityNotification').load('ajax/registration/nameAndSurnameVerifacation.php', 'nameOrSurname='+text);
				})
			})
		</script>
	</head>
	<body>
		<div id='upperBand'><div id='mainDivUpperBand'></div></div>
		<div id='window' style='height: 800px'>
			<h1 id='header'>Регистрация</h1>
			<form method='POST' id='formRegistration'>
				<p class='textForm'>Логин</p>
				<input type='text' name='registrationLogin' class='RegistrationInputText' placeholder='Придумайте логин...'>
				<p class='textForm'>Пароль</p>
				<input type='password' name='registrationPassword' class='RegistrationInputText' placeholder='Придумайте пароль...'>
				<p class='textForm'>Повторите пароль</p>
				<input type='password' name='registrationConfirm' class='RegistrationInputText' placeholder='Повторите пароль...'>
				<p class='textForm'>Имя</p>
				<input type='text' name='registrationName' class='RegistrationInputText' placeholder='Введите свое имя...'>
				<p class='textForm'>Фамилия</p>
				<input type='text' name='registrationSurname' class='RegistrationInputText' placeholder='Введите свою фамилию...'>
				<p class='textForm'>Возраст</p>
				<input type='text' name='registrationAge' class='RegistrationInputText' placeholder='Введите свой возраст...'>
				<p class='textForm'>Ваш город проживания</p>
				<input type='text' name='registrationCity' class='RegistrationInputText' placeholder='Введите свой город...'>
				<p class='textForm'>Ваш пол :</p>
				<div>
					Женский<input type='radio' name='registrationSex' class='RegistrationInputRadio' <?php 
						if(isset($_POST['completionOfRegistration']) && $user->getEverything()[7] == 'woman'){
							echo 'checked';
						}
					?> value='woman'>
					Мужской<input type='radio' name='registrationSex' class='RegistrationInputRadio' <?php 
						if(isset($_POST['completionOfRegistration']) && $user->getEverything()[7] == 'male'){
							echo 'checked';
						}
					?> value='male'>
				</div>
				<input type='submit' name='completionOfRegistration' class='RegistrationSubmit'>
				<input type='submit' name='deregistration' class='RegistrationSubmit' value='Отмена'>
			</form>
			<div id='divErrorNotification'>
				<p class='errorsNotification' id='loginNotification'></p>
				<p class='errorsNotification' id='passwordNotification'></p>
				<p class='errorsNotification' id='confirmNotification'></p>
				<p class='errorsNotification' id='nameNotification'></p>
				<p class='errorsNotification' id='surnameNotification'></p>
				<p class='errorsNotification' id='ageNotification'></p>
				<p class='errorsNotification' id='cityNotification'></p>
				<p class='errorsNotification' id='sexNotification'></p>
			</div>
		</div>
	</body>
	
	<?php/*
					$idImage = 0;
					foreach($fullDataNewsesUser as $news){
						$query = "SELECT * FROM users WHERE id = '$news[idOfTheSender]'";
						$result = mysqli_query($link, $query);
						for($dataOfTheSender = []; $row = mysqli_fetch_assoc($result); $dataOfTheSender = $row);
						$avatarPutch = autoAvatar($link, $dataOfTheSender);
						
						$idImageNews = 'imageNews'.$idImage;
						$idavatarSender = 'avatarSender'.$idImage;
						
						$result = '';
						$result .= "<div class='newsBlock'>";
						$result .= "<form method='POST' class='settingUpNews'>";
						if($itPage == 'user' || $news['idOfTheSender'] == $_COOKIE['userId']){ 
							$result .= "<button type='submit' class='deleteNews' name='deleteNews' value='$news[id]'>X</button>";
						}
						$result .= "</form>";
						$result .= "<div class='theDataSender'>
							<a href='?contactId=$news[idOfTheSender]'><div class='windowAvatarSender'><img id='$idavatarSender' src='$avatarPutch'></div></a>
							<a href='?contactId=$news[idOfTheSender]'><p class='theFullNameSender'>$dataOfTheSender[name] $dataOfTheSender[surname]</p></a>
						</div>";
						if(!empty($news['text'])) $result .= "<p class='newsText'>$news[text]</p>";
						if(!empty($news['attachedFile'])){ $result .= "<div class='newsWindowImage'>
							<img id='$idImageNews' src='data/userImages/$news[userId]/userNewsImages/$news[attachedFile]' class='newsImage'>
						</div>";
						}
						$result .= "</div>";
						echo $result;
						?> <script> <?php if(!empty($news['attachedFile'])){ ?>
						processingPhoto(<?= json_encode(processingPhoto("data/userImages/$news[userId]/userNewsImages/$news[attachedFile]", 550))?>, 550, '<?= $idImageNews ?>', 'stretching'); <?php } ?>
						processingPhoto(<?= json_encode(processingPhoto($avatarPutch, 65))?>, 65, '<?= $idavatarSender ?>', 'cropping');
						</script> <?php
						$idImage++;
					}*/
				?>