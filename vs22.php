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
        $handle = @fopen("files/vs22-" . $id_user . ".txt", "w");
        $strfile = "id ЕГРП|Кадастровый номер ЕГРП|Адрес ЕГРП|пл ЕГРП|название ЕГРП|Литер ЕГРП|Пояснение
";
        fwrite($handle, $strfile);
    } else {
//print("<table border='1'> <tr><td>id ЕГРП/id ГКН</td><td>Адрес ЕГРП</td><td>Адрес ГКН</td><td>КН ЕГРП</td><td>КН ГКН</td><td>Литера ЕГРП</td><td>Литера ГКН</td></tr>");
    };


    $db = mysql_connect("localhost", "root", "");
    mysql_select_db("address" . $id_user, $db) or print(mysql_error());
    set_time_limit(20000);
    //ini_set("memory_limit", "1024M");

    $query1 = "SELECT `cad_num` FROM `egrp_kladr_new` group by `cad_num` having count('id')>1";
    $sql1 = mysql_query($query1) or die(mysql_error());
    while ($row1 = mysql_fetch_assoc($sql1)) {
        $query2 = "SELECT `id`,`cad_num`,`adres`,`area`,`name`,`liter` FROM `egrp_kladr_new` WHERE `cad_num`='" . $row1['cad_num'] . "'";
        $sql2 = mysql_query($query2) or print(mysql_error());
        while ($row2 = mysql_fetch_assoc($sql2)) {
            if ($vfile) {
                $strfile = $row2['id'] . '|' . $row2['cad_num'] . '|' . $row2['adres'] . '|' . $row2['area'] . '|' . $row2['name'] . '|' . $row2['liter'] . '|Совпадает Кадастровый номер
';
                fwrite($handle, $strfile);
            };
        };
    };
    $query1 = "SELECT `new_adres`,`kod_kladr`,`liter`,`area` FROM `egrp_kladr_new` group by `new_adres`,`kod_kladr`,`liter`,`area` having count(`cad_num`)>1";
    $sql1 = mysql_query($query1) or die(mysql_error());
    while ($row1 = mysql_fetch_assoc($sql1)) {
        $query2 = "SELECT `id`,`cad_num`,`adres`,`area`,`name`,`liter` FROM `egrp_kladr_new` WHERE `new_adres`='" . $row1['new_adres'] . "' and `kod_kladr`='" . $row1['kod_kladr'] . "' and `liter` ='" . $row1['liter'] . "' and `area`='" . $row1['area'] . "' and (`new_dom`<>'' or `new_kv`<>'') ";
        $sql2 = mysql_query($query2) or print(mysql_error());
        while ($row2 = mysql_fetch_assoc($sql2)) {
            if ($vfile) {
                $strfile = $row2['id'] . '|' . $row2['cad_num'] . '|' . $row2['adres'] . '|' . $row2['area'] . '|' . $row2['name'] . '|' . $row2['liter'] . '|Совпадает адрес, площадь и литера
';
                fwrite($handle, $strfile);
            };
        };
    };
    mysql_close($db);

    if ($vfile) {
        fclose($handle);
        print('<a href="files/vs22-' . $id_user . '.txt">Файл</a>');
    } else {
        print("</table>");
    };
    gc_collect_cycles();
    ?>
</div>
</body>
</html>	