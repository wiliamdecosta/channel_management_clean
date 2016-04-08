<div id="content">
    <div class="breadcrumbs" id="breadcrumbs">
        <?=$this->breadcrumb;?>
    </div>
	<div id="maintab">	
		<div class="page-content">

			<div class="row">
				<div class="col-xs-12">

					<div class="row">
						<div class="vspace-12-sm"></div>
						<div class="col-sm-12">
							<div class="widget-box transparent">
								<div class="widget-header red widget-header-flat">
									<h4 class="widget-title lighter">
										<!--                    <i class="ace-icon fa fa-money orange"></i>-->
										Template
									</h4>
									<div class="tabbable">
										<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="mytab">
											<li class="tab" id="create_template">
												<a href="javascript:void(0)">Create Template</a>
											</li>
											<li class="tab" id="list_temp">
												<a href="javascript:void(0)">Edit Dokumen</a>
											</li>								
										</ul>										
									</div>										
								</div>
									<div class="tab-content">
											<div id="main_content" style="min-height: 400px; min-width: 600px;">
											</div>
									</div>
							</div>
						</div>
						</div>
				</div>
			</div>
		</div>
	</div>					
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.tab').click(function (e) {
            e.preventDefault();

            var ctrl = $(this).attr('id');
            // var segment = $('#segment').val();
            // var ccid = $('#list_cc').val();
            // var mitra = $('#mitra').val();
            //var lokasisewa = $('#lokasisewa option:selected').text();
            // var lokasisewa = $('#lokasisewa').val();
            // var data = {ccid: ccid, mitra: mitra, lokasisewa: lokasisewa, segment: segment}
            // if (true) {
                $('.tab').removeClass('active');
                $('#' + ctrl).addClass('active');
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url();?>template/" + ctrl,
                    data: {},
                    timeout: 10000,
                    //async: false,
                    success: function (data) {
                        $("#main_content").html(data);
                        //  $(document).scrollTop(position)
                    }
                });
                // return false;
            // }

        })
    });
</script>