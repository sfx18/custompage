<?php
session_start();
include "connect.php"; 
$page = isset($_POST['page']) ? intval($_POST['page']) : 1; 
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15; 
$login = $_SESSION['user']['login'];
$groupid = $_SESSION['user']['groupid'];

$searchTerm = isset($_POST['term']) ? mysqli_real_escape_string($connect, $_POST['term']) : '';
$searchTerm2 = isset($_POST['term2']) ? mysqli_real_escape_string($connect, $_POST['term2']) : '';
// $searchTermDateVidv = isset($_POST['termDateVidv']) ? mysqli_real_escape_string($connect, $_POST['termDateVidv']) : '';
// $searchTermDateReg = isset($_POST['termDateReg']) ? mysqli_real_escape_string($connect, $_POST['termDateReg']) : '';

// $searchTerm2 = $_POST['termDateVidv'];
$offset = ($page-1)*$rows; 
$result = array(); 
 
$whereSQL = "OkrBC LIKE '$searchTerm%' AND NumOkr LIKE '$searchTerm2%'";
// $whereSQL2 = "DateVidv = '$searchTerm2'";

$result = mysqli_query($connect, "SELECT COUNT(*) FROM kandidat WHERE $whereSQL"); 
$row = mysqli_fetch_row($result); 
$response["total"] = $row[0]; 

$result = mysqli_query($connect, "SELECT *, date_format(birthday,'%d.%m.%Y') as birthday2, date_format(DateVidv,'%d.%m.%Y') as DateVidv2, date_format(DateReg,'%d.%m.%Y') as DateReg2 FROM kandidat WHERE $whereSQL ORDER BY OkrBC, NumOkr, last_name ASC LIMIT $offset,$rows");

$users = array(); 
   while($row = mysqli_fetch_assoc($result)){ 
      if($row['NumOkr'] == 0){
         $row['NumOkr'] = '';
      }
      if($row['DateReg'] == "0000-00-00"){
      $row['DateReg2'] = '';
      }
      array_push($users, $row); 
   } 
$response["rows"] = $users; 
echo json_encode($response);
?>