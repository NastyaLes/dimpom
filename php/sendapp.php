<?php
$namee=filter_input(INPUT_POST, 'namee', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/(^[А-ЯЁа-яё]+$)/u')));
$tel=filter_input(INPUT_POST, 'tel', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/(^(\+)[1-9][0-9]{10,20}$)/u')));
require_once('connect.php');
if ($namee == null or $namee == false) {
    echo 'Введите имя правильно';
}
else {
    if ($tel == null or $tel == false) {
        echo 'Введите телефон правильно';
    }
    else {                  
        $stmt1 = $connect->prepare("INSERT INTO apps (name, tel) VALUES (?, ?)");
        $stmt1->bind_param("ss", $namee, $tel);
        $stmt1->execute();
        if (!$stmt1->insert_id) {
            echo "Что-то пошло не так";
        }
        else {
            echo "Ваша заявка принята, ждите звонка";
        }
        $connect->close();

    }
}