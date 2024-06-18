<?php
$namee=filter_input(INPUT_POST, 'namee', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/(^[А-ЯЁа-яё]+$)/u')));
$surname=filter_input(INPUT_POST, 'surname', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/(^[А-ЯЁа-яё]+$)/u')));
$tel=filter_input(INPUT_POST, 'tel', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/(^(\+)[1-9][0-9]{10,20}$)/u')));
$password=filter_input(INPUT_POST, 'password', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/(^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$)/u')));
$repeat_password=$_POST['repeat-password'];
require_once('connect.php');
function generateSalt()
{
    $salt = '';    
    for($i = 0; $i < 8; $i++) {
        $salt .= chr(mt_rand(33, 126)); //Символы из таблицы символов ASCII
    }    
    return $salt;
}
if ($namee == null or $namee == false) {
    echo 'Введите имя правильно';
}
else {
    if ($surname == null or $surname == false) {
        echo 'Введите фамилию правильно';
    }
    else {
        if ($tel == null or $tel == false) {
            echo 'Введите телефон правильно';
        }
        else {
            if ($password == null or $password == false) {
                echo 'Пароль недостаточно надежен';
            }
            else {
                if ($password != $repeat_password) {
                    echo 'Пароли не совпадают';
                }
                else {
                    $salt = generateSalt(); //Генерируем соль
                    $password = md5($salt . $password); //Преобразуем пароль в соленый хеш
                    $stmt0 = $connect->query("SELECT id FROM users WHERE tel=$tel");
                    $user = $stmt0->fetch_all(MYSQLI_ASSOC);
                    if ($user) {
                        echo "Пользователь с таким телефоном уже есть";
                    }
                    else {
                        $stmt0->close();
                        $stmt1 = $connect->prepare("SELECT MAX(id) FROM users");
                        $stmt1->execute();
                        $stmt1->bind_result($id);
                        $stmt1->fetch();
                        $code="0000" . $id + 1;
                        $stmt1->close();
                        
                        $stmt2 = $connect->prepare("INSERT INTO users (code, name, surname, tel, password, salt) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt2->bind_param("ssssss", $code, $namee, $surname, $tel, $password, $salt);
                        $stmt2->execute();
                        if (!$stmt2->insert_id) {
                            echo "Что-то пошло не так, повторите попытку";
                        }
                        else {
                            echo "Ваша учетная запись создана, зайдите в нее через логин";
                        }
                        }
                    $connect->close();
                }
            }
        }
    }
}