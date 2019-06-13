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
    $id_user = $_SESSION['id_user'];

    $db = mysql_connect("localhost", "root", "");
    mysql_select_db("address" . $id_user, $db) or die(mysql_error());
    set_time_limit(20000);
    //очистить всю таблицу
    $queryadres = 'TRUNCATE TABLE `gkn_kladr_new`';
    $sqladres = mysql_query($queryadres) or die(mysql_error());
    print('Очищенно!</br>' . '<a href="gkn.php"> Назад </a>');
    mysql_close($db);
    gc_collect_cycles();
    ?>
</div>
</body>
</html>	