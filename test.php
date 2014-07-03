<?php
$x = 10;
$isValid = new Validator($x);

if($isValid->isInt()->isPos()->exec())

class Validator{
	private $_val;
	private $_err = 0;
	
	function __construct($v){
	$this->_val = $v;
	}
	
	function exec(){
		return !$_err;
	} 
	
	function isInt(){
		if(!is_integer($this->_val)){
			$_err++;
		}
		return $this;
	}
	
	function isPos(){
		if(abs($this->_val) !== $this->_val){
			$_err++;
		}
		return $this;
	}
}


class A{function foo(){echo __CLASS__;}}
class B{function foo(){echo __CLASS__;}}

function deref($name){
	switch($name){
		case 'A': return new A; break;
		case 'B': return new B; break;
	}
}

deref('A')->foo();

/*abstract class Db{
	public $connection;
	function connect(){
		//
	}
	abstract function open($a);
	abstract function query();
	abstract function close();
}

class Bar{
	function __construct($obj){
		$obj->open;
	}
}

$z = new Bar(MyDb);

class MyDb extends Db{
	function open(){}
	function query(){}
	function close(){}
}

$x = new MyDb();
*/
/*class Animal{
	public $name;
	public $age = 0;
	function sayHello($word){
		echo "$this->name says $word.";
		$this->addBr();
	}
	
	function addBr(){
		echo '</br>';
	}
	
	function __construct($num){
		echo "Object #$num created</br>";
	}
	
	function __destruct(){
		echo "Object #$num deleted</br>";
	}
	
	function __clone(){
		echo "Object #$num cloned</br>";
	}
}
$cat = new Animal(1);
$bigCat = clone $cat;
$dog = new Animal(2);
$cat->name = 'Tom';
$dog->name = 'Spanky';
$cat->sayHello('Miu');
$dog->sayHello('Raph');
*/
?>