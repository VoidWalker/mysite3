<?php
$result = $news->getNews();
if(!is_array($result)){
    $notificationMsg = "Requesting news error!";
}else{
echo "<p>Total news: ".count($result)."</p>";
//print_r($result);
foreach($result as $attribute){
	$id = $attribute['id'];
	$title = $attribute['title'];
	$category = $attribute['name'];
	$description = nl2br($attribute['description']);
	$source = $attribute['source'];
	$dt = date('d-m-Y H:i:s',$attribute['datetime']);
	echo <<<OUTPUT
	<hr>
	<h3>$title</h3>($category)
	<p>$description</p>
	<p>Source: $source</p>@$dt
	<p align="right"><a href='news.php?del=$id'>Delete</a></p>
OUTPUT;
}
}