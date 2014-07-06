<?php
$id = $news->clearInt($_GET['del']);
if($id){
    if(!$news->deleteNews($id)){
        $notificationMsg = "Deleting error!";
    }else{
        $notificationMsg = "News have been deleted!";
    }
}