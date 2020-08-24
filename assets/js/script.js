
    jQuery('#raion').change(function(){
        var selectRaion = jQuery('#raion option:selected').text();
        if(selectRaion == 'Выберите ОИК/ТИК'){
            selectRaion = '';
        }else{
            selectRaion = jQuery('#raion option:selected').text();
        }
        jQuery('#dg').datagrid('load', {
        term: selectRaion
        });
    });

    function upload(file, path) {

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
      
        xhr.open("POST", path, true);
        xhr.send(file);
    
      }
    
    function doSearch(){
        $('#dg').datagrid('load', {
        term: $('#term').val()
        });
    }
        
    var url;
    function newUser(){
        $('.progress').text('');
        $('#fileInputNewUser').html('<input type="file" id ="avatar" name="avatar" accept=".docx, .doc" required="true" style="width:100%">');
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Новый кандидат');
        $('#fm').form('clear');
        url = 'vendor/addData.php';
    }
    function editUser(){
        $('.progress').text('');
        $('#fileInputNewUser').html('');
        var row = $('#dg').datagrid('getSelected');
        if (row){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','Изменить');
            $('#fm').form('load',row);
            url = 'vendor/editData.php?id='+row.id;
        }else{alert('Выберите строку!')}
    }
    function uploadImg(){
        $('.progress').text('');
        $('#fileInputUploadImg').html('<input type="file" id ="avatar" name="avatar" style="width:100%">');
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlgUploadImg').dialog('open').dialog('center').dialog('setTitle','Загрузить');
                $('#fmUploadImg').form('load',row);
                url = 'vendor/uploadImg.php?id='+row.id;
            }else{alert('Выберите строку!')}
    }

   function fileList(){
        var row = $('#dg').datagrid('getSelected');
        if (row){
            $('#dlgFileList').dialog('open').dialog('center').dialog('setTitle','Список загруженных файлов');
            
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
        $('#fmUploadImg').form('submit',{
        url: url,
        onSubmit: function(){
            var input = this.elements.avatar;
            var file = input.files[0];
            if (file) {
              upload(file, "../vendor/uploadImg.php");
            }
        return $(this).form('validate');
        },
        success: function(response){
            console.log(response);
        var respData = $.parseJSON(response);
        if(respData.status == 0){
            $.messager.show({
                title: 'Ошибка',
                msg: respData.msg
            });
        }else{
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

    function saveFile(){
        $('#fmRegistration').form('submit',{
        url: url,
        onSubmit: function(){
            var input = this.elements.avatar;
            var file = input.files[0];
            if (file) {
            upload(file, "../vendor/uploadFile.php");
            }
        return $(this).form('validate');
        },
        success: function(response){
            console.log(response);
        var respData = $.parseJSON(response);
        if(respData.status == 0){
            $.messager.show({
                title: 'Ошибка',
                msg: respData.msg
            });
        }else{
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


    function saveUser(){
        $('#fm').form('submit',{
        url: url,
        onSubmit: function(){
            var input = this.elements.avatar;
            var file = input.files[0];
            if (file) {
            upload(file, "../vendor/addData.php");
            }
        return $(this).form('validate');
        },
        success: function(response){
        var respData = $.parseJSON(response);
        if(respData.status == 0){
            $.messager.show({
                title: 'Ошибка',
                msg: respData.msg
            });
        }else{
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


    function destroyUser(){
        var row = $('#dg').datagrid('getSelected');
        if (row){
        $.messager.confirm('Подтвердите','Вы действительно хотите удалить кандидата?',function(r){
        if (r){
        $.post('vendor/deleteData.php', {id:row.id}, function(response){
            if(response.status == 1){
            $('#dg').datagrid('reload');
            }else{
            $.messager.show({
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
        if(jQuery('#DateReg2') == ''){alert('Кандидат уже зарегистрирован');}
        $('.progress').text('');
        $('#fileInputUploadFile').html('<input type="file" accept=".docx, .doc" id ="avatar" name="avatar" style="width:100%">');
            var row = $('#dg').datagrid('getSelected');
            if(row.DateReg2 != ''){
                alert('Кандидат уже зарегистрирован'); 
                return false;}
            if (row){
                $('#dlgRegistration').dialog('open').dialog('center').dialog('setTitle','Зарегистрировать');
                $('#fmRegistration').form('load',row);
                url = 'vendor/uploadFile.php?id='+row.id;
            }else{alert('Выберите строку!')}
    }