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
        
        $DateReg = $_REQUEST['DateReg'];

        //загрузка файла по пути из БД
        $response = uploadFile($pathsrc);
        if($response['status']){ 
            $sql = "UPDATE kandidat SET DateReg='$DateReg' WHERE id = $id";  
            $update = $connect->query($sql);
            $response['msg'] = 'Кандидат успешно зарегистрирован';
            file_put_contents('/var/www/site/custompage/logs/DateReglog.txt', $response['path'].'___DateReg:'.$DateReg.';', $flags = FILE_APPEND);
        }
                  
    }

echo json_encode($response);

?>
