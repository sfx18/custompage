var selectRaion,selectNumKom,termDateVidv;

function upload(file, path) {

    var xhr = new XMLHttpRequest();

    // обработчик для отправки
    xhr.upload.onprogress = function (event) {
        jQuery('.progress').text('Загружено ' + Math.round((event.loaded) / 1024) + 'KB' + ' из ' + Math.round((event.total) / 1024) + 'KB');
        jQuery('.progressmsg').text('Пожалуйста подождите...');
    }

    // обработчики успеха и ошибки
    // если status == 200, то это успех, иначе ошибка
    xhr.onload = xhr.onerror = function () {
        if (this.status == 200) {
            msg = 'File uploaded success';
            console.log(msg);
        } else {
            msg = 'Error uploaded file ';
            console.log(msg + this.status);
        }
    };

    xhr.open("POST", path, true);
    xhr.send(file);

}

function doSearch() {
    $('#dg').datagrid('load', {
        term: $('#term').val(),
    });
}

function doSearchClear() {
    document.getElementById('term').value = '';
    $('#dg').datagrid('reload', {
    });
}

var url;
function newUser() {
    $('.progress').text('');
    jQuery('.progressmsg').text('');
    $('#fileInputNewUser').html('<input type="file" id ="avatar" name="avatar" accept=".docx, .doc" required="true" style="width:100%">');
    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Новый кандидат');
    $('#fm').form('clear');
    url = 'vendor/addData.php';
}
function editUser() {
    $('.progress').text('');
    jQuery('.progressmsg').text('');
    $('#fileInputNewUser').html('');
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Изменить');
        $('#fm').form('load', row);
        url = 'vendor/editData.php?id=' + row.id;
    } else { alert('Выберите строку!') }
}
function uploadImg() {
    $('.progress').text('');
    jQuery('.progressmsg').text('');
    $('#fileInputUploadImg').html('<input type="file" id ="avatar" name="avatar" style="width:100%">');
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlgUploadImg').dialog('open').dialog('center').dialog('setTitle', 'Загрузить');
        $('#fmUploadImg').form('load', row);
        url = 'vendor/uploadImg.php?id=' + row.id;
    } else { alert('Выберите строку!') }
}

function fileList() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $('#dlgFileList').dialog('open').dialog('center').dialog('setTitle', 'Список загруженных файлов');

        jQuery.ajax({
            url: "vendor/fileList.php",
            method: "POST",
            data: { id: row.id },
            dataType: "html",
            success: function (data) {
                jQuery('.fileList').html(data);
            }
        });
    } else { alert('Выберите строку!') }
}

function saveImg() {
    $('#fmUploadImg').form('submit', {
        url: url,
        onSubmit: function () {
            var input = this.elements.avatar;
            var file = input.files[0];
            if (file) {
                upload(file, "../vendor/uploadImg.php");
            }
            return $(this).form('validate');
        },
        success: function (response) {
            var respData = $.parseJSON(response);
            console.log(respData.check);
            if (respData.status == 0) {
                $.messager.show({
                    title: 'Ошибка',
                    msg: respData.msg
                });
            } else {
                $.messager.show({
                    title: 'Оповещение',
                    msg: respData.msg
                });
                $('#dlgUploadImg').dialog('close');
                $('#dg').datagrid('reload');
            }
        }
    });
}

