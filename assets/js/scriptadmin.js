var selectRaion,selectNumKom,termDateVidv,termDateReg;

function upload(file) {

    var xhr = new XMLHttpRequest();
  
    // обработчик для отправки
    xhr.upload.onprogress = function(event) {
        jQuery('.progress').text('Загружено ' + Math.round((event.loaded)/1024) + 'KB' + ' из ' + Math.round((event.total)/1024) + 'KB');
    }
  
    // обработчики успеха и ошибки
    // если status == 200, то это успех, иначе ошибка
    xhr.onload = xhr.onerror = function() {
      if (this.status == 200) {
          msg = 'success';
        console.log(msg);
      } else {
          msg = 'error ';
        console.log(msg + this.status);
      }
    };
  
    xhr.open("POST", "../vendor/uploadImg.php", true);
    xhr.send(file);

  }



  jQuery('#raion').change(function () {
    selectNumKom = '';
    selectRaion = jQuery('#raion option:selected').val();
    if (selectRaion == 0) {
        selectRaion = '';
    } else {
        selectRaion = jQuery('#raion option:selected').text();
    }
    jQuery('#dg').datagrid('load', {
        term: selectRaion,
    });

    if (selectRaion) {
        jQuery.ajax({
            url: "vendor/selectData.php",
            method: "POST",
            data: { uRaionId: selectRaion },
            dataType: "html",
            success: function (data) {
                jQuery('#NumKom').html(data);
            }
        })
    } else {
        jQuery('#NumKom').html('<option value="0">Выберите округ</option>');
        document.getElementById('termDateVidv').value = "";
        // document.getElementById('termDateReg').value = "";
    }
});
    jQuery('#NumKom').change(function () {
        document.getElementById('termDateVidv').value = "";
        // document.getElementById('termDateReg').value = "";
        selectNumKom = jQuery('#NumKom option:selected').val();
        if (selectNumKom == 0) {
            selectNumKom = '';
        } else {
            selectNumKom = jQuery('#NumKom option:selected').text();
        }
        jQuery('#dg').datagrid('load', {
            term: selectRaion,
            term2: selectNumKom,
        });
        if(!selectNumKom){
                document.getElementById('termDateVidv').value = "";
                // document.getElementById('termDateReg').value = "";
        }
    
    });


    jQuery('#termDateVidv').change(function () {
        termDateVidv = jQuery('#termDateVidv').val();
        // alert(termDateVidv);
        jQuery('#dg').datagrid('load', {
            term: selectRaion,
            term2: selectNumKom,
            termDateVidv: termDateVidv,
        });
    
    });
    jQuery('#termDateReg').change(function () {
        termDateReg = jQuery('#termDateReg').val();
        // alert(termDateReg);
        jQuery('#dg').datagrid('load', {
            term: selectRaion,
            term2: selectNumKom,
            termDateReg: termDateReg,
        });
    
    });
    // jQuery('#filter').onSubmit(function(){
    //     this.reset();
    // });
    


function doSearch(){
    jQuery('#dg').datagrid('load', {
        term: $('#term').val(),
        term2: $('#term2').val(),
        termDateVidv: $('#termDateVidv').val(),
        termDateReg: $('#termDateReg').val()
    });
}
    
var url;
function newUser(){
    jQuery('#fileInputNewUser').html('<input type="file" id ="avatar" name="avatar" accept=".docx, .doc" required="true" style="width:100%">');
    jQuery('#dlg').dialog('open').dialog('center').dialog('setTitle','Новый кандидат');
    jQuery('#fm').form('clear');
    url = 'vendor/addAdminData.php';
}
function editUser(){
    jQuery('#fileInputNewUser').html('');
    var row = jQuery('#dg').datagrid('getSelected');
    if (row){
        jQuery('#dlg').dialog('open').dialog('center').dialog('setTitle','Изменить');
        jQuery('#fm').form('load',row);
        url = 'vendor/editData.php?id='+row.id;
    }else{alert('Выберите строку!')}
}
function uploadImg(){
    jQuery('#fileInputUploadImg').html('<input type="file" id ="avatar" name="avatar" style="width:100%">');
        var row = jQuery('#dg').datagrid('getSelected');
        if (row){
            jQuery('#dlgUploadImg').dialog('open').dialog('center').dialog('setTitle','Загрузить');
            jQuery('#fmUploadImg').form('load',row);
            url = 'vendor/uploadImg.php?id='+row.id;
        }else{alert('Выберите строку!')}
}

function fileList(){
    var row = jQuery('#dg').datagrid('getSelected');
    if (row){
        jQuery('#dlgFileList').dialog('open').dialog('center').dialog('setTitle','Список загруженных файлов');
        
        jQuery.ajax({
            url:"vendor/fileList.php",
            method:"POST",
            data:{id:row.id},
            dataType:"html",
            success:function(data){
                jQuery('.fileList').html(data);
            }
        });
    }else{alert('Выберите строку!')}
}

function saveImg(){
    jQuery('#fmUploadImg').form('submit',{
        
    url: url,
    onSubmit: function(){
    var input = this.elements.avatar;
    var file = input.files[0];
    if (file) {
      upload(file, "../vendor/uploadImg.php");
    }
    return jQuery(this).form('validate');
    },
    success: function(response){
        // console.log(response);
    var respData = jQuery.parseJSON(response);
    if(respData.status == 0){
        jQuery.messager.show({
            title: 'Ошибка',
            msg: respData.msg
        });
    }else{
        jQuery.messager.show({
            title: 'Оповещение',
            msg: respData.msg
        });
        jQuery('#dlgUploadImg').dialog('close');
        jQuery('#dg').datagrid('reload');
    }
}
});
}

