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
    <?php
    $vfile = true;
    $id_user = $_SESSION['id_user'];
    if ($vfile) {
        $handle = @fopen("files/vs2-" . $id_user . ".txt", "w");
        $strfile = "id ЕГРП/id ГКН|Адрес ЕГРП|Адрес ГКН|КН ЕГРП|КН ГКН|Литера ЕГРП|Литера ГКН|Площадь ЕГРП|Площадь ГКН
";
        fwrite($handle, $strfile);
    } else {
        print("<table border='1'> <tr><td>id ЕГРП/id ГКН</td><td>Адрес ЕГРП</td><td>Адрес ГКН</td><td>КН ЕГРП</td><td>КН ГКН</td><td>Литера ЕГРП</td><td>Литера ГКН</td></tr>");
    };


    $db = mysql_connect("localhost", "root", "");
    mysql_select_db("address" . $id_user, $db) or print(mysql_error());
    set_time_limit(20000);

    $query1 = "SELECT `id`, `cad_num`,`adres`,`liter`, `new_adres`,`kod_kladr`,`new_dom`,`new_kv`,`new_kom`,`area`,`name` FROM `egrp_kladr_new` where `kod_kladr` is not null and ((`new_dom`<>'') or (`new_kv`<>''))";//and `id`<1200000 and limit 1000
    $sql1 = mysql_query($query1) or die(mysql_error());
    while ($row1 = mysql_fetch_assoc($sql1)) {//$adres=preg_replace('/[\s.,;]/',' ',);     mb_strtoupper($row1['liter'],"UTF-8")
        $query2 = "SELECT `id`, `adres`,`liter`,`new_dom`,`new_kv`,`new_kom`,`area`,`name` FROM `gkn_kladr_new` where  ABS(`area`-" . $row1['area'] . ")<=1 and `kod_kladr`='" . $row1['kod_kladr'] . "' and `cad_num`<>'" . $row1['cad_num'] . "' and `new_dom`='" . $row1['new_dom'] . "' and `new_kv`='" . $row1['new_kv'] . "' and `new_kom`='" . $row1['new_kom'] . "' limit 1";
        $sql2 = mysql_query($query2) or print(mysql_error());
        $row2 = mysql_fetch_assoc($sql2);
        $liter1 = preg_replace('/[\s.,; ]/', '', $row1['liter']);
        $liter2 = preg_replace('/[\s.,; ]/', '', $row2['liter']);
        if ($row1['new_kv'] == '0') {
            $row1['new_kv'] = '';
        };
        if ($row2['new_kv'] == '0') {
            $row2['new_kv'] = '';
        };
        if (($row2['id'] != '') and ($liter1 == $liter2)) {
            //if(($row1['cad_num']!=$row2['cad_num']))
            {
                if ($vfile) {
                    $strfile = $row1['id'] . '/' . $row2['id'] . '|' . $row1['adres'] . '|' . $row2['adres'] . '|' . $row1['cad_num'] . '|' . $row2['cad_num'] . '|' . $row1['liter'] . '|' . $row2['liter'] . '|' . $row1['area'] . '|' . $row2['area'] . '|' . $row1['name'] . '|' . $row2['name'] . '
';
                    fwrite($handle, $strfile);
                } else {
                    print('<tr><td>' . $row1['id'] . '/' . $row2['id'] . '</td><td>' . $row1['adres'] . '</td><td>' . $row2['adres'] . '</td><td>' . $row1['cad_num'] . '</td><td>' . $row2['cad_num'] . '</td><td>' . $row1['liter'] . '</td><td>' . $row2['liter'] . '</td></tr>');
                };
            };
        };
    };
    mysql_close($db);

    if ($vfile) {
        fclose($handle);
        print('<a href="files/vs2-' . $id_user . '.txt">Файл</a>');
    } else {
        print("</table>");
    };
    gc_collect_cycles();
    ?>
</div>
</body>
</html>	