function saveFile() {
    $('#fmRegistration').form('submit', {
        url: url,
        onSubmit: function () {
            var input = this.elements.avatar;
            var file = input.files[0];
            if (file) {
                upload(file, "../vendor/uploadFile.php");
            }
            return $(this).form('validate');
        },
        success: function (response) {
            var respData = $.parseJSON(response);
            console.log(respData.check);
            if (respData.status == 0) {
                $.messager.show({
                    title: 'Ошибка',
                    msg: respData.msg
                });
            } else {
                $.messager.show({
                    title: 'Оповещение',
                    msg: respData.msg
                });
                $('#dlgRegistration').dialog('close');
                $('#dg').datagrid('reload');
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

function saveFileRevocation(){
    jQuery('#fmRevocation').form('submit',{
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
        jQuery('#dlgRevocation').dialog('close');
        jQuery('#dg').datagrid('reload');
    }
}
});
}


function saveUser() {
    $('#fm').form('submit', {
        url: url,
        onSubmit: function () {
            var input = this.elements.avatar;
            var file = input.files[0];
            if (file) {
                upload(file, "../vendor/addData.php");
            }
            return $(this).form('validate');
        },
        success: function (response) {
            var respData = $.parseJSON(response);
            console.log(respData.check);
            if (respData.status == 0) {
                $.messager.show({
                    title: 'Ошибка',
                    msg: respData.msg
                });
            } else {
                $.messager.show({
                    title: 'Оповещение',
                    msg: respData.msg
                });
                $('#dlg').dialog('close');
                $('#dg').datagrid('reload');
            }
        }
    });
}


function destroyUser() {
    var row = $('#dg').datagrid('getSelected');
    if (row) {
        $.messager.confirm('Подтвердите', 'Вы действительно хотите удалить кандидата?', function (r) {
            if (r) {
                $.post('vendor/deleteData.php', { id: row.id }, function (response) {
                    if (response.status == 1) {
                        $('#dg').datagrid('reload');
                    } else {
                        $.messager.show({
                            title: 'Error',
                            msg: respData.msg
                        });
                    }
                }, 'json');
            }
        });
    } else { alert('Выберите строку!') }
}

function registration() {
    $('.progress').text('');
    jQuery('.progressmsg').text('');
    $('#fileInputUploadFile').html('<input type="file" accept=".docx, .doc" id ="avatar" name="avatar" style="width:100%">');
    var row = $('#dg').datagrid('getSelected');
    
    if (row) {
        $('#dlgRegistration').dialog('open').dialog('center').dialog('setTitle', 'Зарегистрировать');
        $('#fmRegistration').form('load', row);
        url = 'vendor/uploadFile.php?id=' + row.id;
    } else { alert('Выберите строку!') }
    if ((row.DateReg2 || row.DateRegRefusal2 || row.DateRevocation2) != '') {
        alert('Дата регистрации/отказа/отзыва документов уже назначена');
        $('#dlgRegistration').dialog('close');
        return false;
    }
}

function registrationRefusal(){
    $('.progress').text('');
    jQuery('.progressmsg').text('');
    jQuery('#fileInputUploadFileRefusal').html('<input type="file" accept=".docx, .doc" id ="avatar" name="avatar" style="width:100%">');
        var row = jQuery('#dg').datagrid('getSelected');
        
        if (row){
            jQuery('#dlgRegistrationRefusal').dialog('open').dialog('center').dialog('setTitle','Отказ');
            jQuery('#fmRegistrationRefusal').form('load',row);
            url = 'vendor/uploadFileRefusal.php?id='+row.id;
        }else{alert('Выберите строку!')}
        if ((row.DateReg2 || row.DateRegRefusal2 || row.DateRevocation2) != '') {
            alert('Дата регистрации/отказа/отзыва документов уже назначена');
            $('#dlgRegistrationRefusal').dialog('close');
            return false;
        }
}

function revocation(){
    $('.progress').text('');
    jQuery('.progressmsg').text('');
    jQuery('#fileInputUploadFileRevocation').html('<input type="file" accept=".docx, .doc" id ="avatar" name="avatar" style="width:100%">');
        var row = jQuery('#dg').datagrid('getSelected');
        
        if (row){
            jQuery('#dlgRevocation').dialog('open').dialog('center').dialog('setTitle','Отзыв');
            jQuery('#fmRevocation').form('load',row);
            url = 'vendor/uploadFileRevocation.php?id='+row.id;
        }else{alert('Выберите строку!')}
        if ((row.DateReg2 || row.DateRegRefusal2 || row.DateRevocation2) != '') {
            alert('Дата регистрации/отказа/отзыва документов уже назначена');
            $('#dlgRevocation').dialog('close');
            return false;
        }
}
