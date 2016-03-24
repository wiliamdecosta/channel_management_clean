<?php 

class Skema_bisnis extends CI_Controller
{

    private $head = "Marketing Fee";
    private $folder = "skema_bisnis";

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        checkAuth();

        /*
            modified by wiliam : untuk kepentingan download excel maka statement berikut dicomment
            if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }*/

        $this->load->model('m_skembis');
        $this->load->model('M_jqGrid', 'jqGrid');
    }

    public function index()
    {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        // Fungsi dropdown tenant
        $this->load->model('M_cm', 'cm');
        if ($this->session->userdata('d_prof_id') == 3) {
            $result['result'] = $this->cm->getPglListByID($this->session->userdata('d_user_id'));
        } else {
            $result['result'] = $this->cm->getPglList();
        }

        $this->load->view('managementmitra/filter_mitra', $result);
        $this->load->view('skema_bisnis/skembis_tab');
    }

    public function createSkema()
    {
        $data["pgl_id"] = $this->input->post("mitra");
        $this->load->view($this->folder . '/create_skema', $data);
    }

    public function benefit_produk_group()
    {
        $data['comp'] = $this->m_skembis->getComfeeByProduct();
        $this->load->view($this->folder . '/create_skema_detail_produk', $data);
    }
    public function benefit_produk_detail()
    {
        $data['pgl_id'] = $this->input->post('mitra');
        $data['schm_fee_id'] = gen_id('SCHM_FEE_ID', 'SCHM_FEE');
        $this->load->view('skema_bisnis/form_rvs_detail', $data);
    }


    public function createSkemaBlended()
    {
        $this->load->view($this->folder . '/create_skema_blended');
    }

    public function createSkemaRC100()
    {
        $this->load->view($this->folder . '/create_skema_rc_100');
    }

    public function createSkemaRCGreater100()
    {
        $this->load->view($this->folder . '/create_skema_rc_greater_100');
    }

    public function createSkemaPAYG()
    {
        $this->load->view($this->folder . '/create_skema_payg');
    }

    public function createSkemaPaygPositiveGrowth()
    {
        $this->load->view($this->folder . '/create_skema_payg_positive_growth');
    }

    public function createSkemaPaygNegativeGrowth()
    {
        $this->load->view($this->folder . '/create_skema_payg_negative_growth');
    }

    public function calculateMF()
    {
        $data['pgl_id'] = $this->input->post('mitra');
        $this->load->view($this->folder . '/calculate_mf', $data);
    }

    public function createBARekon()
    {
        $this->load->view($this->folder . '/create_ba_rekon');
    }

    public function createPerhitunganBillco()
    {
        $this->load->view($this->folder . '/create_perhitungan_billco');
    }

    public function createNPK()
    {
        $data['pgl_id'] = $this->input->post('mitra');
        $this->load->view($this->folder . '/create_npk',$data);
    }

    public function evaluasiMitra()
    {
        $this->load->view($this->folder . '/evaluasi_mitra');
    }

    public function form_skema_bisnis()
    {
        $pgl_id = $this->input->post("form_pgl_id");

        $PPN = intval($this->input->post("PPN"));
        $BPH_JASTEL = intval($this->input->post("BPH_JASTEL"));
        $MARFEE_BEFORE_TAX = intval($this->input->post("MARFEE_BEFORE_TAX"));

        $comp = $this->m_skembis->getComfeeByProduct();
        $arrComp = array();
        foreach ($comp as $comp_fee) {
            if ($this->input->post($comp_fee['CF_NAME']) != null) {
                $arrComp[] = array('CF_NAME' => $comp_fee['CF_NAME'],
                    'CF_ID' => $comp_fee['CF_ID'],
                    'VALUE' => $this->input->post($comp_fee['CF_NAME'])
                );
            }
        }
        $arrPPN = array('CF_NAME' => "PPN",
            'CF_ID' => 6,
            'VALUE' => $PPN
        );
        $arrBPHJ = array('CF_NAME' => "BPH_JASTEL",
            'CF_ID' => 7,
            'VALUE' => $BPH_JASTEL
        );
        $arrBefTax = array('CF_NAME' => "MARFEE_BEFORE_TAX",
            'CF_ID' => 33,
            'VALUE' => $MARFEE_BEFORE_TAX
        );

        /*$smry = $this->m_skembis->getCompfeeSMRY();
        foreach ($comp as $comp_fee) {
            $arrComp[] = array('CF_NAME' => $comp_fee['CF_NAME'],
                'CF_ID' => $comp_fee['CF_ID'],
                'VALUE' => $this->input->post($comp_fee['CF_NAME'])
            );

        }*/

        $arrComp[] = $arrPPN;
        $arrComp[] = $arrBPHJ;
        $arrComp[] = $arrBefTax;


        if ($pgl_id) {
            $this->m_skembis->createSkema($arrComp);
            $data['success'] = true;
            $data['message'] = "Skema berhasil ditambahkan";
            echo json_encode($data);
        } else {
            $data['success'] = false;
            $data['message'] = "Mitra tidak ada";
            echo json_encode($data);
        }
    }

    public function skembis()
    {
        $data['pgl_id'] = $this->input->post('mitra');
        $this->load->view($this->folder . '/grid_skembis', $data);
    }


    public function gridSkembis()
    {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "V_SKEMBIS";

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

        $pgl_id = $this->input->post('pgl_id');
        $periode = $this->input->post('periode');
        $req_param['where'] = array('PGL_ID' => $pgl_id);

        if ($this->input->post('skema_id')) {
            $req_param['where'] = array('SCHM_FEE_ID' => $this->input->post('skema_id'));
        }
        if ($periode) {
            /*$schm_id = $this->m_skembis->getListSchmNPK($pgl_id,$periode);
            $req_param['where_in']['field'] ='SCHM_FEE_ID';
            if($schm_id){
                $req_param['where_in']['value'] = $schm_id;
            }else{
                $req_param['where_in']['value'] = array(null);
            }*/

        }

        $row = $this->jqGrid->get_data($req_param)->result_array();
        //print_r($row);exit;
        $count = count($row);

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

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function gridSkembisCalculate()
    {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "V_SKEMBIS_CALCULATE";

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

        $pgl_id = $this->input->post('pgl_id');
        $periode = $this->input->post('periode');
        $skema_id = $this->input->post('skema_id');


        //print_r($skema_id);
        // exit;

        $req_param['where'] = array('PGL_ID' => $pgl_id);
        $req_param['where'] = array('PERIOD' => $periode);
        if ($this->input->post('skema_id')) {
            $req_param['where'] = array('SCHM_FEE_ID' => $this->input->post('skema_id'));
        }

        $row = $this->jqGrid->get_data($req_param)->result_array();
        //print_r($row);exit;
        $count = count($row);

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

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function edit_skemabisnis()
    {
        $schm_id = $this->input->post("SCHM_FEE_ID");
        //$data['comp'] = $this->m_skembis->getComfeeByProduct();
        $arr = $this->m_skembis->getComfeeByProduct();
        $arrSchm = $this->m_skembis->getSchmByID($schm_id);


        $CF_NAME = array();
        foreach ($arrSchm as $arrcomp) {
            $CF_NAME[] = array("CF_NAME" => $arrcomp['CF_NAME'],
                "CF_TYPE" => $arrcomp['CF_TYPE'],
                "CF_ID" => $arrcomp['CF_ID'],
                "PERCENTAGE" => $arrcomp['PERCENTAGE'],
            );
        }

        $data['comp_json'] = json_encode($CF_NAME);

        $data['PGL_ID'] = $this->input->post("PGL_ID");
        $data['SCHM_FEE_ID'] = $this->input->post("SCHM_FEE_ID");
        $data['CF_ID'] = $this->input->post("CF_ID");
        $data['METHOD_ID'] = $this->input->post("METHOD_ID");
        $data['comp'] = $arr;
        $this->load->view($this->folder . '/form_edit_skembis', $data);
    }

    public function edit_action_skembis()
    {
        $pgl_id = $this->input->post("PGL_ID");

        $PPN = intval($this->input->post("PPN"));
        $BPH_JASTEL = intval($this->input->post("BPH_JASTEL"));
        $MARFEE_BEFORE_TAX = intval($this->input->post("MARFEE_BEFORE_TAX"));

        $comp = $this->m_skembis->getComfeeByProduct();
        $arrComp = array();
        foreach ($comp as $comp_fee) {
            if ($this->input->post($comp_fee['CF_NAME']) != null) {
                $arrComp[] = array('CF_NAME' => $comp_fee['CF_NAME'],
                    'CF_ID' => $comp_fee['CF_ID'],
                    'VALUE' => $this->input->post($comp_fee['CF_NAME'])
                );
            }
        }
        $arrPPN = array('CF_NAME' => "PPN",
            'CF_ID' => 6,
            'VALUE' => $PPN
        );
        $arrBPHJ = array('CF_NAME' => "BPH_JASTEL",
            'CF_ID' => 7,
            'VALUE' => $BPH_JASTEL
        );
        $arrBefTax = array('CF_NAME' => "MARFEE_BEFORE_TAX",
            'CF_ID' => 33,
            'VALUE' => $MARFEE_BEFORE_TAX
        );

        $arrComp[] = $arrPPN;
        $arrComp[] = $arrBPHJ;
        $arrComp[] = $arrBefTax;


        if ($pgl_id) {
            $this->m_skembis->editSkema($arrComp);
            $data['success'] = true;
            $data['message'] = "Skema berhasil diupdate";
            echo json_encode($data);
        } else {
            $data['success'] = false;
            $data['message'] = "Mitra tidak ada";
            echo json_encode($data);
        }
    }

    public function proses_calculate()
    {
        $pgl_id = $this->input->post('pgl_id');
        $skema_id = $this->input->post('skema_id');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        return $this->m_skembis->calculateMF();
    }

    public function grid_skembis_calculate()
    {
        $data['pgl_id'] = $this->input->post('pgl_id');
        $data['skema_id'] = $this->input->post('skema_id');
        $data['periode'] = $this->input->post('tahun') . "" . $this->input->post('bulan');
        $this->load->view('skema_bisnis/grid_skembis_calculate', $data);
    }

    public function loadFlatRevenue()
    {
        $data['pgl_id'] = $this->input->post('mitra');
        $this->load->view('skema_bisnis/flat_revenue', $data);
    }

    public function addFlatSkema()
    {
        $this->m_skembis->addFlatSkema();
    }

    public function loadMTR()
    {
        $data['pgl_id'] = $this->input->post('mitra');
        $data['commitment_id'] = gen_id('COMMITMENT_ID', 'P_COMMITMENT');
        $this->load->view('skema_bisnis/form_mtr', $data);
    }

    public function getTreeComp()
    {
        $result = $this->m_skembis->getTreeComp();
        $data = array();
        foreach ($result as $comp) {

            $data[] = array(
                'id' => $comp->CF_ID,
                'parentid' => $comp->CF_ID,
                'text' => $comp->CF_NAME,
                'value' => $comp->CF_ID,
                'expanded' => true

            );


        }
        echo json_encode($data);
    }

    public function addCompProgressif()
    {
        $comp = $this->input->post("comp");
        if ($comp) {
            $this->m_skembis->add_comp_progressif();
        } else {
            $data['success'] = false;
            $data['message'] = "Tidak ada component yang dipilih !";
            echo json_encode($data);
        }

    }

    public function addCompMTR()
    {
        $comp = $this->input->post("comp");
        if ($comp) {
            $this->m_skembis->add_comp_mtr();
        } else {
            $data['success'] = false;
            $data['message'] = "Tidak ada component yang dipilih !";
            echo json_encode($data);
        }

    }

    public function loadSkemaCustom()
    {
        $data['pgl_id'] = $this->input->post('mitra');
        $data['schm_fee_id'] = gen_id('SCHM_FEE_ID', 'SCHM_FEE');
        $data['commitment_id'] = gen_id('COMMITMENT_ID', 'P_COMMITMENT');
        $this->load->view('skema_bisnis/form_skema_custom', $data);
    }

    public function gridCompSkemaCustom()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : null;
        $sord = isset($_POST['sord']) ? $_POST['sord'] : null;

        $table = "V_SKEMBIS";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "or_where" => null,
            "or_where_in" => null,
            "or_where_not_in" => null,
            "search" => $this->input->post('_search'),
            "search_field" => ($this->input->post('searchField')) ? $this->input->post('searchField') : null,
            "search_operator" => ($this->input->post('searchOper')) ? $this->input->post('searchOper') : null,
            "search_str" => ($this->input->post('searchString')) ? ($this->input->post('searchString')) : null
        );

        // Filter Table *

        $schm_fee_id = $this->input->post('schm_fee_id');
        if ($schm_fee_id) {
            $req_param['where'] = array('SCHM_FEE_ID' => $schm_fee_id);
        }

        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function gridTierCondition(){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : null;
        $sord = isset($_POST['sord']) ? $_POST['sord'] : null;

        $table = "P_COMMITMENT_TIER_COND";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "or_where" => null,
            "or_where_in" => null,
            "or_where_not_in" => null,
            "search" => $this->input->post('_search'),
            "search_field" => ($this->input->post('searchField')) ? $this->input->post('searchField') : null,
            "search_operator" => ($this->input->post('searchOper')) ? $this->input->post('searchOper') : null,
            "search_str" => ($this->input->post('searchString')) ? ($this->input->post('searchString')) : null
        );

        // Filter Table *

        $COMMITMENT_ID = $this->input->post('COMMITMENT_ID');
        if ($COMMITMENT_ID) {
            $req_param['where'] = array('COMMITMENT_ID' => $COMMITMENT_ID);
        }

        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);
    }

    public function getListComponent()
    {
        $result = $this->m_skembis->getTreeComp();
        echo "<select>";
        foreach ($result as $value) {
            echo "<option value=" . $value->CF_ID . ">" . $value->CF_NAME . "</option>";
        }
        echo "</select>";
    }

    public function crud_skema_custom()
    {
        $this->m_skembis->crud_skema_custom();
    }

    public function loadSkemaProgressif()
    {
        $data['pgl_id'] = $this->input->post('mitra');
        $data['commitment_id'] = gen_id('COMMITMENT_ID', 'P_COMMITMENT');
        $this->load->view('skema_bisnis/form_progressif', $data);
    }
    
    
    public function getSkemaSelectOption() {
        
        $period = $this->input->post('period'); 
        $pgl_id = $this->input->post('pgl_id'); 
              
        $sql  = "SELECT SCHM_FEE_ID, NPK_FEE_ID, NAME
                FROM V_CREAT_NPK_FEE 
                WHERE PERIODE = '".$period."'
                AND PGL_ID = ".$pgl_id;        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        
        $option = '<option value=""> -- Pilih Skema -- </option>';
        foreach($result as $content){
            $option  .= "<option value=".$content['NPK_FEE_ID'].">".$content['NAME']."</option>";
        }
        echo $option;
        exit;
    }
    
    public function isSkemaLock() {
        
        $npk_fee_id = $this->input->post('npk_fee_id'); 
        
        $sql  = "SELECT STATUS FROM NPK_FEE
                    WHERE NPK_FEE_ID = ".$npk_fee_id;        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        
        echo $result[0]['STATUS'];
        exit;
    }
    
    
    public function htmlNPKReport() {
        $output = $this->getNPKReport();
        echo $output;
        exit;
    }
    
        
    public function excelNPKReport() {
        $period = $this->input->get('period');
        $schm_fee_name = $this->input->get('schm_fee_name');   
        $schm_fee_arr = explode("-",$schm_fee_name);
        $output = $this->getNPKReport();
        
        startExcel($period."_".str_replace(" ","_",$schm_fee_arr[0]).".xls");
        echo '<html>';
        echo '<head><title>NPK Report</title></head>';
        echo '<body>';
        echo $output;
        echo '</body>';
        echo '</html>';
        exit;
    }
    
    public function getNPKReport() {
                
        $period = !($this->input->post('period')) ? $this->input->get('period') : $this->input->post('period');
        $tahun = !($this->input->post('tahun')) ? $this->input->get('tahun') : $this->input->post('tahun');
        $bulan = !($this->input->post('bulan')) ? $this->input->get('bulan') : $this->input->post('bulan');
        $schm_fee_name = !($this->input->post('schm_fee_name')) ? $this->input->get('schm_fee_name') : $this->input->post('schm_fee_name');
        $npk_fee_id = !($this->input->post('npk_fee_id')) ? $this->input->get('npk_fee_id') : $this->input->post('npk_fee_id');
        
        $schm_fee_arr = explode("-",$schm_fee_name);
        
        $sql  = "SELECT SCHM_FEE_ID FROM V_CREAT_NPK_FEE 
                    WHERE NPK_FEE_ID = ".$npk_fee_id;        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $schm_fee_id = $result[0]['SCHM_FEE_ID'];
        
        /*header*/
        $output = '<style>td { 
                        padding:1px;
                    }</style>';
        $output .= '<table width="100%">';
        $output .= '<tr>
                       <td colspan="4" style="text-align:center;"> <span style="font-size:16px;"><b>NOTA PERHITUNGAN KEUANGAN (NPK) MARKETING FEE</b></span></td>
                   </tr>';
        $output .= '<tr>
                       <td colspan="4" style="text-align:center;"><span style="font-size:16px;"><b>'.$schm_fee_arr[0].'</b></span></td>
                   </tr>';
        $output .= '<tr>
                       <td colspan="4" style="text-align:center;"><span style="font-size:14px;"><b>PERIODE TAGIHAN : '.$bulan.' '.$tahun.'</b></span></td>
                   </tr>';
        $output .= '<tr><td colspan="4">&nbsp;</td></tr>';
        $output .= '<table>';
        
        
        /*content*/
        $sql  = "SELECT * FROM V_SKEMBIS WHERE SCHM_FEE_ID = ?";        
        $query = $this->db->query($sql, array($schm_fee_id));
        $items = $query->result_array();
        
        
        $output .= '<table width="100%" border="1">';
        $output .= '<tr>
                        <th style="text-align:center;">Komponen Fee</th>
                        <th style="text-align:center;">Gross Revenue</th>
                        <th style="text-align:center;">% Hak Telkom</th>
                        <th style="text-align:center;">Net Revenue Telkom</th>
                    </tr>';
        
        foreach($items as $item) {
            
            if(strtoupper($item['CF_NAME']) == 'JML_FASTEL' || strtoupper($item['CF_NAME']) == 'GROSS_ARPU'
                || strtoupper($item['CF_NAME']) == 'NET_ARPU') {
                
                $output .= '<tr>';
                $output .= '<td>'.$item['CF_NAME'].'</td>';
                $output .= '<td style="text-align:right">-</td>';
                $output .= '<td style="text-align:right">-</td>';
                $output .= '<td style="text-align:right">'.numberFormat((float)$item['GROSS_REVENUE'],0).'</td>';
                $output .= '</tr>';
                
            }else {
            
                $output .= '<tr>';
                $output .= '<td>'.$item['CF_NAME'].'</td>';
                $output .= '<td style="text-align:right">Rp. '.numberFormat((float)$item['GROSS_REVENUE'],0).'</td>';
                $output .= '<td style="text-align:right">'.numberFormat((float)$item['PERCENTAGE'],0).' %</td>';
                $output .= '<td style="text-align:right">Rp. '.numberFormat((float)$item['NET_REVENUE'],0).'</td>';
                $output .= '</tr>';
            }
        }
        
        $output .= '</table>';
        
        $output .= '<br><br>';
        
        /* tanggal dan tanda tangan */
        $output .= '<table width="100%">';
        $output .= '<tr><td colspan="2">&nbsp;</td><td colspan="2" style="text-align:center;"><b>Jakarta,&nbsp;&nbsp;&nbsp;'.getMonthName(date("m")).' '.date("Y").'</b></td></tr>';
        $output .= '<tr><td colspan="4">&nbsp;</td></tr>';
        $output .= '<tr>
                        <td colspan="2" style="text-align:center;"> <b>PT TELEKOMUNIKASI INDONESIA, Tbk </b></td>
                        <td colspan="2" style="text-align:center;"> <b>'.strtoupper($schm_fee_arr[0]).'</b></td>
                    </tr>';
        $output .= '<tr><td colspan="4">&nbsp;</td></tr>';
        $output .= '<tr><td colspan="4">&nbsp;</td></tr>';
        $output .= '<tr><td colspan="4">&nbsp;</td></tr>';
        $output .= '<tr><td colspan="4">&nbsp;</td></tr>';
        $output .= '<tr>
                        <td style="text-align:center;"><u><b>NAMA SM MKT DES</b></u></td>
                        <td style="text-align:center;"><u><b>NAMA GENERAL MANAGER</b></u></td>
                        
                        <td colspan="2" style="text-align:center;"><u><b>NAMA DIREKTUR</b></u></td>
                    </tr>';
        $output .= '<tr>
                        <td style="text-align:center;"><b>SM MKT DES</b></td>
                        <td style="text-align:center;"><b>GENERAL MANAGER</b></td>
                        
                        <td colspan="2" style="text-align:center;"><b>DIREKTUR</b></td>
                    </tr>';
        $output .= '</table>';
        
        return $output;
    }
    
    function lockSkemaNPK() {
        
        $data = array('success' => false, 'message' => 'Gagal mengunci skema');
        $npk_fee_id = $this->input->post('npk_fee_id'); 
        
        $sql  = "SELECT SCHM_FEE_ID FROM V_CREAT_NPK_FEE 
                    WHERE NPK_FEE_ID = ".$npk_fee_id;        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $schm_fee_id = $result[0]['SCHM_FEE_ID'];
            
        $sql = "  BEGIN ".
               "  PCKG_CAL_NPK_FEE.SCHM_PROCESS(:params1, :params2); END;";


        $params = array(
            array('name' => ':params1', 'value' => $npk_fee_id, 'type' => SQLT_INT, 'length' => 32),
            array('name' => ':params2', 'value' => $schm_fee_id, 'type' => SQLT_INT, 'length' => 32)
        );
        // Bind the output parameter

        $stmt = oci_parse($this->db->conn_id,$sql);

        foreach($params as $p){
            // Bind Input
            oci_bind_by_name($stmt,$p['name'], $p['value'], $p['length']);
        }

        ociexecute($stmt);
        
        $data['success'] = true;
        $data['message'] = 'Skema Berhasil Dikunci';
        echo json_encode($data);
        exit;
    }
    
    public function rintasheet($pgl_id, $period) {
        // Set unlimited usage memory for big data
        ini_set('memory_limit', '-1');
        // Sheet
        $this->load->model('M_cm','cm');
        $this->load->library("phpexcel");
        $filename = "rinta_".$pgl_id."_".$period.".xls";
        $this->phpexcel->getProperties()->setCreator("PT Telekomunikasi Indonesia, Tbk")
            ->setLastModifiedBy("PT Telekomunikasi Indonesia, Tbk")
            ->setTitle("REPORT")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Rincian Tagihan");
        $this->phpexcel->setActiveSheetIndex(0);
        $sh = & $this->phpexcel->getActiveSheet();
        $sh->setCellValue('A1', 'ND')
            ->setCellValue('B1', 'NAMA PLG')
            ->setCellValue('C1', 'ABONEMEN')
            ->setCellValue('D1', 'KREDIT')
            ->setCellValue('E1', 'DEBET')
            ->setCellValue('F1', 'LOKAL')
            ->setCellValue('G1', 'INTERLOKAL')
            ->setCellValue('H1', 'SLJJ')
            ->setCellValue('I1', 'SLI007')
            ->setCellValue('J1', 'SLI001')
            ->setCellValue('K1', 'SLI008')
            ->setCellValue('L1', 'SLI009')
            ->setCellValue('M1', 'TELKOM GLOBAL 017')
            ->setCellValue('N1', 'TELKOMNET INSTAN')
            ->setCellValue('O1', 'TELKOMSAVE')
            ->setCellValue('P1', 'STB')
            ->setCellValue('Q1', 'STB TSL')
            ->setCellValue('R1', 'STB EXL')
            ->setCellValue('S1', 'STB HCP')
            ->setCellValue('T1', 'STB INM')
            ->setCellValue('U1', 'STB OTHERS')

            ->setCellValue('V1', 'EXPENSE SLI')
            ->setCellValue('W1', 'EXPENSE IN')
            ->setCellValue('X1', 'PAY_TV')

            ->setCellValue('Y1', 'JAPATI')
            ->setCellValue('Z1', 'SPEEDY USAGE')
            ->setCellValue('AA1', 'NON JASTEL')
            ->setCellValue('AB1', 'ISDN DATA')
            ->setCellValue('AC1', 'ISDN VOICE')
            ->setCellValue('AD1', 'KONTEN')
            ->setCellValue('AE1', 'PORTWHOLESALES')
            ->setCellValue('AF1', 'METERAI')
            ->setCellValue('AG1', 'PPN')

            ->setCellValue('AH1', 'LAIN LAIN')

            ->setCellValue('AI1', 'TOTAL RINCIAN')
            ->setCellValue('AJ1', 'GRAND TOTAL')

            ->setCellValue('AK1', 'KURS')

            ->setCellValue('AL1', 'STATUS BAYAR')
            ->setCellValue('AM1', 'TGL BAYAR')

        ;

        $sh->getStyle('A1:AM1')->getFont()->setBold(TRUE);
        $sh->getColumnDimension('A')->setAutoSize(TRUE);
        $sh->getColumnDimension('B')->setAutoSize(TRUE);
        $sh->getColumnDimension('C')->setAutoSize(TRUE);
        $sh->getColumnDimension('D')->setAutoSize(TRUE);
        $sh->getColumnDimension('E')->setAutoSize(TRUE);
        $sh->getColumnDimension('F')->setAutoSize(TRUE);
        $sh->getColumnDimension('G')->setAutoSize(TRUE);
        $sh->getColumnDimension('H')->setAutoSize(TRUE);
        $sh->getColumnDimension('I')->setAutoSize(TRUE);
        $sh->getColumnDimension('J')->setAutoSize(TRUE);
        $sh->getColumnDimension('K')->setAutoSize(TRUE);
        $sh->getColumnDimension('L')->setAutoSize(TRUE);
        $sh->getColumnDimension('M')->setAutoSize(TRUE);
        $sh->getColumnDimension('N')->setAutoSize(TRUE);
        $sh->getColumnDimension('O')->setAutoSize(TRUE);
        $sh->getColumnDimension('P')->setAutoSize(TRUE);
        $sh->getColumnDimension('Q')->setAutoSize(TRUE);
        $sh->getColumnDimension('R')->setAutoSize(TRUE);
        $sh->getColumnDimension('S')->setAutoSize(TRUE);
        $sh->getColumnDimension('T')->setAutoSize(TRUE);
        $sh->getColumnDimension('U')->setAutoSize(TRUE);
        $sh->getColumnDimension('V')->setAutoSize(TRUE);
        $sh->getColumnDimension('W')->setAutoSize(TRUE);
        $sh->getColumnDimension('X')->setAutoSize(TRUE);
        $sh->getColumnDimension('Y')->setAutoSize(TRUE);
        $sh->getColumnDimension('Z')->setAutoSize(TRUE);
        $sh->getColumnDimension('AA')->setAutoSize(TRUE);
        $sh->getColumnDimension('AB')->setAutoSize(TRUE);
        $sh->getColumnDimension('AC')->setAutoSize(TRUE);
        $sh->getColumnDimension('AD')->setAutoSize(TRUE);
        $sh->getColumnDimension('AE')->setAutoSize(TRUE);
        $sh->getColumnDimension('AF')->setAutoSize(TRUE);
        $sh->getColumnDimension('AG')->setAutoSize(TRUE);
        $sh->getColumnDimension('AH')->setAutoSize(TRUE);
        $sh->getColumnDimension('AI')->setAutoSize(TRUE);
        $sh->getColumnDimension('AJ')->setAutoSize(TRUE);
        $sh->getColumnDimension('AK')->setAutoSize(TRUE);
        $sh->getColumnDimension('AL')->setAutoSize(TRUE);
        $sh->getColumnDimension('AM')->setAutoSize(TRUE);
        $sh->getStyle('A1:AM1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('A1:AM1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $sh->getStyle('A1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('B1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('D1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('E1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('F1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('G1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('I1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('J1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('K1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('L1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('M1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('N1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('O1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('P1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('Q1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('R1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('S1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('T1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('U1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('V1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('W1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('X1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('Y1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('Z1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AA1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AB1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AC1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AD1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AE1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AF1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AG1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AH1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AI1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AJ1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AK1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AL1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AM1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AM1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $x = 2;
        $dt = $this->cm->excelRintaFromNPK($period, $pgl_id);
        $no = 1;
        if(count($dt) > 0) {
            foreach($dt as $k => $r) {
                $sh->getCell('A'.$x)->setValueExplicit($r->ND1, PHPExcel_Cell_DataType::TYPE_STRING);
                $sh->setCellValue('B'.$x, @$r->NOM);
                $sh->setCellValue('C'.$x, @$r->ABONEMEN);
                $sh->setCellValue('D'.$x, @$r->MNT_TCK_C);
                $sh->setCellValue('E'.$x, @$r->MNT_TCK_D);
                $sh->setCellValue('F'.$x, @$r->LOKAL);
                $sh->setCellValue('G'.$x, @$r->INTERLOKAL);
                $sh->setCellValue('H'.$x, @$r->SLJJ);
                $sh->setCellValue('I'.$x, @$r->SLI007);
                $sh->setCellValue('J'.$x, @$r->SLI001);
                $sh->setCellValue('K'.$x, @$r->SLI008);
                $sh->setCellValue('L'.$x, @$r->SLI009);
                $sh->setCellValue('M'.$x, @$r->SLI_017);
                $sh->setCellValue('N'.$x, @$r->TELKOMNET_INSTAN);
                $sh->setCellValue('O'.$x, @$r->TELKOMSAVE);
                $sh->setCellValue('P'.$x, @$r->STB);
                //add STB
                $sh->setCellValue('Q'.$x, @$r->STB_TSL);
                $sh->setCellValue('R'.$x, @$r->STB_EXL);
                $sh->setCellValue('S'.$x, @$r->STB_HCP);
                $sh->setCellValue('T'.$x, @$r->STB_INM);
                $sh->setCellValue('U'.$x, @$r->STB_OTHERS);
                // End
                $sh->setCellValue('V'.$x, @$r->EXPENSE_SLI);
                $sh->setCellValue('W'.$x, @$r->EXPENSE_IN);
                $sh->setCellValue('X'.$x, @$r->PAY_TV);

                $sh->setCellValue('Y'.$x, @$r->JAPATI);
                $sh->setCellValue('Z'.$x, @$r->USAGE_SPEEDY);
                $sh->setCellValue('AA'.$x, @$r->NON_JASTEL);
                $sh->setCellValue('AB'.$x, @$r->ISDN_DATA);
                $sh->setCellValue('AC'.$x, @$r->ISDN_VOICE);
                $sh->setCellValue('AD'.$x, @$r->KONTEN);
                $sh->setCellValue('AE'.$x, @$r->PORTWHOLESALES);
                $sh->setCellValue('AF'.$x, @$r->METERAI);
                $sh->setCellValue('AG'.$x, @$r->PPN);

                $sh->setCellValue('AH'.$x, @$r->LAIN_LAIN);

                $sh->setCellValue('AI'.$x, @$r->TOTAL);
                $sh->setCellValue('AJ'.$x, @$r->GRAND_TOTAL);

                $sh->getCell('AK'.$x)->setValueExplicit($r->KURS, PHPExcel_Cell_DataType::TYPE_STRING);

                $sh->getCell('AL'.$x)->setValueExplicit($r->STATUS_PEMBAYARAN, PHPExcel_Cell_DataType::TYPE_STRING);
                $sh->getCell('AM'.$x)->setValueExplicit($r->TGL_BYR, PHPExcel_Cell_DataType::TYPE_STRING);

                $no++;
                $x++;
                //if($x==8000) break;
            }
            $sh->getStyle('A2:A'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('B2:B'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('C2:C'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('D2:D'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('E2:E'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('F2:F'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('G2:G'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('H2:H'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('I2:I'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('J2:J'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('K2:K'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('L2:L'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('M2:M'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('N2:N'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('O2:O'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('P2:P'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('Q2:Q'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('R2:R'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('S2:S'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('T2:T'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('U2:U'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('V2:V'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('W2:W'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('X2:X'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('Y2:Y'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('Z2:Z'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AA2:AA'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AB2:AB'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AC2:AC'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AD2:AD'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AE2:AE'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AF2:AF'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AG2:AG'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AH2:AH'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $sh->getStyle('AI2:AI'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AJ2:AJ'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AK2:AK'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AL2:AL'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AM2:AM'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $sh->getStyle('AM2:AM'.$x)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('C2'.':AJ'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);
            $sh->getStyle('A'.$x.':AM'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('A'.$x.':AM'.$x)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $sh->setCellValue('A'.$x, 'TOTAL');
            //$sh->setCellValue('B'.$x, "=SUM(B2:B".($x-1).")");
            //$sh->getStyle('B'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);
            $sh->setCellValue('C'.$x, "=SUM(C2:C".($x-1).")");
            $sh->getStyle('C'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('D'.$x, "=SUM(D2:D".($x-1).")");
            $sh->getStyle('D'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('E'.$x, "=SUM(E2:E".($x-1).")");
            $sh->getStyle('E'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('F'.$x, "=SUM(F2:F".($x-1).")");
            $sh->getStyle('F'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('G'.$x, "=SUM(G2:G".($x-1).")");
            $sh->getStyle('G'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('H'.$x, "=SUM(H2:H".($x-1).")");
            $sh->getStyle('H'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('I'.$x, "=SUM(I2:I".($x-1).")");
            $sh->getStyle('I'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('J'.$x, "=SUM(J2:J".($x-1).")");
            $sh->getStyle('J'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('K'.$x, "=SUM(K2:K".($x-1).")");
            $sh->getStyle('K'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('L'.$x, "=SUM(L2:L".($x-1).")");
            $sh->getStyle('L'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('M'.$x, "=SUM(M2:M".($x-1).")");
            $sh->getStyle('M'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('N'.$x, "=SUM(N2:N".($x-1).")");
            $sh->getStyle('N'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('O'.$x, "=SUM(O2:O".($x-1).")");
            $sh->getStyle('O'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('P'.$x, "=SUM(P2:P".($x-1).")");
            $sh->getStyle('P'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('Q'.$x, "=SUM(Q2:Q".($x-1).")");
            $sh->getStyle('Q'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('R'.$x, "=SUM(R2:R".($x-1).")");
            $sh->getStyle('R'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('S'.$x, "=SUM(S2:S".($x-1).")");
            $sh->getStyle('S'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('T'.$x, "=SUM(T2:T".($x-1).")");
            $sh->getStyle('T'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('U'.$x, "=SUM(U2:U".($x-1).")");
            $sh->getStyle('U'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('V'.$x, "=SUM(V2:V".($x-1).")");
            $sh->getStyle('V'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('W'.$x, "=SUM(W2:W".($x-1).")");
            $sh->getStyle('W'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('X'.$x, "=SUM(X2:X".($x-1).")");
            $sh->getStyle('X'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('Y'.$x, "=SUM(Y2:Y".($x-1).")");
            $sh->getStyle('Y'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('Z'.$x, "=SUM(Z2:Z".($x-1).")");
            $sh->getStyle('Z'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AA'.$x, "=SUM(AA2:AA".($x-1).")");
            $sh->getStyle('AA'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AB'.$x, "=SUM(AB2:AB".($x-1).")");
            $sh->getStyle('AB'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AC'.$x, "=SUM(AC2:AC".($x-1).")");
            $sh->getStyle('AC'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AD'.$x, "=SUM(AD2:AD".($x-1).")");
            $sh->getStyle('AD'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AE'.$x, "=SUM(AE2:AE".($x-1).")");
            $sh->getStyle('AE'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AF'.$x, "=SUM(AF2:AF".($x-1).")");
            $sh->getStyle('AF'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AG'.$x, "=SUM(AG2:AG".($x-1).")");
            $sh->getStyle('AG'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AH'.$x, "=SUM(AH2:AH".($x-1).")");
            $sh->getStyle('AH'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AI'.$x, "=SUM(AI2:AI".($x-1).")");
            $sh->getStyle('AI'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AJ'.$x, "=SUM(AJ2:AJ".($x-1).")");
            $sh->getStyle('AJ'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AK'.$x, "");
            $sh->getStyle('AK'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AL'.$x, "");
            $sh->getStyle('AL'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('AM'.$x, "");
            $sh->getStyle('AM'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

            $sh->setCellValue('A'.$x, '');


            $sh->getStyle('A'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('B'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('C'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('D'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('E'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('F'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('G'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('H'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('I'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('J'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('K'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('L'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('M'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('N'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('O'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('P'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('Q'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('R'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('S'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('T'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('U'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('V'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('W'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('X'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('Y'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('Z'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AA'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AB'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AC'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AD'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AE'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AF'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AG'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AH'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $sh->getStyle('AI'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AJ'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AK'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AL'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('AM'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $sh->getStyle('AM'.$x)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $sh->getStyle('A'.$x.':AM'.$x)->getFont()->setBold(TRUE);
        }
        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save(dirname(__FILE__).'/../third_party/report/'.$filename);
        // Write file to the browser
       // $objWriter->save('php://output');
        //redirect($this->config->config['base_url'].'application/third_party/report/'.$filename, 'location', 301);
        $data['redirect'] = "true";
        $data['redirect_url'] = $this->config->config['base_url'].'application/third_party/report/'.$filename;

        echo json_encode($data);
    }


	public function crud_tier_cond(){
        $this->m_skembis->crud_tier_cond();

    }

    public function addCommitment(){
        $this->m_skembis->add_commitment();
    }
}