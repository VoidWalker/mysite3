<?php
require "INewsDB.class.php";

class NewsDB implements INewsDB{
	protected $_db;
	const DB_NAME = 'D:\xampp\htdocs\mysite3.local\news.db';
    const RSS_NAME = 'rss.xml';
    const RSS_TITLE = 'Latest news';
    const RSS_LINK = '/news/news.php';

	function __construct(){
        try{
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
			if(!$this->_db->exec($sql))
                throw new Exception($this->_db->lastErrorMsg());
			
			$sql = "CREATE TABLE category(
					id INTEGER,
					name TEXT)";
			if(!$this->_db->exec($sql))
                throw new Exception($this->_db->lastErrorMsg());
			
			$sql = "INSERT INTO category(id, name)
					SELECT 1 as id, 'Политика' as name
					UNION SELECT 2 as id, 'Культура' as name
					UNION SELECT 3 as id, 'Спорт' as name";
			if(!$this->_db->exec($sql))
                throw new Exception($this->_db->lastErrorMsg());
        }
		}catch (Exception $e){
            return false;
        }
	}
	
	function __destruct(){
		unset($this->_db);
	}
	
	function saveNews($title, $category, $description, $source){
		try{
        $dt = time();
		$sql = "INSERT INTO msgs(title, category, description, source, datetime)
				VALUES(:title, :category, :description, :source, :datetime)";
		$stmt = $this->_db->prepare($sql);
		$stmt->bindParam(':title', $title, SQLITE3_TEXT);
		$stmt->bindParam(':category', $category, SQLITE3_INTEGER);
		$stmt->bindParam(':description', $description, SQLITE3_TEXT);
		$stmt->bindParam(':source', $source, SQLITE3_TEXT);
		$stmt->bindParam(':datetime', $dt, SQLITE3_INTEGER);
		$result = $stmt->execute();
        $stmt->reset();
        if(!$result)
            throw new Exception($this->_db->lastErrorMsg());
        $this->createRss();
		return true;
        }catch(Exception $e){
            return false;
        }
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
		try{
        $sql = "SELECT msgs.id as id, title, category.name, description, source, datetime
				FROM msgs, category
				WHERE msgs.category = category.id
				ORDER BY msgs.id DESC";
		$result = $this->_db->query($sql);
        if(!$result)
            throw new Exception($this->_db->lastErrorMsg());
		return $this->db2Arr($result);
        }catch(Exception $e){
            //$e->getMessage();
            return false;
        }
	}
	
	function deleteNews($id){
        try{
        $sql = "DELETE FROM msgs
                WHERE id=:id";
        $stmt = $this->_db->prepare($sql);
        $stmt->bindParam(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $stmt->reset();
        if(!$result)
            throw new Exception($this->_db->lastErrorMsg());
        return true;
        }catch(Exeption $e){
            //$e->getMessage();
            return false;
        }
    }

    function createRss(){
        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->formatOutput = true;
        $dom->preserveWhiteSpace = false;

        $rss = $dom->createElement('rss');
        $dom->appendChild($rss);
        $version = $dom->createAttribute('version');
        $version->value = '2.0';
        $rss->appendChild($version);

        $channel = $dom->createElement('channel');
        $rss->appendChild($channel);

        $title = $dom->createElement('title', self::RSS_TITLE);
        $channel->appendChild($title);
        $link = $dom->createElement('link', self::RSS_LINK);
        $channel->appendChild($link);

        $news = $this->getNews();
        foreach($news as $attribute){
            $item = $dom->createElement('item');

            $newsTitle = $dom->createElement('title', $attribute['title']);
            $item->appendChild($newsTitle);
            $newsLink = $dom->createElement('link', $attribute['source']);
            $item->appendChild($newsLink);
            $newsDescription = $dom->createElement('description', $attribute['description']);
            $item->appendChild($newsDescription);
            $newsDate = $dom->createElement('pubDate', date('d-m-Y H:i:s',$attribute['datetime']));
            $item->appendChild($newsDate);
            $newsCategory = $dom->createElement('category', $attribute['name']);
            $item->appendChild($newsCategory);

            $channel->appendChild($item);
        }
        $dom->save(self::RSS_NAME);
    }
}