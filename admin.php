<?php
session_start();
require_once 'vendor/connect.php';
if ($_SESSION['user']['groupid'] != 4) {
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
     <th field="OkrBC" width="20">ОИК/ТИК</th>
     <th field="NumOkr" width="10">Округ</th>
     <th field="last_name" width="30">Фамилия</th>
     <th field="first_name" width="30">Имя</th>
     <th field="father_name" width="30">Отчество</th>
     <th field="birthday2" width="30">Дата</br>рождения</th>
     <th field="DateVidv2" width="30">Дата</br>выдвижения</th>
     <th field="checkDateVidv" width="10">Отчет</br> о Д.В.</th>
     <th field="DateReg2" width="30">Дата</br>регистрации</th>
     <th field="checkDateReg" width="10">Отчет</br> о Д.Р.</th>
     <th field="path" width="50">Путь</th>

   </tr>
  </thead>
 </table>
 <div id="toolbar">
  <div id="tb">
  <form id="filter">
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
      <option value="42">adm</option>
      </select>
   <select name="NumKom" id="NumKom"><option value="">Выберите округ</option></select>
   <label>По дате выдвижения</label>
   <input type="date" id="termDateVidv">
   <label>По дате регистрации</label>
   <input type="date" id="termDateReg">
   <input type="submit" value="Сбросить фильтр">
   </form>
  </div>
  <div id="tb2">
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">Новый</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Изменить</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Удалить</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-download" plain="true" onclick="uploadImg()">Загрузить материалы</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-list" plain="true" onclick="fileList()">Список файлов</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reg" plain="true" onclick="registration()">Зарегистрировать кандидата</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="isCheckDateVidv()">Отметить о Д.В.</a>
   
   <!-- <a href="javascript:void(0);" class="easyui-linkbutton" plain="true" onclick="doSearchRaion()">Поиск</a> -->
  </div>
 </div>

<!-- ФОРМА СОЗДАНИЯ НОВОГО КАНДИДАТА -->

 <div id="dlg" class="easyui-dialog" style="width:500px;height: 600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
  <form id="fm" method="post" enctype="multipart/form-data" novalidate style="margin:0;padding:20px 50px">
   <h3>Информация</h3>
   <div style="margin-bottom:10px">
    <input name="OkrBC" class="easyui-textbox" readonly="readonly" label="ОИК/ТИК:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="last_name" class="easyui-textbox" required="true" label="Фамилия:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="first_name" class="easyui-textbox" required="true" label="Имя:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input name="father_name" class="easyui-textbox" required="true" label="Отчество:" style="width:100%">
   </div>
   <div style="margin-bottom:50px">
    <input type="date" name="birthday" class="easyui-textbox" required="true" label="Дата рождения:" style="width:100%">
   </div>
   <div style="margin-bottom:50px">
    <input name="NumOkr" class="easyui-textbox" label="№ Округа:" style="width:100%">
   </div>
   

   <div id="fileInputNewUser" style="margin-bottom:10px">
   </div>
   <div class="progress">
      </div>
   <div style="margin-bottom:10px">
    <input type="date" name="DateVidv" class="easyui-textbox" required="true" label="Дата выдвижения:" style="width:100%">
   </div>
   <div style="margin-bottom:10px">
    <input type="date" name="DateReg" class="easyui-textbox" label="Дата регистрации:" style="width:100%">
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
   <div id="fileInputUploadImg" style="margin-bottom:10px">
    </div>
    <div class="progress">
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
   <div class="progress">
      </div>
</form>
</div>
<div id="dlg-buttons-registration">
  <a href="javascript:void(0);" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveFile()" style="width:90px;text-align:center;">Сохранить</a>
  <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgRegistration').dialog('close');" style="width:90px;">Отмена</a>
 </div>

 <div id="dlgCheck" class="easyui-dialog" style="width:500px;height: 600px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons-check'">
<form id="fmCheck" method="post" enctype="multipart/form-data" novalidate style="margin:0;padding:20px 50px">
<h3>Отметка кандидата</h3>
<div style="margin-bottom:10px">
    <input id = "checkDateVidv" name="checkDateVidv" class="easyui-textbox" label="Отметка:" style="width:100%">
   </div>
</form>
</div>
<div id="dlg-buttons-check">
  <a href="javascript:void(0);" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveCheck()" style="width:90px;text-align:center;">Ок</a>
  <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCheck').dialog('close');" style="width:90px;">Отмена</a>
 </div>

 <h3 class="info">Телефон тех. поддержки 077835290</h3>
 <script type="text/javascript" src="assets/js/scriptadmin.js"></script>
</body>
</html>