<?php
session_start();
include "connect.php"; 
include "functions.php";
$response = array( 
    'status' => 0, 
    'msg' => 'Возникли проблемы, попробуйте еще раз.',
    'check' => 'Default'
); 
if(!empty($_REQUEST['first_name']) && !empty($_REQUEST['last_name']) && !empty( $_REQUEST['father_name']) && !empty($_REQUEST['birthday']) && !empty($_REQUEST['DateVidv'])){ 
    $first_name = trim($_REQUEST['first_name']);
    $last_name = trim($_REQUEST['last_name']);
    $father_name = trim($_REQUEST['father_name']);
    $birthday = $_REQUEST['birthday'];
    $DateVidv = $_REQUEST['DateVidv'];
    $DateReg = $_REQUEST['DateReg'];
    $DateRegRefusal = $_REQUEST['DateRegRefusal'];
    $DateRevocation = $_REQUEST['DateRevocation'];
    $NumOkr = trim($_REQUEST['NumOkr']);
    $login = $_SESSION['user']['login'];
    $folder_name = "$last_name $first_name $father_name";
    $path = "/var/kandidat/$login/$folder_name";
    $permit = 0777;

    if(!empty($_REQUEST['NumOkr'])){
        $path = "/var/kandidat/$login/$NumOkr/$folder_name";
        if(!file_exists("/var/kandidat/$login/$NumOkr")){
            mkdir("/var/kandidat/$login/$NumOkr");
            chmod("/var/kandidat/$login/$NumOkr", $permit);
        }
        if(!file_exists("/var/kandidat/$login/$NumOkr/$folder_name")){
            mkdir("/var/kandidat/$login/$NumOkr/$folder_name");
            chmod("/var/kandidat/$login/$NumOkr/$folder_name", $permit);
        }
    }else{
            $NumOkr = '0';
            $path = "/var/kandidat/$login/$folder_name";
            if(!file_exists("/var/kandidat/$login/$folder_name")){
                mkdir("/var/kandidat/$login/$folder_name");
                chmod("/var/kandidat/$login/$folder_name", $permit);
            }
        }

    
    $response = uploadFile($path);
    if($response['status']){ 
        $first_name = mb_strtoupper($first_name);
        $last_name = mb_strtoupper($last_name);
        $father_name = mb_strtoupper($father_name);
        $sql = "INSERT INTO `kandidat` (`first_name`,`last_name`,`father_name`,`birthday`,`DateVidv`, `DateReg`, `DateRegRefusal`, `DateRevocation`, `OkrBC`,`NumOkr`,`path`) VALUES ('$first_name','$last_name','$father_name','$birthday', '$DateVidv', '$DateReg', '$DateRegRefusal', '$DateRevocation', '$login','$NumOkr', '$path')"; 
        $insert = mysqli_query($connect,$sql);
        if($insert){
            $response['check'] = 'Запись успешно добавлена в бд';
            $response['msg'] = 'Кандидат успешно добавлен';
            file_put_contents('/var/www/site/custompage/logs/addDatalog.txt', $path.'___Дата/время добавления: '.date('Y-m-d_H-i-s', strtotime("+3 hours")).'___Дата выдвижения: '.$DateVidv.';', $flags = FILE_APPEND);
            file_put_contents('/var/www/site/custompage/logs/addDataFilelog.txt', $response['path'].';', $flags = FILE_APPEND);
        }else{
            $response['check'] = 'Ошибка добавления записи в бд';
            file_put_contents('/var/www/site/custompage/logs/addDataErrorslog.txt', date('Y-m-d_H-i-s', strtotime("+3 hours")).$login.'/'.$response['msg'].';', $flags = FILE_APPEND);
        }
    }
}
echo json_encode($response);

?>