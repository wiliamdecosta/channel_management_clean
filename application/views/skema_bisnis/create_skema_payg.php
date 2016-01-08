<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1-1"> Type PAYG </label>
    <div class="col-sm-6">
        <select class="form-control" id="type_payg_option">
            <option value=""> -- Pilih Type PAYG -- </option>
            <option value="createSkemaPaygPositiveGrowth"> Positive Growth </option>
            <option value="createSkemaPaygNegativeGrowth"> Negative Growth </option>
        </select>
    </div>
</div>

<div id="payg_detail">
    
</div>

<script type="text/javascript">
     
    function get_payg_detail(id) {
        if(id == "") {
            $("#payg_detail").html("");
            return;
        }
        
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url();?>skema_bisnis/"+id,
            data: {},
            timeout: 10000,
            success: function(data) {
                $("#payg_detail").html(data);
            }
        })
    }
            
    jQuery(function($) {
        
        $('#type_payg_option').on('change', function() {
            get_payg_detail(this.value);
        });
        
    });
</script>