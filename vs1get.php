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

    $egrpbeg = (int)($_POST['egrpbeg']);
    $egrpend = (int)($_POST['egrpend']);

    if ($vfile) {
        $handle = @fopen("files/vs1get-" . $id_user . ".txt", "w");
        $strfile = "id ЕГРП/id ГКН|Кадастровый номер ЕГРП(=КН ГКН)|Адрес ЕГРП|Адрес ГКН|пл ЕГРП|пл ГКН|название ЕГРП|название ГКН|Потенциально возможный КН ГКН| Потенциально возможный адрес ГКН|пл потенциально возможного объекта ГКН
";
        fwrite($handle, $strfile);
    } else {
        print("<table border='1'> <tr><td>id ЕГРП/id ГКН</td><td>Кадастровый номер ЕГРП(=КН ГКН)</td><td>Адрес ЕГРП</td><td>Адрес ГКН</td></tr>");
    };


    $db = mysql_connect("localhost", "root", "");
    mysql_select_db("address" . $id_user, $db) or print(mysql_error());
    set_time_limit(20000);
    ini_set("memory_limit", "1024M");


    $query1 = "SELECT `id`, `cad_num`,`adres`,`liter`, `new_adres`,`kod_kladr`,`new_dom`,`new_kv`,`new_kom`,`area`,`name` FROM `egrp_kladr_new` where `kod_kladr` is not null and `id`>=" . $egrpbeg . " and `id`<=" . $egrpend . " ";//and `id`<1200000
    $sql1 = mysql_query($query1) or die(mysql_error());
    while ($row1 = mysql_fetch_assoc($sql1)) {
        $query2 = "SELECT `id`, `adres`,`liter`, `new_adres`,`kod_kladr`,`new_dom`,`new_kv`,`new_kom`,`area`,`name` FROM `gkn_kladr_new` where `cad_num`='" . $row1['cad_num'] . "' and `kod_kladr` is not null limit 1";
        $sql2 = mysql_query($query2) or print(mysql_error());
        $row2 = mysql_fetch_assoc($sql2);
        $liter1 = preg_replace('/[\s.,; ]/', '', $row1['liter']);
        $liter2 = preg_replace('/[\s.,; ]/', '', $row2['liter']);
        //if($row1['new_kv']=='0'){$row1['new_kv']='';};	if($row2['new_kv']=='0'){$row2['new_kv']='';};
        if ($row2['id'] != '') {
            $adrul1 = preg_split("/[|]/", $row1['new_adres']);
            $adrul2 = preg_split("/[|]/", $row2['new_adres']);

            $adres1 = $row1['adres'];
            $adres1 = preg_replace('[Ж]', '@@1', $adres1);
            $adres1 = preg_replace('[ф]', 'ЕГРП', $adres1);
            $adres1 = preg_replace('/[\s.,;()"]/', ' ', $row1['adres']);
            $adres1 = preg_replace('[@@1]', 'Ж', $adres1);
            $adres1 = preg_replace('[ЕГРП]', 'ф', $adres1);

            $adres2 = $row2['adres'];
            $adres2 = preg_replace('[Ж]', '@@1', $adres2);
            $adres2 = preg_replace('[ф]', 'ЕГРП', $adres2);
            $adres2 = preg_replace('/[\s.,;()"]/', ' ', $adres2);
            $adres2 = preg_replace('[@@1]', 'Ж', $adres2);
            $adres2 = preg_replace('[ЕГРП]', 'ф', $adres2);

            $booladr = true;
            $boolarea = true;

            $kodkl1 = $row1['kod_kladr'];
            $kodkl2 = $row2['kod_kladr'];
            $dom1 = preg_replace("'/А'", 'А', $row1['new_dom']) . (int)(preg_replace("([^0-9])", "",
                    $row1['new_kv'])) . (int)(preg_replace("([^0-9])", "", $row1['new_kom']));
            $dom2 = preg_replace("'/А'", 'А', $row2['new_dom']) . (int)(preg_replace("([^0-9])", "",
                    $row2['new_kv'])) . (int)(preg_replace("([^0-9])", "", $row21['new_kom']));

            if (($kodkl1 != $kodkl2) or ($dom1 != $dom2)) {
                $booladr = false;
            };
            if (($kodkl1 != $kodkl2) and ($dom1 == $dom2) and ((strpos(mb_strtoupper($adres1, "UTF-8"),
                            ' ' . mb_strtoupper($adrul2[3], "UTF-8") . ' ') > -1) or (strpos(mb_strtoupper($adres2,
                            "UTF-8"), ' ' . mb_strtoupper($adrul1[3], "UTF-8") . ' ') > -1))) {
                $booladr = true;
            };
            if ((($row1['new_kv'] != $row2['new_kv']) and ($row2['new_kv'] == '') and (strpos(mb_strtoupper($row2['name'],
                            "UTF-8"),
                            'КВАРТИРА') > -1)) or (($row1['new_kv'] != $row2['new_kv']) and ($row1['new_kv'] == '') and (strpos(mb_strtoupper($row1['name'],
                            "UTF-8"), 'КВАРТИРА') > -1))) {
                $booladr = true;
            };

            if (($row1['new_adres'] == $row2['new_adres'])) {
                $booladr = true;
            };

            if (abs((int)($row1['area']) - (int)($row2['area'])) >= 2) {
                $boolarea = false;
            };

            //if(($row1['kod_kladr']==$row2['kod_kladr'])and($row1['new_dom'].(int)($row1['new_kv'])==$row2['new_dom'].(int)($row2['new_kv']))){$booladr=true;};
            //if((($row1['kod_kladr']!=$row2['kod_kladr'])or($row1['new_dom'].(int)($row1['new_kv'])!=$row2['new_dom'].(int)($row2['new_kv'])))and($row1['new_adres']!=$row2['new_adres'])){$booladr=false;};


            if (($booladr == false) and ($boolarea == false)) {

                $query3 = "SELECT `cad_num`,`id`, `adres`,`area` FROM `gkn_kladr_new` where `kod_kladr`='" . $row1['kod_kladr'] . "' and `new_dom`='" . $row1['new_dom'] . "' and `new_kv`='" . $row1['new_kv'] . "' and `new_kom`='" . $row1['new_kom'] . "' and ABS(`area`-" . $row1['area'] . ")<2  limit 1";
                $sql3 = mysql_query($query3) or print(mysql_error());
                $row3 = mysql_fetch_assoc($sql3);

                $strfile = $row1['id'] . '/' . $row2['id'] . '|' . $row1['cad_num'] . '|' . $row1['adres'] . '|' . $row2['adres'] . '|' . $row1['area'] . '|' . $row2['area'] . '|' . $row1['name'] . '|' . $row2['name'] . '';
                if (($row3['id'] != '') and (abs((int)($row1['area']) - (int)($row3['area'])) < 2)) {
                    $strfile = $strfile . '|' . $row3['cad_num'] . '|' . $row3['adres'] . '|' . $row3['area'] . '
';
                } else {
                    $strfile = $strfile . '||
';
                };
                fwrite($handle, $strfile);
            };
        };
        unset($row2);
        unset($row3);
        unset($sql2);
        unset($sql3);
        unset($query2);
        unset($query3);
        unset($adrul1);
        unset($adres1);
        unset($kodkl1);
        unset($dom1);
        unset($adrul2);
        unset($adres2);
        unset($kodkl2);
        unset($dom2);

    };
    mysql_close($db);

    if ($vfile) {
        fclose($handle);
        print('<a href="files/vs1get-' . $id_user . '.txt">Файл</a>');
    } else {
        print("</table>");
    };
    gc_collect_cycles();
    ?>

</div>
</body>
</html>	