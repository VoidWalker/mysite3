<?php
require "../news/NewsDB.class.php";
class NewsService extends NewsDB{
	/* Метод возвращает новость по её идентификатору */
	function getNewsById($id){
		try{
			$sql = "SELECT id, title, 
					(SELECT name FROM category WHERE category.id=msgs.category) as category, description, source, datetime 
					FROM msgs
					WHERE id = $id";
			$result = $this->_db->query($sql);
			if (!is_object($result)) 
				throw new Exception($this->_db->lastErrorMsg());
			return base64_encode(serialize($this->db2Arr($result)));
		}catch(Exception $e){
			throw new SoapFault('getNewsById', $e->getMessage());
		}
	}
	/* Метод считает количество всех новостей */
	function getNewsCount(){
		try{
			$sql = "SELECT count(*) FROM msgs";
			$result = $this->_db->querySingle($sql);
			if (!$result) 
				throw new Exception($this->_db->lastErrorMsg());
			return $result;
		}catch(Exception $e){
			throw new SoapFault('getNewsCount', $e->getMessage());
		}
	}
	/* Метод считает количество новостей в указанной категории */
	function getNewsCountByCat($cat_id){
		try{
			$sql = "SELECT count(*) FROM msgs WHERE category=$cat_id";
			$result = $this->_db->querySingle($sql);
			if (!$result) 
				throw new Exception($this->_db->lastErrorMsg());
			return $result;
		}catch(Exception $e){
			throw new SoapFault('getNewsCountByCat', $e->getMessage());
		}
	}
}

ini_set("soap.wsdl+cache_enabled", "0");
$server = new SoapServer("http://localhost/mysite3.local/soap/news.wsdl");
$server->setClass("NewsService");
$server->handle();

?>