<?php
header('Access-Control-Allow-Origin: *');
$coors=$_POST['coors'];
 
// создание нового ресурса cURL
$ch = curl_init('https://geocode-maps.yandex.ru/1.x/?apikey=01166edc-f72c-4ec7-9937-95ad19df7e71&format=json&geocode=' . urlencode($coors));

// установка URL и других необходимых параметров
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // true для возврата результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // false для остановки cURL от проверки сертификата узла сети
curl_setopt($ch, CURLOPT_HEADER, false); //	false для отключения заголовков в вывод

// загрузка страницы и выдача её браузеру
$res = curl_exec($ch);

// завершение сеанса и освобождение ресурсов
curl_close($ch);
 
$res = json_decode($res, true);

$coordinates = $res['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['text'];
echo $coordinates;