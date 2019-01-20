<?php
	$password = $_REQUEST['password'];
	
	if(strlen($password) == 0){
	} else if(preg_match('#[А-Яа-я-]#', $password)){
		echo "<p style='color: #b70303'>◒ Содержит недопустимые символы</p>";
	} else if(strlen($password) < 6){
		echo "<p style='color: #b70303'>◒ Слишком короткий пароль</p>";
	} else {
		echo "<p style='color: green'>✔</p>";
	}
 ?>