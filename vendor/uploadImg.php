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
    
    //загрузка файла по пути из БД
    $response = uploadFile($pathsrc);
     
}

echo json_encode($response);
file_put_contents('/var/www/site/custompage/logs/uploadImglog.txt', $path.';', $flags = FILE_APPEND);


?>
