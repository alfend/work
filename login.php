<?php session_start();

if (strlen($_POST['login']) <> '0' and strlen($_POST['password']) <> '0') {

    $login_user = $_POST['login'];
    $password_user = $_POST['password'];

    if ($login_user != '' and $password_user != '') {


        $db = mysql_connect("localhost", "root", "");
        mysql_select_db("users", $db);

        //$id_user = mysql_real_escape_string($_SESSION['id_user']);

        $query = "SELECT passwd FROM users WHERE UPPER(login)=UPPER('" . $login_user . "')";

        $sql = mysql_query($query) or die(mysql_error());

        $row = mysql_fetch_assoc($sql);

        //print($password_user.' '.$row['passwd']);

        if ($row['passwd'] == $password_user) {
            $_SESSION['id_user'] = $login_user;
            header("Location: home.php");
            exit();
        } else {
            $_SESSION['id_user'] = 'null';
            header("Location: index.php");
            exit();
        };


    };
};


?>
