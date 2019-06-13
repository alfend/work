<?php session_start();
gc_collect_cycles(); ?>

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
        $handle = @fopen("files/vs31-" . $id_user . ".txt", "w");
        $strfile = "id ЕГРП/id ГКН|КН|Адрес ЕГРП|Литера ЕГРП|Площадь ЕГРП|Адрес ГКН|Литера ГКН|Площадь ГКН|совпадение адреса (-1 не найден кладр, 0 не совпал, 1 совпал)|совпадение площади (-1 одна из пл = 0, 0 не совпала, 1 совпала)|совпадение литеры (-1 одна из литер пустая, 0 не совпали, 1 совпали)|1 все 3 совпали, 0 хотя бы одна нет, -1 не найдено пары
";
        fwrite($handle, $strfile);
    } else {
        print('<tr><td>id ЕГРП/id ГКН</td></td><td>КН</td><td>Адрес ЕГРП</td></tr>');
    };

    $db = mysql_connect("localhost", "root", "");
    mysql_select_db("address" . $id_user, $db) or print(mysql_error());
    set_time_limit(20000);


    $query1 = "SELECT `id`, `cad_num`,`adres`,`liter`, `new_adres`,`kod_kladr`,`new_dom`,`new_kv`,`new_kom`,`area` FROM `egrp_kladr_new`";//and `id`<1200000
    $sql1 = mysql_query($query1) or die(mysql_error());
    while ($row1 = mysql_fetch_assoc($sql1)) {//$adres=preg_replace('/[\s.,;]/',' ',);     mb_strtoupper($row1['liter'],"UTF-8")
        $query2 = "SELECT `id`, `cad_num`,`adres`,`liter`,`new_adres`,`kod_kladr`,`new_dom`,`new_kv`,`new_kom`,`area` FROM `gkn_kladr_new` where `cad_num`='" . $row1['cad_num'] . "'";// and `kod_kladr`='".$row1['kod_kladr']."' and `kod_kladr`='".$row1['kod_kladr']."' and `new_dom`='".$row1['new_dom']."' and `new_kv`='".$row1['new_kv']."' and `new_kom`='".$row1['new_kom']."' and ABS(`area`-".$row1['area'].")<=1
        $sql2 = mysql_query($query2) or print(mysql_error());
        $row2 = mysql_fetch_assoc($sql2);
        $liter1 = preg_replace('/[\s.,; ]/', '', $row1['liter']);
        $liter2 = preg_replace('/[\s.,; ]/', '', $row2['liter']);

        $dom1 = preg_replace("'/А'", 'А', $row1['new_dom']) . (int)(preg_replace("([^0-9])", "",
                $row1['new_kv'])) . (int)(preg_replace("([^0-9])", "", $row1['new_kom']));
        $dom2 = preg_replace("'/А'", 'А', $row2['new_dom']) . (int)(preg_replace("([^0-9])", "",
                $row2['new_kv'])) . (int)(preg_replace("([^0-9])", "", $row2['new_kom']));

        $strfile = $row1['id'] . '/' . $row2['id'] . '|' . $row1['cad_num'] . '|' . $row1['adres'] . '|' . $row1['liter'] . '|' . $row1['area'] . '|';


        if (($row2['id'] != '')) {

            $strfile = $strfile . $row2['adres'] . '|' . $row2['liter'] . '|' . $row2['area'] . '|';
            $sumdop = 0;
            if (($row2['kod_kladr'] == '') or ($row1['kod_kladr'] == '')) {
                $strfile = $strfile . '-1|';
            } else {
                if (($row2['kod_kladr'] == $row1['kod_kladr']) and ($dom1 == $dom2)) {
                    $strfile = $strfile . '1|';
                    $sumdop++;
                } else {
                    $strfile = $strfile . '0|';
                };
            };

            if ((((int)($row2['area']) == 0) and ((int)($row1['area']) != 0)) or (((int)($row1['area']) == 0) and ((int)($row2['area']) != 0))) {
                $strfile = $strfile . '-1|';
            } else {
                if (abs(($row1['area']) - ($row2['area'])) > 1) {
                    $strfile = $strfile . '0|';
                } else {
                    $strfile = $strfile . '1|';
                    $sumdop++;
                };
            };

            if ((($liter1 == '') and ($liter2 != '')) or (($liter2 == '') and ($liter1 != ''))) {
                $strfile = $strfile . '-1|';
            } else {
                if ($liter1 == $liter2) {
                    $strfile = $strfile . '1|';
                    $sumdop++;
                } else {
                    $strfile = $strfile . '0|';
                };
            };

            if ($sumdop == 3) {
                $strfile = $strfile . '1
';
            } else {
                $strfile = $strfile . '0
';
            };
        } else {
            $strfile = $strfile . '||||||-1
';
        };


        fwrite($handle, $strfile);
    };
    mysql_close($db);
    if ($vfile) {
        fclose($handle);
        print('<a href="files/vs31-' . $id_user . '.txt">Файл</a>');
    } else {
        print("</table>");
    };
    gc_collect_cycles();
    ?>

</div>
</body>
</html>	