<?php 
	$link = mysqli_connect('practice', 'mysql', 'mysql', 'server');
	mysqli_query($link, "SET NAMES = 'UTF8'");
	session_start();
	
	include 'scripts/mainFunction.php';
	
	if(isset($_GET['exit'])){
		$_SESSION['page'] = '';
		setcookie('userId', 0, time());
		$url = strtok($_SERVER['REQUEST_URI'], '?');
		header("Location: $url"); exit();
	}
	
	if(isset($_POST['registrationSubmit'])){
		$_SESSION['page'] = 'registration';
	} else if (isset($_GET['gallery'])){
		$_SESSION['page'] = 'gallery';
	}	
	
	$globalArray['mainHtmlHead'] = 
		'<meta charset="utf-8">
		<link href="data/styles/basicStyle.css" rel="stylesheet">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>';
	 
	if($_SESSION['page'] == 'registration'){
		include 'registration.php';
	} else if($_SESSION['page'] == 'gallery'){
		include 'gallery.php';
	} else if(!isset($_COOKIE['userId'])){
		include 'authorization.php';
	} else {
		include 'mainPage.php';
	}