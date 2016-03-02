<script type="text/javascript">
    function load_mapping_mitra() {
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url();?>parameter/mapping_mitra",
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

