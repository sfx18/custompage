<?php
include "connect.php"; 
$response = array( 
    'status' => 0, 
    'msg' => 'Возникли проблемы, попробуйте еще раз.'
);
if(!empty($_REQUEST['first_name']) && !empty($_REQUEST['last_name']) && !empty( $_REQUEST['father_name']) && !empty($_REQUEST['birthday']) && !empty($_REQUEST['DateVidv'])){ 
    $first_name = $_REQUEST['first_name']; 
    $last_name = $_REQUEST['last_name']; 
    $father_name = $_REQUEST['father_name']; 
    $birthday = $_REQUEST['birthday']; 
    $DateVidv = $_REQUEST['DateVidv'];
    $NumOkr = $_REQUEST['NumOkr'];
    

      
    if(!empty($_REQUEST['id'])){ 
        $id = intval($_REQUEST['id']); 
        $DateReg = $_REQUEST['DateReg'];
          
        $sql = "UPDATE kandidat SET last_name='$last_name', first_name='$first_name', father_name='$father_name', birthday='$birthday', DateVidv ='$DateVidv', DateReg='$DateReg', NumOkr='$NumOkr' WHERE id = $id"; 
        $update = $connect->query($sql); 


        if($update){ 
            $response['status'] = 1; 
            $response['msg'] = "Данные были успешно обновлены"; 
        } 
    } 
}else{ 
    $response['msg'] = 'Заполните все поля!'; 
} 
echo json_encode($response); 
?>