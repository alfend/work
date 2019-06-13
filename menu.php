<?php //session_start();
if ($_SESSION['id_user'] == '') {
    header("Location: index.php");
    exit();
};
?>
    <table width="100%">
        <th>
            Меню
        </th>
        <?php

        print("<tr><td><a href='home.php'>Инструкция</a></td></tr>");

        print("<tr><td><a href='gkn.php'>ГКН</a></td></tr>");

        print("<tr><td><a href='egrp.php'>ЕГРП</a></td></tr>");

        print("<tr><td><a href='vs.php'>Сопоставление</a></td></tr>");


        print("<tr><td><a href='exit.php'>Выход</a></td></tr>");


        ?>
    </table>
<?php
print("Добро пожаловать," . $_SESSION['id_user']);
?>