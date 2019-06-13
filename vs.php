<?php session_start();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>

<body>
<div id="menu">
    <?php include "menu.php"; ?>
</div>
<div id="basis">
    <h3><font color=red>Внимание перед скачиванием сопоставления необходимо выполнить проставления КЛАДРа, в пунктах
            меню ГКН и ЕГРП.</font></br></h3>
    <b>Для формирования сопоставления достаточно нажать по ссылке.</br>

        После нажатия начнет формироваться файл и затем предложит скачать его по новой выведеной ссылке. </br>
        Если формировали файл ранее то его можно скачать по ссылке http://kadastr56.ru:8400/new/files/vs[номер выгрузки,
        1а обозначается как 12]-[код региона].txt.</b></br></br>


    Сформированные файлы необходимо передать в отдел верификации и анализа данных (в тот отдел, который занимается
    анализом данных).</br> Файл рекомендую перевести в удобно читаемый вид:</br>
    Перевести в кодировку win1251 (Открыть с помощью notepad++ и кодировки преобразовать в win1251). </br>Затем открыть
    с помощью эксель и выбрать данные, текст по столбцам, выбрать с разделителем | и сохранить.

    </br>
    Внимание для сопоставления 6 необходимо, чтобы поле тип окс принимал значения
    '002002001000','002002002000','002002004000','002002005000', то есть не был отредактирован или переделан выгружаемый
    скрипт.
    </br></br>

    <table width="100%">
        <th>
            Сопоставление списков ГКН и ЕГРП
        </th>
        <?php

        print("<tr><td>1) <a href='vs1.php'> Неверногармонизированные (Кад номер совпадает, адрес и площадь различается)</a></td></tr>");

        print("<tr><td>1a) <a href='vs12.php'> Подозрительные как неверногармонизированные (Кад номер совпадает, адрес или площадь различается, только одна характеристика не совпадает)</a></td></tr>");

        //print("<tr><td>2) <a href='vs2.php'> Возможные дубликаты (Адрес и площадь совпадают, кад номера разные)</a></td></tr>");

        print("<tr><td>2а) <a href='vs21.php'> Возможные дубликаты (Дубликаты в ГКН)</a></td></tr>");

        print("<tr><td>2б) <a href='vs22.php'> Возможные дубликаты (Дубликаты в ЕГРП)</a></td></tr>");


        print("<tr><td>3) <a href='vs3.php'> сопоставились адреса - кн - площадь - литер (верно гармонизированные данные)</a></td></tr>");

        print("<tr><td>3а) <a href='vs31.php'> Все записи ЕГРП сопоставленые с характеристиками ГКН по КН (поручение ФГБУ 'ФКП Росреестра' 11-3872-КЛ от 26.11.2014)</a></td></tr>");

        //print("<tr><td>3а) <a href='vs32.php'> сопоставились адреса - кн (без учета литер)</a></td></tr>");

        print("<tr><td>4) <a href='vs4.php'> объект есть в ЕГРП, но не нашел пару в списке ГКН (По КН)</a></td></tr>");

        print("<tr><td>5) <a href='vs5.php'> объект есть в ГКН, но отсутсвует в ЕГРП (По КН)</a></td></tr>");

        print("<tr><td>6) <a href='vs6.php'> Связанные ОКС и ЗУ ГКН по адресу</a></td></tr>");


        /*

        <form method="post" enctype="multipart/form-data" action="vs21get.php">
        2) дубликаты ГКН
        начиная с <INPUT TYPE="TEXT" NAME="egrpbeg" VALUE ="0"> до <INPUT TYPE="TEXT" NAME="egrpend" VALUE ="0">
        <INPUT TYPE="SUBMIT" VALUE ="Сформировать" ONCLICK="Отправлено!">
        </form>
        </br>
        <form method="post" enctype="multipart/form-data" action="vs21get.php">
        2) дубликаты ЕГРП
        начиная с <INPUT TYPE="TEXT" NAME="egrpbeg" VALUE ="0"> до <INPUT TYPE="TEXT" NAME="egrpend" VALUE ="0">
        <INPUT TYPE="SUBMIT" VALUE ="Сформировать" ONCLICK="Отправлено!">
        </form>
        </br>

        */

        ?>
    </table>

    </br></br></br>
    <b>Для тех у кого очень большие объемы (в ГКН > 1 000 000) рекомендую выгружать по ограниченному количеству до 250
        000.</br>
        Далее вводите № нач и конечного элемента и нажимаете сформировать. </br>
        Работает аналогично "верхним" выгрузкам, но обработка немного быстрее за счет того что выгружается по
        частям.</b></br></br>

    <form method="post" enctype="multipart/form-data" action="vs1get.php">
        1) Неверногармонизированные по штучно:
        начиная с <INPUT TYPE="TEXT" NAME="egrpbeg" VALUE="0"> до <INPUT TYPE="TEXT" NAME="egrpend" VALUE="0">
        <INPUT TYPE="SUBMIT" VALUE="Сформировать" ONCLICK="Отправлено!">
    </form>
    </br>
    <form method="post" enctype="multipart/form-data" action="vs12get.php">
        1а) Подозрительные как неверногармонизированные по штучно:
        начиная с <INPUT TYPE="TEXT" NAME="egrpbeg" VALUE="0"> до <INPUT TYPE="TEXT" NAME="egrpend" VALUE="0">
        <INPUT TYPE="SUBMIT" VALUE="Сформировать" ONCLICK="Отправлено!">
    </form>
    </br>
    <form method="post" enctype="multipart/form-data" action="vs31get.php">
        3a) Все записи ЕГРП сопоставленые с характеристиками ГКН по КН
        начиная с <INPUT TYPE="TEXT" NAME="egrpbeg" VALUE="0"> до <INPUT TYPE="TEXT" NAME="egrpend" VALUE="0">
        <INPUT TYPE="SUBMIT" VALUE="Сформировать" ONCLICK="Отправлено!">
    </form>
    </br>

</div>
</body>
</html>
