<form class="form-horizontal" role="form">
    <div class="row">

        <div class="col-xs-6">
            <div id="notif">

            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Segmen </label>

                <div class="col-sm-6">
                    <select class="form-control" id="nama_segment">
                        <option value="">Pilih Segment</option>
                        <option value="2">Segment 2</option>
                        <option value="3">Segment 3</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nama Mitra </label>

                <div class="col-sm-6">
                    <select class="form-control" id="mitra">
                        <option value="">Pilih Mitra</option>
                        <?php foreach ($result as $content) {
                            echo "<option value='" . $content->PGL_ID . "'>" . $content->PGL_NAME . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nama CC </label>

                <div class="col-sm-6">
                    <select class="form-control" id="list_cc">
                        <option>Pilih CC</option>

                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nama Lokasi PKS </label>

                <div class="col-sm-6">
                    <?php echo buatcombo('doc_lang', 'doc_lang', 'DOC_LANG', 'DESCRIPTION', 'DOC_LANG_ID', null, 'Pilih Template'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nama User </label>

                <div class="col-sm-6">
                    <input type="text" placeholder="Ketik Nama User" class="input-xlarge required">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Password </label>

                <div class="col-sm-6">
                    <input type="text" placeholder="Password User" class="input-xlarge required">
                </div>
            </div>
        </div>
    </div>
    <hr>
    <span style="float: left" id="group2">
            <a id="save" class="btn btn-white btn-info btn-bold">
                <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                Save User
            </a>
            <a id="view_user" class="btn btn-white btn-success btn-bold">
                <i class="ace-icon fa fa-user bigger-120 green"></i>
                View All Active User
            </a>
        </span>
</form>


<script type="text/javascript">
    $("#mitra").change(function () {
        var mitra = $("#mitra").val();

        // Animasi loading

        if (mitra) {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "<?php echo site_url('cm/listTenant');?>",
                data: {id_mitra: mitra},
                success: function (msg) {
                    // jika tidak ada data
                    if (msg == '') {
                        alert('Tidak ada tenant');
                    }
                    else {
                        $("#list_cc").html(msg);
                    }
                }
            });
        } else {
            $("#list_cc").html('<option> Pilih CC </option>');
        }
    });

    $('#save').click(function () {
        $('#notif').html("<div class='alert alert-success'> "
            + "<button type='button' class='close' data-dismiss='alert'> "
            + "       <i class='ace-icon fa fa-times'></i> "
            + "   </button>"
            + "      <strong>"
            + "  <i class='ace-icon fa fa-times'></i>"
            + "     Sukses"
            + " </strong>"
            + "  1 User berhasil ditambahkan."
            + "    <br>"
            + " </div>");
    })
    $('#view_user').click(function () {
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo site_url('admin/user');?>",
            data: {title:'User'},
            success: function (data) {
                $("#main_content").html(data);
            }
        });
    })

</script>