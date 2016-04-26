<div id="content">
    <div class="breadcrumbs" id="breadcrumbs">
        <?= $this->breadcrumb; ?>
    </div>
    <div class="page-content">
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="mytab">
                <li class="tab" id="list_item">
                    <a href="javascript:void(0)">List Item</a>
                </li>

                <li class="tab" id="list_request">
                    <a href="javascript:void(0)">List Request</a>
                </li>

            </ul>

            <div class="tab-content">
                <div id="main_content" style="min-height: 400px;">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.tab').click(function (e) {
            var menu_id = '<?php echo $menu_id;?>';
            var ctrl = $(this).attr('id');

            $('.tab').removeClass('active');
            $('#' + ctrl).addClass('active');
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url();?>inventory/" + ctrl,
                data: {menu_id:menu_id},
                timeout: 10000,
                //async: false,
                success: function (data) {
                    $("#main_content").html(data);
                }
            })
            return false;
        })
    })

</script>