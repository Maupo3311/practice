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
	
	$query = "SELECT * FROM users";
	$result = mysqli_query($link, $query);
	for($fullUsers = []; $row = mysqli_fetch_assoc($result); $fullUsers[] = $row);
	
?>
<!DOCTYPE html>
<html>
	<head>
		<?= $globalArray['mainHtmlHead'] ?>
		<link href='data/styles/mainPage.css' rel='stylesheet'>
		<link href='data/styles/friends.css' rel='stylesheet'>
		<script type="text/javascript" src="scripts/mainFunctions.js"></script>
		<title>Друзья</title>
		<script>
			$(document).ready(function(){
				$("img").click(function(){ zoomImage(this, document.body) });
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
			<div id='friendWindow'>
				<?php
					$countId = 0;
					foreach($fullUsers as $contact){
						if($contact['id'] == $id) continue;
						$avatarPutch = autoAvatar($link, $contact);
						$avatarId = 'FriendAvatar'.$countId;
						echo "<a href='?contactId=$contact[id]'><div class='friendBlock'>
							<div class='friendAvatarWindow'>
								<img id='$avatarId' class='friendAvatar' src='$avatarPutch'>
							</div>
							<p class='friendData'>$contact[name] $contact[surname]</p>
						</div></a>";
				?> <script> processingPhoto(<?= json_encode(processingPhoto($avatarPutch, 98))?>, 98, '<?= $avatarId ?>', 'cropping') </script> <?php
					++$countId;
					}
				?>
			</div>
		</div>
	</body>
</html>





