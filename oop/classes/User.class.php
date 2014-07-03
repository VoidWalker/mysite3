<?php
class User extends AUser{
		public $name;
		public $login;
		public $password;
		
		static $userCount = 0;
		
		function __construct($name, $login, $password){
			$this->name = $name;
			$this->login = $login;
			$this->password = $password;
			self::$userCount++;
		}
		
		function __destruct(){
			echo "User $this->login has been deleted.<br>";
		}		
		
		function __clone(){
			$this->name = 'Guest';
			$this->login = 'quest';
			$this->password = '';
			self::$userCount++;
		}
		
		function showInfo(){
			echo "Dear $this->name, 
			you can visit our site using next credentials:</br>
			Login: <strong>$this->login</strong></br>
			Password: <strong>$this->password</strong><br>";
		}
		
	}
?>