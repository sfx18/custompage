<?php
include "connect.php"; 
include "functions.php";
$response = array( 
    'status' => 0, 
    'msg' => 'Some problems occurred, please try again.'
);
if(!empty($_REQUEST['id'])){ 
    $id = intval($_REQUEST['id']); 
    $query = "SELECT * FROM dep WHERE id = $id";
    $select = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($select);
    $pathsrc = $row['path'];
    $DateReg = $_REQUEST['DateReg'];
    
    //загрузка файла по пути из БД
    $response = uploadFile($pathsrc);

 if($response['status'] == true){ 
    $sql = "UPDATE dep SET DateReg='$DateReg' WHERE id = $id";  
    $update = $connect->query($sql);
    }else{
        $response['status'] = 0; 
        $response['msg'] = 'Ошибка загрузки файла'; 
    } 

}

echo json_encode($response);
file_put_contents('/var/www/site/custompage/logs/uploadImglog.txt', $path.';', $flags = FILE_APPEND);


?>
