<?php
$login=filter_input(INPUT_POST, 'login', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/(^(\+)[1-9][0-9]{10,20}$)/u')));
$password=filter_input(INPUT_POST, 'password', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/(^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$)/u')));
require_once('connect.php');
if ($login == null or $login == false) {
    echo 'Неправильный логин или пароль';
}
else {
    if ($password == null or $password == false) {
        echo 'Неправильный логин или пароль';
    }
    else {                
        $stmt0 = $connect->query("SELECT password, salt, code FROM users WHERE tel=$login");
        $user = $stmt0->fetch_all(MYSQLI_ASSOC);
        if (!$user) {
            echo 'Неправильный логин или пароль';
        }
        else {
        $salt = $user[0]["salt"]; //соль из БД
		$hash = $user[0]["password"]; //соленый пароль из БД
        $code = $user[0]["code"]; //соль из БД
        $password = md5($salt . $password);
        if ($password == $hash) {
                echo $code;
            }
            else {
                echo 'Неправильный логин или пароль';
            }
        }
        $connect->close();
    }
}