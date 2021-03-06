<?php
	class NewUser{
		private $errors = [];
		
		public $userData;
		private $login;
		private $password;
		private $confirm;
		private $name;
		private $surname;
		private $age;
		private $city;
		private $sex;
		private $registrationDate;
		
		public function setLogin($login, $currentLogin = null){
			if($login == 'undefined') return;
			
			$link = mysqli_connect('practice.local', 'mysql', 'mysql', 'server');
			mysqli_query($link, "SET NAMES = 'UTF8'");
			$query = "SELECT login FROM users WHERE login = '$login'";
			$result = mysqli_query($link, $query);
			for($coincidence = []; $row = mysqli_fetch_assoc($result); $coincidence[] = $row);
			
			if($currentLogin != null && $this->userData['login'] != $currentLogin){
				$this->errors['login'] = '◒ Неверный текущий логин';
			} else if(strlen($login) == 0){
				$this->errors['login'] = '◒ Поле с логином пусто';
			} else if(!empty($coincidence)){
				$this->errors['login'] = '◒ Логин занят';
			} else if(preg_match('#[А-Яа-я-]#', $login)){
				$this->errors['login'] = '◒ Логин содержит недопустимые символы';
			} else if(strlen($login) < 6){
				$this->errors['login'] = '◒ Логин слишком короткий';
			} else {
				$this->login = $login;
			}
		}
		public function setPassword($password, $confirm, $currentPassword = null){
			if($password == 'undefined' && $confirm == 'undefined') return;
			
			if($currentPassword != null && $this->userData['password'] != md5($currentPassword)){
				$this->errors['password'] = '◒ Неверный текущий пароль'; 
			} else if(strlen($password) == 0){
				$this->errors['password'] = '◒ Поле с паролем пусто'; 
			} else if(preg_match('#[А-Яа-я-]#', $password)){
				$this->errors['password'] = '◒ Пароль содержит недопустимые символы';				
			} else if(strlen($password) < 6){
				$this->errors['password'] = '◒ Слишком короткий пароль'; 
				$this->confirm = null;
			} else if($password != $confirm){
				$this->errors['confirm'] = '◒ Пароли не совпадают';
			} else {
				$this->password = $password; 
				$this->confirm = $confirm;
			}
		}
		public function setName($name){
			if($name == 'undefined') return;
			
			if(strlen($name) == 0){
				$this->errors['name'] = '◒ Поле с именем пусто';
			} else if(preg_match('#[\d]#', $name)){
				$this->errors['name'] = '◒ Имя содержит недопустимые символы';
			} else {
				$this->name = $name;
			}
		}
		public function setSurname($surname){
			if($surname == 'undefined') return;
			
			if(strlen($surname) == 0){
				$this->errors['surname'] = '◒ Поле с фамилией пусто';
			} else if(preg_match('#[\d]#', $surname)){
				$this->errors['surname'] = '◒ Фамилия содержит недопустимые символы';
			} else {
				$this->surname = $surname;
			}
		}
		public function setAge($age){
			if($age == 'undefined') return;
			
			if(strlen($age) == 0){
				$this->errors['age'] = '◒ Поле с возрастом пусто';
			} else if(preg_match('#^[\d]+$#', $age) && $age > 7 && $age < 99){
				$this->age = $age;
			} else {
				$this->errors['age'] = '◒ Некорректный возраст';
			}
		}
		public function setCity($city){
			if($city == 'undefined') return;
			
			if(strlen($city) == 0){
				$this->errors['city'] = '◒ Поле с городом пусто';
			} else if(preg_match('#[\d]#', $city)){
				$this->errors['city'] = '◒ Город содержит недопустимые символы';
			} else {
				$this->city = $city;
			}
		}
		public function setSex($sex){
			if(strlen($sex) == 0){
				$this->errors['sex'] = '◒ Не указан пол';
			} else {
				$this->sex = $sex;
			}
		}
		
		public function getLogin(){
			return $this->login;
		}
		public function getPassword(){
			return $this->password;
		}
		public function getName(){
			return $this->name;
		}
		public function getSurname(){
			return $this->surname;
		}
		public function getAge(){
			return $this->age;
		}
		public function getCity(){
			return $this->city;
		}
		public function getSex(){
			return $this->sex;
		}
		public function getErrors(){
			return $this->errors;
		}
		public function getEverything(){
			return [$this->login, $this->password, $this->confirm, $this->name, $this->surname, $this->age, $this->city, $this->sex, $this->registrationDate];
		}
		
		public function __construct($login='undefined', $password='undefined', $confirm='undefined', $name='undefined', $surname='undefined', $age='undefined', $city='undefined', $sex='undefined', $registrationDate='undefined'){
			$this->setLogin($login);
			$this->setPassword($password, $confirm);
			$this->setName($name);
			$this->setSurname($surname);
			$this->setAge($age);
			$this->setCity($city);
			$this->setSex($sex);
			$this->registrationDate = $registrationDate;
		}
	}
?>