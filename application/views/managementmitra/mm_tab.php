<div class="tabbable">
    <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="mytab">
        <li class="tab" id="detailMitra">
            <a href="javascript:void(0)">Detail Mitra</a>
        </li>

        <li class="tab" id="dokPKS">
            <a href="javascript:void(0)">Dokumen PKS</a>
        </li>

        <li class="tab" id="dokNPK">
            <a href="javascript:void(0)">Dokumen NPK</a>
        </li>
        <li class="tab" id="fastels">
            <a href="javascript:void(0)">Fastel</a>
        </li>
        <li class="tab" id="dokKontrak">
            <a href="javascript:void(0)">Dokumen Kontrak</a>
        </li>
        <li class="tab" id="evaluasiMitra">
            <a href="javascript:void(0)">Evaluasi Mitra</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="main_content" style="min-height: 400px;">
        </div>
    </div>
</div>
</div> <!--div dari filter mitra-->

<script type="text/javascript">
    $(document).ready(function () {
        $('.tab').click(function (e) {
            e.preventDefault();

            var ctrl = $(this).attr('id');
            var segment = $('#segment').val();
            var ccid = $('#list_cc').val();
            var mitra = $('#mitra').val();
            var menu_id = '<?php echo $menu_id;?>';
            //var lokasisewa = $('#lokasisewa option:selected').text();
            var lokasisewa = $('#lokasisewa').val();
            var data = {
                ccid: ccid,
                mitra: mitra,
                lokasisewa: lokasisewa,
                segment: segment,
                menu_id: menu_id
            };
            if (checkFilter()) {
                $('.tab').removeClass('active');
                $('#' + ctrl).addClass('active');
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>managementmitra/" + ctrl,
                    data: data,
                    timeout: 10000,
                    //async: false,
                    success: function (data) {
                        $("#main_content").html(data);
                        //  $(document).scrollTop(position)
                    }
                });
                return false;
            }

        })
    });
</script>