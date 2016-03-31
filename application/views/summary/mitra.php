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
                                            <a class="btn btn-minier btn-primary" data-toggle="modal" id="list_mitra" segment="<?php echo $content['SEGMENT']; ?>">List Mitra</a>
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
    $('#list_mitra').click(function(){
        alert(this.segment);
    })
</script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">List Mitra</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="center">Nama Mitra</th>
                        <th class="center">Nama CC</th>
                        <th class="center">Nama AM</th>
                        <th class="center">NIK AM</th>
                        <th class="center">NO Telp AM</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="center"> Mentari Cyber Media</td>
                        <td class="center"> ANZ Tower</td>
                        <td class="center"> R Sigit</td>
                        <td class="center"> 680845</td>
                        <td class="center"> 08128890478</td>
                    </tr>
                    <tr>
                        <td class="center"> Angkasa Pura</td>
                        <td class="center"> Angkasa Pura</td>
                        <td class="center"> Rendi P</td>
                        <td class="center"> 14493</td>
                        <td class="center"> 0812334890</td>
                    </tr>
                    <tr>
                        <td class="center"> BNI</td>
                        <td class="center"> BNI Tower</td>
                        <td class="center"> John Doe</td>
                        <td class="center"> 64309</td>
                        <td class="center"> 0813589509</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>