<div class="row">
    <div class="">
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> Nama AM</div>

                <div class="profile-info-value">
                    <span class="editable"><b><?php echo $am['AM_NAME'];?></b></span>
                </div>
            </div>

            <div class="profile-info-row">
                <div class="profile-info-name"> NIK</div>

                <div class="profile-info-value">
                    <span class="editable"><?php echo $am['NIK'];?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Email</div>

                <div class="profile-info-value">
                    <span class="editable"><?php echo $am['AM_EMAIL'];?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name">No Hp</div>
                <div class="profile-info-value">
                    <span class="editable" id="username"><?php echo $am['AM_NO_HP'];?></span>
                </div>
            </div>

        </div>
    </div>
</div>
&nbsp;
<div class="row">
    <div class="form-group">
        <div class="col-xs-12">
            <div class="clearfix">
            </div>
            <div class="table-header">
               List PIC
            </div>
            <div>
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="center">NO</th>
                        <th> Nama PIC</th>
                        <th> Jenis Kontak</th>
                        <th> Alamat</th>
                        <th> Kota</th>
                        <th> Kode Pos</th>
                        <th> Email</th>
                        <th> No. HP</th>
                        <th> Fax</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $i = 1;
                    foreach ($result as $content){

                        ?>
                        <tr>
                            <td class="center"><?php echo $i; ?> </td>
                            <td>
                                <a href="#"><?php echo $content['PIC_NAME']; ?></a>
                            </td>
                            <td> <?php echo $content['CODE']; ?> </td>
                            <td> <?php echo $content['ADDRESS_1']; ?> </td>
                            <td> <?php echo $content['KOTA']; ?> </td>
                            <td> <?php echo $content['ZIP_CODE']; ?> </td>
                            <td> <?php echo $content['EMAIL']; ?> </td>
                            <td> <?php echo $content['NO_HP']; ?> </td>
                            <td> <?php echo $content['FAX']; ?> </td>
                        </tr>
                        <?php
                        $i++;
                    }

                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

