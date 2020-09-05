<?php
include "connect.php"; 
include "functions.php";
$response = array( 
    'status' => 0, 
    'msg' => 'Возникли проблемы, попробуйте еще раз.'
); 
    if(!empty($_REQUEST['id'])){ 
        $id = intval($_REQUEST['id']); 

        $query = "SELECT * FROM kandidat WHERE id = $id";
        $select = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($select);
        $pathsrc = $row['path'];
        
    
        $sql = "DELETE FROM kandidat WHERE id = $id"; 
        $delete = $connect->query($sql); 

        if($delete && delDir($pathsrc)){ 
            $response['status'] = 1; 
            $response['msg'] = 'Данные были успешно удалены.'; 
        }
        else{
            $response['status'] = 0;
            $response['msg'] = 'Ошибка удаления.'; 
        }
    } 

echo json_encode($response);
?>