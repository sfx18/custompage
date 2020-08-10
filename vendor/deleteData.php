<?php
include "connect.php"; 
$response = array( 
    'status' => 0, 
    'msg' => 'Some problems occurred, please try again.'
); 
if(!empty($_REQUEST['id'])){ 
    $id = intval($_REQUEST['id']); 
      
 
    $sql = "DELETE FROM dep WHERE id = $id"; 
    $delete = $connect->query($sql); 
      
    if($delete){ 
        $response['status'] = 1; 
        $response['msg'] = 'Данные были успешно удалены.'; 
    } 
} 
echo json_encode($response);
?>