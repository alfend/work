<?php session_start();
gc_collect_cycles();
?>

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
    <?php
    $vfile = true;
    $id_user = $_SESSION['id_user'];
    if ($vfile) {
        $handle = @fopen("files/vs6-" . $id_user . ".txt", "w");
        $strfile = "id ОКС ГКН/id ЗУ ГКН|Кадастровый номер ОКС ГКН|Кадастровый номер ЗУ ГКН|Адрес ОКС|Адрес ЗУ|Тип ОКС|Тип ЗУ
";
        fwrite($handle, $strfile);
    } else {
        print("<table border='1'> <tr><td>id ЕГРП/id ГКН</td><td>Адрес ЕГРП</td><td>Адрес ГКН</td><td>КН ЕГРП</td><td>КН ГКН</td><td>Литера ЕГРП</td><td>Литера ГКН</td></tr>");
    };


    $db = mysql_connect("localhost", "root", "");
    mysql_select_db("address" . $id_user, $db) or print(mysql_error());
    set_time_limit(20000);
    //ini_set("memory_limit", "1024M");

    $query1 = "SELECT `id`,`cad_num`,`new_adres`,`adres`,`new_dom`,`new_kv`,`kod_kladr`,`type` FROM `gkn_kladr_new` where (`new_dom`<>'' or `new_kv`<>'') and (`type` in ('002002001000','002002004000','002002005000','Объект незавершенного строительства','Здание','Сооружение'))";
    $sql1 = mysql_query($query1) or die(mysql_error());
    while ($row1 = mysql_fetch_assoc($sql1)) {
        $query2 = "SELECT `id`,`cad_num`,`adres`,`name`,`type` FROM `gkn_zu_kladr_new` WHERE (`new_adres`='" . $row1['new_adres'] . "') or (`kod_kladr`='" . $row1['kod_kladr'] . "' and `new_dom` ='" . $row1['new_dom'] . "' and '" . $row1['new_kv'] . "'='') or (`kod_kladr`='" . $row1['kod_kladr'] . "' and `new_dom` ='" . $row1['new_dom'] . "' and `new_kv`='" . $row1['new_kv'] . "')";
        $sql2 = mysql_query($query2) or print(mysql_error());
        $kol = 0;
        $strfile = '';
        while ($row2 = mysql_fetch_assoc($sql2)) {
            $strfile = $strfile . $row1['id'] . '/' . $row2['id'] . '|' . $row1['cad_num'] . '|' . $row2['cad_num'] . '|' . $row1['adres'] . '|' . $row2['adres'] . '|' . $row1['type'] . '|' . $row2['type'] . '
';
            $kol++;
        };
        if ($kol < 10) {
            fwrite($handle, $strfile);
        };
    };
    mysql_close($db);

    if ($vfile) {
        fclose($handle);
        print('<a href="files/vs21-' . $id_user . '.txt">Файл</a>');
    } else {
        print("</table>");
    };
    gc_collect_cycles();
    ?>
</div>
</body>
</html>	