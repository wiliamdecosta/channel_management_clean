<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contract extends CI_Controller
{

    private $head = "Kontrak";

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        checkAuth();
        $this->load->model('M_jqGrid', 'jqGrid');
        $this->load->model('T_invoice');
        $this->load->model('T_contract');
    }


    public function index() {
        redirect("/");
    }

    public function rincian_contract(){
        $title = "Rincian Kontrak";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);
        
        $result['result'] = $this->T_invoice->getStatus();
        $this->load->view('contract/rincian_contract', $result);
    }

    public function grid_detail_contract() {

        $s_contract_no  = $this->input->post('s_contract_no');
        $s_mitra_name   = $this->input->post('s_mitra_name');
        $s_status       = $this->input->post('s_status');
        $s_awal         = $this->input->post('s_awal');
        $s_akhir        = $this->input->post('s_akhir');

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $where = '';

        if(!empty($s_contract_no)){
            $where .= " AND A.CONTRACT_NO like '%".$s_contract_no."%'";
        }

        if(!empty($s_mitra_name)){
            $where .= " AND D.PGL_NAME like '%".$s_mitra_name."%'";
        }

        if(!empty($s_status)){
            $where .= " AND B.P_ORDER_STATUS_ID = ".$s_status;
        }

        if(!empty($s_awal)){
            $where .= " AND trunc(A.VALID_FROM) = TO_DATE('".$s_awal."', 'DD/MM/YYYY')";
        }

        if(!empty($s_akhir)){
            $where .= " AND trunc(A.VALID_TO) = TO_DATE('".$s_akhir."', 'DD/MM/YYYY')";
        }

        $table = "SELECT A.T_CUSTOMER_ORDER_ID,
                       A.CONTRACT_NO,
                       B.ORDER_NO,
                       B.ORDER_DATE,
                       D.PGL_NAME AS MITRA_NAME,
                       A.VALID_FROM,
                       A.VALID_TO,
                       E.LOKASI,
                       C.CODE AS STATUS,
                       F_GET_LAST_PROC(A.T_CUSTOMER_ORDER_ID) AS LAST_PROCESS   
                FROM  T_CONTRACT_REGISTRATION A, T_CUSTOMER_ORDER B, P_ORDER_STATUS C, CUST_PGL D, P_MP_LOKASI E
                WHERE A.T_CUSTOMER_ORDER_ID = B.T_CUSTOMER_ORDER_ID
                AND B.P_ORDER_STATUS_ID = C.P_ORDER_STATUS_ID
                AND A.PGL_ID = D.PGL_ID
                AND A.P_LOCATION_ID = E.P_MP_LOKASI_ID".$where;

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        // Filter Table *
        $req_param['where'] = array();

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        //print_r($row);exit;
        //$count = count($row);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );


        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);

    }

    public function htmlRincianReport()
    {
        $output = $this->getRincianReport();
        echo $output;
        exit;
    }

    public function excelRincianReport()
    {
        $output = $this->getRincianReport();

        startExcel("rincianKontrak".date('Ymd').".xls");
        echo '<html>';
        echo '<head><title>Rincian Kontrak Report</title></head>';
        echo '<body>';
        echo $output;
        echo '</body>';
        echo '</html>';
        exit;
    }

    public function getRincianReport(){
        $s_contract_no  = !($this->input->post('s_contract_no')) ? $this->input->get('s_contract_no') : $this->input->post('s_contract_no');
        $s_mitra_name   = !($this->input->post('s_mitra_name')) ? $this->input->get('s_mitra_name') : $this->input->post('s_mitra_name');
        $s_status       = !($this->input->post('s_status')) ? $this->input->get('s_status') : $this->input->post('s_status');
        $s_awal         = !($this->input->post('s_awal')) ? $this->input->get('s_awal') : $this->input->post('s_awal');
        $s_akhir        = !($this->input->post('s_akhir')) ? $this->input->get('s_akhir') : $this->input->post('s_akhir');

        $where = '';
        if(!empty($s_contract_no)){
            $where .= " AND A.CONTRACT_NO like '%".$s_contract_no."%'";
        }

        if(!empty($s_mitra_name)){
            $where .= " AND D.PGL_NAME like '%".$s_mitra_name."%'";
        }

        if(!empty($s_status)){
            $where .= " AND B.P_ORDER_STATUS_ID = ".$s_status;
        }

        if(!empty($s_awal)){
            $where .= " AND trunc(A.VALID_FROM) = TO_DATE('".$s_awal."', 'DD/MM/YYYY')";
        }

        if(!empty($s_akhir)){
            $where .= " AND trunc(A.VALID_TO) = TO_DATE('".$s_akhir."', 'DD/MM/YYYY')";
        }

        $sql = "SELECT A.T_CUSTOMER_ORDER_ID,
                       A.CONTRACT_NO,
                       B.ORDER_NO,
                       B.ORDER_DATE,
                       D.PGL_NAME AS MITRA_NAME,
                       A.VALID_FROM,
                       A.VALID_TO,
                       E.LOKASI,
                       C.CODE AS STATUS,
                       F_GET_LAST_PROC(A.T_CUSTOMER_ORDER_ID) AS LAST_PROCESS   
                FROM  T_CONTRACT_REGISTRATION A, T_CUSTOMER_ORDER B, P_ORDER_STATUS C, CUST_PGL D, P_MP_LOKASI E
                WHERE A.T_CUSTOMER_ORDER_ID = B.T_CUSTOMER_ORDER_ID
                AND B.P_ORDER_STATUS_ID = C.P_ORDER_STATUS_ID
                AND A.PGL_ID = D.PGL_ID
                AND A.P_LOCATION_ID = E.P_MP_LOKASI_ID".$where;

        $query = $this->db->query($sql);
        $items = $query->result_array();

        $output = '';
        $output .= '<table width="100%">';
        $output .= '<tr>
                       <td colspan="9" style="text-align:center;"> <span style="font-size:16px;"><b>LAPORAN RINCIAN KONTRAK</b></span></td>
                   </tr>';
        //$output .= '<tr><td colspan="9">&nbsp;</td></tr>';
        $output .= '<table>';

        $output .= '<table width="100%" border="1">';
        $output .= '<tr>
                        <th style="text-align:left;">No. Order</th>
                        <th style="text-align:center;">Tgl. Order</th>
                        <th style="text-align:left;">No. Kontrak</th>                        
                        <th style="text-align:left;">Nama Mitra</th>
                        <th style="text-align:left;">Lokasi</th>
                        <th style="text-align:center;">Tgl. Berlaku</th>
                        <th style="text-align:center;">Sampai</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:left;">Posisi Terakhir</th>
                    </tr>';

        foreach ($items as $item) {
            $no_order = "'".$item['ORDER_NO']."'";
            $output .= '<tr>';
            $output .= '<td style="text-align:left">'.$no_order.'</td>';
            $output .= '<td style="text-align:center">'.$item['ORDER_DATE'].'</td>';
            $output .= '<td style="text-align:left">'.$item['CONTRACT_NO'].'</td>';            
            $output .= '<td style="text-align:left">'.$item['MITRA_NAME'].'</td>';
            $output .= '<td style="text-align:left">'.$item['LOKASI'].'</td>';
            $output .= '<td style="text-align:center">'.$item['VALID_FROM'].'</td>';
            $output .= '<td style="text-align:center">'.$item['VALID_TO'].'</td>';
            $output .= '<td style="text-align:center">'.$item['STATUS'].'</td>';
            $output .= '<td style="text-align:left">'.$item['LAST_PROCESS'].'</td>';
            $output .= '</tr>';
        }

        $output .= '</table>';

        return $output;
    }

    public function summary_contract(){
        $title = "Summary Kontrak";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);
        
        $result['data_chart'] = $this->T_contract->getPieChart();
        $this->load->view('contract/summary_contract', $result);
    }

    public function summary_current_month(){
        $items = $this->T_contract->getSumMonth();
        $result = '';
        foreach($items as $item) {
            $result .= '<tr>
                            <td>'.$item->STATUS.'</td>
                            <td style="text-align:right;">'.numberFormat((float)$item->JML_INV, 2).'</td>
                            <td style="text-align:right;">'.numberFormat((float)$item->TOTAL_NILAI_INV, 2).'</td>
                        </tr>';
            $header = strtoupper($item->BULAN);
        }
        $data['header'] = $header;
        $data['contents'] = $result;
        echo json_encode($data);;
    }

    public function summary_current_year(){
        $items = $this->T_contract->getSumYear();
        $result = '';
        foreach($items as $item) {
            $result .= '<tr>
                            <td>'.$item->BLN_CHAR.'</td>
                            <td style="text-align:right;">'.numberFormat((float)$item->JML_INV, 2).'</td>
                            <td style="text-align:right;">'.numberFormat((float)$item->TOTAL_NILAI_INV, 2).'</td>
                            <td style="text-align:right;">'.numberFormat((float)$item->JML_INV2, 2).'</td>
                            <td style="text-align:right;">'.numberFormat((float)$item->TOTAL_NILAI_INV2, 2).'</td>
                            <td style="text-align:right;">'.numberFormat((float)$item->JML_INV3, 2).'</td>
                            <td style="text-align:right;">'.numberFormat((float)$item->TOTAL_NILAI_INV3, 2).'</td>
                        </tr>';
            $header = strtoupper($item->TAHUN);
        }
        $data['header'] = $header;
        $data['contents'] = $result;
        echo json_encode($data);;
    }

}
