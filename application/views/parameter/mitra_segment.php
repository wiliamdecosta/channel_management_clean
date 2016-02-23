<div class="breadcrumbs" id="breadcrumbs">
    <?= $this->breadcrumb; ?>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12" style="width: 100%;">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="mytab">
                    <li class="tab active" id="mapping_mitra">
                        <a href="javascript:void(0)">Mapping Mitra</a>
                    </li>

                    <li class="tab" id="mapping_lokasi">
                        <a href="javascript:void(0)">Mapping Lokasi</a>
                    </li>

                    <li class="tab" id="mapping_pic">
                        <a href="javascript:void(0)">Mapping PIC</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="main_content" style="min-height: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $('.tab').click(function (e) {
        e.preventDefault();
        var ctrl = $(this).attr('id');
        switch (ctrl) {
            case 'mapping_mitra':
                $('.tab').removeClass('active');
                $('#' + ctrl).addClass('active');
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>parameter/" + ctrl,
                    timeout: 10000,
                    success: function (data) {
                        $("#main_content").html(data);
                    }
                });
                break;
            case 'mapping_lokasi':
                var map_mitra_id = $("#grid-table1").jqGrid('getGridParam', 'selrow');
               // if (map_mitra_id) {
                    $('.tab').removeClass('active');
                    $('#' + ctrl).addClass('active');
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo site_url();?>parameter/" + ctrl,
                        data: {P_MAP_MIT_CC_ID: map_mitra_id},
                        timeout: 10000,
                        success: function (data) {
                            $("#main_content").html(data);
                        }
                    });
                    return false;
               // } else {
                //    swal("Perhatian", "Tidak ada row mitra yang dipilih !", "warning");
               // }
                break;
            case 'mapping_pic':
                var lokasi_id = $("#grid_table_lokasi").jqGrid('getGridParam', 'selrow');
                if (lokasi_id) {
                    $('.tab').removeClass('active');
                    $('#' + ctrl).addClass('active');
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo site_url();?>parameter/" + ctrl,
                        data: {P_MP_LOKASI_ID: lokasi_id},
                        timeout: 10000,
                        success: function (data) {
                            $("#main_content").html(data);
                        }
                    });
                    return false;
                } else {
                    swal("Perhatian", "Tidak ada row lokasi yang dipilih !", "warning");
                }
                break;
        }

    });

    function load_mapping_mitra() {
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url();?>parameter/mapping_mitra",
            data: {},
            timeout: 10000,
            success: function (data) {
                $("#main_content").html(data);
            }
        });
    }

</script>

<script>
    $(document).ready(function () {
        load_mapping_mitra();
    });
</script>