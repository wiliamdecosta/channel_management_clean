<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Summary extends CI_Controller
{

    private $head = "Marketing Fee";
    private $folder = "summary";

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('encrypt');
        checkAuth();

        $this->load->model('mcrud', 'crud');

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $this->load->model('M_summary', 'db_summary');
        $this->load->model('M_jqGrid', 'jqGrid');

    }

    public function index()
    {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('summary/filter_summary');
    }

    public function trend_mf()
    {
        $this->load->view($this->folder . '/trend_mf');
    }

    public function mitra()
    {
        $data['array_mitra'] = $this->db_summary->getSummaryMitra();
        $this->load->view($this->folder . '/mitra', $data);
    }

    public function inventory()
    {
        $this->load->view($this->folder . '/inventory');
    }

    public function lovListMitra()
    {
        $data['segment'] = $this->input->post('segment');
        $data['array_mitra'] = $this->db_summary->getListMitraBySegment();
        $this->load->view($this->folder . '/lov_mitra', $data);
    }

    public function gridListItem()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : null;
        $sord = isset($_POST['sord']) ? $_POST['sord'] : null;

        $table = "P_INVENTORY";

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

    public function req_item()
    {
        $this->load->view('summary/modal_add_list_item');
    }

    public function add_list_item()
    {

        $prof_id = $this->session->userdata('d_prof_id');
        if ($prof_id == 10) { // Prof AM
            $this->db_summary->addListItem();
        } else {
            $status["success"] = false;
            $status["message"] = "Request hanya bisa dilakukan oleh AM !";
            echo json_encode($status);
        }
    }

    public function list_request()
    {
        $this->load->view('summary/list_request');
    }

    public function gridListRequest()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : null;
        $sord = isset($_POST['sord']) ? $_POST['sord'] : null;

        $table = "V_LIST_REQUEST";

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

        $req_param['where'] = array('P_DAT_AM' => intval($this->session->userdata('d_user_id')));

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

    public function filterTrendMF()
    {
        $periode = $this->input->post('periode');
        $skema_id = $this->input->post('skema_id');
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');

        $array_period = array();
        if ($periode) {
            $interval = new DateInterval('P1M');
            $daterange = new DatePeriod(new DateTime($startdate), $interval ,new DateTime($enddate));
            foreach($daterange as $date){
                $array_period[] = (string)$date->format('Ym');
            }

        }
        $string_periode = implode(',',$array_period);

        if(!$skema_id){
            $skema_list = $this->db->select('REFERENCE_NAME')->where('P_REFERENCE_TYPE_ID',3)->get('P_REFERENCE_LIST')->result_array();

        }else{
            $skema_list = $this->db->select('REFERENCE_NAME')->where('P_REFERENCE_LIST_ID',$skema_id)->get('P_REFERENCE_LIST')->result_array();
        }

        $mf = $this->db_summary->getTrendMFData();

        foreach($skema_list as $skema){
            $skema['REFERENCE_NAME'];

        }

        $data['periode'] = $string_periode;
        $this->load->view('summary/mf_chart',$data);


    }

}