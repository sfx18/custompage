<?php
require 'connect.php';
$result = mysqli_query($connect, "SELECT * FROM kandidat WHERE OkrBC = '".$_POST["uRaionId"]."' ORDER BY OkrBC");
$output = '<option value="">Выберите город</option>';
while ($row = mysqli_fetch_assoc($result)) {
	
	$output .= '<option value="'.$row["NumOkr"].'">'.$row["NumOkr"].'</option>';	
}
echo $output;
?>