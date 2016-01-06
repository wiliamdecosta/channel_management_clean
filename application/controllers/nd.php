<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class nd extends CI_Controller {
    private $head = "Management Data";
	function __construct() {
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        checkAuth();
		$this->load->model('M_cm','cm');
        $this->load->model('M_param');
        $this->load->model('M_tenant');
        $this->load->model('M_jqGrid', 'jqGrid');

	}

    public function index(){
        echo "Forbidden Access ";
    }

    public function listBatchND(){
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

        $result['result'] = $this->cm->getPglList();
        $result['product'] = $this->M_param->getParamProducts();
        $this->load->view('nd/expense',$result);
    }

    public function checkPeriod(){
        $batch_id = $this->input->post("batch_id");
        $count = $this->M_tenant->checkPeriod($batch_id);
        echo $count;
    }

    public function gridBatchND() {
        $page = intval($_REQUEST['page']) ;
        $limit = $_REQUEST['rows'] ;
        $sidx = $_REQUEST['sidx'] ;
        $sord = $_REQUEST['sord'] ;

        $table = "V_SHOW_BATCH";

        $req_param = array (
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null
        );

        $req_param['field'] = array('P_BATCH_TYPE_ID');
        $req_param['value'] = array(4);

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

    public function expensePeriod(){

        $username = $this->session->userdata('d_user_nik');
        $tmpPeriod = $this->input->post('periode');
        $batch_id = $this->input->post('batch_id');
        $copy_val = $this->input->post('copy');
        $period = implode('#',$tmpPeriod);

        if($copy_val == 0){
            // action insert period expense
            $result['data']= $this->M_tenant->createPeriod($period,$username,$batch_id);
            json_encode($result);
        }else{
            // action copy batch expense
            $result['data']= $this->M_tenant->copyBatch($period,$username,$batch_id);
            json_encode($result);
        }

    }

    public function gridND() {
        $id = $this->input->post("batch_id");
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sidx = $_POST['sidx'] ;
        $sord = $_POST['sord'] ;

        $count = $this->M_tenant->getCountListND($id);
        $record= $count[0]->COUNT;

        $result['page'] = $page;
        $result['total'] = ceil($record/$rows);
        $result['records'] = $record;
        $result['sidx'] = $sidx;
        $result['sord'] = $sord;
        $result['id'] = $id;

        $req_param = array (
            "sort_by" => $sidx,
            "page" => isset($_POST['page']) ? intval($_POST['page']) : 1,
            "rows" => isset($_POST['rows']) ? intval($_POST['rows']) : 10,
            "sord" => $sord,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null,
            "id" => $id
        );

        $this->parent_id = $id;
        $result['Data'] = $this->M_tenant->getListND($req_param);
        echo json_encode($result);
    }

	
}