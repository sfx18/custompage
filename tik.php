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
    <table id="dg" title="Список кандидатов" class="easyui-datagrid" url="vendor/getData.php" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" style="width:100%;height:487px;">
  <thead>
   <tr>
    <th field="NumOkr" width="30">Округ</th>
     <th field="last_name" width="50">Фамилия</th>
     <th field="first_name" width="50">Имя</th>
     <th field="father_name" width="50">Отчество</th>
     <th field="birthday2" width="25">Дата</br>рождения</th>
     <th field="DateVidv2" width="25">Дата</br>выдвижения</th>
     <th field="DateReg2" width="25">Дата</br>регистрации</th>
     <th field="DateRegRefusal2" width="25">Дата отказа </br>в регистрации</th>
     <!-- <th field="DateRevocation2" width="25">Дата отзыва</br>документов</th> -->

   </tr>
  </thead>
 </table>
 <div id="toolbar">
  <div id="tb">
   <input id="term" placeholder="Ввод">
   <a href="javascript:void(0);" class="easyui-linkbutton" plain="true" onclick="doSearch()">Поиск</a>
   <a href="javascript:void(0);" class="easyui-linkbutton" plain="true" onclick="doSearchClear()">Очистить</a>
  </div>
  <div id="tb2">
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Новый</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-download" plain="true" onclick="uploadImg()">Загрузить материалы</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-list" plain="true" onclick="fileList()">Список файлов</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reg" plain="true" onclick="registration()">Зарегистрировать кандидата</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-del" plain="true" onclick="registrationRefusal()">Отказ в регистрации</a>
   <!-- <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-revocation" plain="true" onclick="revocation()">Отзыв документов</a> -->
  </div>
 </div>


<!-- ФОРМА СОЗДАНИЯ НОВОГО КАНДИДАТА -->

 <div id="dlg" class="easyui-dialog" style="width:500px;height: 600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
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
   <div style="margin-bottom:50px">
    <input name="NumOkr" class="easyui-textbox" required="true" label="№ Округа:" style="width:100%">
    <label>Если кандидат по единому округу - пишем название населенного пункта, например: Катериновка.<br>Если что-то непонятно, звонить по номеру:<br>778 3-52-90 (Иван).</label>
   </div>
   

   <div id="fileInputNewUser" style="margin-bottom:10px">
   </div>
   <div style="margin-bottom:20px">
    <input type="date" name="DateVidv" class="easyui-textbox" required="true" label="Дата выдвижения:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <div class="progress"></div>
    <div class="progressmsg"></div>
   </div>
  </form>
 </div>
 <div id="dlg-buttons">
  <a href="javascript:void(0);" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px;">Сохранить</a>
  <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close');" style="width:90px;">Отмена</a>
 </div>


<!-- ФОРМА ЗАГРУЗКИ МАТЕРИАЛОВ ДЛЯ КАНДИДАТА -->

 <div id="dlgUploadImg" class="easyui-dialog" style="width:500px;height: 600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons-uploadimg'">
<form id="fmUploadImg" method="post" enctype="multipart/form-data" novalidate style="margin:0;padding:20px 50px">
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
   <div id="fileInputUploadImg" style="margin-bottom:20px">
    </div> 
    <div style="margin-bottom:10px">
    <div class="progress"></div>
    <div class="progressmsg"></div>
   </div>
</form>
</div>
<div id="dlg-buttons-uploadimg">
  <a href="javascript:void(0);" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveImg()" style="width:90px;text-align:center;">Сохранить</a>
  <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgUploadImg').dialog('close');" style="width:90px;">Отмена</a>
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


<!-- ФОРМА РЕГИСТРАЦИИ КАНДИДАТА -->

 <div id="dlgRegistration" class="easyui-dialog" style="width:500px;height: 600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons-registration'">
