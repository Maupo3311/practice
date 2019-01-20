<?php

	$id = $_COOKIE['userId'];
	
	$query = "SELECT * FROM users WHERE id = '$id'";
	$result = mysqli_query($link, $query);
	for($fullDataUser = []; $row = mysqli_fetch_assoc($result); $fullDataUser[] = $row);
	$fullDataUser = $fullDataUser[0];
	
?>
<!DOCTYPE html>
<html>
	<head>
		<?= $globalArray['mainHtmlHead'] ?>
		<link href='data/styles/mainPage.css' rel='stylesheet'>
		<script type="text/javascript" src="scripts/mainFunctions.js"></script>
		<title>Practice</title>
		<script>
			$(document).ready(function(){
				$('#buttonForBlockOutput').click(function(){
					$('#buttonForBlockOutput').css({'display': 'none'});
					$('#shareTheNews').css({'display': 'block'});
				})
				$('#shareTheNews').blur(function(){
					$('#buttonForBlockOutput').css({'display': 'block'});
					$('#shareTheNews').css({'display': 'none'});
				})
			})
		</script>
	</head>
	<body>
		<div id='upperBand'>
			<div id='mainDivUpperBand'>
				<a href='?exit' class='aButton' id='exitButton'>Выйти</a>
			</div>
		</div>
		<div id='window'>
			<div id='avatarWindow'><img id='avatar' src='data/userImages/noAvatar.png'></div>
			<div id='userData'>
				<h1 id='fullNameUser'><?= "$fullDataUser[name] $fullDataUser[surname]" ?></h1>
				<p class='additionalData'>Город: <?= "$fullDataUser[city]" ?></p>
				<p class='additionalData'>Возраст: <?= "$fullDataUser[age]" ?></p>
			</div>
			<div id='userMenu'>
				<a href='?gallery' class='aButton'>Изображения</a>
			</div>
			<div id='newsWindow'>
				<div id='buttonForBlockOutput'>Поделиться записью</div>
				<textarea id='shareTheNews'></textarea>
			</div>
		</div>
	</body>
</html>