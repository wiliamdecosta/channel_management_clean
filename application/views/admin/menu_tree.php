<?php $prv = getPrivilege($menu_id); ?>
<div class="widget-box widget-color-blue">
    <div class="widget-header">
        <h4 class="widget-title lighter smaller">Daftar Menu</h4>
    </div>

    <div style="margin-left:10px;">
        <input type="checkbox" name="all" id="all" value="">All<br>
        <?php if($prv['UBAH'] == "Y"){
            echo '<button class="btn btn-sm btn-primary" id="save">Save</button></div>';
        };?>



    <div class="widget-body">
        <div class="widget-main padding-8">
             <div id='jqxTree' style='visibility: hidden;'>

             </div>
             <div>
                <input type="hidden" name="prof_id" id="prof_id" value="<?= $prof_id;?>">
             </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('#jqxTree').css('visibility', 'visible');

        $('#save').click(function () {
            var str = [];
            var uncheck_val = [];
            var items = $('#jqxTree').jqxTree('getCheckedItems');
            var itemsUn = $('#jqxTree').jqxTree('getUncheckedItems');

            for (var i = 0; i < items.length; i++) {
                var item = items[i];
                str[i]= item.value ;
            }

            for (var u = 0; u < itemsUn.length; u++) {
                var uncheck = itemsUn[u];
                uncheck_val[u]= uncheck.value ;
            }
            var menu_id = '<?php echo $menu_id;?>';
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/updateProfile');?>',
                data: {check_val:str,uncheck_val:uncheck_val, prof_id:<?= $prof_id;?>,menu_id : menu_id},
                timeout: 10000,
                success: function(data) {
                    $("#menutreAjax").html(data);
                    $('#jqxTree').jqxTree('refresh');
                }
            })
        });
        $('#selectall').click(function(event) {
            $('#jqxTree').jqxTree('checkAll');
        });
        $('#all').on('change', function (event) {
            if($(this).is(':checked')){
                $('#jqxTree').jqxTree('checkAll');
            }else{
                $('#jqxTree').jqxTree('uncheckAll');
            }

        });
        $('#jqxTree').on('checkChange', function (event) {

            var args = event.args;
            var checked = args.checked;
            var element = args.element;
            var items_check = $('#jqxTree').jqxTree('getCheckedItems');
            var items_uncheck = $('#jqxTree').jqxTree('getUncheckedItems');
            var item = items_check[0];
            var checkString = checked ? 1 :  0; // 1:checked , 0:unchecked


           // alert(checkString + ''  + items_check);
            return false;
            if(checkString == '1'){

                item = items_check[0].value;
            }else{

                item = items_uncheck[0].value;
            }


            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/updateProfile');?>',
                data: {check:checkString,check_val:item, prof_id:<?= $prof_id;?>},
                timeout: 10000,
                success: function(data) {
                    $("#menutreAjax").html(data);
                }
            })
        });

    });
</script>
<script>
    $(document).ready(function () {
        // prepare the data
        var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id' },
                { name: 'parentid' },
                { name: 'text' },
                { name: 'value' },
                { name: 'checked' },
                { name: 'app_menu_profile_id' }
            ],
            id: 'id',
            url: '<?php echo site_url('admin/getMenuTreeJson');?>/<?= $prof_id;?>',
            async: false
//            localdata: data
        };
        // create data adapter.
        var dataAdapter = new $.jqx.dataAdapter(source);
        // perform Data Binding.
        dataAdapter.dataBind();
        // get the tree items. The first parameter is the item's id. The second parameter is the parent item's id. The 'items' parameter represents
        // the sub items collection name. Each jqxTree item has a 'label' property, but in the JSON data, we have a 'text' field. The last parameter
        // specifies the mapping between the 'text' and 'label' fields.
        var records = dataAdapter.getRecordsHierarchy('id', 'parentid', 'items', [{ name: 'text', map: 'label'}]);
        $('#jqxTree').jqxTree({
            source: records,
            checkboxes: true,
            height: '300px'
//            hasThreeStates: true,
//            theme: 'energyblue'
        });


        $("#jqxTree").on('select', function (event) {
                var args = event.args;
                var item = $('#jqxTree').jqxTree('getItem', args.element);
                var app_menu_profile_id;
                var id = args.element.id;
                var recursion = function (object) {
                    for (var i = 0; i < object.length; i++) {
                        if (id == object[i].id) {
                            app_menu_profile_id = object[i].app_menu_profile_id;
                            break;
                        } else if (object[i].items) {
                            recursion(object[i].items);
                        };
                    };
                };
                recursion(records);

                if(app_menu_profile_id == "") {
                    $('#save-privilege').hide();
                    $('#privilege-table').css('visibility', 'visible');
                    $('#privilege-title').text('Setting Privilege');
                    $('#privilege-content').html('Setting privilege belum bisa dilakukan. Checklist dan simpan menu yang bersangkutan terlebih dahulu agar dapat mengatur privilege menu.');
                    $('#form-privelege').html('');
                }else {
                    $('#save-privilege').show();
                    $('#privilege-table').css('visibility', 'visible');
                    $('#privilege-title').text('Setting Privilege : ' + item.label);
                    $('#privilege-content').html('');
                    getPrivilegeTable(app_menu_profile_id);
                }

        });


        /*$('#save-privilege').click(function () {
            var options = {
                success:       showResponsePrivilegeFormSubmit  // post-submit callback
            };

            // bind to the form's submit event
            $("#form-privelege").ajaxSubmit(options);
            return false;
        });*/

    });

</script>

<script>

    $("#form-privelege").on('submit', (function (e) {

        e.preventDefault();
        var data = $(this).serialize();
       // data.append('ten_id', ten_id);
        $.ajax({
            url: "<?php echo site_url('admin/setPrivilegeMenu');?>", // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            cache: false,             // To unable request pages to be cached
            dataType: "json",
            success: function (data)   // A function to be called if request succeeds
            {
                if (data.success == true) {
                    swal("", data.msg, "success");
                    getPrivilegeTable(data.return_id);
                } else {
                    swal("", data.msg, "error");
                }
            }
        });
        return false;
    }));

    function getPrivilegeTable(the_id) {
        $("#form-privelege").html("");
        var menu_id = '<?php echo $menu_id;?>';
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url('admin/getPrivilegeMenuTable');?>",
            data: {app_menu_profile_id: the_id, menu_id : menu_id},
            success: function(data) {
                $("#form-privelege").html(data);
            }
        });

    }

    /*function showResponsePrivilegeFormSubmit(responseText, statusText, xhr, $form)  {
        swal("Berhasil", "Data berhasil disimpan", "success");
        getPrivilegeTable(responseText);
    } */

</script>