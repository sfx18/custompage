<?php
include "connect.php"; 
include "functions.php";
$response = array( 
    'status' => 0, 
    'msg' => 'Возникли проблемы, попробуйте еще раз.'
);

    if(!empty($_REQUEST['id'])){ 

        $id = intval($_REQUEST['id']); 
        // ВЫБОРКА ПУТЕЙ ИЗ БД
        $query = "SELECT * FROM kandidat WHERE id = $id";
        $select = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($select);
        $pathsrc = $row['path'];
        
        
        //ЗАГРУЗКА ФАЙЛА ПО ПУТИ ИЗ БД
        $response = uploadFile($pathsrc);
        if($response['status']){ 
            file_put_contents('/var/www/site/custompage/logs/uploadImglog.txt', $response['path'].';', $flags = FILE_APPEND);
        }
            
    }

echo json_encode($response);

?>
