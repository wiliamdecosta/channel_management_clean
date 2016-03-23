<form class="form-horizontal" role="form">
    <div class="row">

        <div class="col-xs-8">
            <div id="notif">

            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Template Info </label>

                <div class="col-sm-6">
                  <label  for="form-field-1"> PKS / Skema Custom / Dokumen Bisnis </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Nama Table </label>

                <div class="col-sm-6">
                    <select class="form-control" id="mitra">
                        <option value="">Pilih Table</option>
                        <?php foreach ($result as $content){
                            echo "<option value='".$content->TABLE_NAME."'>".$content->TABLE_NAME."</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="table-header">
              Daftar Kolom table <span id="namatable"></span>
            </div>
            <table id="column-table" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>Nama Kolom</th>
                  <th>Tipe Data</th>
                  <th>  <button class="btn btn-xs btn-success">
                      <i class="ace-icon fa fa-plus smaller-120"></i>&nbsp;&nbsp;ALL
                    </button> <button class="btn btn-xs btn-danger">
                        <i class="ace-icon fa fa-minus smaller-120"></i>&nbsp;&nbsp;ALL
                      </button> </th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>
                    <a href="#">Kolom 1</a>
                  </td>
                  <td>
                    <a href="#">Kolom 1</a>
                  </td>
                  <td>
                      <button class="btn btn-xs btn-success">
                        <i class="ace-icon fa fa-plus smaller-100"></i>
                      </button>
                      <button class="btn btn-xs btn-danger">
                        <i class="ace-icon fa fa-minus smaller-100"></i>
                      </button>
                  </td>
                </tr>
              </tbody>
            </table>
        </div>
        <div class="col-xs-4">
          <div class="table-header">
              Daftar Variable Template
          </div>
          <table id="column-table" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>Nama Kolom</th>
                <th>Tipe Data</th>
                <th>  <button class="btn btn-xs btn-success">
                    <i class="ace-icon fa fa-plus smaller-120"></i>&nbsp;&nbsp;ALL
                  </button> <button class="btn btn-xs btn-danger">
                      <i class="ace-icon fa fa-minus smaller-120"></i>&nbsp;&nbsp;ALL
                    </button> </th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>
                  <a href="#">Kolom 1</a>
                </td>
                <td>
                  <a href="#">Kolom 1</a>
                </td>
                <td>
                    <button class="btn btn-xs btn-success">
                      <i class="ace-icon fa fa-plus smaller-100"></i>
                    </button>
                    <button class="btn btn-xs btn-danger">
                      <i class="ace-icon fa fa-minus smaller-100"></i>
                    </button>
                </td>
              </tr>
            </tbody>
          </table>
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
	//$(Document).ready(function(){

		//alert("Test 123");

	//});
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
			alert("test 123456");
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
