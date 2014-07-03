<?php
class SuperUser extends User implements ISuperUser{
		public $role;
		
		static $userCount = 0;
		
		public function __construct($name, $login, $pass, $role){
			parent::__construct($name, $login, $pass);
			$this->role = $role;
			self::$userCount++;
			parent::$userCount--;
		}
		
		public function getInfo(){
			$info = array();
			foreach($this as $k => $value){
				$info[$k] = $value;
			}
			return $info;
			//return (array)$this;
		}
		
		public function showInfo(){
			parent::showInfo();
			echo "Role: $this->role.</br>";
		}
	}
?>