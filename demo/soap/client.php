<?php
	try {
		// Создание SOAP-клиента
		$client = new SoapClient("http://localhost/mysite3.local/demo/soap/stock.wsdl");
		
		// Посылка SOAP-запроса c получением результат
		//print_r($client->__getFunctions());exit;
        $result = $client->getStock("3");
		echo "Текущий запас на складе: ", $result;
	} catch (SoapFault $exception) {
		echo $exception->getMessage();	
	}
?>