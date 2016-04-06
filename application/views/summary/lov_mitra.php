<!-- Modal -->
<div class="modal fade" id="modal_list_mitra"  role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">List Mitra Segment <?php echo $segment;?></h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="center">Nama Mitra</th>
                        <th class="center">Nama CC</th>
                        <th class="center">Nama AM</th>
                        <th class="center">NIK AM</th>
                        <th class="center">Kontak</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($array_mitra as $content) {
                        ; ?>
                        <tr>
                            <td class="left"><?php echo $content['PGL_NAME']; ?></td>
                            <td class="left"><?php echo $content['CC_NAME']; ?></td>
                            <td class="left"><?php echo $content['AM_NAME']; ?></td>
                            <td class="left"><?php echo $content['NIK']; ?></td>
                            <td class="left "><?php echo $content['NO_HP_AM']; ?></td>
                        </tr>

                    <?php }; ?>
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