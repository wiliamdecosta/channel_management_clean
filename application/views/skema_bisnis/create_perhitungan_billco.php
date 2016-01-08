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
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pilih Template </label>
                <div class="col-sm-6">
                    <select class="form-control" id="contract">
                        <option value=""> Bahasa Indonesia </option>
                        <option value="1"> English </option>
                        <option value="2"> Billingual </option>
                        <option value="3"> Skema Custom </option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Bulan MF </label>
                
                <div class="col-sm-6">   
                    <div class="input-daterange input-group" id="bulanmf">
                      <input type="text" name="start" />
                      s.d
                      <input type="text" name="end" />
                    </div>
                </div> 
                
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tgl Penandatangan BA </label>
                <div class="col-sm-6">
                    <input type="date" name="tgl_penandatangan_ba" id="tgl_penandatangan_ba" />
                </div>
               
            </div>
        </div>
        
        <div class="col-xs-12">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">EAM</label>
                <div class="col-sm-2">
                    <input type="text" id="form-field-1-1" placeholder="Ketik Nama EAM" class="form-control col-sm-4" value=""/> 
                </div>
                <div class="col-sm-2">
                    <input type="text" id="form-field-1-1" placeholder="Jabatan" class="form-control col-sm-4" value=""/> 
                </div>
                <div class="col-sm-4">
                    <a class="btn btn-sm btn-primary"> Save </a>
                    <a class="btn btn-sm btn-warning"> Edit </a>
                    <a class="btn btn-sm btn-danger"> Delete </a>   
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">GM Segmen</label>
                <div class="col-sm-2">
                    <input type="text" id="form-field-1-1" placeholder="Nama GM ESS" class="form-control col-sm-4" value=""/> 
                </div>
                <div class="col-sm-2">
                    <input type="text" id="form-field-1-1" placeholder="Jabatan" class="form-control col-sm-4" value=""/> 
                </div>
                <div class="col-sm-4">
                    <a class="btn btn-sm btn-primary"> Save </a>
                    <a class="btn btn-sm btn-warning"> Edit </a>
                    <a class="btn btn-sm btn-danger"> Delete </a>   
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1">FBCC</label>
                <div class="col-sm-2">
                    <input type="text" id="form-field-1-1" placeholder="Nama FBCC" class="form-control col-sm-4" value=""/> 
                </div>
                <div class="col-sm-2">
                    <input type="text" id="form-field-1-1" placeholder="Jabatan" class="form-control col-sm-4" value=""/> 
                </div>
                <div class="col-sm-4">
                    <a class="btn btn-sm btn-primary"> Save </a>
                    <a class="btn btn-sm btn-warning"> Edit </a>
                    <a class="btn btn-sm btn-danger"> Delete </a>   
                </div>
            </div>

        </div>
                
        
    </div>
        
    <div id="button-form" class="">
        <span id="group1">
            <a class="btn btn-white btn-sm btn-info btn-bold">
                Add Penandatanganan
            </a>
            <a class="btn btn-white btn-sm btn-info btn-bold">
                Insert MF Calculation
            </a>
            <a class="btn btn-white btn-sm btn-info btn-bold">
                View Detail BA Rekonsiliasi
            </a>
            
        </span>
        
    </div>
    <hr>
    <div id="button-form" class="">
        <span id="group2" style="float: right">
            <a class="btn btn-white btn-sm btn-info btn-bold">
                Print
            </a>
            <a class="btn btn-white btn-sm btn-info btn-bold">
                Save
            </a>
            <a class="btn btn-white btn-sm btn-info btn-bold">
                Delete
            </a>
        </span>
    </div>
    
    
    </form>

</div>
<script>
$('#bulanmf').datepicker({autoclose:true});

$('#tgl_penandatangan_ba').datepicker({
   autoclose: true,
   todayHighlight: true
})
</script>