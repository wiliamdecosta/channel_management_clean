<div id="content-mitra">
<!--    <div id="group1">-->
<!--         <a class="btn btn-white btn-info btn-round">-->
<!--            <i class="ace-icon fa fa-plus bigger-120 green"></i>-->
<!--                Add Mitra-->
<!--          </a>-->
<!--    </div>-->
    <br>
    <form class="form-horizontal" role="form" id="mitraForm">
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Methods </label>
                <div class="col-sm-6">
                    <select class="form-control" id="contract">
                        <option value="">Net/Gros </option>
                        <option value="1">...</option>
                        <option value="2">....</option>
                        <option value="3">.....</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pilih Skema Bisnis </label>
                <div class="col-sm-6">
                    <select class="form-control" id="select_skema_bisnis">
                        <option value=""> - Pilih Skema Bisnis - </option>
                        <option value="revenue_sharing"> Revenue Sharing </option>
                        <option value="wholesale"> Wholesale </option>
                        <option value="one_time_charge"> One Time Charge </option>
                        <option value="skema_custom"> Skema Custom</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> <span id="benefit_mitra_caption">Benefit Mitra</span> </label>
                <div class="col-sm-6">
                    <select class="form-control" id="select_benefit_mitra">
                        <!-- <option value="createSkemaDetailProduk"> Produk </option>
                        <option value="createSkemaBlended"> Blended </option>
                        <option value="createSkemaRC100"> Revenue Commitment = 100% </option>
                        <option value="createSkemaRCGreater100"> Revenue Commitment > 100%  </option> -->
                    </select>
                    
                </div>
            </div>
        </div>
        
        <div class="col-xs-12" id="benefit_mitra_detail">
            <!-- on select benefit mitra -->
        </div>
        
    </div>
        
    </form>

</div>

<script type="text/javascript">
     
    function get_benefit_mitra_detail(id) {
        if(id == "") {
            $("#benefit_mitra_detail").html("");
            return;
        }
        
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url();?>skema_bisnis/"+id,
            data: {},
            timeout: 10000,
            success: function(data) {
                $("#benefit_mitra_detail").html(data);
            }
        })
    }
            
    jQuery(function($) {
        
        $('#select_benefit_mitra').on('change', function() {
            get_benefit_mitra_detail(this.value);
        });
        
        $('#select_skema_bisnis').on('change', function() {
              $("#benefit_mitra_detail").html(""); 
              
              
              switch(this.value) {
                    
                    case 'revenue_sharing' :
                        $('#benefit_mitra_caption').val('Benefit Mitra');
                        $('#select_benefit_mitra').find('option').remove();
                        $('#select_benefit_mitra').append('<option value=""> -- Pilih Benefit Mitra --</option>');
                        $('#select_benefit_mitra').append('<option value="createSkemaDetailProduk"> Produk </option>');   
                        $('#select_benefit_mitra').append('<option value="createSkemaBlended"> Blended </option>');
                    break;   
                    
                    case 'wholesale' :
                        $('#benefit_mitra_caption').val('Type Wholesale');
                        $('#select_benefit_mitra').find('option').remove();
                        $('#select_benefit_mitra').append('<option value=""> -- Pilih Benefit Mitra --</option>');
                        $('#select_benefit_mitra').append('<option value="createSkemaRC100"> Revenue Commitment = 100%  </option>');   
                        $('#select_benefit_mitra').append('<option value="createSkemaRCGreater100"> Revenue Commitment > 100%  </option>');
                        $('#select_benefit_mitra').append('<option value="createSkemaPAYG"> Pay as you grow (PAYG)  </option>');
                    break; 
                    
                    default :
                        $('#select_benefit_mitra').find('option').remove();
                    break;
              }
        });
        
    });
</script>