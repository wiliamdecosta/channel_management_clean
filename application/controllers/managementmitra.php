<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Managementmitra extends CI_Controller
{

    private $head = "Marketing Fee";
    private $folder = "managementmitra";

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('encrypt');
        checkAuth();
        $this->load->helper('download');

        $this->load->model('M_jqGrid', 'jqGrid');
        $this->load->model('M_managementmitra', 'm_mitra');
        $this->load->model('Mfee');

//        if (!$this->input->is_ajax_request()) {
//            exit('No direct script access allowed');
//        }
    }

    public function index()
    {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->model('M_cm', 'cm');
        if ($this->session->userdata('d_prof_id') == 3) {
            $result['result'] = $this->cm->getPglListByID($this->session->userdata('d_user_id'));
        } else {
            $result['result'] = $this->cm->getPglList();
        }

        $this->load->view($this->folder . '/filter_mitra', $result);
    }

    public function detailMitra()
    {
        $result = $this->m_mitra->getMapPIC();
        if ($result->num_rows() > 0) {
            $data['result'] = $result->result_array();
            $data['am'] = $result->row_array(0);
        } else {
            $data['result'] = array();
            $data['am'] = null;
        }
        $this->load->view($this->folder . '/detail_mitra', $data);
    }

    public function dokPKS()
    {
        $lokasi_id = $this->input->post("lokasisewa");
        $result["P_MP_LOKASI_ID"] = $lokasi_id;

        //   $this->m_mm_mitra->getListPKSByLokasi();

        $this->load->view($this->folder . '/dok_pks', $result);
    }

    public function dokNPK()
    {

        $result['result'] = $this->db->get_where('DOC', array('DOC_TYPE_ID' => '2'))->result();

        $this->load->view($this->folder . '/dok_npk', $result);
    }

    public function fastels()
    {
        // Default periode current yyyymm
        $tahun = date("Y");
        $bulan = date("m");
        $data['periode'] = $tahun . "" . $bulan;

        $data['pgl_id'] = $this->input->post('mitra');
        $this->load->view($this->folder . '/fastel', $data);
    }

    public function gridFastel()
    {
        $pgl_id = $this->input->post('pgl_id'); //261
        $periode = $this->input->post('periode');

        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        if ($this->input->post('searchField') == "ND1") {
            $s_field = "B.ND";
        } else {
            $s_field = $this->input->post('searchField');
        }

        if ($this->input->post('periode')) {
            $periode = $this->input->post('periode');
        }

        //JqGrid Parameters
        $req_param = array(
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "pgl_id" => $pgl_id,
            "period" => $periode,
            "search" => $this->input->post('_search'),
            "search_field" => ($s_field) ? $s_field : null,
            "search_operator" => ($this->input->post('searchOper')) ? $this->input->post('searchOper') : null,
            "search_str" => ($this->input->post('searchString')) ? ($this->input->post('searchString')) : null
        );


        // Get limit paging
        $count = $this->m_mitra->getFastel($req_param)->num_rows();
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

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->m_mitra->getFastel($req_param)->result_array();
        echo json_encode($result);

    }

    public function gridDatin()
    {
        $pgl_id = $this->input->post('pgl_id'); //261
        $periode = $this->input->post('periode');

        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc


        //JqGrid Parameters
        $req_param = array(
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "pgl_id" => $pgl_id,
            "periode" => $periode,
            "search" => $this->input->post('_search'),
            "search_field" => ($this->input->post('searchField')) ? $this->input->post('searchField') : null,
            "search_operator" => ($this->input->post('searchOper')) ? $this->input->post('searchOper') : null,
            "search_str" => ($this->input->post('searchString')) ? ($this->input->post('searchString')) : null
        );


        // Get limit paging
        $count = $this->m_mitra->getDatin($req_param)->num_rows();
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

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->m_mitra->getDatin($req_param)->result_array();
        echo json_encode($result);

    }

    public function dokKontrak()
    {
        $result['pgl_id'] = $this->input->post("mitra");
        $this->load->view($this->folder . '/dok_kontrak', $result);
    }

    public function evaluasiMitra()
    {
        $result['pgl_id'] = $this->input->post("mitra");
        $this->load->view($this->folder . '/evaluasi_mitra', $result);
    }

    public function listCC()
    {
        $this->load->model('mfee');
        $segmen = $this->input->post('segmen');

        $pgl_id = $this->session->userdata('d_pgl_id');
        if($pgl_id){
            $result = $this->mfee->getCCbySEGMENPGL_ID($segmen);
        }else{
            $result = $this->mfee->getCCbySEGMEN($segmen);
        }

        $option = "";
        if ($result->num_rows() > 0) {
            $option .= "<option value=''> Pilih CC </option>";
            foreach ($result->result() as $content) {
                $option .= "<option value=" . $content->ID . ">" . $content->NAME . "</option>";
            }
        } else {
            $option .= "<option value=''> Tidak ada CC </option>";
        }

        echo $option;


    }

    public function listMitra()
    {
        $this->load->model('mfee');
        $ccid = intval($this->input->post('ccid'));


        $pgl_id = $this->session->userdata('d_pgl_id');
        if($pgl_id){
            $result = $this->mfee->getMitraByCCPGL_ID($ccid);
        }else{
            $result = $this->mfee->getMitraByCC($ccid);
        }

        $option = "";
        if ($result->num_rows() > 0) {
            $option .= "<option value=''> Pilih Mitra </option>";
            foreach ($result->result() as $content) {
                $option .= "<option value='" . $content->ID . "'>" . $content->NAME . "</option>";
            }

        } else {
            $option .= "<option value=''> Tidak ada mitra </option>";
        }

        echo $option;


    }

    public function listLokasiSewa()
    {
        $this->load->model('mfee');
        $mitra = $this->input->post('mitra');
        $result = $this->mfee->getLokasisewaByMitra($mitra);

        $option = "";
        if ($result->num_rows() > 0) {
            $option .= "<option value=''> Pilih Lokasi Sewa </option>";
            foreach ($result->result() as $content) {
                $option .= "<option value='" . $content->ID . "'>" . $content->NAME . "</option>";

            }

        } else {
            $option .= "<option value=''> Tidak ada Lokasi Sewa </option>";
        }
        echo $option;

    }

    public function gridPIC()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "V_MP_PIC";

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

        $lokasisewa = $this->input->post('lokasisewa');

        if ($lokasisewa) {
            $req_param['where'] = array('P_MP_LOKASI_ID' => $lokasisewa);
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

    public function lovPIC()
    {
        $data['divID'] = $this->input->post('divID');
        $data['lov_target_id'] = $this->input->post('lov_target_id');
        $data['modal_id'] = $this->input->post('modal_id');
        $this->load->view('managementmitra/lov_pic', $data);
    }

    public function lovPKS()
    {
        $data['divID'] = $this->input->post('divID');
        $data['lov_target_id'] = $this->input->post('lov_target_id');
        $data['modal_id'] = $this->input->post('modal_id');
        $data['lokasi_id'] = $this->input->post('lokasi_id');
        $this->load->view('managementmitra/lov_pks', $data);
    }

    public function lovSegment()
    {
        $data['divID'] = $this->input->post('divID');
        $data['lov_target_id'] = $this->input->post('lov_target_id');
        $data['modal_id'] = $this->input->post('modal_id');
        $this->load->view('managementmitra/lov_segment', $data);
    }

    public function lovCC()
    {
        $data['divID'] = $this->input->post('divID');
        $data['lov_target_id'] = $this->input->post('lov_target_id');
        $data['modal_id'] = $this->input->post('modal_id');
        $data['cc_name'] = $this->input->post('cc_name');
        $this->load->view('managementmitra/lov_cc', $data);
    }

    public function lovMitra()
    {
        $data['divID'] = $this->input->post('divID');
        $data['lov_target_id'] = $this->input->post('lov_target_id');
        $data['modal_id'] = $this->input->post('modal_id');
        $this->load->view('managementmitra/lov_mitra', $data);
    }

    public function lovEAM()
    {
        $data['divID'] = $this->input->post('divID');
        $data['lov_target_id'] = $this->input->post('lov_target_id');
        $data['modal_id'] = $this->input->post('modal_id');
        $this->load->view('managementmitra/lov_eam', $data);
    }

    public function grid_lov_pic()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "P_PIC";

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
            "search" => null,
            "search_field" => null,
            "search_operator" => null,
            "search_str" => null
        );

        if ($this->input->post('_search') == "true") {
            $filter = json_decode($this->input->post('filters'));
            $req_param['search'] = "true";
            $req_param['search_field'] = $filter->rules[0]->field;
            $req_param['search_operator'] = $filter->rules[0]->op;
            $req_param['search_str'] = $filter->rules[0]->data;
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

    public function grid_lov_pks()
    {
        $lokasi_id = $this->input->post('lokasi_id');
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "P_MP_PKS";

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
            "search" => null,
            "search_field" => null,
            "search_operator" => null,
            "search_str" => null
        );

        if ($this->input->post('_search') == "true") {
            $filter = json_decode($this->input->post('filters'));
            $req_param['search'] = "true";
            $req_param['search_field'] = $filter->rules[0]->field;
            $req_param['search_operator'] = $filter->rules[0]->op;
            $req_param['search_str'] = $filter->rules[0]->data;
        }


        $req_param['where'] = array('P_MP_LOKASI_ID' => $lokasi_id);

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

    public function grid_lov_eam()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "P_DAT_AM";

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
            "search" => null,
            "search_field" => null,
            "search_operator" => null,
            "search_str" => null
        );

        if ($this->input->post('_search') == "true") {
            $filter = json_decode($this->input->post('filters'));
            $req_param['search'] = "true";
            $req_param['search_field'] = $filter->rules[0]->field;
            $req_param['search_operator'] = $filter->rules[0]->op;
            $req_param['search_str'] = $filter->rules[0]->data;
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

    public function grid_lov_cc()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "V_PARAM_SEGMENT_CC";

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
            "search" => null,
            "search_field" => null,
            "search_operator" => null,
            "search_str" => null
        );

        $req_param["where"] = array("CODE_SGM" => $this->input->post("cc_name"));
        if ($this->input->post('_search') == "true") {
            $filter = json_decode($this->input->post('filters'));
            $req_param['search'] = "true";
            $req_param['search_field'] = $filter->rules[0]->field;
            $req_param['search_operator'] = $filter->rules[0]->op;
            $req_param['search_str'] = $filter->rules[0]->data;
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


    public function grid_lov_segment()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "SELECT DISTINCT(CODE_SGM) CODE_SGM, SEGMENT_NAME FROM MV_PARAM_SEGMENT_CC";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => null,
            "search_field" => null,
            "search_operator" => null,
            "search_str" => null
        );

        if ($this->input->post('_search') == "true") {
            $filter = json_decode($this->input->post('filters'));
            $req_param['search'] = "true";
            $req_param['search_field'] = $filter->rules[0]->field;
            $req_param['search_operator'] = $filter->rules[0]->op;
            $req_param['search_str'] = $filter->rules[0]->data;
        }

        // Get limit paging
        $count = $this->jqGrid->countAllQuery($req_param);

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

        $result['Data'] = $this->jqGrid->get_dataQuery($req_param);
        echo json_encode($result);

    }

    public function grid_lov_mitra()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "CUST_PGL";

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
            "search" => null,
            "search_field" => null,
            "search_operator" => null,
            "search_str" => null
        );

        if ($this->input->post('_search') == "true") {
            $filter = json_decode($this->input->post('filters'));
            $req_param['search'] = "true";
            $req_param['search_field'] = $filter->rules[0]->field;
            $req_param['search_operator'] = $filter->rules[0]->op;
            $req_param['search_str'] = $filter->rules[0]->data;
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

    public function gridPKS()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : null;
        $sord = isset($_POST['sord']) ? $_POST['sord'] : null;

        $table = "V_PKS";

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

        $pks_id = $this->input->post('pks_id');
        $P_MP_LOKASI_ID = $this->input->post('P_MP_LOKASI_ID');
        $valid_from = $this->input->post('valid_from');
        $valid_until = $this->input->post('valid_until');

        if ($P_MP_LOKASI_ID) {
            $req_param['where'] = array('P_MP_LOKASI_ID' => $P_MP_LOKASI_ID);
        }
        if ($pks_id) {
            $req_param['where'] = array('P_MP_PKS_ID' => $pks_id);
            // $req_param['where'] = array('UPPER(NO_PKS) LIKE ' => strtoupper('%'.$this->input->post('no_pks').'%'));
        }
        if ($valid_from) {
            $req_param['where'] = array('VALID_FROM' => $valid_from);
        }
        if ($valid_until) {
            $req_param['where'] = array('VALID_UNTIL' => $valid_until);
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

    public function modalUploadPKS()
    {
        $this->load->view($this->folder . '/modal_upload_pks');
    }

    public function modalUploadKontrak()
    {
        $data['pgl_id'] = $this->input->post("pgl_id");
        $this->load->view($this->folder . '/modal_upload_kontrak', $data);
    }

    public function modalUploadEvaluasi()
    {
        $data['pgl_id'] = $this->input->post("pgl_id");
        $this->load->view($this->folder . '/modal_upload_evaluasi', $data);
    }

    public function pks_uploaddo()
    {
        $no_pks = trim(strtoupper($this->input->post("no_pks")));
        $doc_name = trim(strtoupper($this->input->post("doc_name")));
        $start_date_pks = $this->input->post("start_date_pks");
        $end_date_pks = $this->input->post("end_date_pks");
        $lokasi_pks = 5;

        if ($lokasi_pks != "") {
            // Upload Process
            $config['upload_path'] = './application/third_party/upload/pks';
            $config['allowed_types'] = 'docx|pdf';
            $config['max_size'] = '0';
            $config['overwrite'] = TRUE;
            $file_id = time();
            $config['file_name'] = str_replace(" ", "_", $doc_name) . "_" . $file_id;

            $this->load->library('upload');
            $this->upload->initialize($config);

            //cek duplicate
            $ck = $this->Mfee->checkDuplicate('P_PKS', 'DOC_NAME', $doc_name);

            if ($ck == 1) {

                $data['status'] = false;
                $data['msg'] = " Dokumen sudah ada !";

                echo json_encode($data);
            } else {
                if (!$this->upload->do_upload("filename")) {
                    $error = $this->upload->display_errors();
                    $data['status'] = "F";
                    $data['msg'] = $error;
                    echo json_encode($data);
                } else {
                    // Do Upload
                    $data = $this->upload->data();
                    $datas = array(
                        "NO_PKS" => $no_pks,
                        "DOC_NAME" => $doc_name,
                        "FILE_PATH" => $data['file_name'],
                        "PKS_START_DATE" => date('d/M/Y', strtotime($start_date_pks)),
                        "PKS_END_DATE" => date('d/M/Y', strtotime($end_date_pks)),
                        "UPDATE_DATE" => date('d/M/Y'),
                        "UPDATE_BY" => $this->session->userdata('d_user_name')
                    );

                    $this->m_mitra->insertPKS($datas);
                    $data['success'] = true;
                    $data['msg'] = "Upload Berhasil";
                    echo json_encode($data);

                }
            }

        }

    }

    public function kontrak_uploaddo()
    {
        $doc_name = trim(ucfirst($this->input->post("doc_name")));
        $pgl_id = $this->input->post("pgl_id");
        // Upload Process
        $config['upload_path'] = './application/third_party/upload/kontrak';
        $config['allowed_types'] = 'docx|pdf|doc|gif|jpg|png';
        $config['max_size'] = '0';
        $config['overwrite'] = TRUE;
        $file_id = time();
        $config['file_name'] = str_replace(" ", "_", $doc_name) . "_" . $file_id;

        $this->load->library('upload');
        $this->upload->initialize($config);

        //cek duplicate
        $ck = $this->Mfee->checkDuplicated('P_DOK_KONTRAK', array('DOC_NAME' => $doc_name, 'PGL_ID' => $pgl_id));

        if ($ck == 1) {

            $data['status'] = false;
            $data['msg'] = "Nama dokumen sudah ada !";
            echo json_encode($data);
        } else {
            if (!$this->upload->do_upload("filename")) {
                $error = $this->upload->display_errors();
                $data['status'] = "F";
                $data['msg'] = $error;
                echo json_encode($data);
            } else {
                // Do Upload
                $data = $this->upload->data();
                $datas = array(
                    "DOC_NAME" => $doc_name,
                    "FILE_PATH" => $data['file_name'],
                    "UPDATE_DATE" => date('d/M/Y'),
                    "UPDATE_BY" => $this->session->userdata('d_user_name'),
                    "PGL_ID" => $pgl_id
                );

                $this->m_mitra->insertDokKontrak($datas);
                $data['success'] = true;
                $data['msg'] = "Upload Berhasil";
                echo json_encode($data);

            }
        }


    }

    public function evaluasi_uploaddo()
    {
        $doc_name = trim(ucfirst($this->input->post("doc_name")));
        $pgl_id = $this->input->post("pgl_id");
        // Upload Process
        $config['upload_path'] = './application/third_party/upload/kontrak';
        $config['allowed_types'] = 'docx|pdf|doc|jpg|png';
        $config['max_size'] = '0';
        $config['overwrite'] = TRUE;
        $file_id = time();
        $config['file_name'] = str_replace(" ", "_", $doc_name) . "_" . $file_id;

        $this->load->library('upload');
        $this->upload->initialize($config);

        //cek duplicate
        $ck = $this->Mfee->checkDuplicated('P_DOK_EVALUASI', array('DOC_NAME' => $doc_name, 'PGL_ID' => $pgl_id));

        if ($ck == 1) {

            $data['status'] = false;
            $data['msg'] = "Nama dokumen sudah ada !";
            echo json_encode($data);
        } else {
            if (!$this->upload->do_upload("filename")) {
                $error = $this->upload->display_errors();
                $data['status'] = "F";
                $data['msg'] = $error;
                echo json_encode($data);
            } else {
                // Do Upload
                $data = $this->upload->data();
                $datas = array(
                    "DOC_NAME" => $doc_name,
                    "FILE_PATH" => $data['file_name'],
                    "UPDATE_DATE" => date('d/M/Y'),
                    "UPDATE_BY" => $this->session->userdata('d_user_name'),
                    "PGL_ID" => $pgl_id
                );

                $this->m_mitra->insertDokEvaluasi($datas);
                $data['success'] = true;
                $data['msg'] = "Upload Berhasil";
                echo json_encode($data);

            }
        }


    }

    public function downloadPKS($FILE_PATH)
    {
        //$FILE_PATH = $this->input->post('FILE_PATH');
        $data = file_get_contents("./application/third_party/upload/pks/" . $FILE_PATH);
        force_download($FILE_PATH, $data);
    }

    public function downloadDokKontrak($FILE_PATH)
    {
        $data = file_get_contents("./application/third_party/upload/kontrak/" . $FILE_PATH);
        force_download($FILE_PATH, $data);
    }

    public function crud_pks()
    {
        $this->m_mitra->crud_pks();
    }

    public function crud_kontrak()
    {
        $this->m_mitra->crud_kontrak();
    }

    public function crud_evaluasi()
    {
        $this->m_mitra->crud_evaluasi();
    }

    public function gridDocKontrak()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "P_DOK_KONTRAK";

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

        $pgl_id = $this->input->post("pgl_id");
        if ($pgl_id) {
            $req_param['where'] = array('PGL_ID' => $pgl_id);
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

    public function gridDocEvaluasi()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "P_DOK_EVALUASI";

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

        $pgl_id = $this->input->post("pgl_id");
        if ($pgl_id) {
            $req_param['where'] = array('PGL_ID' => $pgl_id);
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

    public function mitra_form()
    {
        $data["action"] = $this->input->post("action");
        $this->load->view('managementmitra/add_mitra', $data);
    }

    public function crud_detailmitra()
    {
        $return = $this->m_mitra->crud_detailmitra();
        if ($return == 1) {
            $data["success"] = true;
            $data["message"] = "Data berhasil ditambahakan";

        } else {
            $data["success"] = false;
            $data["message"] = "Gagal menambah data";
        }
        echo json_encode($data);
    }

}