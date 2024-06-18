<?php
$code=$_POST['code'];
require_once('connect.php');
if ($connect->connect_error) {
    error_log("Соединение неудачно: " . $connect->connect_error);
}
$result = $connect->query("SELECT name, tel FROM users WHERE code=$code");
if (!$result) {
    echo "Что-то пошло не так";
}
else {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $stroka = json_encode($rows);
    echo $stroka;
}
$connect->close();