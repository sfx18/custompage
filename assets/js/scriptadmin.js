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



jQuery(document).ready(function(){

    




    jQuery('#raion').change(function(){
        var selectRaion = jQuery('#raion option:selected').text();
        if(selectRaion == 'Выберите ТИК'){
            selectRaion = '';
        }else{
            selectRaion = jQuery('#raion option:selected').text();
        }
        jQuery('#dg').datagrid('load', {
        term: selectRaion
        });
        
        if(selectRaion){
            jQuery.ajax({
                url:"vendor/selectData.php",
                method:"POST",
                data:{uRaionId:selectRaion},
                dataType:"html",
                success:function(data){
                    jQuery('#NumKom').html(data);
                    // jQuery('#NumKom').change(function(){
                    //     var selectNumKom = jQuery('#NumKom option:selected').text();
                    //                 if(selectNumKom == 'Выберите ТИК'){
                    //                     selectNumKom = '';
                    //                 }else{
                    //                     selectNumKom = jQuery('#NumKom option:selected').text();
                    //                 }
                    //                 jQuery('#dg').datagrid('load', {
                    //                 term: selectNumKom
                    //                 });
                    // });
                }
            })
        }else{
            jQuery('#NumKom').html('');
        }
        
       
    });
    jQuery('#NumKom').change(function(){
        var selectNumKom = jQuery('#NumKom option:selected').text();
                    if(selectNumKom == 'Выберите ТИК'){
                        selectNumKom = '';
                    }else{
                        selectNumKom = jQuery('#NumKom option:selected').text();
                    }
                    jQuery('#dg').datagrid('load', {
                    term: selectNumKom
                    });
    });

    
    
});

function doSearch(){
    jQuery('#dg').datagrid('load', {
    term: jQuery('#term').val()
    });
}
    
var url;
function newUser(){
    jQuery('#fileInputNewUser').html('<input type="file" id ="avatar" name="avatar" accept=".docx, .doc" required="true" style="width:100%">');
    jQuery('#dlg').dialog('open').dialog('center').dialog('setTitle','Новый кандидат');
    jQuery('#fm').form('clear');
    url = 'vendor/addData.php';
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
    jQuery('#fileInputUploadFile').html('<input type="file" accept=".docx, .doc" id ="avatar" name="avatar" style="width:100%">');
        var row = jQuery('#dg').datagrid('getSelected');
        if (row){
            jQuery('#dlgRegistration').dialog('open').dialog('center').dialog('setTitle','Зарегистрировать');
            jQuery('#fmRegistration').form('load',row);
            url = 'vendor/uploadFile.php?id='+row.id;
        }else{alert('Выберите строку!')}
}