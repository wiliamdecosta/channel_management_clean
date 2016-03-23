<div class="tabbable">
    <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="mytab">
        <li class="tab" id="skembis">
            <a href="javascript:void(0)">Create Skema</a>
        </li>

        <li class="tab" id="calculateMF">
            <a href="javascript:void(0)">Calculate MF</a>
        </li>

        <!--<li class="tab" id="createBARekon">
            <a href="javascript:void(0)">Create BA Rekon</a>
        </li>
        <li class="tab" id="createPerhitunganBillco">
            <a href="javascript:void(0)">Create Perhitungan Billco</a>
        </li>-->
        <li class="tab" id="createNPK">
            <a href="javascript:void(0)">Create NPK</a>
        </li>
        <!--<li class="tab" id="evaluasiMitra">
            <a href="javascript:void(0)">Evaluasi Mitra</a>
        </li>-->
    </ul>

    <div class="tab-content">
        <div id="main_content" style="min-height: 400px;">
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.tab').click(function (e) {
            e.preventDefault();

            var ctrl = $(this).attr('id');
            var segment = $('#segment').val();
            var ccid = $('#list_cc').val();
            var mitra = $('#mitra').val();
            //var lokasisewa = $('#lokasisewa option:selected').text();
            var lokasisewa = $('#lokasisewa').val();
            var data = {ccid: ccid, mitra: mitra, lokasisewa: lokasisewa, segment: segment}
            if (checkFilter()) {
                $('.tab').removeClass('active');
                $('#' + ctrl).addClass('active');
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>skema_bisnis/" + ctrl,
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