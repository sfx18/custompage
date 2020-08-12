<?php
include "connect.php"; 

  if(!empty($_POST['id'])){ 
    $id = intval($_POST['id']);

    $query = "SELECT * FROM kandidat WHERE id = $id";
    $select = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($select);
    $pathsrc = $row['path'];

$files = scandir($pathsrc);
    if(count($files) == 2){
        echo '<p>Список пуст<p>';
    }
echo '<ul>';
    foreach ($files as $file):
        if($file != '.' && $file != '..'){  
        echo '<li>'.$file .'</li>';
        }
    endforeach;
echo '</ul>';
      
 }

?>