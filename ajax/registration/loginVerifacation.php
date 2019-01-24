<?php
	$link = mysqli_connect('practice.local', 'mysql', 'mysql', 'server');
	mysqli_query($link, "SET NAMES = 'UTF8'");
 
	$login = $_REQUEST['login'];
	
	$query = "SELECT login FROM users WHERE login = '$login'";
	$result = mysqli_query($link, $query);
	for($coincidence = []; $row = mysqli_fetch_assoc($result); $coincidence[] = $row);
	
	if(strlen($login) == 0){
	} else if(!empty($coincidence)){
		echo "<p style='color: #b70303'>◒ Логин занят</p>";
	} else if(preg_match('#[А-Яа-я-]#', $login)){
		echo "<p style='color: #b70303'>◒ Содержит недопустимые символы</p>";
	} else if(strlen($login) < 6){
		echo "<p style='color: #b70303'>◒ Слишком короткий логин</p>";
	} else {
		echo "<p style='color: green'>✔</p>";
	}
 ?>