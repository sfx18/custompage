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
        
        $DateRegRefusal = $_REQUEST['DateRegRefusal'];

        //загрузка файла по пути из БД
        $response = uploadFile($pathsrc);
        if($response['status']){ 
            $sql = "UPDATE kandidat SET DateRegRefusal='$DateRegRefusal' WHERE id = $id";  
            $update = mysqli_query($connect,$sql);
            if($update){
            $response['check'] = 'Запись в бд успешно добавлена';
            $response['msg'] = 'В регистрации отказано';
            file_put_contents('/var/www/site/custompage/logs/DateRegRefusallog.txt', 'Время и дата изменения строки: '.date('Y-m-d_H-i-s').' Путь: '.$response['path'].'Дата отказа в регистрации: '.$DateRegRefusal.';', $flags = FILE_APPEND);
            }else{
                $response['check'] = 'Ошибка добавления записи в бд';
                $response['msg'] = 'Ошибка отказа в регистрации';
            }
        }
                  
    }

echo json_encode($response);

?>
