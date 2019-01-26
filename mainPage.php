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
	
	
	$query = "SELECT * FROM users WHERE id = '$id'";
	$result = mysqli_query($link, $query);
	for($fullDataUser = []; $row = mysqli_fetch_assoc($result); $fullDataUser = $row);
	
	$query = "SELECT * FROM newses WHERE userId = '$id'";
	$result = mysqli_query($link, $query);
	for($fullDataNewsesUser = []; $row = mysqli_fetch_assoc($result); $fullDataNewsesUser[] = $row);
	$fullDataNewsesUser = array_reverse($fullDataNewsesUser);
	$copyFullDataNewsesUser = $fullDataNewsesUser;
	
	if(!empty($_POST['textNewNews']) ){
		if(!empty($_FILES['attachedFile']['name'])){
			if(!file_exists("data/userImages/$id")) mkdir("data/userImages/$id");
			if(!file_exists("data/userImages/$id/userNewsImages")) mkdir("data/userImages/$id/userNewsImages");
			copy($_FILES['attachedFile']['tmp_name'], "data/userImages/$id/userNewsImages/".basename($_FILES['attachedFile']['name']));
			$attachedFileName = $_FILES['attachedFile']['name'];
		}
		
		$query = "INSERT INTO newses (text, userId, idOfTheSender, attachedFile ) VALUES ('$_POST[textNewNews]', '$id', '$_COOKIE[userId]', '$attachedFileName')";
		mysqli_query($link, $query);
		$url = strtok($_SERVER['REQUEST_URI'], '?');
		header("Location: $url"); exit();
	} else if(isset($_POST['deleteNews'])){
		$query = "DELETE FROM newses WHERE id = '$_POST[deleteNews]'";
		mysqli_query($link, $query);
		$url = strtok($_SERVER['REQUEST_URI'], '?');
		header("Location: $url"); exit();
	}
	
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
			
				function newsUpdate(){ $.ajax({url: 'newsOutput.php',
				data: "itPage=<?= $itPage ?>&id=<?= $id ?>&currentNewsCount="+newsCount,
				type: 'POST',
				success: function(result){
					if(result == 0) return;
					$('#testBlock').html(result)
						
						var arrayAvatarSender = $('[data-needAvatarSize]');
						var arrayImageNews = $('[data-needNewsImageSize]');
						var arrayAvatarSender = document.getElementsByClassName('avatarSender');
						var arraySizeImageNews = <?= json_encode($arraySizeImageNews) ?>;
						var arraySizeAvatarSender = <?= json_encode($arraySizeAvatarSender) ?>;
						var countNewsImage = 0;
					
						for(let count = 0; count < arrayAvatarSender.length; ++count){
							var strSizeCropping = arrayAvatarSender[count].getAttribute('data-needAvatarSize').replace(/^.*\[(.+)\].+\[(.+)\].*$/, '$1');
							var strSizeStretching = arrayAvatarSender[count].getAttribute('data-needAvatarSize').replace(/^.*\[(.+)\].+\[(.+)\].*$/, '$2');
							var arraySizeCropping = []; arraySizeCropping['cropping'] = strSizeCropping.split(',');
							var arraySizeStretching = []; arraySizeStretching['stretching'] = strSizeStretching.split(',');
							
							processingPhoto(arraySizeCropping, 65, arrayAvatarSender[count].id, 'cropping');	
						}
						for(let count = 0; count < arrayImageNews.length; ++count){
							var strSizeCropping = arrayImageNews[count].getAttribute('data-needNewsImageSize').replace(/^.*\[(.+)\].+\[(.+)\].*$/, '$1');
							var strSizeStretching = arrayImageNews[count].getAttribute('data-needNewsImageSize').replace(/^.*\[(.+)\].+\[(.+)\].*$/, '$2');
							var arraySizeCropping = []; arraySizeCropping['cropping'] = strSizeCropping.split(',');
							var arraySizeStretching = []; arraySizeStretching['stretching'] = strSizeStretching.split(',');
							
							processingPhoto(arraySizeStretching, 550, arrayImageNews[count].id, 'stretching');
						}
						
						newsCount = arrayAvatarSender.length;
						pageFit('newsBlock', window.pageYOffset);
						$("img").click(function(){ zoomImage(this, document.body) });
					}	
				})};
				var newsCount = 0;
				newsUpdate();
				var interval = setInterval(function(){newsUpdate()}, 3000);
				$(document).click(function(event){
					var target = event.target;
					if(target.id != 'shareTheNews' && target.class != 'newsButton' && target.id != 'buttonForBlockOutput' && target.getAttribute('type') != 'file'){
						$('#buttonForBlockOutput').css({'display': 'block'});
						$('#formShareTheNews').css({'display': 'none'});
						
						pageFit('newsBlock', window.pageYOffset);
					}
				})
				$('#buttonForBlockOutput').click(function(){
					$('#buttonForBlockOutput').css({'display': 'none'});
					$('#formShareTheNews').css({'display': 'block'});
					pageFit('newsBlock', window.pageYOffset);
				})
				$('#showFileInput').toggle(function(){
					$('#fileInput').css('display', 'block');
					$('#showFileInput').attr('value', 'Отмена');}, function(){
					$('#fileInput').css('display', 'none');
					$('#showFileInput').attr('value', 'Прикрепить');
				})
				pageFit('newsBlock', window.pageYOffset);
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
			<div id='avatarWindow'><img id='avatar' src='<?= autoAvatar($link, $fullDataUser) ?>'></div>
			<script> processingPhoto(<?= json_encode(processingPhoto(autoAvatar($link, $fullDataUser), 250))?>, 250, 'avatar', 'cropping') </script>
			<div id='userData'>
				<h1 id='fullNameUser'><?= "$fullDataUser[name] $fullDataUser[surname]" ?></h1>
				<p class='additionalData'>Город: <?= "$fullDataUser[city]" ?></p>
				<p class='additionalData'>Возраст: <?= "$fullDataUser[age]" ?></p>
			</div>
			<div id='userMenu'>
				<a href='?mainPage' class='aButton'><div class='menuButton'>Моя страница</div></a>
				<a href='?friends' class='aButton'><div class='menuButton'>Друзья</div></a>
				<a href='?gallery' class='aButton'><div class='menuButton'>Фотографии</div></a>
			</div>
			<div id='newsWindow'>
				<div id='buttonForBlockOutput'>Поделиться записью</div>
				<form id='formShareTheNews' method='POST' enctype='multipart/form-data'>
					<textarea id='shareTheNews' name='textNewNews'></textarea>
					<input type='button' class='newsButton' id='showFileInput' value='Прикрепить'>
					<input type='submit' name='newNews' id='sendNewNews' class='newsButton' value='Отправить'>
					<input type='file' name='attachedFile' class='newsButton' id='fileInput'>
				</form>
				<div id='testBlock'></div>
				
			</div>
		</div>
	</body>
</html>