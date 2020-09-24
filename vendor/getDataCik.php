<?php
session_start();
include "connect.php"; 
$page = isset($_POST['page']) ? intval($_POST['page']) : 1; 
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15; 
$login = $_SESSION['user']['login'];
$groupid = $_SESSION['user']['groupid'];
$searchTerm = '';
$searchTerm2 = '';
$searchTerm3 = '';
$searchTerm4 = '';

   $searchTerm = isset($_POST['term']) ? mysqli_real_escape_string($connect, $_POST['term']) : '';
   $searchTerm2 = isset($_POST['term2']) ? mysqli_real_escape_string($connect, $_POST['term2']) : '';
   $searchTerm3 = isset($_POST['termDateVidv']) ? $_POST['termDateVidv'] : '';
   $searchTerm4 = isset($_POST['termDateReg']) ? $_POST['termDateReg'] : '';

$offset = ($page-1)*$rows; 
$result = array();

// // ФИЛЬТРАЦИЯ ПО РАЙОНУ, ОКРУГУ И ДАТЕ ВЫДВИЖЕНИЯ
// if(isset($_POST['term']) && isset($_POST['term2'])){
//    if(isset($_POST['termDateVidv'])){
//       $whereSQL = "OkrBC LIKE '$searchTerm%' AND NumOkr LIKE '$searchTerm2%' AND DateVidv = '$searchTerm3'";
//    }else{
//       $whereSQL = "OkrBC LIKE '$searchTerm%' AND NumOkr LIKE '$searchTerm2%'";
//    }  
// }// ФИЛЬТРАЦИЯ ПО РАЙОНУ И ДАТЕ ВЫДВИЖЕНИЯ
// elseif(isset($_POST['term']) && isset($_POST['termDateVidv'])){
//    $whereSQL = "OkrBC LIKE '$searchTerm%' AND DateVidv = '$searchTerm3'";
// }// ФИЛЬТРАЦИЯ ПО ДАТЕ ВЫДВИЖЕНИЯ
// elseif(!isset($_POST['term']) && !isset($_POST['term2']) && isset($_POST['termDateVidv'])){
//    $whereSQL = "DateVidv = '$searchTerm3'";
// }else{
//    $whereSQL = "OkrBC LIKE '$searchTerm%' AND NumOkr LIKE '$searchTerm2%'";
// }


// ФИЛЬТРАЦИЯ ПО РАЙОНУ, ОКРУГУ И ДАТЕ ВЫДВИЖЕНИЯ
if(isset($_POST['term']) && isset($_POST['term2'])){
   if(isset($_POST['termDateVidv'])){
      $whereSQL = "OkrBC LIKE '$searchTerm%' AND NumOkr LIKE '$searchTerm2%' AND DateVidv = '$searchTerm3'";
   }elseif(isset($_POST['termDateReg'])){
      $whereSQL = "OkrBC LIKE '$searchTerm%' AND NumOkr LIKE '$searchTerm2%' AND DateReg = '$searchTerm4'";
   }else{
      $whereSQL = "OkrBC LIKE '$searchTerm%' AND NumOkr LIKE '$searchTerm2%'";
   }  
}// ФИЛЬТРАЦИЯ ПО РАЙОНУ И ДАТЕ ВЫДВИЖЕНИЯ
elseif(isset($_POST['term']) && isset($_POST['termDateVidv'])){
   $whereSQL = "OkrBC LIKE '$searchTerm%' AND DateVidv = '$searchTerm3'";
}// ФИЛЬТРАЦИЯ ПО ДАТЕ ВЫДВИЖЕНИЯ
elseif(isset($_POST['term']) && isset($_POST['termDateReg'])){
   $whereSQL = "OkrBC LIKE '$searchTerm%' AND DateReg = '$searchTerm4'";
}
elseif(!isset($_POST['term']) && !isset($_POST['term2']) && isset($_POST['termDateVidv'])){
   $whereSQL = "DateVidv = '$searchTerm3'";
}elseif(!isset($_POST['term']) && !isset($_POST['term2']) && isset($_POST['termDateReg'])){
   $whereSQL = "DateReg = '$searchTerm4'";
}else{
   $whereSQL = "OkrBC LIKE '$searchTerm%' AND NumOkr LIKE '$searchTerm2%'";
}



$result = mysqli_query($connect, "SELECT COUNT(*) FROM kandidat WHERE $whereSQL"); 
$row = mysqli_fetch_row($result); 
$response["total"] = $row[0]; 

$result = mysqli_query($connect, "SELECT *, date_format(birthday,'%d.%m.%Y') as birthday2, date_format(DateVidv,'%d.%m.%Y') as DateVidv2, date_format(DateReg,'%d.%m.%Y') as DateReg2, date_format(DateRegRefusal,'%d.%m.%Y') as DateRegRefusal2 FROM kandidat WHERE $whereSQL ORDER BY OkrBC, NumOkr, last_name ASC LIMIT $offset,$rows");

$users = array(); 
   while($row = mysqli_fetch_assoc($result)){ 
      if($row['NumOkr'] == '0'){
         $row['NumOkr'] = '';
      }
      if($row['DateReg'] == "0000-00-00"){
      $row['DateReg2'] = '';
      }
      if($row['DateRegRefusal'] == "0000-00-00"){
         $row['DateRegRefusal2'] = '';
      }
      array_push($users, $row); 
   } 
$response["rows"] = $users; 
echo json_encode($response);
?>