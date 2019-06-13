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
    <?php $id_user = $_SESSION['id_user'];
    print("работает</br>");
    //кол-во символов в коде субъекта, так как есть субъекты менбше 10 и при превращенье в цифру нужно правильно извлекать кладр
    $selectnumb = (int)($_POST['selectnumb']);
    $kodsublen = strlen($id_user);
    $db = mysql_connect("localhost", "root", "");
    mysql_select_db("address" . $id_user, $db);
    set_time_limit(500000);
    ini_set("memory_limit", "2048M");
    $kolins = 0;
    if ($id_user == '050') {
        $kodsublen = 2;
        $id_user = '50';
    };
    //Выбрать все у которых код кладра не проставлен
    $queryadres = "SELECT `id`,`adres`,`type` FROM `gkn_zu_kladr_new` WHERE `kod_kladr` is null and `id`>" . $selectnumb . "  ";//  and `id`>
    $sqladres = mysql_query($queryadres) or die(mysql_error());
    //Извлечь название субекта, чтобы его удалть. Часто встречается, что есть улица в городе с названием субъекта и тогда система будет находить навзание этой улицы и на этом останавливать поиск улицы
    $query2 = "SELECT `name`,`short` FROM `kladr_rgs` where `number` like '" . $id_user . "00000000000';";
    $sql2 = mysql_query($query2) or die(mysql_error());
    $subject = mysql_fetch_assoc($sql2);
    $subjectname = ' ' . mb_strtoupper($subject['name'], "UTF-8") . ' ';
    $subjectshort = mb_strtoupper($subject['short'], "UTF-8");
    while ($rowadres = mysql_fetch_assoc($sqladres)) {
        $kolins++;
        $numberkladr = $id_user;
        $adres = " " . mb_strtoupper($rowadres[adres], "UTF-8") . " ";

        //заменить Ж, потому что они при замене спец символов портятся
        $adres = preg_replace('[Ж]', '@@1', $adres);
        //заменить спец символы пробелами
        $adres = preg_replace('/[\s.,;()_"]/', ' ', $adres);
        //вернуть Ж
        $adres = preg_replace('[@@1]', 'Ж', $adres);
        $adres = preg_replace('[Ё]', 'Е', $adres);
        $adres = preg_replace("'/'", ' / ', $adres);
        $adres = preg_replace("'№'", ' № ', $adres);
        $adres = preg_replace("' С / С '", ' ', $adres);

        //заменить субъект, т к может быть в городе улица с названием субъекта
        $adres = preg_replace("' РОССИЙСКАЯ '", ' ', $adres);
        $adres = preg_replace("' РФ '", ' ', $adres);
        $adres = preg_replace("' РОССИЯ '", ' ', $adres);
        $adres = preg_replace("' ГОРОД '", ' Г ', $adres);
        $adres = preg_replace("' РАЙОН '", ' Р-Н ', $adres);
        $adres = preg_replace("' Р-ОН '", ' Р-Н ', $adres);
        $adres = preg_replace("' МИКРОРАЙОН '", ' МКР ', $adres);
        $adres = preg_replace("' УЛИЦА '", ' УЛ ', $adres);
        $adres = preg_replace("' ПЕРЕУЛОК '", ' ПЕР ', $adres);
        $adres = preg_replace("' ПРОСПЕКТ '", ' ПР-КТ ', $adres);
        $adres = preg_replace("' СЕЛО '", ' С ', $adres);
        $adres = preg_replace("' ПОСЕЛОК '", ' П ', $adres);
        $adres = preg_replace("' ПОС '", ' П ', $adres);
        $adres = preg_replace("' САДОВЫЙ ДОМИК '", ' Д ', $adres);
        $adres = preg_replace("' ДОМ '", ' Д ', $adres);

        $adres = preg_replace("' УЧАСТОК '", ' Д ', $adres);
        $adres = preg_replace("' УЧ '", ' Д ', $adres);

        $adres = preg_replace("' ГАРАЖНО СТРОИТЕЛЬНЫЙ КООПЕРАТИВ '", ' ГСК ', $adres);
        $adres = preg_replace("' ГАРАЖНО-СТРОИТЕЛЬНЫЙ КООПЕРАТИВ '", ' ГСК ', $adres);

        $adres = preg_replace("' ПОМЕЩЕНИЯ '", ' ПОМ ', $adres);
        $adres = preg_replace("' ПОМЕЩЕНИЕ '", ' ПОМ ', $adres);
        $adres = preg_replace("' КВАРТИРА '", ' КВ ', $adres);
        $adres = preg_replace("' ГАР '", ' ГАРАЖ ', $adres);
        $adres = preg_replace("' КОМНАТА '", ' КОМ ', $adres);
        $adres = preg_replace("' ЛИТЕРА '", ' ЛИТ ', $adres);
        $adres = preg_replace("' ЛИТЕР '", ' ЛИТ ', $adres);

        $adres = preg_replace("[ БЕЗ НОМЕРА ]", ' Б / Н ', $adres);
        $adres = preg_replace("[ НОМЕР ]", ' № ', $adres);
        $adres = preg_replace("[ Д КОРП ]", ' / ', $adres);
        $adres = preg_replace("[ КОР ]", ' / ', $adres);
        $adres = preg_replace("[ КОРП ]", ' / ', $adres);
        $adres = preg_replace("[ КОРПУС ]", ' / ', $adres);
        $adres = preg_replace("[ БЛОК СЕКЦИЯ ]", ' / ', $adres);


        //заменить двойные пробелы
        while ((strpos($adres, '  ') > -1) and (strlen($adres) != 0)) {
            $adres = preg_replace("'  '", ' ', $adres);
        };

        //Убрать название субъеукта
        if (($id_user != '78')) {
            if ((substr_count($adres, $subjectname) == 1) and (!((strpos($adres,
                            ' УЛ' . $subjectname) > -1) or (strpos($adres, ' ПЕР' . $subjectname) > -1)))) {
                $adres = preg_replace("'" . $subjectname . "'", ' ', $adres);
            };
            if ((strpos($adres, $subjectname . $subjectshort) > -1) or (strpos($adres,
                        $subjectshort . $subjectname) > -1)) {
                $adres = preg_replace("'" . $subjectname . $subjectshort . "'", ' ', $adres);
                $adres = preg_replace("'" . $subjectshort . $subjectname . "'", ' ', $adres);
            };
            if ($id_user == '41') {
                $subjectname = ' КАМЧАТСКАЯ ';
                if ((substr_count($adres, $subjectname) == 1) and (!((strpos($adres,
                                ' УЛ' . $subjectname) > -1) or (strpos($adres, ' ПЕР' . $subjectname) > -1)))) {
                    $adres = preg_replace("'" . $subjectname . "'", ' ', $adres);
                };
            };
        };
        $adres = preg_replace("' ОБЛАСТЬ '", ' ', $adres);
        $adres = preg_replace("' РЕСПУБЛИКА '", ' ', $adres);
        $adres = preg_replace("' КРАЙ '", ' ', $adres);


        //Поиск происходит по точному совпадению с кладр, поэтому если название написано с ошибкой или в кладре написано Братьев-Башиловых а у вас Бр-Башиловых система данный объект не найдет
        //совпадение рассматривается здесь (strpos(mb_strtoupper($adres,"UTF-8"), ' '.mb_strtoupper($row2['name'],"UTF-8").' ')>-1), можно использовать функцию сравнение на наличие ошибки или использовать например Ливенштейна, но это сильно затормаживает поиск в данном случае средняя скорость 500 записей в минуту в случае с одной ошибкой порядка 30 в минуту
        //kladr_rgs состоит из SSRRRGGGNNNNTT где SS - код субъекта, RRR - код района, GGG - код города (при этом в кладр город не подчиняется районам), NNNN - населенный пункт, TT - актуальность (переименования) кладра
        //поиск города
        $query2 = "SELECT `name`,`number` FROM `kladr_rgs` where `short`='г' and `number` like '" . $numberkladr . "%00';";
        $sql2 = mysql_query($query2) or die(mysql_error());
        $gorod = '';
        $gorodUP = '';
        $tempnumbg = 0;

        while ($row2 = mysql_fetch_assoc($sql2)) {
            $gorodUP = preg_replace('[Ё]', 'Е', ' ' . mb_strtoupper($row2['name'], "UTF-8") . ' ');
            if (strpos($adres, $gorodUP) > -1) {
                $gorod = $row2['name'];
                $tempnumbg = $row2['number'][$kodsublen] . $row2['number'][$kodsublen + 1] . $row2['number'][$kodsublen + 2] . $row2['number'][$kodsublen + 3] . $row2['number'][$kodsublen + 4] . $row2['number'][$kodsublen + 5];
                break;
            };
        };
        if ($tempnumbg > 0) {
            //Если город починен району убираем и его
            //if($tempnumbg>1000)
            {
                $query2 = "SELECT `name` FROM `kladr_rgs` where `short`='р-н' and `number` like '%00' and ((`number`='" . $numberkladr . $tempnumbg[0] . $tempnumbg[1] . $tempnumbg[2] . "00000000') or (`name` like '" . $gorod . "%'));";
                $sql2 = mysql_query($query2) or die(mysql_error());
                while ($row2 = mysql_fetch_assoc($sql2)) {
                    $rnUP = preg_replace('[Ё]', 'Е', ' ' . mb_strtoupper($row2['name'], "UTF-8") . ' ');
                    $adres = preg_replace("' Р-Н" . $rnUP . "'", ' ', $adres);
                    $adres = preg_replace("'" . $rnUP . "Р-Н '", ' ', $adres);
                    if (substr_count($adres, $rnUP) == 1) {
                        $adres = preg_replace("'" . $rnUP . "'", ' ', $adres);
                    };
                };
            };
            $numberkladr = $numberkladr * 1000000 + $tempnumbg;
            $adres = preg_replace("' Г" . $gorodUP . "'", ' ', $adres);
            $adres = preg_replace("'" . $gorodUP . "'", ' ', $adres);
        };


        //поиск района если не нашли город
        $rn = '';
        if ($tempnumbg == 0) {
            $rnUP = '';
            $rnUPtemp = '';
            $tempnumbr = 0;
            $query2 = "SELECT `name`,`number` FROM `kladr_rgs` where `short`='р-н' and `number` like '%00' and `number` like '" . $numberkladr . "%';";
            $sql2 = mysql_query($query2) or die(mysql_error());
            while ($row2 = mysql_fetch_assoc($sql2)) {
                $rnUPtemp = preg_replace('[Ё]', 'Е', ' ' . mb_strtoupper($row2['name'], "UTF-8") . ' ');
                if ((strpos($adres, $rnUPtemp . 'Р-Н ') > -1) or (strpos($adres, ' Р-Н' . $rnUPtemp) > -1)) {
                    $rn = $row2['name'];
                    $rnUP = $rnUPtemp;
                    $tempnumbr = ($row2['number'][$kodsublen] . $row2['number'][$kodsublen + 1] . $row2['number'][$kodsublen + 2]);
                    break;
                };
            };
            if ($tempnumbr == 0) {
                $sql2 = mysql_query($query2) or die(mysql_error());
                while ($row2 = mysql_fetch_assoc($sql2)) {
                    $rnUPtemp = preg_replace('[Ё]', 'Е', ' ' . mb_strtoupper($row2['name'], "UTF-8") . ' ');
                    if ((strpos($adres, $rnUPtemp) > -1)) {
                        $rn = $row2['name'];
                        $tempnumbr = ($row2['number'][$kodsublen] . $row2['number'][$kodsublen + 1] . $row2['number'][$kodsublen + 2]);
                        $rnUp = $rnUPtemp;
                        break;
                    };
                };
            };
            if ($tempnumbr > 0) {
                $numberkladr = $numberkladr * 1000000 + $tempnumbr * 1000;
                $adres = preg_replace("' Р-Н" . $rnUP . "'", ' ', $adres);
                $adres = preg_replace("'" . $rnUP . "Р-Н '", ' ', $adres);
                if (($rnUP != '') and (substr_count($adres, $rnUP) == 1)) {
                    $adres = preg_replace("'" . $rnUP . "'", ' ', $adres);
                };
            };
        };

        //населенный пункт
        $query2 = "SELECT `short`,`name`,`number` FROM `kladr_rgs` where `short` not in ('АО','Аобл','Респ','г','край','обл','Чувашия','р-н') and  `number` like '" . $numberkladr . "%00';";
        $sql2 = mysql_query($query2) or die(mysql_error());
        $np = '';
        $npUP = '';
        $tempnumbs = 0;

        while ($row2 = mysql_fetch_assoc($sql2)) {
            $npUP = preg_replace('[Ё]', 'Е',
                ' ' . mb_strtoupper($row2['short'], "UTF-8") . ' ' . mb_strtoupper($row2['name'], "UTF-8") . ' ');
            if (strpos($adres, $npUP) > -1) {
                $np = $row2['name'];
                $tempnumbs = substr($row2['number'], 0, strlen($row2['number']) - 2);
                break;
            };
        };
        if ($tempnumbs == 0) {
            $sql2 = mysql_query($query2) or die(mysql_error());
            while ($row2 = mysql_fetch_assoc($sql2)) {
                $npUP = preg_replace('[Ё]', 'Е', ' ' . mb_strtoupper($row2['name'], "UTF-8") . ' ');
                if (strpos($adres, $npUP) > -1) {
                    $np = $row2['name'];
                    $tempnumbs = substr($row2['number'], 0, strlen($row2['number']) - 2);
                    break;
                };
            };
        };
        if ($tempnumbs > 0) {

            $numberkladr = $tempnumbs * 1;

            $adres = preg_replace("'" . $npUP . "'", ' ',
                $adres);//	$adres=preg_replace("'".$rnUP."Р-Н '",' ',$adres);	$adres=preg_replace("'".$rnUP."'",' ',$adres);
        } else {
            if ($gorod != '') {
                $numberkladr = $numberkladr * 1000;
            };
        };

        if (($id_user == '78') and (($gorod == '') and ($rn == '') and ($np == ''))) {
            $numberkladr = '78000000000';
            $gorod = 'Санкт-Петербург';
        };

        //поиск улици
        $ul = '';
        if (($gorod != '') or ($rn != '') or ($np != '')) {
            $ul = '';
            $short = '';
            $ulUPtemp = '';
            $uladresUP = '';
            $ulUP = '';
            $tempnumbu = '';
            $ullen = 0;
            $posul = -1;
            if (strpos($adres, ' УЛ ') > -1) {
                $posul = strpos($adres, ' УЛ ') + 6;
            };
            if (strpos($adres, ' ПЕР ') > -1) {
                $posul = strpos($adres, ' ПЕР ') + 7;
            };
            $posd = strpos($adres, ' Д ');
            //поиск от ул до д
            if (($posd > $posul) and ($posul > -1)) {
                $uladresUP = substr($adres, $posul, $posd - $posul);

                $query2 = "SELECT `short`,`name`,`number` FROM `kladr_street` where `number` like '" . $numberkladr . "%00' and upper(`name`) = '" . $uladresUP . "';";
                $sql2 = mysql_query($query2) or die(mysql_error());
                $row2 = mysql_fetch_assoc($sql2);
                if ($row2['number'] + 0 > 0) {
                    $ul = $row2['name'];
                    $tempnumbu = $row2['number'];
                    $short = preg_replace('[Ё]', 'Е', ' ' . mb_strtoupper($row2['short'], "UTF-8") . ' ');
                    $ulUP = preg_replace('[Ё]', 'Е', ' ' . mb_strtoupper($row2['name'], "UTF-8") . ' ');
                };
            };
            //ищем просто название внутри
            if ($tempnumbu == '') {
                $ul = '';
                $short = '';
                $ulUPtemp = '';
                $ulUP = '';
                $tempnumbu = '';
                $query2 = "SELECT `short`,`name`,`number` FROM `kladr_street` where `number` like '" . $numberkladr . "%00';";
                $sql2 = mysql_query($query2) or die(mysql_error());

                while ($row2 = mysql_fetch_assoc($sql2)) {
                    $ulUPtemp = preg_replace('[Ё]', 'Е', ' ' . mb_strtoupper($row2['name'], "UTF-8") . ' ');
                    if ((strpos($adres, $ulUPtemp) > -1) and (strlen($row2['name']) > $ullen)) {
                        $ullen = strlen($row2['name']);
                        $ul = $row2['name'];
                        $tempnumbu = $row2['number'];
                        $short = preg_replace('[Ё]', 'Е', ' ' . mb_strtoupper($row2['short'], "UTF-8") . ' ');
                        $ulUP = $ulUPtemp;
                    };
                };
            };
            //искать 2 улицы (М Горького = Максима Горького = Горького)
            if (($tempnumbu == '') and ($uladresUP != '') and (count(preg_split("/[ ]/", $uladresUP)) > 1)) {
                $newulUPtemp = '%';
                $uladresUP = preg_replace("'-'", ' ', $uladresUP);
                $ulmas = preg_split("/[ ]/", $uladresUP);
                for ($i = 0; $i < count($ulmas); $i++) {
                    if ((preg_replace("([^0-9])", '', $ulmas[$i]) != '') and (strlen($ulmas[$i]) < 5) and ($i < 3)) {
                        $newulUPtemp = $newulUPtemp . (preg_replace("([^0-9])", '', $ulmas[$i])) . '%';
                    } else {
                        if ((strlen($ulmas[$i]) > 4) or ($ulmas[$i] == 'Б') or ($ulmas[$i] == 'М') or ($ulmas[$i] == 'Н') or ($ulmas[$i] == 'В')) {
                            $newulUPtemp = $newulUPtemp . $ulmas[$i] . '%';
                        };
                    };
                };
                $query2 = "SELECT `short`,`name`,`number` FROM `kladr_street` where `number` like '" . $numberkladr . "%00' and ((upper(`name`) like '" . $newulUPtemp . "')or(upper(concat(`name`,`short`)) like '" . $newulUPtemp . "'));";
                $sql2 = mysql_query($query2) or die(mysql_error());
                $row2 = mysql_fetch_assoc($sql2);
                if ($row2['number'] + 0 > 0) {
                    $ul = $row2['name'];
                    $tempnumbu = $row2['number'];
                    $short = preg_replace('[Ё]', 'Е', ' ' . mb_strtoupper($row2['short'], "UTF-8") . ' ');
                    $ulUP = preg_replace('[Ё]', 'Е', ' ' . mb_strtoupper($row2['name'], "UTF-8") . ' ');
                };
            };


            if ($tempnumbu != '') {
                $numberkladr = $tempnumbu;
                $adres = preg_replace("'" . $ulUP . "'", ' ', $adres);
                $adres = preg_replace("'" . $short . "'", ' ', $adres);
            };
        };

        $dom = '';
        $kv = '';
        $kom = '';
        $domnew = '';
        $kvnew = '';
        $komnew = '';
        if (strpos($adres, ' КМ ') > -1) {
            ;
        } else {
            //вычисление номера дома
            //Номер дама в промежутке м/у $dom1 и $dom2

            $dombeg = 0;
            $kvbeg = strlen($adres);
            $kombeg = strlen($adres);
            $dom = '';
            $kv = '';
            $kom = '';
            $domnew = '';
            $kvnew = '';
            $komnew = '';
            //начало дома
            if (strpos($adres, ' Д ') > -1) {
                $dombeg = strpos($adres, ' Д ') + 3;
            };
            //if((strpos($adres,' № ')>-1)and($dombeg==0)){$dombeg=strpos($adres,' № ')+3;};
            if ((strpos($adres, ' Д') > -1) and ($dombeg == 0)) {
                $dombeg = strpos($adres, ' Д') + 2;
            };
            //начало квартиры
            if (strrpos($adres, ' КВ ') > -1) {
                $kvbeg = strrpos($adres, ' КВ ');
            };
            //гараж заносится в кв с пометкой ГАРАЖ
            if ((strrpos($adres, ' ГАРАЖ ') > -1) and ($kvbeg == strlen($adres))) {
                $kvbeg = strrpos($adres, ' ГАРАЖ ');
                $kv = 'ГАРАЖ';
            };
            if ((strrpos($adres, ' БОКС ') > -1) and ($kvbeg == strlen($adres))) {
                $kvbeg = strrpos($adres, ' БОКС ');
                $kv = 'ГАРАЖ';
            };

            if ((strrpos($adres, ' ПОМ ') > -1) and ($kvbeg == strlen($adres))) {
                $kvbeg = strrpos($adres, ' ПОМ ');
            };
            if ((strrpos($adres, ' К ') > -1) and ($kvbeg == strlen($adres))) {
                $kvbeg = strrpos($adres, ' К ');
            };
            //начало комнаты при наличие квартиры
            if ((strrpos($adres, ' КОМ ') > -1) and ($kvbeg != strlen($adres))) {
                $kombeg = strrpos($adres, ' КОМ ');
            };
            if ((strrpos($adres,
                        ' ПОМ ') > -1) and ($kvbeg != strlen($adres)) and ($kombeg == strlen($adres)) and (strrpos($adres,
                        ' КВ ') > -1)) {
                $kombeg = strrpos($adres, ' ПОМ ');
            };
            //погреб заносится в ком с пометкой ПОГРЕб
            if ((strrpos($adres, ' ПОГРЕБ ') > -1) and ($kombeg == strlen($adres))) {
                $kombeg = strrpos($adres, ' ПОГРЕБ ');
                $kom = 'ПОГРЕБ';
                if ($kvbeg == strlen($adres)) {
                    $kvbeg = $kombeg;
                };
            };

            if ($kvbeg < $dombeg) {
                $kvbeg = strlen($adres);
            };
            if (($kombeg < $kvbeg) and ($kombeg < $dombeg)) {
                $kombeg = strlen($adres);
            };

            $domadres = substr($adres, $dombeg, $kvbeg - $dombeg + 1);
            if (strpos($adres, ' Б / Н ') > -1) {
                $domnew = 'б/н';
            } else {
                //if(($id_user=='57'))
                {
                    if (strpos($domadres, ' ЛИТ ') > -1) {
                        $domadres = substr($domadres, 0, strpos($domadres, ' ЛИТ ') + 1);
                    };
                };

                //разделить строку дома на массив с разделителем пробел
                $dommas = preg_split("/[ ]/", $domadres);
                //Пройтись по всем и вычислить дом либо если в элементе массива есть число либо строка меньше 3 символов(литера) можно ограничить for($i=0;$i<3;$i++) но если дом будет записан как д 3 литера А то уже не сработает решил проверять все
                for ($i = 0; $i < count($dommas); $i++) {
                    if ((preg_replace("([^0-9])", "", $dommas[$i]) + 0 != 0) or (strlen($dommas[$i]) < 3)) {
                        $domnew = $domnew . $dommas[$i];
                    };
                };
                //убрать из дома №
                $domnew = preg_replace('/[\s№"-]/', '', $domnew);
                //Если дом начинается с буквы убрать букву (5 штук)
                while ((strlen($domnew) != 0) and (preg_replace("([^0-9])", "", $domnew[0]) + 0 == 0)) {
                    $domnew = substr($domnew, 1, strlen($domnew) - 1);
                };

                //Если дом больше 10 символов то мы определили дом не правильно
                if (strlen($domnew) > 8) {
                    $domnew = '';
                };
            };

            //квартира это цифры после $kvbeg
            if ($kvbeg < strlen($adres)) {
                $kvnew = substr($adres, $kvbeg, $kombeg - $kvbeg + 1);
                //if(($id_user=='57'))
                {
                    if (strpos($kvnew, ' ЛИТ ') > -1) {
                        $kvnew = substr($kvnew, 0, strpos($kvnew, ' ЛИТ ') + 1);
                    };
                };
                $kvnew = (preg_replace("([^0-9])", "", $kvnew));;
                if (preg_replace("([^0-9])", "", $kvnew[0]) + 0 == 0) {
                    $kvnew = substr($kvnew, 1, strlen($kvnew) - 1);
                };
                $kv = $kv . $kvnew;
            };

            //комната это цифры после $kombeg
            if ($kombeg < strlen($adres)) {

                $komnew = substr($adres, $kombeg, strlen($adres) - $kombeg + 1);
                //print($rowadres[adres].'</br>Остатки "'.$adres.'" str '.$komnew.'</br> b '.$kombeg.' e '.(strlen($adres)-$kombeg+1).'</br></br>');
                //if(($id_user=='57'))
                {
                    if (strpos($komnew, ' ЛИТ ') > -1) {
                        $komnew = substr($komnew, 0, strpos($komnew, ' ЛИТ ') + 1);
                    };
                };
                $komnew = (preg_replace("([^0-9])", "", $komnew));;
                if (preg_replace("([^0-9])", "", $komnew[0]) + 0 == 0) {
                    $komnew = substr($komnew, 1, strlen($komnew) - 1);
                };
                $kom = $kom . $komnew;
            };

            if ((strlen($adres) != 0)) {
                $adres = preg_replace("' " . $domnew . " '", ' ', $adres);
            };
            if ((strlen($adres) != 0)) {
                $adres = preg_replace("' " . $kvnew . " '", ' ', $adres);
            };
            if ((strlen($adres) != 0)) {
                $adres = preg_replace("' " . $komnew . " '", ' ', $adres);
            };
            if ((strlen($adres) != 0)) {
                $adres = preg_replace("' Б / Н '", ' ', $adres);
            };
            if ((strlen($adres) != 0)) {
                $adres = preg_replace("' № '", ' ', $adres);
            };
            if ((strlen($adres) != 0)) {
                $adres = preg_replace("' Д '", ' ', $adres);
            };
            if ((strlen($adres) != 0)) {
                $adres = preg_replace("' КВ '", ' ', $adres);
            };
            if ((strlen($adres) != 0)) {
                $adres = preg_replace("' ПОМ '", ' ', $adres);
            };
            if ((strlen($adres) != 0)) {
                $adres = preg_replace("' КОМ '", ' ', $adres);
            };
            if ((strlen($adres) != 0)) {
                $adres = preg_replace("' / '", '/', $adres);
            };

            while ((strpos($adres, '  ') > -1) and (strlen($adres) != 0)) {
                $adres = preg_replace("'  '", ' ', $adres);
            };
        };

        $newadres = $gorod . '|' . $rn . '|' . $np . '|' . $ul . '|' . mb_strtoupper($domnew,
                "UTF-8") . '|' . $kv . '|' . $kom;

//		if($kolins<200){if(strlen(''.$numberkladr)>15){print('Записи '.$rowadres['id'].' с адресом '.$rowadres[adres].' соответсвует адрес '.$adres.'</br>');}else{print('Записи '.$rowadres['id'].' с адресом '.$rowadres[adres].' выявлен '.$adres.' адрес не поставлен</br>');};};
        if ($kolins == 1000) {
            print(' Далее подробной информации выводится не будет</br>');
        };


        if ($kolins % 1000 == 0) {
            print('Обработано ' . $kolins . ' строк ' . date("m.d.y H:i:s") . '</br>');
        };
        //если нашел улицу занести в базу данные
        if ((strlen('' . $numberkladr) > 15) or ((strlen('' . $numberkladr) > 2) and (($rowadres['type'] == 'Сооружение') or ($rowadres['type'] == '002002004000'))) or ((strlen('' . $numberkladr) > 2) and (strlen($adres) < 6))) {

            if ($kolins < 1000) {
                print('Записи ' . $rowadres['id'] . ' с адресом: <b>' . $rowadres['adres'] . ' </b> </br> соответсвует адрес:<b>' . $newadres . ' </b> кладр: <b>' . str_pad($numberkladr,
                        $kodsublen + 11, "0") . '</b></br></br>');
            };

            $queryinsert = "update `gkn_zu_kladr_new` set `kod_kladr`='" . $numberkladr . "', `new_dom`='" . mb_strtoupper($domnew,
                    "UTF-8") . "', `new_kv`='" . $kv . "', `new_kom`='" . $kom . "', new_adres='" . $newadres . "' where `id`='" . $rowadres['id'] . "'; ";

            $sqlqueryinsert = mysql_query($queryinsert) or print(mysql_error() . "</br></br>" . $queryinsert . "</br>");
        } else {
            if ($kolins < 1000) {
                print('Записи ' . $rowadres['id'] . ' с адресом ' . $rowadres['adres'] . '</br> выявлен ' . $newadres . ' адрес не поставлен' . $numberkladr . '</br></br>');
            };
        };
        //print('</br>'.$rowadres[adres].'</br>Остатки "'.$adres.'" новый адрес:'.$newadres.'</br>'.$numberkladr.' '.$rowadres[type].'</br>');//
    };
    mysql_close($db);
    print('Адрес по кладр проставлены!</br>' . '<a href="gkn.php"> Назад </a>');
    gc_collect_cycles();
    ?>

</div>
</body>
</html>	