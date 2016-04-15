<!-- #section:basics/content.breadcrumbs -->
<style>
    .pointer {
        cursor:pointer;
    }
</style>
<div class="breadcrumbs" id="breadcrumbs">
    <?php echo getBreadcrumb(array('Workflow Summary')); ?>
</div>

<div class="page-content">
    <div class="col-xs-4" id="summary-panel">

    </div>
</div>

<script>
    
    $(function() {

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('wf/summary_list');?>',
            data: {P_W_DOC_TYPE_ID : <?php echo $this->input->post('P_W_DOC_TYPE_ID'); ?> },
            timeout: 10000,
            success: function(data) {
                 $("#summary-panel").html(data);
            }
        });

    });
</script>