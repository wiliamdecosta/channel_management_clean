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

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
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
        $data['ccid'] = $this->input->post('ccid');
        $data['mitra'] = $this->input->post('mitra');
        $data['lokasisewa'] = $this->input->post('lokasisewa');
        $data['segment'] = $this->input->post('segment');
        $this->load->view($this->folder . '/detail_mitra', $data);
    }

    public function dokPKS()
    {

        $result['result'] = $this->db->get_where('DOC', array('DOC_TYPE_ID' => '1'))->result();

        $this->load->view($this->folder . '/dok_pks', $result);
    }

    public function dokNPK()
    {

        $result['result'] = $this->db->get_where('DOC', array('DOC_TYPE_ID' => '2'))->result();

        $this->load->view($this->folder . '/dok_npk', $result);
    }

    public function fastel()
    {
        $this->load->view($this->folder . '/fastel');
    }

    public function dokKontrak()
    {

        $result['result'] = $this->db->get_where('DOC', array('DOC_TYPE_ID' => '3'))->result();

        $this->load->view($this->folder . '/dok_kontrak', $result);
    }

    public function evaluasiMitra()
    {

        $result['result'] = $this->db->get_where('DOC', array('DOC_TYPE_ID' => '4'))->result();

        $this->load->view($this->folder . '/evaluasi_mitra', $result);
    }

    public function downloadDokPKS()
    {
        $data = file_get_contents(base_url('')); // Read the file's contents
        $name = 'myphoto.jpg';

        force_download($name, $data);
    }

    public function listCC()
    {
        $this->load->model('mfee');
        $segmen = $this->input->post('segmen');
        $result = $this->mfee->getCCbySEGMEN($segmen);


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
        $result = $this->mfee->getMitraByCC($ccid);


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
        $mitra_name = $this->input->post('mitra_name');
        $result = $this->mfee->getLokasisewaByMitra($mitra_name);

        $option = "";
        if ($result->num_rows() > 0) {
            $option .= "<option value=''> Pilih Lokasi Sewa </option>";
            foreach ($result->result() as $content) {
                $option .= "<option value='" . $content->NAME . "'>" . $content->NAME . "</option>";

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

        $table = "V_MAP_MIT_CC";

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

        $segment = $this->input->post('segment');
        $ccid = $this->input->post('ccid');
        $pgl_id = $this->input->post('mitra');
        $lokasisewa = $this->input->post('lokasisewa');
        if ($segment) {
            $req_param['where'] = array('SEGMENT' => $segment);
        }
        if ($ccid) {
            $req_param['where'] = array('ID_CC' => $ccid);
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
        $this->load->view('managementmitra/lov_pic', $data);
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
            "search" => $this->input->post('_search'),
            "search_field" => ($this->input->post('searchField')) ? $this->input->post('searchField') : null,
            "search_operator" => ($this->input->post('searchOper')) ? $this->input->post('searchOper') : null,
            "search_str" => ($this->input->post('searchString')) ? ($this->input->post('searchString')) : null
        );

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


}