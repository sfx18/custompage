<?php
require 'connect.php';
$result = mysqli_query($connect, "SELECT DISTINCT NumOkr FROM kandidat WHERE OkrBC = '".$_POST["uRaionId"]."' ORDER BY NumOkr=0, -NumOkr DESC, NumOkr");
$output = '<option value="">Выберите округ</option>';
while ($row = mysqli_fetch_array($result)) {
	$output .= '<option value="'.$row['NumOkr'].'">'.$row['NumOkr'].'</option>';	
}
echo $output;

?>