<?php
	function __autoload($className){
		include "classes/$className.class.php";
	}
	
	$user1 = new User("User1", "login1", "password1");
	$user1->showInfo();
	
	$user2 = new User("User2", "login2", "password2");
	$user2->showInfo();
	
	$user3 = new User("User3", "login3", "password3");
	$user3->showInfo();
	
	$user4 = clone $user1;
	$user4->showInfo();
	
	$user = new SuperUser('TestUser', 'supper', 'superpass', 'admin');
	$user->showInfo();
	
	$user5 = new SuperUser('TestUser', 'supper', 'superpass', 'admin');
	echo "<hr>";
	echo "Total regular users:".User::$userCount."<br>";
	echo "Total super users:".SuperUser::$userCount."<hr>";
	
	
?>