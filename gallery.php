<?php
	$mainFilePutch = "data/userImages/$_COOKIE[userId]";
	$arrayUserImages = array_slice(scandir($mainFilePutch), 2);

	if(isset($_POST['loadImage'])){
		if(!file_exists("$mainFilePutch")){
			mkdir("$mainFilePutch");
		}
		if(!empty($_FILES['newImage']['name'])){
			copy($_FILES['newImage']['tmp_name'], "$mainFilePutch/".basename($_FILES['newImage']['name']));
			$url = strtok($_SERVER['REQUEST_URI'], '?');
			header("Location: $url"); exit();
		}
	}
?>
<!DOCTYPE html>
	<head>
		<?= $globalArray['mainHtmlHead'] ?>
		<link href='data/styles/gallery.css' rel='stylesheet'>
		<script src='scripts/mainFunctions.js'></script>
		<title>Изображения</title>
	</head>
	<body>
		<div id='upperBand'>
			<div id='mainDivUpperBand'>
				<a href='?exit' class='aButton' id='exitButton'>Выйти</a>
			</div>
		</div>
		<div id='window'>
			<div id='menu'>
				<form method='POST' enctype='multipart/form-data' id='formLoadImage'>
					<input type='file' name='newImage'>
					<input type='submit' name='loadImage' value='Загрузить'>
				</form>
			</div>
			<div id='imageWindow'>
				<?php
					$count = 0;
					foreach($arrayUserImages as $image){
						$imagePutch = "$mainFilePutch/$image";
						echo "<div class='miniImageWindow'><img src='$imagePutch' id='$count'></div>";
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