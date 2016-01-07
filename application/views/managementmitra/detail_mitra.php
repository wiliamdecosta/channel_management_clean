<div id="content-mitra">
    <br>
    <form class="form-horizontal" role="form" id="mitraForm">
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Contract Type </label>
                <div class="col-sm-6">
                    <select class="form-control required" id="contract">
                        <option value="">Kontrak </option>
                        <option value="1">...</option>
                        <option value="2">....</option>
                        <option value="3">.....</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Nama PIC </label>
                <div class="col-sm-6">
                    <input type="text" id="form-field-1-1" placeholder="Text Field" class="form-control required" value="Amirudin"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Jabatan </label>
                <div class="col-sm-6">
                    <input type="text" id="form-field-1-1" placeholder="Text Field" class="form-control" value="Direktur"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Alamat </label>
                <div class="col-sm-6">
                    <textarea class="form-control limited" id="form-field-9" maxlength="50">Gedung Attira Lt.9 Jl. Jendral Sudirman Kav 45 Jakarta</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-4 control-label no-padding-right" for="form-field-1-1">Email </label>
                <div class="col-sm-6">
                    <input type="text" id="form-field-1-1" placeholder="Text Field" class="form-control" value="amirudin@attira.com" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">No Telp </label>
                <div class="col-sm-6">
                    <input type="text" id="form-field-1-1" placeholder="Text Field" class="form-control" value="021-102938"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Fax</label>
                <div class="col-sm-6">
                    <input type="text" id="form-field-1-1" placeholder="Text Field" class="form-control" value="021-102934"/>
                </div>
            </div>
        </div>

        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Nama EAM</label>
                <div class="col-sm-6">
                    <input type="text" id="form-field-1-1" placeholder="Text Field" class="form-control" value="Sigit"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">NIK </label>
                <div class="col-sm-6">
                    <input type="text" id="form-field-1-1" placeholder="Text Field" class="form-control" value="740099"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">Email </label>
                <div class="col-sm-6">
                    <input type="text" id="email" placeholder="Text Field" class="form-control" value="sigit@telkom.co.id"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right" for="form-field-1-1">No Hp </label>
                <div class="col-sm-6">
                    <input type="text" id="form-field-1-1" placeholder="Text Field" class="form-control" value="081290237909"/>
                </div>
            </div>
        </div>
    </div>
        <hr>
    <div id="button-form" class="">
        <span id="group1" style="float: left">
            <button class="btn btn-white btn-info btn-bold">
                <i class="ace-icon fa fa-cloud-download bigger-120 green"></i>
                Download
            </button>
            <button class="btn btn-white btn-info btn-bold">
                <i class="ace-icon fa fa-print bigger-120 green"></i>
                Print
            </button>
        </span>
        <span id="group2" style="float: right">
            <a class="btn btn-white btn-info btn-bold" id="save">
                <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                Save
            </a>
            <a class="btn btn-white btn-warning btn-bold" id="edit">
                <i class="ace-icon fa fa-pencil-square-o bigger-120 orange"></i>
                Edit
            </a>
            <a class="btn btn-white btn-default btn-bold">
                <i class="ace-icon fa fa-times red2"></i>
                Delete
            </a>
        </span>
    </div>

    </form>
<script type="text/javascript">
    $('#mitraForm').find('input[type=text],select,textarea').each(function() {
        $(this).attr('disabled', true);
       // $('#contract').attr("disabled", true);
    })

    $("#edit").click(function(){
        $('#mitraForm').find('input[type=text],select,textarea').each(function() {
            $(this).attr('disabled', false);
            // $('#contract').attr("disabled", true);
        })
    });
    $("#save").click(function(){
        $('#mitraForm').find('input[type=text],select,textarea').each(function() {
            $(this).attr('disabled', true);
            // $('#contract').attr("disabled", true);
        })
    });



</script>

</div>