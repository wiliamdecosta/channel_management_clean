<!-- #section:basics/content.breadcrumbs -->
<style>
    .pointer {
        cursor:pointer;
    }

    .summary-table {
        table-layout:fixed !important;
        white-space:nowrap !important;
    }

    .summary-table td {
        overflow:hidden !important;
        white-space:nowrap !important;
        text-overflow: ellipsis !important;                                          
    }
</style>
<div class="breadcrumbs" id="breadcrumbs">
    <?php echo getBreadcrumb(array('Workflow Summary')); ?>
</div>

<div class="page-content">
    <div class="row">
        <input type="hidden" id="TEMP_ELEMENT_ID" value="<?php echo $this->input->post('ELEMENT_ID'); ?>" />
        <input type="hidden" id="TEMP_PROFILE_TYPE" value="<?php echo $this->input->post('PROFILE_TYPE'); ?>" />
        <input type="hidden" id="TEMP_P_W_DOC_TYPE_ID" value="<?php echo $this->input->post('P_W_DOC_TYPE_ID'); ?>" />
        <input type="hidden" id="TEMP_P_W_PROC_ID" value="<?php echo $this->input->post('P_W_PROC_ID'); ?>" />
        <input type="hidden" id="TEMP_USER_ID" value="<?php echo $this->input->post('USER_ID'); ?>" />
        <input type="hidden" id="TEMP_FSUMMARY" value="wf-workflow_summary.php" />


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
                    <table class="table table-bordered summary-table" style="margin-bottom:0px;">
                        <thead>
                            <tr>
                                <th width="80">Terima</th>
                                <th>Pekerjaan</th>
                                <th>Dokumen</th>
                                <th width="60">Pesan</th>
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
            data: {P_W_DOC_TYPE_ID : <?php echo $this->input->post('P_W_DOC_TYPE_ID'); ?> , ELEMENT_ID : $("#TEMP_ELEMENT_ID").val()},
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
        $('#TEMP_ELEMENT_ID').val( choosen_radio.value );
        openUserTaskList(choosen_radio.value, 1);
    }

    
    function openUserTaskList(element_id, page_number) {
        
        var params = {};
        var p_w_doc_type_id = $("#"+element_id+"_p_w_doc_type_id").val();
        var p_w_proc_id = $("#"+element_id+"_p_w_proc_id").val();
        var profile_type = $("#"+element_id+"_profile_type").val();
        
        params.p_w_doc_type_id = p_w_doc_type_id;
        params.p_w_proc_id = p_w_proc_id;
        params.profile_type = profile_type;
        params.element_id = element_id;
        if( typeof page_number == 'undefined' ) {
            params.page = $(pager_selector).pagination('getCurrentPage');
        }else {
            params.page = page_number;
            $(pager_selector).pagination('selectPage', page_number);
            window.location.replace("#");
        }

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
            },
            error: function(xhr, textStatus, errorThrown){
                swal("Perhatian", "Summary Error", "warning");
            }
        });
    }


    function loadWFForm(file_name, wfobj) {
        if( wfobj.USER_ID_LOGIN == '' || wfobj.USER_ID_LOGIN == null ) {
            swal("Perhatian", "Session Anda habis. Silahkan login kembali", "warning");
            return;
        }
        
        if( file_name == '' ) {
            swal("Perhatian", "File Name Kosong", "warning");
            return;
        }

        wfobj.ELEMENT_ID = $('#TEMP_ELEMENT_ID').val();
        wfobj.PROFILE_TYPE = $('#TEMP_PROFILE_TYPE').val();
        wfobj.P_W_DOC_TYPE_ID = $('#TEMP_P_W_DOC_TYPE_ID').val();
        wfobj.P_W_PROC_ID = $('#TEMP_P_W_PROC_ID').val();
        wfobj.USER_ID = $('#TEMP_USER_ID').val();
        wfobj.FSUMMARY = $('#TEMP_FSUMMARY').val();

        if(wfobj.ACTION_STATUS == 'TERIMA') {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo site_url('wf/taken_task');?>',
                data: {curr_ctl_id : wfobj.CURR_CTL_ID, curr_doc_type_id : wfobj.CURR_DOC_TYPE_ID},
                timeout: 10000,
                success: function(data) {
                    if( data.success )
                        loadContentWithParams( file_name , wfobj );
                    else
                        swal("Perhatian", "Taken Task Error", "warning");
                },
                error: function(xhr, textStatus, errorThrown){
                    swal("Perhatian", "Summary Error", "warning");
                }
            });
        }else {
            loadContentWithParams( file_name , wfobj );
        }
    }

</script>