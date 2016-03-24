
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
                    <select class="form-control" id="tablename">
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
                  <th>  <button class="btn btn-xs btn-success" id="addall" onclick="AddOrDel_all('add',$('#tablename').val())">
                      <i class="ace-icon fa fa-plus smaller-120"></i>&nbsp;&nbsp;ALL
                    </button> <button class="btn btn-xs btn-danger" style="display:none;" id="delall" onclick="AddOrDel_all('del',$('#tablename').val())">
                        <i class="ace-icon fa fa-minus smaller-120"></i>&nbsp;&nbsp;ALL
                      </button> </th>
                </tr>
              </thead>

              <tbody id="namatable_body">
              
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
                <th>Nama Table</th>
                <th> <button class="btn btn-xs btn-danger">
                      <i class="ace-icon fa fa-minus smaller-120"></i>&nbsp;&nbsp;ALL
                    </button> </th>
              </tr>
            </thead>

            <tbody id="tablevariable_body">
              
            </tbody>
          </table>
        </div>
    </div>
</form>


<script type="text/javascript">
    
  
    function move_to_variable(elem) {
        //swal($(elem).attr("data"));
        data = $(elem).attr("data").split('|');
        column_name = data[0];
        tablename = data[1];
        var elemtable =  "<tr>"+
            "<td>"+
              column_name+
            "</td>"+
            "<td>"+
              tablename+
            "</td>"+
            "<td>"+
                "<a class='btn btn-xs btn-danger' onClick='javascript:move_to_variable(this);' id='del"+tablename+column_name+"'>"+
                  "<i class='ace-icon fa fa-minus smaller-100'></i>"+
                "</a>"+
            "</td>"+
         "</tr>";
         $('#tablevariable_body').html( $('#tablevariable_body').html()+elemtable);
        $(elem).css('display','none');
        $('#tr'+column_name+tablename).hide();
       // $('#del'+column_name+tablename).css('display','block');
    }
    
    function AddOrDel_all(act,tablename) {
        if (tablename) {
            swal(tablename);
        }else{
            swal('aaaaa');
        }
        
    }
    
    $("#tablename").change(function () {
        var tablename = $("#tablename").val();

        // Animasi loading

        if (tablename) {
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "<?php echo site_url('template/get_column_name');?>"+'/'+tablename,
                //data: {id_mitra: mitra},
                success: function (msg) {
                    // jika tidak ada data
                    if (msg == '') {
                        swal('Tidak ada data');
                    }
                    else {
                        $("#namatable_body").html(msg);
                    }
                }
            });
        } else {
            $("#namatable_body").html('');
        }
    });


</script>
