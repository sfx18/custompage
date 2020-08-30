<?php
session_start();
require_once 'vendor/connect.php';
if ($_SESSION['user']['groupid'] != 3) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="assets/css/icon.css">
    <link rel="stylesheet" type="text/css" href="assets/css/color.css">
    <link rel="stylesheet" type="text/css" href="assets/css/demo.css">
    <link rel="stylesheet" type="text/css" href="assets/css/easyui.css">
    <script type="text/javascript" src="assets/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.easyui.min.js"></script>
</head>
<body>
    <h2 class="logout"><a href="vendor/logout.php">Выйти</a></h2>
    <table id="dg" title="Список кандидатов" class="easyui-datagrid" url="vendor/getDataCik.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" style="width:100%;height:750px;">
  <thead>
   <tr>
     <th field="OkrBC" width="30">ОИК/ТИК</th>
     <th field="NumOkr" width="15">Округ</th>
     <th field="last_name" width="50">Фамилия</th>
     <th field="first_name" width="50">Имя</th>
     <th field="father_name" width="50">Отчество</th>
     <th field="birthday2" width="30">Дата</br>рождения</th>
     <th field="DateVidv2" width="30">Дата</br>выдвижения</th>
     <th field="DateReg2" width="50">Дата</br>регистрации</th>

   </tr>
  </thead>
 </table>
 <div id="toolbar">
 <!-- <input id="term" placeholder="Введите район">
 <input id="term2" placeholder="Введите округ">
   <a href="javascript:void(0);" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a> -->
  <div id="tb" style="padding-left:5px;padding-top:5px;">
      <select name="raion" id="raion">
      <option value="0">Выберите ТИК</option>
      <option value="1">Тирасполь</option>
      <option value="2">Бендеры</option>
      <option value="3">Слободзея</option>
      <option value="4">Григориополь</option>
      <option value="5">Дубоссары</option>
      <option value="6">Рыбница</option>
      <option value="7">Каменка</option>
      <option value="8">Днестровск</option>
      <option value="9">оик01</option>
      <option value="10">оик02</option>
      <option value="11">оик03</option>
      <option value="12">оик04</option>
      <option value="13">оик05</option>
      <option value="14">оик06</option>
      <option value="15">оик07</option>
      <option value="16">оик08</option>
      <option value="17">оик09</option>
      <option value="18">оик10</option>
      <option value="19">оик11</option>
      <option value="20">оик12</option>
      <option value="21">оик13</option>
      <option value="22">оик14</option>
      <option value="23">оик15</option>
      <option value="24">оик16</option>
      <option value="25">оик17</option>
      <option value="26">оик18</option>
      <option value="27">оик19</option>
      <option value="28">оик20</option>
      <option value="29">оик21</option>
      <option value="30">оик22</option>
      <option value="31">оик23</option>
      <option value="32">оик24</option>
      <option value="33">оик25</option>
      <option value="34">оик26</option>
      <option value="35">оик27</option>
      <option value="36">оик28</option>
      <option value="37">оик29</option>
      <option value="38">оик30</option>
      <option value="39">оик31</option>
      <option value="40">оик32</option>
      <option value="41">оик33</option>
      </select>
      <select name="NumKom" id="NumKom"><option value="">Выберите округ</option></select>
      <input type="date" id="termDateVidv" style="margin-left:645px;width:130px">
      <input type="date" id="termDateReg" style="margin-left:10px;width:160px">
  </div>
  <div id="tb2">
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fileList()">Список файлов</a>
  </div>
 </div>
 
 <!-- ФОРМА СО СПИСКОМ ФАЙЛОВ КАНДИДАТА -->
 <div id="dlgFileList" class="easyui-dialog" style="width:500px;height: 600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons-filelist'">
<form id="fmFileList" method="post" enctype="multipart/form-data" novalidate style="margin:0;padding:20px 50px">
<h3>Список файлов</h3>
   <div class="fileList"></div>
</form>
</div>
<div id="dlg-buttons-filelist">
  <a href="javascript:void(0);" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="javascript:$('#dlgFileList').dialog('close');" style="width:90px;text-align:center;">Ок</a>
  <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgFileList').dialog('close');" style="width:90px;">Отмена</a>
 </div>
 


 
 <h3 class="info">Телефон тех. поддержки 077835290</h3>
 <script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>