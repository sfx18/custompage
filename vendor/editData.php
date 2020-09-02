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
    $OkrBC = $_REQUEST['OkrBC'];
    $foldername = "$last_name $first_name $father_name";
    if(!empty($_REQUEST['NumOkr'])){
        $path = "/var/kandidat/$OkrBC/$NumOkr/$foldername";
    }else{
        $path = "/var/kandidat/$OkrBC/$foldername";
    }
    
    

      
    if(!empty($_REQUEST['id'])){ 
        $id = intval($_REQUEST['id']); 
        $sql = "SELECT * FROM kandidat WHERE id = '$id'";
        $select = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($select);
        $OkrBCdb = $row['OkrBC'];
        $last_namedb = $row['last_name'];
        $first_namedb = $row['first_name'];
        $father_namedb = $row['father_name'];
        $DateVidvdb = $row['DateVidv'];
        $foldernamedb = "$last_namedb $first_namedb $father_namedb";
          
        $sql = "UPDATE kandidat SET last_name='$last_name', first_name='$first_name', father_name='$father_name', birthday='$birthday', DateVidv ='$DateVidv', NumOkr='$NumOkr', path = '$path' WHERE id = $id"; 
        $update = $connect->query($sql); 


        if($update){ 
            $response['status'] = 1; 
            $response['msg'] = "Данные были успешно обновлены"; 
            file_put_contents('/var/www/site/custompage/logs/editDatalog.txt', 'Изменено с ОИК/ТИК: '.$OkrBCdb.' Ф.И.О. '.$foldernamedb.' Д.В. '.$DateVidvdb.' на ОИК/ТИК: '.$OkrBC.' Ф.И.О. '.$foldername.' Д.В. '.$DateVidv.' Время: '.date('Y-m-d_H-i-s', strtotime("+3 hours")).';', $flags = FILE_APPEND);
        } 
    } 
}else{ 
    $response['msg'] = 'Заполните все поля!'; 
} 
echo json_encode($response); 
?>