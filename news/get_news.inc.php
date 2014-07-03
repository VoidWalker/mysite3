<?php
$result = $news->getNews();
echo "<p>Total news:".count($result)."</p>";
//print_r($result);
?>
<?php
foreach($result as $attribute){
	$id = $attribute['id'];
	$title = $attribute['title'];
	$category = $attribute['name'];
	$description = nl2br($attribute['description']);
	$dt = date('d-m-Y H:i:s',$attribute['datetime']);
	echo <<<OUTPUT
	<hr>
	<h3>$title</h3>($title)
	<p>$description</p>@$dt
	<p align="right"><a href='news.php?del=$id'>Delete</a></p>
OUTPUT;
}
?>