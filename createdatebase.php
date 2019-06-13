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

    $querycreate = "DROP DATABASE IF EXISTS address" . $id_users . " ;";
    $sqlquerycreate = mysql_query($querycreate);

    /*
    $querycreate="DROP DATABASE users;";
    $sqlquerycreate= mysql_query($querycreate);
    */


    $querycreate = "CREATE DATABASE IF NOT EXISTS users;";
    $sqlquerycreate = mysql_query($querycreate) or print(mysql_error());
    mysql_select_db("users", $db);
    $queryusers = "
CREATE TABLE IF NOT EXISTS `users` (
  `login` varchar(100) COLLATE utf8_bin NOT NULL,
  `passwd` varchar(100) COLLATE utf8_bin NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
";
    $sqlusers = mysql_query($queryusers) or print(mysql_error());

    $query2 = "SELECT `login` FROM `users` where `login`='" . $id_users . "';";
    $sql2 = mysql_query($query2) or die(mysql_error());
    $row2 = mysql_fetch_assoc($sql2);
    if ($row2['login'] == '') {
        $queryusers = "INSERT INTO `users` (`login`, `passwd`, `name`) VALUES
('" . $id_users . "', '" . $id_users . "', '" . $id_users . " Субъект')
";
        $sqlusers = mysql_query($queryusers) or print(mysql_error());
    };
    print("Пользователь создан.</br>");

    $query = "CREATE DATABASE address" . $id_users . ";";
    $sqlqueryinsert = mysql_query($query) or die(mysql_error());

    mysql_select_db("address" . $id_users, $db);
    //Создаем структуру ЕГРП если нужно еще одно поле добавьте его после строик `new_kv`: `dop_pole` varchar(100) COLLATE utf8_bin DEFAULT NULL,
    $queryadres = "
CREATE TABLE IF NOT EXISTS `address" . $id_users . "`.`egrp_kladr_new` (
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
  KEY `new_adres` (`new_adres`),
  KEY `kod_kladr` (`kod_kladr`),
  KEY `new_dom` (`new_dom`),
  KEY `new_kv` (`new_kv`),
  KEY `new_kom` (`new_kom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
";
    $sqladres = mysql_query($queryadres) or die(mysql_error());
    //Создаем структуру ГКН если нужно еще одно поле добавьте его после строик `new_kv`: `dop_pole` varchar(100) COLLATE utf8_bin DEFAULT NULL,
    $queryadres = "
CREATE TABLE IF NOT EXISTS `address" . $id_users . "`.`gkn_kladr_new` (
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
    //Создаем структуру улиц кладра
    $queryadres = "
CREATE TABLE IF NOT EXISTS `address" . $id_users . "`.`kladr_street` (
`name` varchar( 50 ) COLLATE utf8_bin NOT NULL ,
`short` varchar( 10 ) COLLATE utf8_bin DEFAULT NULL ,
`number` bigint( 13 ) NOT NULL ,
KEY `number` ( `number` ) ,
KEY `name` ( `name` ) ,
KEY `short` ( `short` )
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;
";
    $sqladres = mysql_query($queryadres) or die(mysql_error());
    //Создаем структуру городов, райнов и нас пунктов кладра(в кладре их подчинение происходит только с помощью кода но не на уровне бд)
    $queryadres = "
CREATE TABLE IF NOT EXISTS `address" . $id_users . "`.`kladr_rgs` (
`name` varchar( 50 ) COLLATE utf8_bin NOT NULL ,
`short` varchar( 10 ) COLLATE utf8_bin DEFAULT NULL ,
`number` bigint( 13 ) NOT NULL ,
KEY `number` ( `number` ) ,
KEY `name` ( `name` ) ,
KEY `short` ( `short` )
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;
";
    $sqladres = mysql_query($queryadres) or die(mysql_error());

    print("Структура БД создана.</br> Начинается загрузка кладра вашего региона.</br>");

    //загрузка районов, городов и населенных пунктов кладра
    $handle = @fopen("rgs.txt", "r");

    if ($handle) {
        $i = 1;
        $id = 1;
        while ((($buffer = fgets($handle, 4096)) !== false)) {
            $str = preg_split("/[|]/", $buffer);
            $id = (int)($str[2][0] . $str[2][1]);
            $query = "INSERT INTO `kladr_rgs` (`name`, `short`, `number`) VALUES ";
            {
                $query = $query . "('" . $str[0] . "','" . $str[1] . "','" . $str[2] . "');";
            };

            mysql_select_db("address" . $id, $db);
            if ($id == $id_users) {
                $sql = mysql_query($query) or die(mysql_error());
            };
        };

        fclose($handle);
    };
    print("Загрузка районов, городов и населенных пунктов кладра региона " . $id_users . " выполнена.</br>");


    //загрузка улиц кладра
    $handle = @fopen("street.txt", "r");

    if ($handle) {
        $i = 1;
        $id = 1;
        $query = "INSERT INTO `kladr_street` (`name`, `short`, `number`) VALUES ";
        while ((($buffer = fgets($handle, 4096)) !== false)) {
            $str = preg_split("/[|]/", $buffer);
            $id = (int)($str[2][0] . $str[2][1]);
            $query = "INSERT INTO `kladr_street` (`name`, `short`, `number`) VALUES ";
            {
                $query = $query . "('" . $str[0] . "','" . $str[1] . "','" . $str[2] . "');";
            };

            mysql_select_db("address" . $id, $db);
            if ($id == $id_users) {
                $sql = mysql_query($query) or die(mysql_error());
            };
        };

        fclose($handle);
    };
    print("Улицы кладра региона " . $id_users . " загружены.</br>");
    print('Инициализация выполнена <a href="index.php">На главную</a>.</br>');

    mysql_close($db);

    ?>
</div>
</body>
</html>	