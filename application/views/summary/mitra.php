<div id="dokPKS">
    <form class="form-horizontal" role="form">
        <div class="rows">
            <div class="form-group">
                <div class="col-xs-6">
                    <div class="clearfix">
                    </div>
                    <div class="table-header">
                        Mitra
                    </div>
                    <div>
                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="center"> Segment</th>
                                <th class="center"> Jumlah Mitra</th>
                                <th class="center"> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($array_mitra as $content) {
                                ; ?>
                                <tr>
                                    <td class="center"><?php echo $content['SEGMENT']; ?></td>
                                    <td class="center"><span class="badge badge-success"> <?php echo $content['JUMLAH_MITRA']; ?><span></td>
                                    <td class="center">
                                        <div class="hidden-sm hidden-xs action-buttons">
                                            <a class="btn btn-minier btn-primary list_mitra" id="<?php echo $content['SEGMENT']; ?>">List Mitra</a>
                                        </div>
                                    </td>
                                </tr>

                            <?php }; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $('.list_mitra').click(function(){
        var segment = $(this).attr('id');

        $.ajax({
            url: "<?php echo base_url();?>summary/lovListMitra",
            type: "POST",
            data: {segment:segment},
            success: function (data) {
                $("#lov_list_mitra").html(data);
                $("#modal_list_mitra").modal('show');
            }
        });

    })
</script>
<div id="lov_list_mitra">

</div>

