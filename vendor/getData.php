<?php
session_start();
include "connect.php"; 
$page = isset($_POST['page']) ? intval($_POST['page']) : 1; 
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10; 
$login = $_SESSION['user']['login'];
$groupid = $_SESSION['user']['groupid'];

$searchTerm = '';  
$searchTerm = isset($_POST['term']) ? $connect->real_escape_string($_POST['term']) : ''; 
  
$offset = ($page-1)*$rows; 
  
$result = array(); 
 
$whereSQL = "OkrBC LIKE '$searchTerm%' OR NumOkr LIKE '$searchTerm%' OR first_name LIKE '$searchTerm%' OR last_name LIKE '$searchTerm%' OR father_name LIKE '$searchTerm%'";
$result = $connect->query("SELECT COUNT(*) FROM dep WHERE $whereSQL"); 
$row = $result->fetch_row(); 
$response["total"] = $row[0]; 
 if($groupid == 3){
    $result = $connect->query( "SELECT *, date_format(birthday,'%d.%m.%Y') as birthday FROM dep WHERE $whereSQL ORDER BY last_name, first_name ASC LIMIT $offset,$rows");
 }else{
    $result = $connect->query( "SELECT *, date_format(birthday,'%d.%m.%Y') as birthday FROM dep WHERE OkrBC = '$login' ORDER BY last_name, first_name ASC LIMIT $offset,$rows");
 }
  
$users = array(); 
while($row = $result->fetch_assoc()){ 
    array_push($users, $row); 
} 
$response["rows"] = $users; 
 
echo json_encode($response);
?>