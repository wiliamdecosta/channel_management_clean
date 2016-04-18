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

        $selected = 'checked="checked"';
        foreach ($items as $item) {
            

            if($item['STYPE'] == 'PROFILE') {
                $strOutput .= '<tr>
                                    <td colspan="3"><strong class="blue">'.$item['DISPLAY_NAME'].'</strong></td>
                              </tr>';
            }else {

                $strOutput .= '<tr>
                                    <td style="padding-left:35px;"><strong class="green">'.$item['DISPLAY_NAME'].'</strong></td>
                                    <td style="text-align:right;">'.$item['SCOUNT'].'</td>
                                    <td class="center"><input class="pointer" type="radio" '.$selected.' name="pilih_summary" value="'.$item['ELEMENT_ID'].'" onclick="loadUserTaskList(this);"></td>
                                    <td style="display:none;">
                                        <input type="hidden" id="'.$item['ELEMENT_ID'].'_p_w_doc_type_id" value="'.$item['P_W_DOC_TYPE_ID'].'">
                                        <input type="hidden" id="'.$item['ELEMENT_ID'].'_p_w_proc_id" value="'.$item['P_W_PROC_ID'].'">
                                        <input type="hidden" id="'.$item['ELEMENT_ID'].'_profile_type" value="'.$item['PROFILE_TYPE'].'">
                                    </td>
                              </tr>';

                $selected = 'checked=""';

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
        $sort = 'PERIOD';
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
        
        $result  = '';
        foreach($items as $item) {
            $result .= '<tr>
                            <td colspan="4"> <span class="green"><strong>'.$item['CUST_INFO'].'</strong></span></td>
                        </tr>';
            
            $result .= '<tr>';
            if($item['IS_READ'] == 'N')
                $result .= '<td><button type="button" class="btn btn-sm btn-primary">Terima</button></td>';
            else
                $result .= '<td><button type="button" class="btn btn-sm btn-primary">Buka</button></td>';        
            
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

}
