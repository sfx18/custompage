<?php
include "connect.php"; 
$response = array( 
    'status' => 0, 
    'msg' => 'Возникли проблемы, попробуйте еще раз.'
);

    if(!empty($_REQUEST['id'])){ 

        $id = intval($_REQUEST['id']); 
        // ВЫБОРКА ПУТЕЙ ИЗ БД
        // $query = "SELECT * FROM kandidat WHERE id = $id";
        // $select = mysqli_query($connect, $query);
        // $row = mysqli_fetch_assoc($select);
        // $pathsrc = $row['path'];
        
        // $DateReg = $_REQUEST['DateReg'];
$check = 1;
        //загрузка файла по пути из БД
        // $response = uploadFile($pathsrc);
            $sql = "UPDATE kandidat SET checkDateVidv='$check' WHERE id = $id";  
            $update = mysqli_query($connect,$sql);
            if($update){
            $response['status'] = 1; 
            $response['check'] = 'Запись в бд успешно добавлена';
            $response['msg'] = 'Кандидат отмечен';
            }else{
                $response['status'] = 0;
                $response['check'] = 'Ошибка добавления записи в бд';
                $response['msg'] = 'Ошибка отметки кандитата';
            }
        
                  
    }

echo json_encode($response);

?>
