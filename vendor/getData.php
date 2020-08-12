<?php
session_start();
include "connect.php"; 
$page = isset($_POST['page']) ? intval($_POST['page']) : 1; 
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 15; 
$login = $_SESSION['user']['login'];
$groupid = $_SESSION['user']['groupid'];

$searchTerm = isset($_POST['term']) ? $connect->real_escape_string($_POST['term']) : ''; 
  
$offset = ($page-1)*$rows; 
  
$result = array(); 
 
$whereSQL = "OkrBC LIKE '$searchTerm%' OR NumOkr LIKE '$searchTerm%' OR first_name LIKE '$searchTerm%' OR last_name LIKE '$searchTerm%' OR father_name LIKE '$searchTerm%'";
$result = $connect->query("SELECT COUNT(*) FROM kandidat WHERE $whereSQL"); 
$row = $result->fetch_row(); 
$response["total"] = $row[0]; 
   if($groupid == 3 || $groupid == 4){
      $result = $connect->query( "SELECT *, date_format(birthday,'%d.%m.%Y') as birthday2, date_format(DateVidv,'%d.%m.%Y') as DateVidv2, date_format(DateReg,'%d.%m.%Y') as DateReg2 FROM kandidat WHERE $whereSQL ORDER BY last_name, first_name ASC LIMIT $offset,$rows");
   }else{
      $result = $connect->query( "SELECT * FROM (SELECT *, date_format(birthday,'%d.%m.%Y') as birthday2, date_format(DateVidv,'%d.%m.%Y') as DateVidv2, date_format(DateReg,'%d.%m.%Y') as DateReg2 FROM kandidat WHERE OkrBC = '$login') AS OIK WHERE $whereSQL ORDER BY last_name, first_name ASC LIMIT $offset,$rows");
   }
  
$users = array(); 
   while($row = $result->fetch_assoc()){ 
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