<?php
$status=$_POST['status'];
$id=$_POST['id'];
require_once('connect.php');
if ($status != 'В обработке') {
    echo "Вы уже не можете изменить заказ";
}
else {
$stmt = $connect->query("DELETE FROM orders WHERE id=$id");
echo "Ваш заказ успешно удален";
}
$connect->close();