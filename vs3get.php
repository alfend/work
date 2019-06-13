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
    $egrpbeg = (int)($_POST['egrpbeg']);
    $egrpend = (int)($_POST['egrpend']);
    $id_user = $_SESSION['id_user'];
    if ($vfile) {
        $handle = @fopen("files/vs3get-" . $id_user . ".txt", "w");
        $strfile = "id ЕГРП/id ГКН|КН|Адрес ЕГРП|Литера ЕГРП|Литера ГКН.
";
        fwrite($handle, $strfile);
    } else {
        print('<tr><td>id ЕГРП/id ГКН</td></td><td>КН</td><td>Адрес ЕГРП</td></tr>');
    };

    $db = mysql_connect("localhost", "root", "");
    mysql_select_db("address" . $id_user, $db) or print(mysql_error());
    set_time_limit(20000);


    $query1 = "SELECT `id`, `cad_num`,`adres`,`liter`, `new_adres`,`kod_kladr`,`new_dom`,`new_kv`,`area` FROM `egrp_kladr_new` where `kod_kladr` is not null  and `id`>=" . $egrpbeg . " and `id`<=" . $egrpend . " ";//and `id`<1200000

    $sql1 = mysql_query($query1) or die(mysql_error());
    while ($row1 = mysql_fetch_assoc($sql1)) {//$adres=preg_replace('/[\s.,;]/',' ',);     mb_strtoupper($row1['liter'],"UTF-8")
        $query2 = "SELECT `id`, `cad_num`,`adres`,`liter`,`new_adres`,`kod_kladr`,`new_dom`,`new_kv`,'area' FROM `gkn_kladr_new` where `cad_num`='" . $row1['cad_num'] . "' and `kod_kladr`='" . $row1['kod_kladr'] . "' and `kod_kladr`='" . $row1['kod_kladr'] . "' and `new_dom`='" . $row1['new_dom'] . "' and `new_kv`='" . $row1['new_kv'] . "' and `new_kom`='" . $row1['new_kom'] . "' and ABS(`area`-" . $row1['area'] . ")<=1";
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
        if (($row2['id'] != '') and ($liter1 == $liter2)) {//
            if ($vfile) {
                $strfile = $row1['id'] . '/' . $row2['id'] . '|' . $row1['cad_num'] . '|' . $row1['adres'] . '|' . $row1['liter'] . '|' . $row2['liter'] . '
';
                fwrite($handle, $strfile);
            } else {
                print('<tr><td>' . $row1['id'] . '/' . $row2['id'] . '</td><td>' . $row1['cad_num'] . '</td><td>' . $row1['adres'] . '</td><td>' . $row1['liter'] . '</td><td>' . $row2['liter'] . '</td></tr>');
            };
        };
    };
    mysql_close($db);
    if ($vfile) {
        fclose($handle);
        print('<a href="files/vs3get-' . $id_user . '.txt">Файл</a>');
    } else {
        print("</table>");
    };
    gc_collect_cycles();
    ?>

</div>
</body>
</html>	