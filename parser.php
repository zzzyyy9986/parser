<?php
$out = file_get_contents("https://www.vinorus.ru/ru-RU/about/contacts.aspx");

//$text = mb_convert_encoding($out, 'utf-8', 'UTF-8');

$out = mb_convert_encoding($out, 'HTML-ENTITIES', 'utf-8');

$dom = new DOMDocument;	//создаем объект
$dom->loadHTML($out);	//загружаем контент
$node = $dom->getElementById('section-2030');


$finder = new DomXPath($dom);
$classname="col-sm-4  mb-4";
$parentNodes = $finder->query("//*[contains(@class, '$classname')]");
//$parentNodes = array_slice($parentNodes,1,count($parentNodes));
$result = [];
$i = 0;
foreach ($parentNodes as $parentNode){
    foreach ($parentNode->childNodes as $el){
        $keys = ["name","position","phone","email"];
        foreach ($el->childNodes as $subEl){
                if(strlen($subEl->nodeValue)>1) {
                    if($keys[0] === 'email') {
                        $subEl->nodeValue = preg_replace("~e-mail:~", "", $subEl->nodeValue);
                    }
                    $result[$i][array_shift($keys)] = $subEl->nodeValue;

                }
        }
    }
    $i++;
}
print_r(json_encode($result));
die();