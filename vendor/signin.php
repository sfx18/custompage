<?php

    session_start();
    require_once 'connect.php';

    $login = $_POST['login'];
    $password = $_POST['password'];
    $permit = 0777;

    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
    if (mysqli_num_rows($check_user) > 0) {
        if(file_exists("/var/kandidat/$login")){
        }
        else{
        mkdir("/var/kandidat/$login");
        chmod("/var/kandidat/$login", $permit);
        }

        $user = mysqli_fetch_assoc($check_user);

        $_SESSION['user'] = [
            "id" => $user['id'],
            "login" => $user['login'],
            "password" => $user['password'],
            "groupid" => $user['groupid'],

        ];
        if($user['groupid'] == 1){
        header('Location: ../oik.php');
        }elseif($user['groupid'] == 2){
            header('Location: ../tik.php');
        }elseif($user['groupid'] == 3){
            header('Location: ../profile.php');
        }elseif($user['groupid'] == 4){
            header('Location: ../admin.php');
        }

    } else {
        $_SESSION['message'] = 'Не верный логин или пароль';
        header('Location: ../index.php');
    }
    ?>


