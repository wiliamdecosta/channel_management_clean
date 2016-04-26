<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends CI_Controller
{

    private $head = "Marketing Fee";
    private $folder = "inventory";

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

        $this->load->model('M_jqGrid', 'jqGrid');
        $this->load->model('M_inventory', 'db_inventory');
        $this->load->model('Mfee');

    }

    public function index()
    {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $data['menu_id'] = $this->uri->segment(3);

        $this->load->view('inventory/filter_inventory',$data);
    }


    public function list_item()
    {
        $data['menu_id'] = $this->input->post('menu_id');
        $this->load->view('inventory/list_inventory',$data);
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

    public function tambah_stok()
    {
        $data['title'] = "Tambah stok";
        $data['code'] = "tambah";

        $this->load->view('inventory/modal_edit_stok',$data);
    }

    public function kurang_stok()
    {
        $data['title'] = "Kurangi stok";
        $data['code'] = "kurang";

        $this->load->view('inventory/modal_edit_stok',$data);
    }

    public function logEditStok() {
        $page = intval($_REQUEST['page']) ;
        $limit = $_REQUEST['rows'] ;
        $sidx = $_REQUEST['sidx'] ;
        $sord = $_REQUEST['sord'] ;

        $table = "INVENTORY_LOG";

        $req_param = array (
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null
        );

        $req_param['where'] = array('P_INVENTORY_ID' => $this->input->post('log_id'));

        $row = $this->jqGrid->get_data($req_param)->result_array();
        $count = count($row);

        if( $count >0 ) {
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

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);
    }

    public function editStokActon(){
        $this->db_inventory->editStok();
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
        $data['menu_id'] = $this->input->post('menu_id');
        $this->load->view('inventory/list_request',$data);
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

    public function crudItem(){
        $this->db_inventory->crud_item();
    }

    public function listStatusReq(){
        $result = $this->db_inventory->getListStatusReq();
        echo "<select>";
        foreach($result  as $value ){
            echo "<option value=".$value['P_REFERENCE_LIST_ID'].">".$value['REFERENCE_NAME']."</option>";
        }
        echo "</select>";
    }

    public function updateListReq(){
        $this->db_inventory->updateStatusReq();
    }


}