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

    public function benefit_product()
    {
        $data['comp'] = $this->m_skembis->getComfeeByProduct();
        $this->load->view($this->folder . '/create_skema_detail_produk', $data);
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
                
        $period = empty($this->input->post('period')) ? $this->input->get('period') : $this->input->post('period');   
        $tahun = empty($this->input->post('tahun')) ? $this->input->get('tahun') : $this->input->post('tahun');   
        $bulan = empty($this->input->post('bulan')) ? $this->input->get('bulan') : $this->input->post('bulan');   
        $schm_fee_name = empty($this->input->post('schm_fee_name')) ? $this->input->get('schm_fee_name') : $this->input->post('schm_fee_name');   
        $npk_fee_id = empty($this->input->post('npk_fee_id')) ? $this->input->get('npk_fee_id') : $this->input->post('npk_fee_id');  
        
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

}