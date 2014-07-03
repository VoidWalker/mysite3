<?php
require "INewsDB.class.php";

class NewsDB implements INewsDB{
	protected $_db;
	const DB_NAME = 'D:\xampp\htdocs\mysite3.local\news.db';
	
	function __construct(){
		if(is_file(self::DB_NAME)){
			$this->_db = new SQLite3(self::DB_NAME);
		}else{
			$this->_db = new SQLite3(self::DB_NAME);
			
			$sql = "CREATE TABLE msgs(
					id INTEGER PRIMARY KEY AUTOINCREMENT,
					title TEXT,
					category INTEGER,
					description TEXT,
					source TEXT,
					datetime INTEGER)";
			$this->_db->exec($sql) or die($this->_db->lastErrorMsg());
			
			$sql = "CREATE TABLE category(
					id INTEGER,
					name TEXT)";
			$this->_db->exec($sql) or die($this->_db->lastErrorMsg());
			
			$sql = "INSERT INTO category(id, name)
					SELECT 1 as id, 'Политика' as name
					UNION SELECT 2 as id, 'Культура' as name
					UNION SELECT 3 as id, 'Спорт' as name";
			$this->_db->exec($sql) or die($this->_db->lastErrorMsg());
		}
	}
	
	function __destruct(){
		unset($this->_db);
	}
	
	function saveNews($title, $category, $description, $source){
		$dt = time();
		$sql = "INSERT INTO msgs(title, category, description, source, datetime)
				VALUES(:title, :category, :description, :source, :datetime)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindParam(':title', $title, SQLITE3_TEXT);
		$stmt->bindParam(':category', $category, SQLITE3_INTEGER);
		$stmt->bindParam(':description', $description, SQLITE3_TEXT);
		$stmt->bindParam(':source', $source, SQLITE3_TEXT);
		$stmt->bindParam(':datetime', $dt, SQLITE3_INTEGER);
		$result = $stmt->execute() or die($this->_db->lastErrorMsg());
		$stmt->reset();
	}
	
	function clearStr($data){
		return $this->_db->escapeString(trim(strip_tags($data))); 
	}
	
	function clearInt($data){
		return abs((int)$data);
	}
	
	protected function db2Arr($data){
		$arr = array();
		while($row = $data->fetchArray(SQLITE3_ASSOC)){
			$arr[] = $row;
		}
		return $arr;
	}
	
	function getNews(){
		$sql = "SELECT msgs.id as id, title, category.name, description, source, datetime
				FROM msgs, category
				WHERE msgs.category = category.id
				ORDER BY msgs.id DESC";
		$result = $this->_db->query($sql) or die($this->_db->lastErrorMsg());
		return $this->db2Arr($result);
	}
	
	function deleteNews($id){}
}
?>