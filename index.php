<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link rel = "stylesheet" href = "css/style.css">
</head>
<body>
    
    <form action = "php/scripts.php" method = "POST">
    <div style = "width : 30%;margin-left:35%;margin-bottom: 50px;">
        <h2 style = "margin-left : 40%;width: 20%">Форма</h2>
        <p>ФИО <input type = "text" name = "FIO"></p>
        <p>Адрес <input type = "text" name = "addres"></p>
        <p>Серия и номер паспорта<input type = "text" name = "dataPassport"></p>
        <p>Дата приема <input type = "date" name = "dateAdmission"></p>
        <input type = "submit" name = "add" value = "Добавить"> 
        <input type = "submit" name = "del" value = "Удалить">
        <input type = "submit" name = "upd" value = "Изменить">
        <a href = "php/query.php" style = "text-align:left;">Запросы</a>
    </div>
        

        
        <table>
            
            <h2 style = "margin-left : 45%; width:10%">Агенты</h2>
            <tr>
                <td style = "width : 2%"></td>
                <td class =  "firstСolumns">Id</td>
                <td class =  "firstСolumns">ФИО</td>
                <td class =  "firstСolumns">Адрес</td>
                <td class =  "firstСolumns">Паспортные данные</td>
                <td class =  "firstСolumns">Приняли на работу</td>
            </tr>
            <?php
                require_once('config.php'); 
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
            ?>
        </table>
    </form>


</body>