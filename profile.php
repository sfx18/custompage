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
    <table id="dg" title="Список кандидатов" class="easyui-datagrid" url="vendor/getData.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" style="width:100%;height:750px;">
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
  <div id="tb" style="padding-left:5px;padding-top:5px;">
  <select name="raion" id="raion">
  <option value="0">Выберите ОИК/ТИК</option>
   <option value="1">Тирасполь</option>
   <option value="2">Бендеры</option>
   <option value="3">Слободзея</option>
   <option value="4">Григориополь</option>
   <option value="5">Дубоссары</option>
   <option value="6">Рыбница</option>
   <option value="7">Каменка</option>
   <option value="8">Днестровск</option>
   </select>
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