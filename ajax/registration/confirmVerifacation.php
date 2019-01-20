<?php
	$password = $_REQUEST['password'];
	$confirm = $_REQUEST['confirm'];
	
	if(strlen($confirm) == 0){
	} else if($password != $confirm){
		echo "<p style='color: #b70303'>◒ Пароли не совпадают</p>";
	} else {
		echo "<p style='color: green'>✔</p>";
	}
 ?>