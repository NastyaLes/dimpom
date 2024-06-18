<?php
header('Access-Control-Allow-Origin: *');
$address=$_POST['address'];
 
// создание нового ресурса cURL
$ch = curl_init('https://suggest-maps.yandex.ru/v1/suggest?text=Санкт-Петербург,' . urlencode($address) . '&results=1&print_address=1&apikey=8c86df02-2a99-4ef0-85f7-01f56916efad');
//results=1 - Получить единственный объект в ответе; print_address=1 - получить в ответе покомпонентный адрес

// установка URL и других необходимых параметров
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // true для возврата результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // false для остановки cURL от проверки сертификата узла сети
curl_setopt($ch, CURLOPT_HEADER, false); //	false для отключения заголовков в вывод

// загрузка страницы и выдача её браузеру
$res = curl_exec($ch);
// завершение сеанса и освобождение ресурсов
curl_close($ch);
 
$res = json_decode($res, true);

$result = $res['results'][0]['address']['formatted_address'];
echo $result;