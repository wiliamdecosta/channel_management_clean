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
        $this->load->view($this->folder . '/mitra',$data);
    }

    public function inventory()
    {
        $this->load->view($this->folder . '/inventory');
    }

    public function lovListMitra(){
        $data['segment'] = $this->input->post('segment');
        $data['array_mitra'] = $this->db_summary->getListMitraBySegment();
        $this->load->view($this->folder . '/lov_mitra',$data);
    }

    public function gridListItem(){
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


}