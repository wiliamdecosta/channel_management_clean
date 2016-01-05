<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Create New Batch</h4>
            </div>
            <div class="modal-body">
<!--                <iframe src="//www.youtube.com/embed/_Wo9JxLIQYg" allowfullscreen="" frameborder="0" height="315" width="100%"></iframe>-->
                <div class="widget-main">


                    <div class="row">
                        <div class="col-xs-4">
                            <!-- #section:plugins/date-time.datepicker -->
                            <div class="input-group">
                                <label class="control-label bolder blue">Pilih Tahun</label>
                                <select class="form-control" id="tahun">
                                    <option value=""> Pilih Tahun</option>
                                    <?php
                                    $year = date("Y");
                                    for($i = ($year); $i >= $year-5; $i--){
                                        echo "<option value=$i>$i</option>";
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <div class='control-group'>
                                <label class="control-label bolder blue">Daftar Period</label>
                                <div id="checkbox_period">
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_batch">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#tahun').change(function() {
            var val = $(this).val();
            addCheckbox(val);
        });
    });

    function addCheckbox(name) {
        var container = $('#checkbox_period');
        var inputs = container.find('input');
        var id = inputs.length+1;

        var i;
        var input = '';
        var tgl = ''
        for (i = 1; i <= 12; i++) {
            if(i<10){
                tgl = '0'+i;
            }else{
                tgl = i;
            }

            input += "<div class='checkbox'><label> <input name='form-field-checkbox[]' id='check_id' type='checkbox' class='ace' value="+name+""+tgl+"><span class='lbl'> "+name+""+tgl+"</span></label>";
            //container.html($('<input />', { type: 'checkbox', id: 'cb'+id, value: name }));
            //container.html( $('<label />', { 'for': 'cb'+id, text: name }));
        }

        container.html(input);
        //  container.html( $('<label />', { 'for': 'cb'+id, text: name }));

    }
    jQuery("#save_batch" ).click(function() {
        var target = document.getElementById('content')
        var spinner = new Spinner(opts).spin(target);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('loaddata/createBatch');?>',
            data: {periode:val},
            success: function(data) {
                $(".main-content-inner").html(data);
            },
            error: function(jqXHR, textStatus, errorThrown){
                // alert(errorThrown);
                $(".main-content-inner").html(errorThrown);
            },
            timeout: 10000 // sets timeout to 10 seconds
        })
        return false;

        // Get value checked
        var val = [];
        $(':checkbox:checked').each(function(i){
            val[i] = $(this).val();

        });
        // Cek Apakah tahun sudah dipilih
        var thn = $('#tahun').val();
        if(!thn) {
            alert ('Silahkan pilih tahun !!!');
            return false;
        }
        if(val.length == 0){
            alert ('Silahkan pilih periode !!!');
            return false;
        }

        var c =  confirm('Apakah Anda Yakin Create New Batch ?');
        if(c == true){


        }

    });
</script>