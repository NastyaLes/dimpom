<?php
header('Access-Control-Allow-Origin: *');
$connect=new mysqli('localhost', 'leskina_diplom', 'Taxi=123', 'leskina_diplom'); //подключение к базе данных сервера
$connect->set_charset('utf8'); //задание кодировки