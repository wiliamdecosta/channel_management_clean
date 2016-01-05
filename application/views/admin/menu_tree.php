<div class="widget-box widget-color-blue">
    <div class="widget-header">
        <h4 class="widget-title lighter smaller">Daftar Menu</h4>
    </div>

    <div style="margin-left:10px;">
        <input type="checkbox" name="all" id="all" value="">All<br>
        <button class="btn btn-sm btn-primary" id="save">Save</button></div>

    <div class="widget-body">
        <div class="widget-main padding-8">
             <div id='jqxTree' style='visibility: hidden;'>

             </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('#jqxTree').css('visibility', 'visible');
        $('#save').click(function () {
            var str = [];
            var items = $('#jqxTree').jqxTree('getCheckedItems');
            for (var i = 0; i < items.length; i++) {
                var item = items[i];
                str[i]= item.value ;
            }
            //alert("The checked items are " + str);
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/updateProfile');?>',
                data: {check_val:str, prof_id:<?= $prof_id;?>},
                timeout: 10000,
                success: function(data) {
                    $("#menutreAjax").html(data);
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
<!--        $('#jqxTree').on('checkChange', function (event) {-->
<!--            var str_check = "";-->
<!--            var str_uncheck = "";-->
<!--            var items_check = $('#jqxTree').jqxTree('getCheckedItems');-->
<!--            var items_uncheck = $('#jqxTree').jqxTree('getUncheckedItems');-->
<!--            for (var c = 0; c < items_check.length; c++) {-->
<!--                var item_check = items_check[c];-->
<!--                str_check += item_check.label + ",";-->
<!--            }-->
<!--            for (var u = 0; u < items_uncheck.length; u++) {-->
<!--                var item_uncheck = items_uncheck[u];-->
<!--                str_uncheck += item_uncheck.label + ",";-->
<!--            }-->
<!--            //alert("The checked items are " + str_check + "Uncek" +str_uncheck);-->
<!---->
<!--            // AJax proses cek / uncek-->
<!--            $.ajax({-->
<!--                type: 'POST',-->
<!--                url: '--><?php //echo site_url('admin/updateProfile');?><!--',-->
<!--                data: {check:str_check , uncheck:str_uncheck,prof_id:--><?//= $prof_id;?><!--},-->
<!--                timeout: 10000,-->
<!--                success: function(data) {-->
<!--                    $("#menutreAjax").html(data);-->
<!--                    spinner.stop();-->
<!--                }-->
<!--            })-->
<!--        });-->


    });
</script>
<script type="text/javascript">
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
                { name: 'checked' }
//                { name: 'expanded' }

            ],
            id: 'id',
            url: '<?php echo site_url('admin/getMenuTreeJson');?>/<?= $prof_id;?>',
            async: false
//                        localdata: data
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
    });
</script>