<!-- #section:basics/content.breadcrumbs -->
<div class="breadcrumbs" id="breadcrumbs">
    <?php echo getBreadcrumb(array('Inbox')); ?>
</div>

<div class="page-content" id="inbox-panel">

</div>

<script>
    
    $(function() {

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('wf/list_inbox');?>',
            timeout: 10000,
            success: function(data) {
                 $("#inbox-panel").html(data);
            }
        });

    });
</script>