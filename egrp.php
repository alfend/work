<?php session_start();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>Выявления не верно гармонизированных ОКС</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>

<body>
<div id="menu">
    <?php include "menu.php"; ?>
</div>
<div id="basis">
    ЕГРП
    </br>
    <?php
    $id_user = $_SESSION['id_user'];
    $db = mysql_connect("localhost", "root", "");
    mysql_select_db("address" . $id_user, $db) or print(mysql_error());

    $querykol = 'SELECT count(`id`) id FROM `egrp_kladr_new` ';//and `id`<1200000
    $sqlkol = mysql_query($querykol) or die(mysql_error());
    $kol = mysql_fetch_assoc($sqlkol);

    $querykol = 'SELECT count(`id`) id FROM `egrp_kladr_new` WHERE `kod_kladr` is not null';//and `id`<1200000
    $sqlkol = mysql_query($querykol) or die(mysql_error());
    $kolnotnull = mysql_fetch_assoc($sqlkol);

    print("Количество загруженных " . $kol['id'] . ", из них с найденом кодом кладра " . $kolnotnull['id']);
    ?>
    </br>
    Файл должен иметь след формат: Кадастровый номер|Адрес|Литера|Тип|Площадь|Название (знак разделителя | ,строки
    разделены enter. Кодировка должна быть UTF-8).</br>
    <a href="egrp.txt">пример</a>
    </br>
    <form method="post" enctype="multipart/form-data" action="egrpinsert.php">
        Файл:
        <INPUT TYPE="file" NAME="sendfile" size="80">
        <INPUT TYPE="SUBMIT" VALUE="Загрузить" ONCLICK="Отправлено!">
    </form>
    </br>
    <form method="post" enctype="multipart/form-data" action="egrpupdate.php">
        Проставить код адресам по кладру:
        начиная с <INPUT TYPE="TEXT" NAME="selectnumb" VALUE="0">
        <INPUT TYPE="SUBMIT" VALUE="Проставить" ONCLICK="Отправлено!">
    </form>
    </br>
    <form method="post" enctype="multipart/form-data" action="egrpselect.php">
        Отобразить 1000 записей начиная с
        <INPUT TYPE="TEXT" NAME="selectnumb" VALUE="1">
        <INPUT TYPE="SUBMIT" VALUE="Проверить" ONCLICK="Отправлено!">
    </form>
    </br>
    <form method="post" enctype="multipart/form-data" action="egrptruncate.php">
        Очистить все данные в ЕГРП (Внимание все данные прогруженные и обработанные в ЕГРП удаляться)
        <INPUT TYPE="SUBMIT" VALUE="Очистить ЕГРП" ONCLICK="return confirm('Вы точно хотите удалить записи ЕГРП?')">
    </form>


</div>
</body>
</html>
