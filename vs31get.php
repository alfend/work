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
    $egrpbeg = (int)($_POST['egrpbeg']);
    $egrpend = (int)($_POST['egrpend']);
    $vfile = true;
    $id_user = $_SESSION['id_user'];
    if ($vfile) {
        $handle = @fopen("files/vs31get-" . $id_user . ".txt", "w");
        $strfile = "id ЕГРП/id ГКН|КН|Адрес ЕГРП|Литера ЕГРП|Площадь ЕГРП|Название ЕГРП|Адрес ГКН|Литера ГКН|Площадь ГКН|Название ГКН|совпадение адреса (-1 не найден кладр, 0 не совпал, 1 совпал)|совпадение площади (-1 одна из пл = 0, 0 не совпала, 1 совпала)|совпадение литеры (-1 одна из литер пустая, 0 не совпали, 1 совпали)|совпадение наименования(по просьбе Москвы) в итоговом поле не учитывается|1 все 3 совпали, 0 хотя бы одна нет, -1 не найдено пары
";
        fwrite($handle, $strfile);
    } else {
        print('<tr><td>id ЕГРП/id ГКН</td></td><td>КН</td><td>Адрес ЕГРП</td></tr>');
    };

    $db = mysql_connect("localhost", "root", "");
    mysql_select_db("address" . $id_user, $db) or print(mysql_error());
    set_time_limit(20000);


    $query1 = "SELECT `id`, `cad_num`,`adres`,`liter`, `new_adres`,`kod_kladr`,`new_dom`,`new_kv`,`new_kom`,`area`,`name` FROM `egrp_kladr_new` where `id`>=" . $egrpbeg . " and `id`<=" . $egrpend . " ";//and `id`<1200000
    $sql1 = mysql_query($query1) or die(mysql_error());
    while ($row1 = mysql_fetch_assoc($sql1)) {//$adres=preg_replace('/[\s.,;]/',' ',);     mb_strtoupper($row1['liter'],"UTF-8")
        $query2 = "SELECT `id`, `cad_num`,`adres`,`liter`,`new_adres`,`kod_kladr`,`new_dom`,`new_kv`,`new_kom`,`area`,`name` FROM `gkn_kladr_new` where `cad_num`='" . $row1['cad_num'] . "'";// and `kod_kladr`='".$row1['kod_kladr']."' and `kod_kladr`='".$row1['kod_kladr']."' and `new_dom`='".$row1['new_dom']."' and `new_kv`='".$row1['new_kv']."' and `new_kom`='".$row1['new_kom']."' and ABS(`area`-".$row1['area'].")<=1
        $sql2 = mysql_query($query2) or print(mysql_error());
        $row2 = mysql_fetch_assoc($sql2);

        $liter1 = preg_replace('/[\s.,; ]/', '', $row1['liter']);
        $liter2 = preg_replace('/[\s.,; ]/', '', $row2['liter']);

        $name1 = mb_strtoupper(preg_replace('/[\s.,; ]/', '', $row1['name']), "UTF-8");
        $name2 = mb_strtoupper(preg_replace('/[\s.,; ]/', '', $row2['name']), "UTF-8");
        $cifname1 = -1;
        $cifname2 = -1; //SELECT `name`,count(`id`) FROM `egrp_kladr_new` group by `name` order by count(`id`)
        if ((strpos($name1, 'СООРУЖЕНИ') > -1)) {
            $cifname1 = 4;
        };
        if ((strpos($name2, 'СООРУЖЕНИ') > -1)) {
            $cifname2 = 4;
        };
        if ((strpos($name1, 'ЗДАНИЕ') > -1) or (strpos($name1, 'СТРОЕНИЕ') > -1)) {
            $cifname1 = 5;
        };
        if ((strpos($name2, 'ЗДАНИЕ') > -1) or (strpos($name2, 'СТРОЕНИЕ') > -1)) {
            $cifname2 = 5;
        };
        if ((strpos($name1, 'КОМНАТА') > -1)) {
            $cifname1 = 7;
        };
        if ((strpos($name2, 'КОМНАТА') > -1)) {
            $cifname2 = 7;
        };
        if ((strpos($name1, 'ОНС') > -1) or (strpos($name1, 'ОБЪЕКТ НЕЗАВЕРШЕННОГО СТРОИТЕЛЬСТВА') > -1)) {
            $cifname1 = 8;
        };
        if ((strpos($name2, 'ОНС') > -1) or (strpos($name2, 'ОБЪЕКТ НЕЗАВЕРШЕННОГО СТРОИТЕЛЬСТВА') > -1)) {
            $cifname2 = 8;
        };
        if ((strpos($name1, 'СКВАЖИНА') > -1) or (strpos($name1, 'МЕСТОРОЖДЕНИЕ') > -1)) {
            $cifname1 = 9;
        };
        if ((strpos($name2, 'СКВАЖИНА') > -1) or (strpos($name2, 'МЕСТОРОЖДЕНИЕ') > -1)) {
            $cifname2 = 9;
        };
        if ((strpos($name1, 'ДОМ') > -1)) {
            $cifname1 = 2;
        };
        if ((strpos($name2, 'ДОМ') > -1)) {
            $cifname2 = 2;
        };
        if ((strpos($name1, 'КВАРТИРА') > -1)) {
            $cifname1 = 1;
        };
        if ((strpos($name2, 'КВАРТИРА') > -1)) {
            $cifname2 = 1;
        };
        if ((strpos($name1, 'ГАРАЖ') > -1) or (strpos($name1, 'БОКС') > -1)) {
            $cifname1 = 3;
        };
        if ((strpos($name2, 'ГАРАЖ') > -1) or (strpos($name2, 'БОКС') > -1)) {
            $cifname2 = 3;
        };
        if ((strpos($name1, 'ПОМЕЩЕНИ') > -1)) {
            $cifname1 = 6;
        };
        if ((strpos($name2, 'ПОМЕЩЕНИ') > -1)) {
            $cifname2 = 6;
        };


        $dom1 = preg_replace("'/А'", 'А', $row1['new_dom']) . (int)(preg_replace("([^0-9])", "",
                $row1['new_kv'])) . (int)(preg_replace("([^0-9])", "", $row1['new_kom']));
        $dom2 = preg_replace("'/А'", 'А', $row2['new_dom']) . (int)(preg_replace("([^0-9])", "",
                $row2['new_kv'])) . (int)(preg_replace("([^0-9])", "", $row2['new_kom']));

        $strfile = $row1['id'] . '/' . $row2['id'] . '|' . $row1['cad_num'] . '|' . $row1['adres'] . '|' . $row1['liter'] . '|' . $row1['area'] . '|' . $row1['name'] . '|';


        if (($row2['id'] != '')) {

            $strfile = $strfile . $row2['adres'] . '|' . $row2['liter'] . '|' . $row2['area'] . '|' . $row2['name'] . '|';
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

            if ((($cifname1 == -1) or ($cifname2 == -1)) and (($name1 != $name2))) {
                $strfile = $strfile . '-1|';
            } else {
                if (($name1 == $name2) or ($cifname1 == $cifname2) or
                    (($cifname1 == 1 and $cifname2 == 6) or ($cifname2 == 1 and $cifname1 == 6)) or
                    (($cifname1 == 2 and ($cifname2 == 5 or $cifname2 == 8)) or ($cifname2 == 2 and ($cifname1 == 5 or $cifname1 == 8))) or
                    (($cifname1 == 3 and $cifname2 == 6) or ($cifname2 == 3 and $cifname1 == 6)) or
                    (($cifname1 == 4 and $cifname2 == 9) or ($cifname2 == 4 and $cifname1 == 9)) or
                    (($cifname1 == 5 and $cifname2 == 8) or ($cifname2 == 5 and $cifname1 == 8)) or
                    (($cifname1 == 6 and $cifname2 == 7) or ($cifname2 == 6 and $cifname1 == 7))) {
                    $strfile = $strfile . '1|';
                } else {
                    $strfile = $strfile . '0|';
                };
            };

//$strfile=$strfile.'   '.$cifname1.' '.$cifname2.' n '.$name1.' n2 '.$name2;


            if ($sumdop == 3) {
                $strfile = $strfile . '1
';
            } else {
                $strfile = $strfile . '0
';
            };
        } else {
            $strfile = $strfile . '|||||||-1
';
        };


        fwrite($handle, $strfile);
    };
    mysql_close($db);
    if ($vfile) {
        fclose($handle);
        print('<a href="files/vs31get-' . $id_user . '.txt">Файл</a>');
    } else {
        print("</table>");
    };
    gc_collect_cycles();

    /*
    1) квартира: 1-комнатная квартира, 2-комнатная квартира и т.д., часть жилого дома
    2) жилой дом (садовый): садовый дом, дачный дом
    3) жилой дом: основное строение, основная постройка
    */
    ?>

</div>
</body>
</html>	