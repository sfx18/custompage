<?php
session_start();
include "connect.php"; 
include "functions.php";
$response = array( 
    'status' => 0, 
    'msg' => 'Возникли проблемы, попробуйте еще раз.',
    'check' => 'Default'
);

if(!empty($_REQUEST['first_name']) && !empty($_REQUEST['last_name']) && !empty( $_REQUEST['father_name']) && !empty($_REQUEST['birthday']) && !empty($_REQUEST['DateVidv'])){ 
    $first_name = $_REQUEST['first_name'];
    $last_name = $_REQUEST['last_name'];
    $father_name = $_REQUEST['father_name']; 
    $birthday = $_REQUEST['birthday'];
    $DateVidv = $_REQUEST['DateVidv'];
    $DateReg = $_REQUEST['DateReg'];
    $NumOkr = $_REQUEST['NumOkr'];
    $login = $_SESSION['user']['login'];
    $folder_name = "$last_name $first_name $father_name";
    $path = "/var/kandidat/$login/$folder_name";
    $permit = 0777;

    if(!empty($_REQUEST['NumOkr'])){
        // $pathForWindows = "\\16.16.16.180\\kandidat\\$login\\$NumOkr\\$folder_name";
        $path = "/var/kandidat/$login/$NumOkr/$folder_name";
        if(!file_exists("/var/kandidat/$login/$NumOkr")){
            mkdir("/var/kandidat/$login/$NumOkr");
            chmod("/var/kandidat/$login/$NumOkr", $permit);
        }
        if(!file_exists("/var/kandidat/$login/$NumOkr/$folder_name")){
            mkdir("/var/kandidat/$login/$NumOkr/$folder_name");
            chmod("/var/kandidat/$login/$NumOkr/$folder_name", $permit);
        }
    }else{
        // $pathForWindows = "\\"."\\"."16.16.16.180"."\\"."kandidat"."\\"."$login"."\\"."$folder_name";
            $path = "/var/kandidat/$login/$folder_name";
            if(!file_exists("/var/kandidat/$login/$folder_name")){
                mkdir("/var/kandidat/$login/$folder_name");
                chmod("/var/kandidat/$login/$folder_name", $permit);
            }
        }

    
    $response = uploadFile($path);
    if($response['status']){ 
        $first_name = mb_strtoupper($first_name);
        $last_name = mb_strtoupper($last_name);
        $father_name = mb_strtoupper($father_name);
        $sql = "INSERT INTO `kandidat` (`first_name`,`last_name`,`father_name`,`birthday`,`DateVidv`, `DateReg`, `OkrBC`,`NumOkr`,`path`) VALUES ('$first_name','$last_name','$father_name','$birthday', '$DateVidv', '$DateReg', '$login','$NumOkr', '$path')"; 
        $insert = mysqli_query($connect,$sql);
        if($insert){
            
                // Токен бота и идентификатор чата
$token='1386744179:AAFVxfaHZcKPVUT0xhi6Z6wpvKG3OSXfxoU';
$chat_id='540095914';
$text='Привет!';
file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=$text");
// сюда нужно вписать токен вашего бота

// $text = 'Привет мир'; 
// // Отправить сообщение
// $ch=curl_init();
// curl_setopt($ch, CURLOPT_URL,
//        'https://api.telegram.org/bot'.$token.'/sendMessage?');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HEADER, false);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS,
//        'chat_id='.$chat_id.'&text='.urlencode($text));
// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
 
// // // Настройки прокси, если это необходимо
// // $proxy='111.222.222.111:8080';
// // $auth='login:password';
// // curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
// // curl_setopt($ch, CURLOPT_PROXY, $proxy);
// // curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth);
 
// // Отправить сообщение
// curl_exec($ch);
// curl_close($ch);
            $response['check'] = 'Запись успешно добавлена в бд';
            $response['msg'] = 'Кандидат успешно добавлен';
            // file_put_contents('/var/www/site/custompage/logs/addDatalog.txt', $path.'___Дата/время добавления: '.date('Y-m-d_H-i-s', strtotime("+3 hours")).'___Дата выдвижения: '.$DateVidv.';', $flags = FILE_APPEND);
            // file_put_contents('/var/www/site/custompage/logs/addDataFilelog.txt', $response['path'].';', $flags = FILE_APPEND);
        }else{
            $response['check'] = 'Ошибка добавления записи в бд';
            // file_put_contents('/var/www/site/custompage/logs/addDataErrorslog.txt', date('Y-m-d_H-i-s', strtotime("+3 hours")).$login.'/'.$response['msg'].';', $flags = FILE_APPEND);
        }
    }

}
echo json_encode($response);

?>