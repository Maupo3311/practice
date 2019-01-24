<?php
	if($_SESSION['contactId'] == $_COOKIE['userId']){
		$id = $_COOKIE['userId'];
		$itPage = 'user';
		$_SESSION['contactId'] = '';
	} else if(!empty($_SESSION['contactId'])){
		$id = $_SESSION['contactId'];
		$itPage = 'contact';
	} else {
		$id = $_COOKIE['userId'];
		$itPage = 'user';
	}
	

	$mainFilePutch = "data/userImages/$id";
	if(file_exists($mainFilePutch)){
		$arrayUserImages = array_slice(scandir($mainFilePutch), 2);
	} else {
		$arrayUserImages = [];
	}
	$newArrayUserImage = [];
	foreach($arrayUserImages as $elem){
		if($elem == 'userNewsImages') continue;
		$newArrayUserImage[] = $elem;
	}

	if(isset($_POST['loadImage'])){
		if(!file_exists("$mainFilePutch")){
			mkdir("$mainFilePutch");
		}
		if(!empty($_FILES['newImage']['name'])){
			copy($_FILES['newImage']['tmp_name'], "$mainFilePutch/".basename($_FILES['newImage']['name']));
			$url = strtok($_SERVER['REQUEST_URI'], '?');
			header("Location: $url"); exit();
		}
	} else if(isset($_GET['backward'])){
		$_SESSION['page'] = '';
		$url = strtok($_SERVER['REQUEST_URI'], '?');
		header("Location: $url"); exit();
	} else if(isset($_GET['newAvatar'])){
		$newAvatar = $_GET['newAvatar'];
		$query = "UPDATE users SET avatar = '$newAvatar' WHERE id = '$id'";
		mysqli_query($link, $query);
		$_SESSION['page'] = '';
		$url = strtok($_SERVER['REQUEST_URI'], '?');
		header("Location: $url"); exit();
	}
?>
<!DOCTYPE html>
	<head>
		<?= $globalArray['mainHtmlHead'] ?>
		<link href='data/styles/gallery.css' rel='stylesheet'>
		<script src='scripts/mainFunctions.js'></script>
		<title>Изображения</title>
		<script>
			$(document).ready(function(){
				var idOfTheCurrentElement;
				$('#showFormLoadImage').toggle(function(){
					$('#showFormLoadImage').attr('value', 'Отменить загрузку');
					$('#formLoadImage').css('display', 'block');}, function(){
					$('#showFormLoadImage').attr('value', 'Загрузить фотографию');
					$('#formLoadImage').css('display', 'none');
				})
				$('#newAvatarButton').toggle(
					function(){
						var aImageArray = document.getElementsByClassName('aImage');
						for(let count = 0; count < aImageArray.length; ++count){
							aImageArray[count].href = '?newAvatar=' + aImageArray[count].getAttribute('data-nameImage');
							$('#newAvatarButton').attr('value', 'Отменить выбор аватара');
						}
					}, 
					function(){
						var aImageArray = document.getElementsByClassName('aImage');
						for(let count = 0; count < aImageArray.length; ++count){
							aImageArray[count].href = '#';
							$('#newAvatarButton').attr('value', 'Выбрать новый аватар');
						}
					}
				)
				$("img").click(function(){ zoomImage(this, document.body) }); 
				pageFit('miniImageWindow', window.pageYOffset);
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
			<div id='menu'>
				<?php if($itPage == 'user'){?>
					<input type='button' class='menuButton' id='showFormLoadImage' value='Загрузить фотографию'>
					<form method='POST' enctype='multipart/form-data' id='formLoadImage'>
						<input type='file' name='newImage'>
						<input type='submit' name='loadImage' value='Загрузить'>
					</form>
					<input type='button' class='menuButton' id='newAvatarButton' value='Выбрать новый аватар'>
				<?php } ?>
				<a href='?backward'><input type='button' class='menuButton' id='' value='Назад'></a>
			</div>
			<div id='imageWindow'>
				<?php
					$count = 0;
					foreach($newArrayUserImage as $image){
						$imagePutch = "$mainFilePutch/$image";
						echo "<div class='miniImageWindow'>
							<a class='aImage' data-nameImage='$image'><img class='miniImage' src='$imagePutch' id='$count'></a>
						</div>";
						$imageSize = processingPhoto($imagePutch, 200); 
				?> 
					<script>
							processingPhoto(<?= json_encode($imageSize) ?>, 200, <?= $count++ ?>, 'cropping');
					</script>
				<?php
					}
				?>
			</div>
		</div>
	</body>
		
		
		