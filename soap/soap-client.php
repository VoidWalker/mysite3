<?php
$client = new SoapClient("http://localhost/mysite3.local/soap/news.wsdl");
try{
    //echo "<pre>";
    //print_r($client->__getFunctions());exit;
    $result = $client->getNewsCount();
    echo "<p>Total news quantity: $result</p>";
    $result = $client->getNewsCountByCat(1);
    echo "<p>Total news quantity in category Polotics: $result</p>";
    $result = $client->getNewsById(1);
    $news = unserialize(base64_decode($result));
    var_dump($news);
}catch(SoapFault $e){
    echo "Operation".$e->faultcode." returned error: ".$e->getMessage();
}
?>