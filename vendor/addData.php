<?php
session_start();
include "connect.php"; 
include "functions.php";
$response = array( 
    'status' => 0, 
    'msg' => 'Возникли проблемы, попробуйте еще раз.'
); 
if(!empty($_REQUEST['first_name']) && !empty($_REQUEST['last_name']) && !empty( $_REQUEST['father_name']) && !empty($_REQUEST['birthday']) && !empty($_REQUEST['DateVidv'])){ 
    $first_name = $_REQUEST['first_name']; 
    $last_name = $_REQUEST['last_name']; 
    $father_name = $_REQUEST['father_name']; 
    $birthday = $_REQUEST['birthday'];
    $DateVidv = $_REQUEST['DateVidv'];
    $DateReg = $_REQUEST['DateReg'];
    $NumOkr = $_REQUEST['NumOkr'];
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
            $path = "/var/kandidat/$login/$folder_name";
            if(!file_exists("/var/kandidat/$login/$folder_name")){
                mkdir("/var/kandidat/$login/$folder_name");
                chmod("/var/kandidat/$login/$folder_name", $permit);
            }
        }

    
    $response = uploadFile($path);
    if($response['status']){ 
        $sql = "INSERT INTO `kandidat` (`first_name`,`last_name`,`father_name`,`birthday`,`DateVidv`, `DateReg`, `OkrBC`,`NumOkr`,`path`) VALUES ('$first_name','$last_name','$father_name','$birthday', '$DateVidv', '$DateReg', '$login','$NumOkr', '$path')"; 
        $insert = $connect->query($sql);
        $response['msg'] = 'Кандидат успешно добавлен';
        file_put_contents('/var/www/site/custompage/logs/addDatalog.txt', $path.'___DataAdd:'.date('Y-m-d_H-i', strtotime("+3 hours")).'___DateVidv:'.$DateVidv.';', $flags = FILE_APPEND);
        file_put_contents('/var/www/site/custompage/logs/addDataFilelog.txt', $response['path'].';', $flags = FILE_APPEND); 
    }

}
echo json_encode($response);

?>