function saveFile(){
    jQuery('#fmRegistration').form('submit',{
    url: url,
    onSubmit: function(){
    return jQuery(this).form('validate');
    },
    success: function(response){
        console.log(response);
    var respData = jQuery.parseJSON(response);
    if(respData.status == 0){
        jQuery.messager.show({
            title: 'Ошибка',
            msg: respData.msg
        });
    }else{
        jQuery.messager.show({
            title: 'Оповещение',
            msg: respData.msg
        });
        jQuery('#dlgRegistration').dialog('close');
        jQuery('#dg').datagrid('reload');
    }
}
});
}

function saveFileRefusal(){
    jQuery('#fmRegistrationRefusal').form('submit',{
    url: url,
    onSubmit: function(){
    return jQuery(this).form('validate');
    },
    success: function(response){
        console.log(response);
    var respData = jQuery.parseJSON(response);
    if(respData.status == 0){
        jQuery.messager.show({
            title: 'Ошибка',
            msg: respData.msg
        });
    }else{
        jQuery.messager.show({
            title: 'Оповещение',
            msg: respData.msg
        });
        jQuery('#dlgRegistrationRefusal').dialog('close');
        jQuery('#dg').datagrid('reload');
    }
}
});
}


function saveUser(){
    jQuery('#fm').form('submit',{
    url: url,
    onSubmit: function(){
    return jQuery(this).form('validate');
    },
    success: function(response){
    var respData = jQuery.parseJSON(response);
    if(respData.status == 0){
        jQuery.messager.show({
            title: 'Ошибка',
            msg: respData.msg
        });
    }else{
        jQuery.messager.show({
            title: 'Оповещение',
            msg: respData.msg
        });
        jQuery('#dlg').dialog('close');
        jQuery('#dg').datagrid('reload');
    }
}
});
}

function saveCheck(){
    jQuery('#fmCheck').form('submit',{
    url: url,
    onSubmit: function(){
    return jQuery(this).form('validate');
    },
    success: function(response){
    var respData = jQuery.parseJSON(response);
    if(respData.status == 0){
        jQuery.messager.show({
            title: 'Ошибка',
            msg: respData.msg
        });
    }else{
        jQuery.messager.show({
            title: 'Оповещение',
            msg: respData.msg
        });
        jQuery('#dlgCheck').dialog('close');
        jQuery('#dg').datagrid('reload');
    }
}
});
}

function saveCheckReg(){
    jQuery('#fmCheckReg').form('submit',{
    url: url,
    onSubmit: function(){
    return jQuery(this).form('validate');
    },
    success: function(response){
    var respData = jQuery.parseJSON(response);
    if(respData.status == 0){
        jQuery.messager.show({
            title: 'Ошибка',
            msg: respData.msg
        });
    }else{
        jQuery.messager.show({
            title: 'Оповещение',
            msg: respData.msg
        });
        jQuery('#dlgCheckReg').dialog('close');
        jQuery('#dg').datagrid('reload');
    }
}
});
}


function destroyUser(){
    var row = jQuery('#dg').datagrid('getSelected');
    if (row){
    jQuery.messager.confirm('Подтвердите','Вы действительно хотите удалить кандидата?',function(r){
    if (r){
    jQuery.post('vendor/deleteData.php', {id:row.id}, function(response){
        if(response.status == 1){
        jQuery('#dg').datagrid('reload');
        }else{
        jQuery.messager.show({
        title: 'Error',
        msg: respData.msg
        });
        }
    },'json');
    }
    });
    }else{alert('Выберите строку!')}
}

function registration(){
    $('#fileInputUploadFile').html('<input type="file" accept=".docx, .doc" id ="avatar" name="avatar" style="width:100%">');
    var row = $('#dg').datagrid('getSelected');
    
    if (row) {
        $('#dlgRegistration').dialog('open').dialog('center').dialog('setTitle', 'Зарегистрировать');
        $('#fmRegistration').form('load', row);
        url = 'vendor/uploadFile.php?id=' + row.id;
    } else { alert('Выберите строку!') }
    if ((row.DateReg2 || row.DateRegRefusal2) != '') {
        alert('Дата регистрации/отказа уже назначена');
        $('#dlgRegistration').dialog('close');
        return false;
    }
}

function registrationRefusal(){
    jQuery('#fileInputUploadFileRefusal').html('<input type="file" accept=".docx, .doc" id ="avatar" name="avatar" style="width:100%">');
        var row = jQuery('#dg').datagrid('getSelected');
        
        if (row){
            jQuery('#dlgRegistrationRefusal').dialog('open').dialog('center').dialog('setTitle','Отказ');
            jQuery('#fmRegistrationRefusal').form('load',row);
            url = 'vendor/uploadFileRefusal.php?id='+row.id;
        }else{alert('Выберите строку!')}
        if ((row.DateReg2 || row.DateRegRefusal2) != '') {
            alert('Дата регистрации/отказа уже назначена');
            $('#dlgRegistrationRefusal').dialog('close');
            return false;
        }
}

function isCheckDateVidv(){
    var row = jQuery('#dg').datagrid('getSelected');
    if (row){
        jQuery('#fmCheck').form('load',row);
        url = 'vendor/checkDateVidv.php?id='+row.id;
        saveCheck();
    }else{alert('Выберите строку!')}
}

function isCheckDateReg(){
    var row = jQuery('#dg').datagrid('getSelected');
    if (row){
        jQuery('#fmCheck').form('load',row);
        url = 'vendor/checkDateReg.php?id='+row.id;
        saveCheckReg();
    }else{alert('Выберите строку!')}
}
