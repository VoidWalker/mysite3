<?php
$title = $news->clearStr($_POST['title']);
$description = $news->clearStr($_POST['description']);
$source = $news->clearStr($_POST['source']);
$category = $news->clearInt($_POST['category']);
if(empty($title) or empty($description)){
	$errMsg = 'Fill required fields!';
}else{
	$news->saveNews($title, $category, $description, $source);
	header('Location: news.php');
}
?>