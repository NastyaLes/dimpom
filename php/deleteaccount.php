<?php
$code=$_POST['code'];
require_once('connect.php');
$stmt = $connect->query("DELETE FROM users WHERE code=$code");
echo "Ваш аккаунт успешно удален";
$connect->close();