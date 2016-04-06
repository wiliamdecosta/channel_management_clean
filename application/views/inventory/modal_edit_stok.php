<div id="modal_edit_stok" class="modal fade" role="dialog" style="z-index:1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $title;?></h4>
            </div>
            <form role="form" id="form_edit_stok" method="post" class="form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <div class="widget-main">

                            <div class="form-group">
                                <div id="label" class="col-xs-12 col-sm-3 no-padding-right">
                                    <label>Nama Item</label>
                                </div>
                                <div class="col-xs-9">
                                    <div class="clearfix">
                                        <?php buatcombo_new('form_list_item',
                                            'form_list_item',
                                            'P_INVENTORY',
                                            'ITEM_NAME',
                                            'P_INVENTORY_ID',
                                            null,
                                            'Plih Item',
                                            'ITEM_NAME',
                                            'ASC'

                                        ); ?>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div id="label" class="col-xs-3">
                                    <label>Jumlah item</label>
                                </div>
                                <div class="col-xs-3">
                                    <div class="clearfix">
                                        <input type="text" id="qty" name="qty" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                   value="<?php echo
                                   $this->security->get_csrf_hash(); ?>">
                            <!--                            <input type="hidden" name="pgl_id" id="pgl_id" value="-->
                            <?php //echo $pgl_id;?><!--">-->
                            <input type="hidden" name="action" value="<?php echo $code;?>" required>
                            <div id="output" class="row">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="btn_submit">Submit</button>
                </div>
            </form>


        </div>
    </div>
</div>
<script type="text/javascript">
    var validator = $("#form_edit_stok").validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: true,
        ignore: "",
        rules: {
            qty: {
                required: true,
                digits: true
            },
            form_list_item: {
                required: true
            }
        },

        highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
        },

        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
            $(e).remove();
        },

        errorPlacement: function (error, element) {
            if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                var controls = element.closest('div[class*="col-"]');
                if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            }
            else if (element.is('.select2')) {
                error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            }
            else if (element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            }
            else error.insertAfter(element.parent());
        },

        submitHandler: function (form) {
        },
        invalidHandler: function (form) {
        }
    });


</script>
<script type="text/javascript">

    $("#form_edit_stok").on('submit', (function (e) {
        e.preventDefault();
        var form = $('#form_edit_stok');
        //alert(form.valid());
        if(form.valid() == true){
            var data = $(this).serializeArray();
            $.ajax({
                url: "<?php echo site_url('inventory/editStokActon');?>",
                type: "POST",
                data: data,
                dataType: "json",
                success: function (data)
                {
                    if (data.success == true) {
                         var grid = $("#grid-table");
                         swal("", data.message, "success")
                         grid.trigger("reloadGrid", [{page: 1}]);
                         $("#modal_edit_stok").modal("hide");
                    } else {
                    swal("", data.message, "error")

                    }
                }
            });
        }else{
            return false;
        }


    }));

</script>