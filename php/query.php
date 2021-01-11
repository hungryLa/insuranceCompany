<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <title>Запросы</title>
    <link rel = "stylesheet" href = "../css/style.css">
</head>
<body>
    <form method = "POST">
        <h2 style = "text-align : center;">Запросы</h2>
        <table >
            <tr>
                <td style = "width : 2%"><input type = "radio" name = 'rad' value = '1'></td>
                <td>1. Вывести информацию по id</td>
                <td><input type = "text" name = "val1"></td>
                <input type = "hidden" name = "query1" value = 
                "SELECT * FROM `agent` WHERE `idAgent`=">
                <input type = "hidden" name = "queryType1" value = "1">
            </tr>
            <tr>
                <td><input type = "radio" name = 'rad' value = '2'></td>
                <td>2. Вывести сотрудников , которые начали работать с </td>
                <td><input type = "date" name = "val2"></td>
                <input type = "hidden" name = "query2" value = 
                "SELECT * FROM `agent` WHERE `dateAdmission` > ">
                <input type = "hidden" name = "queryType2" value = "2">
            </tr>
            <tr>
                <td><input type = "radio" name = 'rad' value = '3'></td>
                <td>3. Вывести сотрудников , которые работают в городе </td>
                <td><input type = "text" name = "val3"></td>
                <input type = "hidden" name = "query3" value = 
                "SELECT * FROM `agent` WHERE `addres` LIKE ">
                <input type = "hidden" name = "queryType3" value = "3">
            </tr>
            <tr>
                <td><input type = "radio" name = 'rad' value = '4'></td>
                <td>4. Вывести страховые случаи , которые дороже </td>
                <td><input type = "text" name = "val4"></td>
                <input type = "hidden" name = "query4" value = 
                "SELECT idInsuranceEvent,name,cost FROM `insuranceevent` WHERE `cost` > ">
                <input type = "hidden" name = "queryType4" value = "4">
            </tr>
            <tr>
                <td><input type = "radio" name = 'rad' value = '5'></td>
                <td>5. Вывести все договора агента по id</td>
                <td><input type = "text" name = "val5"></td>
                <input type = "hidden" name = "query5" value = 
                "SELECT idContract, nameClient, insuranceevent.name, insuranceevent.cost, dateСonclusion, term 
                    FROM `сontract`,`client`,`insuranceevent`
                    WHERE (`сontract`.`idClient` = `client`.`idClient`)&&
                    (`сontract`.`idInsuranceEvent` = `insuranceevent`.`idInsuranceEvent`)&&
                    (`сontract`.`idAgent` = ">
                <input type = "hidden" name = "queryType5" value = "5">
            </tr>
            <tr>
                <td><input type = "radio" name = 'rad' value = '6'></td>
                <td>6. Вывести 3 самых популярных страховой случай</td>
                <input type = "hidden" name = "query6" value = 
                "SELECT insuranceevent.idInsuranceEvent, insuranceevent.name, insuranceevent.cost,
                    SUM(insuranceevent.count) as Count FROM `insuranceevent`, `сontract`
                    WHERE `insuranceevent`.`idInsuranceEvent` = `сontract`.`idInsuranceEvent`
                    GROUP BY `сontract`.`idInsuranceEvent`
                    ORDER BY Count DESC LIMIT 3">
                <input type = "hidden" name = "queryType6" value = "6">
            </tr>
            <tr>
                <td><input type = "radio" name = 'rad' value = '7'></td>
                <td>7. Вывести самый дорогой страховой случай</td>
                <input type = "hidden" name = "query7" value =
                    'SELECT idInsuranceEvent,name,cost FROM `insuranceevent`
                    WHERE `cost`= (SELECT MAX(cost) FROM insuranceevent)'>
                <input type = "hidden" name = "queryType7" value = "7">
            </tr>
            
        </table>
        <a href = "../index.php" style = "margin-left: 10%">Главная</a>
        <input type = "submit" name = "push" value = "Выполнить" style = "margin-right: 10%">
    </form>

    <table style = "margin-top : 30px;">
    <?php
    require_once "../config.php";
    
    //var_dump($_POST);
    if ($_POST['rad'] && $_POST['push']){
        
        $query = $_POST['query'.$_POST['rad']];
        $num = $_POST['rad'];
        var_dump($num);
        if ($_POST['queryType'.$num] == 1){
            $query .= $_POST['val'.$num];
            printCollumsAgent();
        }
        if ($_POST['queryType'.$num] == 2){
            $mydate = $_POST['val'.$num];
            $query .= "'".$mydate."'";
            printCollumsAgent();
        }
        if($_POST['queryType'.$num] == 3){
            $query .= "'%".$_POST['val'.$num]."%'";
            printCollumsAgent();
        } 
        if($_POST['queryType'.$num] == 4){
            $query .= "'".$_POST['val'.$num]."'";
            printCollumsType4();
        } 
        if($_POST['queryType'.$num] == 5){
            $query .= "'".$_POST['val'.$num]."')";
            printCollumsType5();
        } 
        if($_POST['queryType'.$num] == 6){
            printCollumsType6();
        }
        if($_POST['queryType'.$num] == 7){
            printCollumsType4();
        }
        var_dump($query);

        $agent = mysqli_query($link,$query) or die("Ошибка " . mysqli_error($link));
        $agent = mysqli_fetch_all($agent);

        foreach ($agent as $agent) {
            echo "<tr>";
            for ($i = 0; $i < count($agent);$i++)
            {
                echo "<td>".$agent[$i]."</td>"; 
            }
            echo "</tr>";
        } 
    }
    else{
        $query = "SELECT * FROM agent";
        $agents = mysqli_query($link,$query) or die("Ошибка " . mysqli_error($link));
        $agents = mysqli_fetch_all($agents);
        foreach ($agents as $agents) {
            $radValue = $agents[0];
            echo "<tr>";
            echo "<td><input type = 'radio' name = 'rad' value = '".$radValue."'></td>"; 
            for ($i = 0; $i < count($agents);$i++)
            {
                echo "<td>".$agents[$i]."</td>"; 
            }
            echo "</tr>";
        } 
    }

    ?>
    </table>
    

</body>
<?php

function printCollumsAgent(){
    echo "<tr>
        <td>Id</td>
        <td>ФИО агента</td>
        <td>Адрес проживания</td>
        <td>Данные паспорта</td>
        <td>Дата приема на работу</td>
    </tr>";
}

function printCollumsType4(){
    echo "<tr>
        <td>Id</td>
        <td>Название страхового случая</td>
        <td>Цена страховки</td>
    </tr>";
}
function printCollumsType5(){
    echo "<tr>
        <td>Id</td>
        <td>Имя клиента</td>
        <td>Название страхового случая</td>
        <td>Цена страховки</td>
        <td>Дата заключения</td>
        <td>Срок страховки</td>
    </tr>";
}

function printCollumsType6(){
    echo "<tr>
        <td>Id</td>
        <td>Название страхового случая</td>
        <td>Цена страховки</td>
        <td>Кол-во договоров</td>
    </tr>";
}
?>