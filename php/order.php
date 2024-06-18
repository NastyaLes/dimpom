<?php
$namee=filter_input(INPUT_POST, 'namee', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/(^[А-ЯЁа-яё]+$)/u')));
$tel=filter_input(INPUT_POST, 'tel', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/(^(\+)[1-9][0-9]{10,20}$)/u')));
$address_in=filter_input(INPUT_POST, 'address_in', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/(^(?=.*\s)(?=.*,)(?=.*[А-ЯЁа-яё0-9]).{4,}$)/u')));
$address_to=filter_input(INPUT_POST, 'address_to', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/(^(?=.*\s)(?=.*,)(?=.*[А-ЯЁа-яё0-9]).{4,}$)/u')));
$tariff=$_POST['tariff'];
$price=$_POST['price'];
$comm=$_POST['comm'];
$time_ride=$_POST['time'];
$km_ride=$_POST['km'];
require_once('connect.php');
if ($address_in == null or $address_in == false) {
    echo 'Введите адрес отправления правильно';
}
else {
    if ($address_to == null or $address_to == false) {
        echo 'Введите адрес прибытия правильно';
    }
    else {
        if ($namee == null or $namee == false) {
            echo 'Введите имя правильно';
        }
        else {
            if ($tel == null or $tel == false) {
                echo 'Введите номер телефона правильно';
            }
            else {
                $stmt5 = $connect->query("SELECT id FROM tariffs WHERE km_price=$tariff");
                $tariff = $stmt5->fetch_all(MYSQLI_ASSOC);
                $id_tariff = $tariff[0]["id"];
                $stmt0 = $connect->query("SELECT id FROM drivers WHERE status='Свободен' AND tariff_id=$id_tariff ORDER BY RAND() LIMIT 1");
                $driver = $stmt0->fetch_all(MYSQLI_ASSOC);
                if (!$driver) {
                    echo "Все водители заняты, подождите немного и повторите попытку";
                }
                else {
                    $id_driver = $driver[0]["id"];
                    $stmt0->close();

                    $stmt6 = $connect->query("SELECT id FROM users WHERE tel=$tel");
                    $id_namee = $stmt6->fetch_all(MYSQLI_ASSOC);
                    $nt = $namee . ' ' . $tel;
                    if (!$id_namee) {
                        $stmt2 = $connect->prepare("INSERT INTO orders (address_in, address_to, name, driver_id, count_min, count_km, price, comm) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt2->bind_param("sssiiids", $address_in, $address_to, $nt, $id_driver, $time_ride, $km_ride, $price, $comm);
                        $stmt2->execute();
                        if (!$stmt2->insert_id) {
                            echo "Что-то пошло не так, повторите попытку";
                        }
                        else {
                            echo "Ваш заказ принят, ждите звонка или сообщения от водителя, когда он будет подъезжать";
                        }
                    }
                    else {
                        $user = $id_namee[0]["id"];
                        $stmt3 = $connect->prepare("INSERT INTO orders (address_in, address_to, user_id, driver_id, count_min, count_km, price, comm) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt3->bind_param("ssiiiids", $address_in, $address_to, $user, $id_driver, $time_ride, $km_ride, $price, $comm);
                        $stmt3->execute();
                    if (!$stmt3->insert_id) {
                        echo "Что-то пошло не так, повторите попытку";
                    }
                    else {
                        echo "Ваш заказ принят, ждите звонка от водителя, когда он будет подъезжать";
                    }
                    }
                }
                $connect->close();
            }
        }
    }
}