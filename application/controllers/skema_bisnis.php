<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Skema_bisnis extends CI_Controller
{

    private $head = "Marketing Fee";
    private $folder = "skema_bisnis";

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        checkAuth();

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

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
        $this->load->view($this->folder . '/calculate_mf');
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
        $this->load->view($this->folder . '/create_npk');
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
        /*$smry = $this->m_skembis->getCompfeeSMRY();
        foreach ($comp as $comp_fee) {
            $arrComp[] = array('CF_NAME' => $comp_fee['CF_NAME'],
                'CF_ID' => $comp_fee['CF_ID'],
                'VALUE' => $this->input->post($comp_fee['CF_NAME'])
            );

        }*/

        $arrComp[] = $arrPPN;
        $arrComp[] = $arrBPHJ;


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

    /*public function add_skema(){
        $this->load->view('')
    }*/


}