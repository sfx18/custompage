<?php
session_start();
require_once 'vendor/connect.php';
if ($_SESSION['user']['groupid'] != 2) {
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
    <header class="header123">
    <h2 class="logout"><a href="vendor/logout.php">Выйти</a></h2>
    </header>
    <table id="dg" title="Список кандидатов" class="easyui-datagrid" url="vendor/getData.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" style="width:100%;height:700px;">
  <thead>
   <tr>
    <th field="NumOkr" width="20">№ Округа</th>
     <th field="last_name" width="50">Фамилия</th>
     <th field="first_name" width="50">Имя</th>
     <th field="father_name" width="50">Отчество</th>
     <th field="birthday" width="50">Дата рождения</th>
     <th field="DateReg" width="50">Дата регистрации</th>

   </tr>
  </thead>
 </table>
 <div id="toolbar">
  <div id="tb">
   <input id="term" placeholder="Ввод">
   <a href="javascript:void(0);" class="easyui-linkbutton" plain="true" onclick="doSearch()">Поиск</a>
  </div>
  <div id="tb2">
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Новый</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Изменить</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Удалить</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="uploadImg()">Загрузить материалы</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="fileList()">Список файлов</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="registration()">Зарегистрировать кандидата</a>
  </div>
 </div>
 <div id="dlg" class="easyui-dialog" style="width:450px;height: 600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
  <form id="fm" method="post" enctype="multipart/form-data" novalidate style="margin:0;padding:20px 50px">
   <h3>Информация</h3>
   <div style="margin-bottom:10px">
    <input name="last_name" class="easyui-textbox" required="true" label="Фамилия:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="first_name" class="easyui-textbox" required="true" label="Имя:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="father_name" class="easyui-textbox" required="true" label="Отчество:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input type="date" name="birthday" class="easyui-textbox" required="true" label="Дата рождения:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="NumOkr" class="easyui-textbox" required="true" label="№ Округа:" style="width:100%">
   </div>
   

   <div id="fileInputNewUser" style="margin-bottom:10px">
    
   </div>
  </form>
 </div>
 <div id="dlg-buttons">
  <a href="javascript:void(0);" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px;">Сохранить</a>
  <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close');" style="width:90px;">Отмена</a>
 </div>
 <div id="dlg2" class="easyui-dialog" style="width:450px;height: 600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons2'">
<form id="fm2" method="post" enctype="multipart/form-data" novalidate style="margin:0;padding:20px 50px">
<h3>Вы загружаете файл для кандидата</h3>
   <div style="margin-bottom:10px">
    <input name="last_name" class="easyui-textbox" readonly="readonly" label="Фамилия:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="first_name" class="easyui-textbox" readonly="readonly" label="Имя:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="father_name" class="easyui-textbox" readonly="readonly" label="Отчество:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input type="date" name="birthday" class="easyui-textbox" readonly="readonly" label="Дата рождения:" style="width:100%">
   </div>
   <div id="fileInputUploadImg" style="margin-bottom:10px">
    </div> 
</form>
</div>
<div id="dlg-buttons2">
  <a href="javascript:void(0);" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveImg()" style="width:90px;text-align:center;">Сохранить</a>
  <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close');" style="width:90px;">Отмена</a>
 </div>
 <div id="dlg3" class="easyui-dialog" style="width:450px;height: 600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons3'">
<form id="fm3" method="post" enctype="multipart/form-data" novalidate style="margin:0;padding:20px 50px">
<h3>Список файлов</h3>
   <div class="fileList"></div>
</form>
</div>
<div id="dlg-buttons3">
  <a href="javascript:void(0);" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="javascript:$('#dlg3').dialog('close');" style="width:90px;text-align:center;">Ок</a>
  <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg3').dialog('close');" style="width:90px;">Отмена</a>
 </div>
 <h3 class="info">Телефон тех. поддержки 077835290</h3>
 <script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>