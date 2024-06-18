<?php
$code=$_POST['code'];
require_once('connect.php');
if ($connect->connect_error) {
    error_log("Соединение неудачно: " . $connect->connect_error);
}
$result = $connect->query("SELECT drivers.name, drivers.surname, orders.id, orders.count_min, orders.price, orders.comm, orders.status, orders.date_create FROM orders, users, drivers WHERE orders.driver_id = drivers.id AND orders.user_id = users.id AND users.code=$code ORDER BY orders.date_create DESC");
if (!$result) {
    echo "Что-то пошло не так";
}
else {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $stroka = json_encode($rows);
    echo $stroka;
}
$connect->close();