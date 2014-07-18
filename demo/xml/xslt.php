<?php
	//Создание объекта XML
	$xml = new DOMDocument;
	//Загрузка XML документа
	$xml->load('catalog.xml');
	//Создание объекта XSL
    $xsl = new DOMDocument;
	//Загрузка XSL документа
    $xsl->load('catalog.xsl');
	//Создание XSLT парсера
	$process = new XSLTProcessor;
	//Загрузка XSL объекта
	$process->importStylesheet($xsl);
	//Парсинг
    echo $process->transformToXml($xml);
?>