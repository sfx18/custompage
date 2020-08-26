<?php
function uploadFile($folderpath){
    $path = "$folderpath/".date('Y-m-d_H-i-s', strtotime("+3 hours")).'_'.$_FILES['avatar']['name'];
    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $path)) {
        return [
            "status" => 0,
            "msg" => "Ошибка загрузки файла",
            "check" => "Error of upload file",
        ];
    }else{ 
        return  [
            "status" => 1,
            "msg" => "Файл успешно загружен",
            "check" => "File uploaded success",
            "path" => $path,
        ];
    }
}

function delDir($dir) {
    $files = array_diff(scandir($dir), ['.','..']);
    foreach ($files as $file) {
        (is_dir($dir.'/'.$file)) ? delDir($dir.'/'.$file) : unlink($dir.'/'.$file);
    }
    return rmdir($dir);
}


?>