<form id="fmRegistration" method="post" enctype="multipart/form-data" novalidate style="margin:0;padding:20px 50px">
<h3>Вы регистрируете кандидата</h3>
   <div style="margin-bottom:10px">
    <input name="last_name" class="easyui-textbox" readonly="readonly" label="Фамилия:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="first_name" class="easyui-textbox" readonly="readonly" label="Имя:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="father_name" class="easyui-textbox" readonly="readonly" label="Отчество:" style="width:100%">
   </div>
   <div style="margin-bottom:50px">
    <input type="date" name="birthday" class="easyui-textbox" readonly="readonly" label="Дата рождения:" style="width:100%">
   </div>
   <div id="fileInputUploadFile" style="margin-bottom:10px">
    </div> 
    <div style="margin-bottom:20px">
    <input type="date" name="DateReg" class="easyui-textbox" required="true" label="Дата регистрации:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <div class="progress"></div>
    <div class="progressmsg"></div>
   </div>
</form>
</div>
<div id="dlg-buttons-registration">
  <a href="javascript:void(0);" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveFile()" style="width:90px;text-align:center;">Сохранить</a>
  <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgRegistration').dialog('close');" style="width:90px;">Отмена</a>
 </div>


 <!-- ФОРМА ОТКАЗА В РЕГИСТРАЦИИ -->

 <div id="dlgRegistrationRefusal" class="easyui-dialog" style="width:500px;height: 600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons-registration-refusal'">
<form id="fmRegistrationRefusal" method="post" enctype="multipart/form-data" novalidate style="margin:0;padding:20px 50px">
<h3>Отказ в регистрации</h3>
   <div style="margin-bottom:10px">
    <input name="last_name" class="easyui-textbox" readonly="readonly" label="Фамилия:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="first_name" class="easyui-textbox" readonly="readonly" label="Имя:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="father_name" class="easyui-textbox" readonly="readonly" label="Отчество:" style="width:100%">
   </div>
   <div style="margin-bottom:50px">
    <input type="date" name="birthday" class="easyui-textbox" readonly="readonly" label="Дата рождения:" style="width:100%">
   </div>
   <div id="fileInputUploadFileRefusal" style="margin-bottom:10px">
    </div> 
    <div style="margin-bottom:20px">
    <input type="date" name="DateRegRefusal" class="easyui-textbox" required="true" label="Дата отказа в регистрации:" style="width:100%">
   </div>
   <div class="progress">
      </div>
</form>
</div>
<div id="dlg-buttons-registration-refusal">
  <a href="javascript:void(0);" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveFileRefusal()" style="width:90px;text-align:center;">Сохранить</a>
  <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgRegistrationRefusal').dialog('close');" style="width:90px;">Отмена</a>
 </div>


 <!-- ФОРМА ОТЗЫВА ДОКУМЕНТОВ -->

<div id="dlgRevocation" class="easyui-dialog" style="width:500px;height: 600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons-revocation'">
<form id="fmRevocation" method="post" enctype="multipart/form-data" novalidate style="margin:0;padding:20px 50px">
<h3>Отзыв пакета документов</h3>
   <div style="margin-bottom:10px">
    <input name="last_name" class="easyui-textbox" readonly="readonly" label="Фамилия:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="first_name" class="easyui-textbox" readonly="readonly" label="Имя:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="father_name" class="easyui-textbox" readonly="readonly" label="Отчество:" style="width:100%">
   </div>
   <div style="margin-bottom:50px">
    <input type="date" name="birthday" class="easyui-textbox" readonly="readonly" label="Дата рождения:" style="width:100%">
   </div>
   <div id="fileInputUploadFileRevocation" style="margin-bottom:10px">
    </div> 
    <div style="margin-bottom:20px">
    <input type="date" name="DateRevocation" class="easyui-textbox" required="true" label="Дата отзыва документов:" style="width:100%">
   </div>
   <div class="progress"></div>
    <div class="progressmsg"></div>
</form>
</div>
<div id="dlg-buttons-revocation">
  <a href="javascript:void(0);" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveFileRevocation()" style="width:90px;text-align:center;">Сохранить</a>
  <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgRevocation').dialog('close');" style="width:90px;">Отмена</a>
 </div>

 <h3 class="info">Телефон тех. поддержки 0(778)3-52-90 (Иван)</h3>
 <script type="text/javascript" src="assets/js/script.js"></script>
</body>
</html>