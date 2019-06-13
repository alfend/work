<?php ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>

<div id="basis">

    <?php

    $db = mysql_connect("localhost", "root", "");
    set_time_limit(10000);
    $id_users = $_POST['id_users'];
    //$id_users=56;
    //Создаем БД пользователей и добавляем введенного пользователя

    //$querycreate="DROP DATABASE IF EXISTS address".$id_users." ;"; $sqlquerycreate= mysql_query($querycreate);

    /*
    $querycreate="DROP DATABASE users;";
    $sqlquerycreate= mysql_query($querycreate);
    */


    //$querycreate="CREATE DATABASE IF NOT EXISTS users;"; $sqlquerycreate= mysql_query($querycreate) or print(mysql_error());

    //$query="CREATE DATABASE address".$id_users.";";$sqlqueryinsert = mysql_query($query) or die(mysql_error());

    mysql_select_db("address" . $id_users, $db);
    //Создаем структуру ГКН если нужно еще одно поле добавьте его после строик `new_kv`: `dop_pole` varchar(100) COLLATE utf8_bin DEFAULT NULL,
    $queryadres = "
CREATE TABLE IF NOT EXISTS `address" . $id_users . "`.`gkn_zu_kladr_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cad_num` varchar(50) COLLATE utf8_bin NOT NULL,
  `adres` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `liter` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `new_adres` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `kod_kladr` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `new_dom` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `new_kv` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `new_kom` varchar( 30 ) COLLATE utf8_bin DEFAULT NULL ,
  `name` varchar( 100 ) COLLATE utf8_bin DEFAULT NULL ,
  `area` decimal( 10, 1 ) DEFAULT NULL ,
  `notkladr` varchar( 255 ) COLLATE utf8_bin DEFAULT NULL ,
  `dop1` varchar( 100 ) COLLATE utf8_bin DEFAULT NULL ,
  `dop2` varchar( 100 ) COLLATE utf8_bin DEFAULT NULL ,
  PRIMARY KEY (`id`),
  KEY `cad_num` (`cad_num`),
  KEY `area` (`area`),
  KEY `new_adres` (`new_adres`),
  KEY `kod_kladr` (`kod_kladr`),
  KEY `new_dom` (`new_dom`),
  KEY `new_kv` (`new_kv`),
  KEY `new_kom` (`new_kom`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
";
    $sqladres = mysql_query($queryadres) or die(mysql_error());

    print("Структура БД обновлена.</br>");
    print('БД обновлена выполнена <a href="index.php">На главную</a>.</br>');

    mysql_close($db);

    ?>
</div>
</body>
</html>	