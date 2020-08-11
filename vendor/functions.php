<?php
function uploadFile($folderpath)
{
    $path = "$folderpath/".date('Y-m-d_H-i', strtotime("+3 hours")).'_'.$_FILES['avatar']['name'];
    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $path)) {
        return [
            "status" => 0,
            "msg" => "Ошибка загрузки",
        ];
    }else{ 
        return  [
            "status" => 1,
            "msg" => "Файл успешно загружен",
        ];
    }
}


?>