

    jQuery('#raion').change(function(){
        var selectRaion = jQuery('#raion option:selected').text();
        if(selectRaion == 'Выберите ТИК'){
            selectRaion = '';
        }else{
            selectRaion = jQuery('#raion option:selected').text();
        }
        $('#dg').datagrid('load', {
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
                    //                 $('#dg').datagrid('load', {
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
                    $('#dg').datagrid('load', {
                    term: selectNumKom
                    });
    });

    
    function doSearch(){
        $('#dg').datagrid('load', {
        term: $('#term').val()
        });
    }
        
    var url;
    function newUser(){
        $('#fileInputNewUser').html('<input type="file" id ="avatar" name="avatar" accept=".docx, .doc" required="true" style="width:100%">');
        $('#dlg').dialog('open').dialog('center').dialog('setTitle','Новый кандидат');
        $('#fm').form('clear');
        url = 'vendor/addData.php';
    }
    function editUser(){
        $('#fileInputNewUser').html('');
        var row = $('#dg').datagrid('getSelected');
        if (row){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','Изменить');
            $('#fm').form('load',row);
            url = 'vendor/editData.php?id='+row.id;
        }else{alert('Выберите строку!')}
    }
    function uploadImg(){
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
        $('#fileInputUploadFile').html('<input type="file" accept=".docx, .doc" id ="avatar" name="avatar" style="width:100%">');
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlgRegistration').dialog('open').dialog('center').dialog('setTitle','Зарегистрировать');
                $('#fmRegistration').form('load',row);
                url = 'vendor/uploadFile.php?id='+row.id;
            }else{alert('Выберите строку!')}
    }