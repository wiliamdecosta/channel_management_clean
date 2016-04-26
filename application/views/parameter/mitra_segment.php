<script type="text/javascript">
    function load_mapping_mitra() {
        var menu_id = '<?php echo $menu_id;?>';
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url();?>parameter/mapping_mitra",
            data: {menu_id:menu_id},
            timeout: 10000,
            success: function (data) {
                $("#mappingmitra").html(data);
            }
        });
    }
</script>
<div class="breadcrumbs" id="breadcrumbs">
    <?= $this->breadcrumb; ?>
</div>
&nbsp;
<div id="mappingmitra">
    <script type="text/javascript">
         $(document).ready(function () {
            load_mapping_mitra();
         });
    </script>
</div>

