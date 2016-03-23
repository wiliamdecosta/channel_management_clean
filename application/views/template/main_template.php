        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="mytab">
                <li class="tab2" id="data_template">
                    <a href="javascript:void(0)">Data Template</a>
                </li>

                <li class="tab2" id="create_template">
                    <a href="javascript:void(0)">Body</a>
                </li>
                <li class="tab2" id="variable_template">
                    <a href="javascript:void(0)">Variable</a>
                </li>

                <!-- <li class="tab" id="create_user">
                    <a href="javascript:void(0)">Create User</a>
                </li> -->

            </ul>

            <div class="tab-content">
                <div id="main_content2" style="min-height: 400px;">
                </div>
            </div>
        </div>
      </div>
<!-- #section:basics/content.breadcrumbs -->
<script type="text/javascript">

  function click_tab(tab,ctrl,id){
    // tab = class tab (tab or tab2)
    // ctrl = id to click
    $('.'+tab).removeClass('active');
    $('#'+ctrl).addClass('active');
    $.ajax({
        type: 'POST',
        url: "<?php echo site_url();?>template/"+ctrl+'/'+id,
        data: {},
        timeout: 10000,
        //async: false,
        success: function(data) {
            $("#main_content2").html(data);
        }
    })

  }


    $(document).ready(function(){
        // init first tab active
          click_tab('tab2','data_template');

        $('.tab2').click(function(e){
            e.preventDefault();
            var ctrl = $(this).attr('id');
            click_tab('tab2',ctrl);
            return false;
        })
    })
			var JDok = document.getElementById("doc_type");
			var JDokHasil = JDok.options[JDok.selectedIndex].text;
			var PilTemp = document.getElementById("doc_lang");
			var PilTempHasil = PilTemp.options[PilTemp.selectedIndex].text;
	$('#Finishing_Edit').click(function () {
        $.ajax({
            type: "POST",
           dataType: "html",
            url: "<?php echo site_url('template/parseBackTemplate');?>",
            data: {title1:document.getElementById('docx_name').value, title2:document.getElementById('docx_descript').value},
            success: function (data) {
               alert(data[1]);
			   alert(data[2]);
            }
        });
		})
</script>
