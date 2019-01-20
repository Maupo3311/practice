<?php
	$nameOrSurname = $_REQUEST['nameOrSurname'];
	
	if(strlen($nameOrSurname) == 0){
	} else if(preg_match('#[\d]#', $nameOrSurname)){
		echo "<p style='color: #b70303'>◒ Содержит недопустимые символы</p>";
	} else {
		echo "<p style='color: green'>✔</p>";
	}
 ?>