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
        
        $DateRevocation = $_REQUEST['DateRevocation'];

        //загрузка файла по пути из БД
        $response = uploadFile($pathsrc);
        if($response['status']){ 
            $sql = "UPDATE kandidat SET DateRevocation='$DateRevocation' WHERE id = $id";  
            $update = mysqli_query($connect,$sql);
            if($update){
            $response['check'] = 'Запись в бд успешно добавлена';
            $response['msg'] = 'Документы успешно отозваны';
            file_put_contents('/var/www/site/custompage/logs/DateRevocationlog.txt', 'Время и дата изменения строки: '.date('Y-m-d_H-i-s').' Путь: '.$response['path'].'Дата отзыва документов: '.$DateRevocation.';', $flags = FILE_APPEND);
            }else{
                $response['check'] = 'Ошибка добавления записи в бд';
                $response['msg'] = 'Ошибка отзыва документов';
            }
        }
                  
    }

echo json_encode($response);

?>
