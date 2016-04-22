<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wf extends CI_Controller {
    
    function __construct() {
        parent::__construct();

        checkAuth();
        $this->load->model('Workflow','workflow');
        $this->load->model('M_jqGrid', 'jqGrid');
    }

    public function list_inbox() {
        $user_name = $this->session->userdata("d_user_name");
        $items = $this->workflow->getListInbox($user_name);

        $strOutput = '';
        $total = 0;
        foreach($items as $item) {

            $url_arr = explode("#", $item['URL']);
            $summary = str_replace("/", "-", $url_arr[0]);
            $str_params = $url_arr[1];

            $total += $item['JUMLAH'];
            $strOutput .= '<div class="row">
                                <div class="col-xs-12 col-sm-5">
                                    <div class="widget-box ui-sortable-handle" style="opacity: 1;">
                                        <div class="widget-header widget-header-small">
                                            <h5 class="widget-title blue smaller">'.$item['PROFILE_TYPE'].'</h5>
                                            <div class="widget-toolbar">
                                                <span class="label label-success">
                                                    Pekerjaan Baru : '.$item['JUMLAH'].'
                                                </span>
                                                <a data-action="collapse" href="#">
                                                    <i class="ace-icon fa fa-chevron-up"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="widget-body">
                                            <div class="widget-main padding-6">
                                                <button class="btn btn-sm btn-danger" onClick="loadContentWithParams(\''.$summary.'\','.$str_params.');"> Lihat Detail </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
        }

        $strOutput .= '<div class="row">
                            <div class="col-xs-12 col-sm-5"> 
                                <hr style="border:width:2px 0 0;">
                                <h4 class="blue" style="text-align:right;"> Jumlah Pekerjaan Tersedia : '.$total.'</h4>
                            </div>
                      </div>';

        echo $strOutput;
    }

    public function summary_list() {
        $P_W_DOC_TYPE_ID = $this->input->post('P_W_DOC_TYPE_ID');
        $user_name = $this->session->userdata("d_user_name");
        $ELEMENT_ID = $this->input->post('ELEMENT_ID');

        $items = $this->workflow->getSummaryList($P_W_DOC_TYPE_ID, $user_name);
        $strOutput = '<div class="table-header">
                            Summary
                      </div>
                      <table class="table table-bordered table-hover" id="dynamic-table">
                        <thead>
                            <tr>
                                <th class="center"> Pekerjaan</th>
                                <th class="center" width="15"> Jumlah </th>
                                <th class="center"> Pilih </th>
                                <th style="display:none;"> Hidden Value </th>
                            </tr>
                        </thead>
                        ';
        
        $strOutput .= '<tbody>';

              
        $selected = '';
        $not_checked = true;
        foreach ($items as $item) {

            if($item['STYPE'] == 'PROFILE') {
                $strOutput .= '<tr>
                                    <td colspan="3"><strong class="blue">'.$item['DISPLAY_NAME'].'</strong></td>
                              </tr>';
            }else {
                
                if(!empty($ELEMENT_ID)) {
                    if( $ELEMENT_ID == $item['ELEMENT_ID']) {
                        $selected = 'checked=""';    
                    }else {
                        $selected = ''; 
                    }
                }else {
                    if( $not_checked ) {
                        $selected = 'checked=""';
                        $not_checked = false;        
                    }else {
                        $selected = '';    
                    }
                }

                $strOutput .= '<tr>
                                    <td style="padding-left:35px;"><strong class="green">'.$item['DISPLAY_NAME'].'</strong></td>
                                    <td style="text-align:right;">'.$item['SCOUNT'].'</td>
                                    <td class="center"><input class="pointer radio-bigger" type="radio" '.$selected.' name="pilih_summary" value="'.$item['ELEMENT_ID'].'" onclick="loadUserTaskList(this);"></td>
                                    <td style="display:none;">
                                        <input type="hidden" id="'.$item['ELEMENT_ID'].'_p_w_doc_type_id" value="'.$item['P_W_DOC_TYPE_ID'].'">
                                        <input type="hidden" id="'.$item['ELEMENT_ID'].'_p_w_proc_id" value="'.$item['P_W_PROC_ID'].'">
                                        <input type="hidden" id="'.$item['ELEMENT_ID'].'_profile_type" value="'.$item['PROFILE_TYPE'].'">
                                    </td>
                              </tr>';

            }
        }
        $strOutput .= '</tbody>';

        $strOutput .= '</table>';

        echo $strOutput;
    }
    
    public function user_task_list() {
        
        $p_w_doc_type_id = $this->input->post('p_w_doc_type_id');
        $p_w_proc_id     = $this->input->post('p_w_proc_id');
        $profile_type    = $this->input->post('profile_type');
        $element_id      = $this->input->post('element_id');
        $user_name       = strtoupper($this->session->userdata("d_user_name"));
        
        $page = intval($this->input->post('page')) ;
        $limit = $this->input->post('limit');
        $sort = 'DONOR_DATE';
        $dir = 'DESC';
        
        /* search parameter */
        $searchPhrase      = $this->input->post('searchPhrase');
        $tgl_terima        = $this->input->post('tgl_terima');
        
        if(empty($p_w_doc_type_id) || empty($p_w_proc_id) || empty($profile_type)) {
            return self::emptyTaskList();
        }

        $sql = "SELECT * FROM TABLE (pack_task_profile.user_task_list (".$p_w_doc_type_id.",".$p_w_proc_id.",'".$profile_type."','".$user_name."',''))";
        $req_param = array (
            "table" => $sql,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
			"search" => ''
        );
        $req_param['where'] = array();
        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(upper(KEYWORD) LIKE upper('%".$searchPhrase."%'))";
        }
        
        if(!empty($tgl_terima)) {
            $req_param['where'][] = "trunc(DONOR_DATE) = nvl(to_date('".$tgl_terima."','YYYY-MM-DD'),trunc(DONOR_DATE))";
        }
        
        $count = $this->jqGrid->bootgrid_countAll($req_param);
        if( $count > 0 && !empty($limit) ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );
        
        $items = $this->jqGrid->bootgrid_get_data($req_param);
        $data = array();
        
        $data['total'] = $count;
        $data['contents'] = self::getTaskListHTML($items);
        
        echo json_encode($data);
    }
    
    public function emptyTaskList() {
        return '<tr>
                        <td colspan="4"> Tidak ada data untuk ditampilkan </td>
                    </tr>';

    }

    public function getTaskListHTML($items) {
        
        if(count($items) == 0) {
            return self::emptyTaskList();
        }
        
        $user_id_login = $this->session->userdata("d_user_id");

        $result  = '';
        foreach($items as $item) {
            $result .= '<tr>
                            <td colspan="4"> <span class="green"><strong>'.$item['CUST_INFO'].'</strong></span></td>
                        </tr>';
            
            $result .= '<tr>';

            $params = array();
            $file_name = str_replace("/","-",$item['FILENAME']);
            $params['CURR_DOC_ID'] = intval($item['DOC_ID']);
            $params['CURR_DOC_TYPE_ID'] = intval($item['P_W_DOC_TYPE_ID']);
            $params['CURR_PROC_ID'] = intval($item['P_W_PROC_ID']);
            $params['CURR_CTL_ID'] = intval($item['T_CTL_ID']);
            $params['USER_ID_DOC'] = intval($item['P_APP_USER_ID_DONOR']);
            $params['USER_ID_DONOR'] = intval($item['P_APP_USER_ID_DONOR']);
            $params['USER_ID_LOGIN'] = intval($user_id_login);
            $params['USER_ID_TAKEN'] = intval($item['P_APP_USER_ID_TAKEOVER']);
            $params['IS_CREATE_DOC'] = "N";
            $params['IS_MANUAL'] = "N";
            $params['CURR_PROC_STATUS'] = $item['PROC_STS'];
            $params['CURR_DOC_STATUS'] = $item['DOC_STS'];
            $params['PREV_DOC_ID'] = intval($item['PREV_DOC_ID']);
            $params['PREV_DOC_TYPE_ID'] = intval($item['PREV_DOC_TYPE_ID']);
            $params['PREV_PROC_ID'] = intval($item['PREV_PROC_ID']);
            $params['PREV_CTL_ID'] = intval($item['PREV_CTL_ID']);
            $params['SLOT_1'] = $item['SLOT_1'];
            $params['SLOT_2'] = $item['SLOT_2'];
            $params['SLOT_3'] = $item['SLOT_3'];
            $params['SLOT_4'] = $item['SLOT_4'];
            $params['SLOT_5'] = $item['SLOT_5'];
            $params['MESSAGE'] = $item['MESSAGE'];
            
            if($item['PROFILE_TYPE'] != 'INBOX') {
                $params['ACTION_STATUS'] = "VIEW";
                $json_param = str_replace('"', "'", json_encode($params));
                $result .= '<td><button type="button" class="btn btn-sm btn-primary" onClick="loadWFForm(\''.$file_name.'\','.$json_param.')">View</button></td>';
            }else {
                if($item['IS_READ'] == 'N') {
                    $params['ACTION_STATUS'] = "TERIMA";
                    $json_param = str_replace('"', "'", json_encode($params));
                    $result .= '<td><button type="button" class="btn btn-sm btn-primary" onClick="loadWFForm(\''.$file_name.'\','.$json_param.')">Terima</button></td>';
                }else {
                    $params['ACTION_STATUS'] = "BUKA";
                    $json_param = str_replace('"', "'", json_encode($params));
                    $result .= '<td><button type="button" class="btn btn-sm btn-primary" onClick="loadWFForm(\''.$file_name.'\','.$json_param.')">Buka</button></td>';        
                }
            }

            $result .= '<td>
                            <table class="table">
                                <tr>
                                    <td>Nama Pekerjaan</td>
                                    <td>:</td>
                                    <td colspan="2"><span class="red"><strong>'.$item['LTASK'].'</strong></span></td>
                                </tr>
                                <tr>
                                    <td>Pengirim</td>
                                    <td>:</td>
                                    <td>'.$item['SENDER'].'</td>
                                    <td>'.$item['DONOR_DATE'].'</td>
                                </tr>
                                <tr>
                                    <td>Penerima</td>
                                    <td>:</td>
                                    <td>'.$item['RECIPIENT'].'</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Pengambil</td>
                                    <td>:</td>
                                    <td>'.$item['TAKEOVER'].'</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Submitter</td>
                                    <td>:</td>
                                    <td>'.$item['CLOSER'].'</td>
                                    <td>'.$item['SUBMIT_DATE'].'</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>'.$item['PROC_STS'].'</td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>'; /* pekerjaan */
            $result .= '<td>
                            <table class="table">
                                <tr>
                                    <td>Nomor Permohonan</td>
                                    <td>:</td>
                                    <td>'.$item['DOC_NO'].'</td>
                                </tr>
                                <tr>
                                    <td>Periode</td>
                                    <td>:</td>
                                    <td>'.$item['PERIOD'].'</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Dibaca</td>
                                    <td>:</td>
                                    <td>'.$item['READ_DATE'].'</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>'.$item['DOC_STS'].'</td>
                                </tr>
                            </table>
                        </td>'; /* dokumen */
            $result .= '<td>'.$item['MESSAGE'].'</td>'; /* pesan */
            $result .= '</tr>';
        }
        
        return $result;
    }


    public function taken_task() {
        $curr_ctl_id = $this->input->post('curr_ctl_id');
        $curr_doc_type_id = $this->input->post('curr_doc_type_id');
        $user_name = strtoupper($this->session->userdata("d_user_name"));

        $curr_doc_type_id = empty($curr_doc_type_id) ? NULL : $curr_doc_type_id;       

        try {

            $sql = "  BEGIN ".
                    "  pack_task_profile.taken_task(:params1, :params2, :params3); END;";

            $params = array(
                array('name' => ':params1', 'value' => $curr_ctl_id, 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params2', 'value' => $user_name, 'type' => SQLT_CHR, 'length' => 100),
                array('name' => ':params3', 'value' => $curr_doc_type_id, 'type' => SQLT_INT, 'length' => 100)
            );
            // Bind the output parameter

            $stmt = oci_parse($this->workflow->db->conn_id,$sql);

            foreach($params as $p){
                // Bind Input
                oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
            }

            ociexecute($stmt);

            $data['success'] = true;
            $data['message'] = 'Taken Task Berhasil';
        }catch(Exception $e){
            $data['success'] = false;
            $data['message'] = 'Taken Task Gagal';
        }
        
        echo json_encode($data);
    }


    public function pekerjaan_tersedia() {

        $curr_proc_id = $this->input->post('curr_proc_id');
        $curr_doc_type_id = $this->input->post('curr_doc_type_id');

        $sql = "select f_get_next_info(".$curr_proc_id.",".$curr_doc_type_id.")as task from dual";
        $query = $this->workflow->db->query($sql);
        $row = $query->row_array();
                        
        $data = array();
        $data['task'] = $row['TASK'];
        
        echo json_encode($data);
    }

    public function status_dokumen_workflow() {

        $sql = "select * from v_document_workflow_status";
        $query = $this->workflow->db->query($sql);

        $items = $query->result_array();
        $opt_status = '';

        foreach ($items as $item) {
            $opt_status .= '<option value="'.$item['P_STATUS_LIST_ID'].'"> '.$item['CODE'].' </option>';
        }

        echo json_encode( array('opt_status' => $opt_status ) );
    }


    public function submitter_submit() {

        $o_submitter_id = null;
        $o_error_message = "";
        $o_result_msg = "";
        $o_warning = ""; 
        $user_id_login = $this->session->userdata("d_user_id");

        /* posting from submit lov */
        $interactive_message = $this->input->post('interactive_message');
        $submitter_params = json_decode($this->input->post('params') , true);

        try {

            $sql = "SELECT SUBMITTER_SEQ.nextval AS SEQ FROM DUAL";
            $query = $this->workflow->db->query($sql);
            $row = $query->row_array();
            $o_submitter_id = $row['SEQ'];

            $submitter_params['USER_ID_DOC'] = empty($submitter_params['USER_ID_DOC']) ? NULL : $submitter_params['USER_ID_DOC'];
            $submitter_params['USER_ID_DONOR'] = empty($submitter_params['USER_ID_DONOR']) ? NULL : $submitter_params['USER_ID_DOC'];
            $submitter_params['USER_ID_TAKEN'] = empty($submitter_params['USER_ID_TAKEN']) ? $user_id_login : $submitter_params['USER_ID_TAKEN'];

            $submitter_params['CURR_CTL_ID'] = empty($submitter_params['CURR_CTL_ID']) ? NULL : $submitter_params['CURR_CTL_ID'];
            $submitter_params['CURR_DOC_TYPE_ID'] = empty($submitter_params['CURR_DOC_TYPE_ID']) ? NULL : $submitter_params['CURR_DOC_TYPE_ID'];
            $submitter_params['CURR_PROC_ID'] = empty($submitter_params['CURR_PROC_ID']) ? NULL : $submitter_params['CURR_PROC_ID'];
            $submitter_params['CURR_DOC_ID'] = empty($submitter_params['CURR_DOC_ID']) ? NULL : $submitter_params['CURR_DOC_ID'];
            
            $submitter_params['PREV_CTL_ID'] = empty($submitter_params['PREV_CTL_ID']) ? NULL : $submitter_params['PREV_CTL_ID'];
            $submitter_params['PREV_DOC_TYPE_ID'] = empty($submitter_params['PREV_DOC_TYPE_ID']) ? NULL : $submitter_params['PREV_DOC_TYPE_ID'];
            $submitter_params['PREV_PROC_ID'] = empty($submitter_params['PREV_PROC_ID']) ? NULL : $submitter_params['PREV_PROC_ID'];
            $submitter_params['PREV_DOC_ID'] = empty($submitter_params['PREV_DOC_ID']) ? NULL : $submitter_params['PREV_DOC_ID'];
            
            $str_params = "";
            define("TOTAL_PARAMS", 23);
            for($i = 1; $i <= TOTAL_PARAMS; $i++) {
                if($i == 1) $str_params .= ":params".$i;
                else $str_params .= ",:params".$i;
            }

            $sql = "  BEGIN ".
                        "  pack_workflow.submit_engine(".$str_params."); END;";

            $params = array(
                array('name' => ':params1', 'value' => $o_submitter_id, 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params2', 'value' => $submitter_params['IS_CREATE_DOC'], 'type' => SQLT_CHR, 'length' => 500), 
                array('name' => ':params3', 'value' => $submitter_params['IS_MANUAL'], 'type' => SQLT_CHR, 'length' => 500), 
                array('name' => ':params4', 'value' => $submitter_params['USER_ID_DOC'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params5', 'value' => $submitter_params['USER_ID_DONOR'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params6', 'value' => $user_id_login, 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params7', 'value' => $submitter_params['USER_ID_TAKEN'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params8', 'value' => $submitter_params['CURR_CTL_ID'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params9', 'value' => $submitter_params['CURR_DOC_TYPE_ID'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params10', 'value' => $submitter_params['CURR_PROC_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params11', 'value' => $submitter_params['CURR_DOC_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params12', 'value' => $submitter_params['CURR_DOC_STATUS'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params13', 'value' => $submitter_params['CURR_PROC_STATUS'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params14', 'value' => $submitter_params['PREV_CTL_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params15', 'value' => $submitter_params['PREV_DOC_TYPE_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params16', 'value' => $submitter_params['PREV_PROC_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params17', 'value' => $submitter_params['PREV_DOC_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params18', 'value' => $interactive_message, 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params19', 'value' => $submitter_params['SLOT_1'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params20', 'value' => $submitter_params['SLOT_2'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params21', 'value' => $submitter_params['SLOT_3'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params22', 'value' => $submitter_params['SLOT_4'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params23', 'value' => $submitter_params['SLOT_5'], 'type' => SQLT_CHR, 'length' => 500)
            );
            // Bind the output parameter

            $stmt = oci_parse($this->workflow->db->conn_id,$sql);

            foreach($params as $p){
                // Bind Input
                oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
            }

            ociexecute($stmt);

            $sql_message = "SELECT ERROR_MESSAGE, RETURN_MESSAGE, WARNING FROM SUBMITTER WHERE SUBMITTER_ID = ".$o_submitter_id;
            $query_message = $this->workflow->db->query($sql_message);
            $row_message = $query_message->row_array();

            $data = array();

            if($row_message['RETURN_MESSAGE'] != "0") {
                $data['submit_success'] = true;
                $row_message['RETURN_MESSAGE'] = "BERHASIL";
            }else {
                $data['submit_success'] = false;
                $row_message['RETURN_MESSAGE'] = "";
            }
            
            $data['success'] = true;
            $data['return_message'] = $row_message['RETURN_MESSAGE'];
            $data['error_message'] = $row_message['ERROR_MESSAGE'];
            $data['warning'] = $row_message['WARNING'];        

        } catch( Exception $e ) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }

        echo json_encode($data);
    }


    public function submitter_reject() {

        $o_submitter_id = null;
        $o_error_message = "";
        $o_result_msg = "";
        $o_warning = ""; 
        $user_id_login = $this->session->userdata("d_user_id");

        /* posting from submit lov */
        $interactive_message = $this->input->post('interactive_message');
        $submitter_params = json_decode($this->input->post('params') , true);

        try {

            $sql = "SELECT SUBMITTER_SEQ.nextval AS SEQ FROM DUAL";
            $query = $this->workflow->db->query($sql);
            $row = $query->row_array();
            $o_submitter_id = $row['SEQ'];

            $submitter_params['USER_ID_DOC'] = empty($submitter_params['USER_ID_DOC']) ? NULL : $submitter_params['USER_ID_DOC'];
            $submitter_params['USER_ID_DONOR'] = empty($submitter_params['USER_ID_DONOR']) ? NULL : $submitter_params['USER_ID_DOC'];
            $submitter_params['USER_ID_TAKEN'] = empty($submitter_params['USER_ID_TAKEN']) ? $user_id_login : $submitter_params['USER_ID_TAKEN'];

            $submitter_params['CURR_CTL_ID'] = empty($submitter_params['CURR_CTL_ID']) ? NULL : $submitter_params['CURR_CTL_ID'];
            $submitter_params['CURR_DOC_TYPE_ID'] = empty($submitter_params['CURR_DOC_TYPE_ID']) ? NULL : $submitter_params['CURR_DOC_TYPE_ID'];
            $submitter_params['CURR_PROC_ID'] = empty($submitter_params['CURR_PROC_ID']) ? NULL : $submitter_params['CURR_PROC_ID'];
            $submitter_params['CURR_DOC_ID'] = empty($submitter_params['CURR_DOC_ID']) ? NULL : $submitter_params['CURR_DOC_ID'];
            
            $submitter_params['PREV_CTL_ID'] = empty($submitter_params['PREV_CTL_ID']) ? NULL : $submitter_params['PREV_CTL_ID'];
            $submitter_params['PREV_DOC_TYPE_ID'] = empty($submitter_params['PREV_DOC_TYPE_ID']) ? NULL : $submitter_params['PREV_DOC_TYPE_ID'];
            $submitter_params['PREV_PROC_ID'] = empty($submitter_params['PREV_PROC_ID']) ? NULL : $submitter_params['PREV_PROC_ID'];
            $submitter_params['PREV_DOC_ID'] = empty($submitter_params['PREV_DOC_ID']) ? NULL : $submitter_params['PREV_DOC_ID'];
            
            $str_params = "";
            define("TOTAL_PARAMS", 23);
            for($i = 1; $i <= TOTAL_PARAMS; $i++) {
                if($i == 1) $str_params .= ":params".$i;
                else $str_params .= ",:params".$i;
            }

            $sql = "  BEGIN ".
                        "  pack_workflow.reject_engine(".$str_params."); END;";

            $params = array(
                array('name' => ':params1', 'value' => $o_submitter_id, 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params2', 'value' => $submitter_params['IS_CREATE_DOC'], 'type' => SQLT_CHR, 'length' => 500), 
                array('name' => ':params3', 'value' => $submitter_params['IS_MANUAL'], 'type' => SQLT_CHR, 'length' => 500), 
                array('name' => ':params4', 'value' => $submitter_params['USER_ID_DOC'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params5', 'value' => $submitter_params['USER_ID_DONOR'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params6', 'value' => $user_id_login, 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params7', 'value' => $submitter_params['USER_ID_TAKEN'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params8', 'value' => $submitter_params['CURR_CTL_ID'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params9', 'value' => $submitter_params['CURR_DOC_TYPE_ID'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params10', 'value' => $submitter_params['CURR_PROC_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params11', 'value' => $submitter_params['CURR_DOC_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params12', 'value' => $submitter_params['CURR_DOC_STATUS'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params13', 'value' => $submitter_params['CURR_PROC_STATUS'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params14', 'value' => $submitter_params['PREV_CTL_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params15', 'value' => $submitter_params['PREV_DOC_TYPE_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params16', 'value' => $submitter_params['PREV_PROC_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params17', 'value' => $submitter_params['PREV_DOC_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params18', 'value' => $interactive_message, 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params19', 'value' => $submitter_params['SLOT_1'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params20', 'value' => $submitter_params['SLOT_2'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params21', 'value' => $submitter_params['SLOT_3'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params22', 'value' => $submitter_params['SLOT_4'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params23', 'value' => $submitter_params['SLOT_5'], 'type' => SQLT_CHR, 'length' => 500)
            );
            // Bind the output parameter

            $stmt = oci_parse($this->workflow->db->conn_id,$sql);

            foreach($params as $p){
                // Bind Input
                oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
            }

            ociexecute($stmt);

            $sql_message = "SELECT ERROR_MESSAGE, RETURN_MESSAGE, WARNING FROM SUBMITTER WHERE SUBMITTER_ID = ".$o_submitter_id;
            $query_message = $this->workflow->db->query($sql_message);
            $row_message = $query_message->row_array();

            $data = array();

            if($row_message['RETURN_MESSAGE'] != "0") {
                $data['submit_success'] = true;
                $row_message['RETURN_MESSAGE'] = "BERHASIL";
            }else {
                $data['submit_success'] = false;
                $row_message['RETURN_MESSAGE'] = "";
            }
            
            $data['success'] = true;
            $data['return_message'] = $row_message['RETURN_MESSAGE'];
            $data['error_message'] = $row_message['ERROR_MESSAGE'];
            $data['warning'] = $row_message['WARNING'];        

        } catch( Exception $e ) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }

        echo json_encode($data);
    }


    public function submitter_back() {

        $o_submitter_id = null;
        $o_error_message = "";
        $o_result_msg = "";
        $o_warning = ""; 
        $user_id_login = $this->session->userdata("d_user_id");

        /* posting from submit lov */
        $interactive_message = $this->input->post('interactive_message');
        $submitter_params = json_decode($this->input->post('params') , true);

        try {

            $sql = "SELECT SUBMITTER_SEQ.nextval AS SEQ FROM DUAL";
            $query = $this->workflow->db->query($sql);
            $row = $query->row_array();
            $o_submitter_id = $row['SEQ'];

            $submitter_params['USER_ID_DOC'] = empty($submitter_params['USER_ID_DOC']) ? NULL : $submitter_params['USER_ID_DOC'];
            $submitter_params['USER_ID_DONOR'] = empty($submitter_params['USER_ID_DONOR']) ? NULL : $submitter_params['USER_ID_DOC'];
            $submitter_params['USER_ID_TAKEN'] = empty($submitter_params['USER_ID_TAKEN']) ? $user_id_login : $submitter_params['USER_ID_TAKEN'];

            $submitter_params['CURR_CTL_ID'] = empty($submitter_params['CURR_CTL_ID']) ? NULL : $submitter_params['CURR_CTL_ID'];
            $submitter_params['CURR_DOC_TYPE_ID'] = empty($submitter_params['CURR_DOC_TYPE_ID']) ? NULL : $submitter_params['CURR_DOC_TYPE_ID'];
            $submitter_params['CURR_PROC_ID'] = empty($submitter_params['CURR_PROC_ID']) ? NULL : $submitter_params['CURR_PROC_ID'];
            $submitter_params['CURR_DOC_ID'] = empty($submitter_params['CURR_DOC_ID']) ? NULL : $submitter_params['CURR_DOC_ID'];
            
            $submitter_params['PREV_CTL_ID'] = empty($submitter_params['PREV_CTL_ID']) ? NULL : $submitter_params['PREV_CTL_ID'];
            $submitter_params['PREV_DOC_TYPE_ID'] = empty($submitter_params['PREV_DOC_TYPE_ID']) ? NULL : $submitter_params['PREV_DOC_TYPE_ID'];
            $submitter_params['PREV_PROC_ID'] = empty($submitter_params['PREV_PROC_ID']) ? NULL : $submitter_params['PREV_PROC_ID'];
            $submitter_params['PREV_DOC_ID'] = empty($submitter_params['PREV_DOC_ID']) ? NULL : $submitter_params['PREV_DOC_ID'];
            
            $str_params = "";
            define("TOTAL_PARAMS", 23);
            for($i = 1; $i <= TOTAL_PARAMS; $i++) {
                if($i == 1) $str_params .= ":params".$i;
                else $str_params .= ",:params".$i;
            }

            $sql = "  BEGIN ".
                        "  pack_workflow.back_engine(".$str_params."); END;";

            $params = array(
                array('name' => ':params1', 'value' => $o_submitter_id, 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params2', 'value' => $submitter_params['IS_CREATE_DOC'], 'type' => SQLT_CHR, 'length' => 500), 
                array('name' => ':params3', 'value' => $submitter_params['IS_MANUAL'], 'type' => SQLT_CHR, 'length' => 500), 
                array('name' => ':params4', 'value' => $submitter_params['USER_ID_DOC'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params5', 'value' => $submitter_params['USER_ID_DONOR'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params6', 'value' => $user_id_login, 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params7', 'value' => $submitter_params['USER_ID_TAKEN'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params8', 'value' => $submitter_params['CURR_CTL_ID'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params9', 'value' => $submitter_params['CURR_DOC_TYPE_ID'], 'type' => SQLT_INT, 'length' => 100), 
                array('name' => ':params10', 'value' => $submitter_params['CURR_PROC_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params11', 'value' => $submitter_params['CURR_DOC_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params12', 'value' => $submitter_params['CURR_DOC_STATUS'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params13', 'value' => $submitter_params['CURR_PROC_STATUS'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params14', 'value' => $submitter_params['PREV_CTL_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params15', 'value' => $submitter_params['PREV_DOC_TYPE_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params16', 'value' => $submitter_params['PREV_PROC_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params17', 'value' => $submitter_params['PREV_DOC_ID'], 'type' => SQLT_INT, 'length' => 100),
                array('name' => ':params18', 'value' => $interactive_message, 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params19', 'value' => $submitter_params['SLOT_1'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params20', 'value' => $submitter_params['SLOT_2'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params21', 'value' => $submitter_params['SLOT_3'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params22', 'value' => $submitter_params['SLOT_4'], 'type' => SQLT_CHR, 'length' => 500),
                array('name' => ':params23', 'value' => $submitter_params['SLOT_5'], 'type' => SQLT_CHR, 'length' => 500)
            );
            // Bind the output parameter

            $stmt = oci_parse($this->workflow->db->conn_id,$sql);

            foreach($params as $p){
                // Bind Input
                oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
            }

            ociexecute($stmt);

            $sql_message = "SELECT ERROR_MESSAGE, RETURN_MESSAGE, WARNING FROM SUBMITTER WHERE SUBMITTER_ID = ".$o_submitter_id;
            $query_message = $this->workflow->db->query($sql_message);
            $row_message = $query_message->row_array();

            $data = array();

            if($row_message['RETURN_MESSAGE'] != "0") {
                $data['submit_success'] = true;
                $row_message['RETURN_MESSAGE'] = "BERHASIL";
            }else {
                $data['submit_success'] = false;
                $row_message['RETURN_MESSAGE'] = "";
            }
            
            $data['success'] = true;
            $data['return_message'] = $row_message['RETURN_MESSAGE'];
            $data['error_message'] = $row_message['ERROR_MESSAGE'];
            $data['warning'] = $row_message['WARNING'];        

        } catch( Exception $e ) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }

        echo json_encode($data);
    }

}
