<?php
header('Access-Control-Allow-Origin: *');
$coors_in=$_POST['coors_in'];
$coors_to=$_POST['coors_to'];
$array_in = preg_split("/[\s]+|[,]+/", $coors_in);
$array_to = preg_split("/[\s]+|[,]+/", $coors_to);

$url = 'https://routing.api.2gis.com/get_dist_matrix?key=5cbe366b-340a-4d2a-ae6e-48238aa41725&version=2.0';
$headers = array('Content-Type: application/json');

$data = array(
    "points" => array(
        array("lat" => floatval($array_in[1]), "lon" =>  floatval($array_in[0])),
        array("lat" =>  floatval($array_to[1]), "lon" =>  floatval($array_to[0])),
    ),
    "type" => "jam",
    "sources" => array(0),
    "targets" => array(1)
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true); //true для отправки запроса обычным HTTP-методом POST. 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //true для возврата результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер.
curl_setopt($ch, CURLOPT_HEADER, false); //false для отключения заголовков в вывод
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); //параметр, используемый для установки тела POST-запроса
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); //параметр, который задает HTTP-заголовки, отправляемые вместе с запросом
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //false для остановки cURL от проверки сертификата узла сети.
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$res = curl_exec($ch);

curl_close($ch);

echo $res;
