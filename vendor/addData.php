<?php
session_start();
include "connect.php"; 
include "functions.php";
$response = array( 
    'status' => 0, 
    'msg' => 'Some problems occurred, please try again.'
); 
if(!empty($_REQUEST['first_name']) && !empty($_REQUEST['last_name']) && !empty( $_REQUEST['father_name']) && !empty($_REQUEST['birthday'])){ 
    $first_name = $_REQUEST['first_name']; 
    $last_name = $_REQUEST['last_name']; 
    $father_name = $_REQUEST['father_name']; 
    $birthday = $_REQUEST['birthday'];
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
 if($response['status'] == true){ 
    $sql = "INSERT INTO `dep` (`first_name`,`last_name`,`father_name`,`birthday`,`OkrBC`,`NumOkr`,`path`) VALUES ('$first_name','$last_name','$father_name','$birthday', '$login','$NumOkr', '$path')"; 
    $insert = $connect->query($sql); 
    }else{
        $response['status'] = 0; 
        $response['msg'] = 'Ошибка загрузки файла'; 
    } 
}
echo json_encode($response);
file_put_contents('/var/www/site/custompage/logs/addDatalog.txt', $path.date("Y-m-d_H-i").';', $flags = FILE_APPEND);
?>