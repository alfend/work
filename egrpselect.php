<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<div id="menu">
    <?php include "menu.php"; ?>
</div>
<div id="basis">
    <a href='egrp.php'> Назад </a>
    <table border='1'>
        <tr>
            <td>id</td>
            <td>Кадастровый номер</td>
            <td>Адрес</td>
            <td>Литера</td>
            <td>Вид объекта</td>
            <td>Название объекта</td>
            <td>Площадь</td>
            <td>Адрес по кладр</td>
            <td>Код по кладр</td>
        </tr>
        <?php
        $selectnumb = $_POST['selectnumb'];
        $id_user = $_SESSION['id_user'];

        $db = mysql_connect("localhost", "root", "");
        mysql_select_db("address" . $id_user, $db) or die(mysql_error());
        set_time_limit(20000);

        $queryadres = 'SELECT `id`,`cad_num`,`adres`,`type`,`area`,`liter`,`name`,`new_adres`,`kod_kladr` FROM `egrp_kladr_new` WHERE `id`>=' . $selectnumb . ' limit 1000';//and `id`<1200000
        $sqladres = mysql_query($queryadres) or die(mysql_error());
        while ($rowadres = mysql_fetch_assoc($sqladres)) {
            print('<tr><td>' . $rowadres['id'] . '</td><td>' . $rowadres['cad_num'] . '</td><td>' . $rowadres['adres'] . '</td><td>' . $rowadres['liter'] . '</td><td>' . $rowadres['type'] . '</td><td>' . $rowadres['name'] . '</td><td>' . $rowadres['area'] . '</td><td>' . $rowadres['new_adres'] . '</td><td>' . $rowadres['kod_kladr'] . '</td></tr>');
        };
        mysql_close($db);
        gc_collect_cycles();
        ?>
    </table>
</div>
</body>
</html>	