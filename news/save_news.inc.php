<?php
$title = $news->clearStr($_POST['title']);
$description = $news->clearStr($_POST['description']);
$source = $news->clearStr($_POST['source']);
$category = $news->clearInt($_POST['category']);
if(empty($title) or empty($description)){
	$notificationMsg = 'Fill required fields!';
}else{
	if(!$news->saveNews($title, $category, $description, $source)){
        $notificationMsg = "Saving error!";
    }else{
	header('Location: news.php');
        exit;
    }
}