<?php
	$age = $_REQUEST['age'];
	
	if(strlen($age) == 0){
	} else if(preg_match('#^[\d]+$#', $age) && $age > 12 && $age < 99){
		echo "<p style='color: green'>✔</p>";
	} else {
		echo "<p style='color: #b70303'>◒ Некоректный возраст</p>";
	}
 ?>