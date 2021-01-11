<?php

// Подключаемся к БД
require_once '../config.php';

// Возврат на главную страницу после выполенния скрипта
header( 'Location: ../index.php');
var_dump($_POST);

// Записываем данные формы в переменныем
$idAgent = $_POST['rad'];
$FIO = $_POST['FIO'];
$addres = $_POST['addres'];
$dataPassport = $_POST['dataPassport'];
$dateAdmission = $_POST['dateAdmission'];

//Скрипт добавления записи
if ($_POST['add']){
// Добавляем новую запись со значениями ,полученными выше. 
    $link->query("INSERT INTO `agent` (`idAgent`,`FIO`,`addres`, `dataPassport`, `dateAdmission`)
        VALUES (NULL,'$FIO', '$addres', '$dataPassport', '$dateAdmission')");
}

//Скрипт удаления записи
if ($_POST['del'] && $_POST['rad']){
    mysqli_query($link,"DELETE FROM `agent` WHERE `agent`.`idAgent` = '$idAgent'");
}

//Скрипт изменение записи
if ($_POST['upd'] && $_POST['rad']){
    mysqli_query($link,"UPDATE `agent` SET 
        `FIO` = '$FIO',
        `addres` = '$addres',
        `dataPassport` = '$dataPassport',
        `dateAdmission` = '$dateAdmission' 
    WHERE `agent`.`idAgent` = '$idAgent'");
}


