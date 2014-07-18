<?php
define('FILE_NAME', 'news.xml');
define('RSS_URL', 'http://localhost/mysite3.local/news/rss.xml');

function download($url, $fileName){
    $file = file_get_contents($url);
    if($file){
        file_put_contents($fileName, $file);
    }
}
if(!is_file(FILE_NAME)){
    download(RSS_URL, FILE_NAME);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<title>Новостная лента</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<h1>Последние новости</h1>
<?php
$xml = simplexml_load_file(FILE_NAME);
$i = 1;
foreach($xml->channel->item as $item){
    echo <<<RSS
    <H3>{$item->title}</H3>
    <p>
        {$item->description}<br>
        <strong>Category: {$item->category}</strong>&nbsp;
    </p>
    <em>Posted: {$item->pubDate}</em>
    <p align='right'><a href='{$item->link}'>Read more..</a></p>
    <hr>
RSS;
    $i++;
    if($i>5) break;
}
if(time() > filemtime(FILE_NAME) + 600){
    download(RSS_URL, FILE_NAME);
}

?>
</body>
</html>