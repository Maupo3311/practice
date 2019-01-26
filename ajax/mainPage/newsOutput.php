<?php
	$link = mysqli_connect('practice.local', 'mysql', 'mysql', 'server');
	mysqli_query($link, "SET NAMES = 'UTF8'");
	session_start();
	include 'scripts/mainFunction.php';
	
	$query = "SELECT * FROM newses WHERE userId = '$_COOKIE[userId]'";
	$result = mysqli_query($link, $query);
	for($fullDataNewsesUser = []; $row = mysqli_fetch_assoc($result); $fullDataNewsesUser[] = $row);
	$fullDataNewsesUser = array_reverse($fullDataNewsesUser);
	
	$itPage = $_REQUEST['itPage'];
							
						
							$idImage = 0;
							echo "'";
							foreach($fullDataNewsesUser as $news){
								$query = "SELECT * FROM users WHERE id = '$news[idOfTheSender]'";
								$result = mysqli_query($link, $query);
								for($dataOfTheSender = []; $row = mysqli_fetch_assoc($result); $dataOfTheSender = $row);
								$avatarPutch = autoAvatar($link, $dataOfTheSender);
								
								$idImageNews = 'imageNews'.$idImage;
								$idavatarSender = 'avatarSender'.$idImage;
								
								$result = "";
								$result .= "<div class=\'newsBlock\'>";
								$result .= "<form method=\'POST\' class=\'settingUpNews\'>";
								if($itPage == 'user' || $news['idOfTheSender'] == $_COOKIE['userId']){ 
									$result .= "<button type=\'submit\' class=\'deleteNews\' name=\'deleteNews\' value=\'$news[id]\'>X</button>";
								}
								$result .= "</form>";
								$result .= "<div class=\'theDataSender\'><a href=\'?contactId=$news[idOfTheSender]\'><div class=\'windowAvatarSender\'><img class=\'avatarSender\' id=\'$idavatarSender\' src=\'$avatarPutch\'></div></a><a href=\'?contactId=$news[idOfTheSender]\'><p class=\'theFullNameSender\'>$dataOfTheSender[name] $dataOfTheSender[surname]</p></a></div>";
								if(!empty($news['text'])) $result .= "<p class=\'newsText\'>$news[text]</p>";
								if(!empty($news['attachedFile'])){ $result .= "<div class=\'newsWindowImage\'><img id=\'$idImageNews\' src=\'data/userImages/$news[userId]/userNewsImages/$news[attachedFile]\' class=\'newsImage\'></div>";
								}
								$result .= "</div>";
								echo $result;
								
								$idImage++;
							}
								echo "'"; ?>

