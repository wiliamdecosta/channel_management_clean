<!-- #section:basics/content.breadcrumbs -->
<style>
    .pointer {
        cursor:pointer;
    }
</style>
<div class="breadcrumbs" id="breadcrumbs">
    <?php echo getBreadcrumb(array('Workflow Summary')); ?>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12 col-sm-4" id="summary-panel">

        </div>
    
        <div class="col-xs-12 col-sm-8" id="user-task-list-panel">
            <div class="row">
                <div class="table-header col-xs-12">
                    Daftar Pekerjaan
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 well well-sm" style="margin-bottom:0px;">
                    <div class="col-sm-3">   
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Tgl Terima" id="filter_date_task_list"/>
                            <span class="input-group-addon">
                                <span class="ace-icon fa fa-calendar icon-on-right bigger-110"></span>
                            </span>
                        </div>
                    </div> 
                    
                    <div class="col-sm-6 input-group">
                        <input class="form-control" type="text" placeholder="Pencarian teks" id="filter_search_task_list"/>
                        <span class="input-group-btn">
                            <button class="btn btn-xs btn-success" type="button" id="btn_filter_task_list">
                                <span class="ace-icon fa fa-search icon-on-right bigger-130"> Filter </span> 
                            </button>
                        </span>
                    </div>
                </div>
            </div>                       
            <div class="row">
                <div class="col-sm-12-offset">
                    <table class="table table-bordered" style="margin-bottom:0px;">
                        <thead>
                            <tr>
                                <th width="80">Terima</th>
                                <th>Pekerjaan</th>
                                <th>Dokumen</th>
                                <th>Pesan</th>
                            </tr>
                        </thead>
                        
                        <tbody id="task-list-content">
                            
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12-offset well well-sm">
                    <div id="task-list-pager"></div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script>
    var pager_selector = '#task-list-pager';
    var pager_items_on_page = 5;
    
    $(function() {
        
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('wf/summary_list');?>',
            data: {P_W_DOC_TYPE_ID : <?php echo $this->input->post('P_W_DOC_TYPE_ID'); ?> },
            timeout: 10000,
            success: function(data) {
                 $("#summary-panel").html(data);
                 var element_id = $('input[name=pilih_summary]:checked').val();
                 openUserTaskList(element_id);
            }
        });

        $(pager_selector).pagination({
            items: 0, /* total data */
            itemsOnPage: pager_items_on_page, /* data pada suatu halaman default 10*/
            cssStyle: 'light-theme',
            onPageClick:function(pageNumber, ev) {
                var element_id = $('input[name=pilih_summary]:checked').val();
                openUserTaskList(element_id);
            }
        });

        $("#filter_date_task_list").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            orientation : 'top',
            todayHighlight : true
        });
        
        
        $('#btn_filter_task_list').on('click', function() {
            var element_id = $('input[name=pilih_summary]:checked').val();
            openUserTaskList(element_id);        
        });
        
    });

    function updatePager(total_data) {
        $(pager_selector).pagination('updateItems', total_data);
    }

    function loadUserTaskList(choosen_radio) {
        $('#filter_date_task_list').datepicker('setDate', null);
        $('#filter_search_task_list').val("");
        openUserTaskList(choosen_radio.value);
    }

    function openUserTaskList(element_id) {
        
        var params = {};
        var p_w_doc_type_id = $("#"+element_id+"_p_w_doc_type_id").val();
        var p_w_proc_id = $("#"+element_id+"_p_w_proc_id").val();
        var profile_type = $("#"+element_id+"_profile_type").val();
        
        params.p_w_doc_type_id = p_w_doc_type_id;
        params.p_w_proc_id = p_w_proc_id;
        params.profile_type = profile_type;
        params.element_id = element_id;

        params.page = $(pager_selector).pagination('getCurrentPage');
        params.limit = pager_items_on_page;
        
        params.searchPhrase = $('#filter_search_task_list').val();
        params.tgl_terima = $('#filter_date_task_list').val();
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '<?php echo site_url('wf/user_task_list');?>',
            data: params,
            timeout: 10000,
            success: function(data) {
                 /* update right content */
                 $("#task-list-content").html(data.contents);
                 /* update pager */
                 updatePager(data.total);
            }
        });
    }
</script>