<?php

    $connect = mysqli_connect('localhost', 'vanya', '87654321Qaz', 'authphp');

    if (!$connect) {
        die('Error connect to DataBase');
    }