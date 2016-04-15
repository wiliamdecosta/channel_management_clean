<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wf extends CI_Controller {
    
    function __construct() {
        parent::__construct();

        checkAuth();
        $this->load->model('Workflow','workflow');
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
                                <div class="col-xs-5">
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
                            <div class="col-xs-5"> 
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
                            </tr>
                        </thead>
                        ';
        
        $strOutput .= '<tbody>';
        foreach ($items as $item) {
            
            if($item['STYPE'] == 'PROFILE') {
                $strOutput .= '<tr>
                                    <td colspan="3"><strong>'.$item['DISPLAY_NAME'].'</strong></td>
                              </tr>';
            }else {
                $strOutput .= '<tr>
                                    <td style="padding-left:35px;"><strong class="green">'.$item['DISPLAY_NAME'].'</strong></td>
                                    <td style="text-align:right;">'.$item['SCOUNT'].'</td>
                                    <td class="center"><input class="pointer" type="radio" name="pilih_summary"></td>
                              </tr>';
            }
        }
        $strOutput .= '</tbody>';

        $strOutput .= '</table>';
        echo $strOutput;
    }

}
