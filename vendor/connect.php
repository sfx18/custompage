<?php

    $connect = mysqli_connect('localhost', 'vanya', '87654321Qaz', 'vibori');

    if (!$connect) {
        die('Error connect to DataBase');
    }