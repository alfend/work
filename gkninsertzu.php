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
    set_time_limit(200000);

    $id_user = $_SESSION['id_user'];
    if (isset($_FILES['sendfile']) && $_FILES['sendfile']['error'] != 4) {
        if ($_FILES["sendfile"]["size"] > 1024 * 1024 * 1024) {
            echo("Размер файла превышает 1 гигабайт");
            exit;
        }

        // Проверяем загружен ли файл
        if (is_uploaded_file($_FILES["sendfile"]["tmp_name"])) {
            print('Загрузка ' . $_FILES["sendfile"]["name"] . '</br>');
            // Если файл загружен успешно, перемещаем его
            // из временной директории в конечную
            $path = '/files';  //'.$id_user.'/'
            if (!is_dir($path)) {
                mkdir($path);
            }
            move_uploaded_file($_FILES["sendfile"]["tmp_name"], $path . "/" . $_FILES["sendfile"]["name"] . $id_user);
        } else {
            echo("Ошибка загрузки файла" . $_FILES['sendfile']['error']);
        };

        print('Файл передан, начинается обработка ' . $_FILES["sendfile"]["name"] . '</br>');


        $handle = @fopen($path . "/" . $_FILES["sendfile"]["name"] . $id_user, "r");
        if ($handle) {
            $i = 1;
            $query = "INSERT INTO `gkn_zu_kladr_new` (`cad_num`,`adres`,`liter`,`type`,`area`,`name`) VALUES ";
            while ((($buffer = fgets($handle, 4096)) !== false)) {
                $buffer = str_replace("\\", "", $buffer);
                $buffer = str_replace("\r", "", $buffer);
                $buffer = str_replace("\n", "", $buffer);
                $buffer = str_replace("'", "", $buffer);


                $str = preg_split("/[|]/", $buffer);
                //$str[1]= preg_replace("/[']/","",$str[1]);
                //$str[2]= preg_replace("/[']/","",$str[2]);
                //$str[3]= preg_replace("/[']/","",$str[3]);

                //if($str[0]!=''){
                $query = $query . "('" . $str[0] . "','" . $str[1] . "','" . $str[2] . "','" . $str[3] . "','" . str_replace(",",
                        ".", $str[4]) . "','" . $str[5] . "'),";
                //}else{print('Строка '.$i.' не добавлена, так как кад номер пустой.</br>');};

                if ($i % 1000 == 0) {
                    $query[strlen($query) - 1] = ';';
                    $sql = mysql_query($query) or print(mysql_error() . " " . $query . "<br> Не добавлен:" . $query);
                    print('Добавлено ' . $i . ' тыс. строк</br>');
                    $query = "INSERT INTO `gkn_zu_kladr_new` (`cad_num`,`adres`,`liter`,`type`,`area`,`name`) VALUES ";
                };
                $i++;
            };
        };
        $query[strlen($query) - 1] = ';';
        $sql = mysql_query($query) or print(mysql_error() . "<br> Не добавлен:" . $query);
        print('Загруженно!</br>' . '<a href="gkn.php"> Назад </a>');

        fclose($handle);
        mysql_close($db);
    };
    gc_collect_cycles();
    ?>
</div>
</body>
</html>	