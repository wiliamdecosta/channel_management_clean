<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class JqGrid extends CI_Controller {
	function __construct() {
		parent::__construct();

        checkAuth();
		$this->load->model('M_profiling');
		$this->load->model('M_user');
        $this->load->model('M_jqgrid', 'jqGrid');
	}

	public function index()
	{
		redirect("/");
	}
	
	public function get_json() {
        $page = $_REQUEST['page'] ;
        $limit = $_REQUEST['rows'] ;
        $sidx = $_REQUEST['sidx'] ;
        $sord = $_REQUEST['sord'] ;

        $req_param = array (
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null
        );

        $row = $this->jqGrid->get_data($req_param)->result_array();
        $count = count($row);

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = ($limit*$page)+1 - $limit;

        // Limit for paging
        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        // Parametes post to json viewer
        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        // Get Data
		$result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);
	}

    public function crud_master(){
        // crud(tabel_name,field,key_unix,field yg mau di insert/update)
        $table = "APP_MENU";
        $id = $this->input->post('id');
        $this->M_admin->crud($table,'MENU_ID', $id, array('MENU_NAME', 'MENU_ICON','MENU_DESC'));
    }

    public function crud_detail(){
        // crud(tabel_name,field,key_unix,field yg mau di insert/update)
        $table = "APP_MENU";
        $id = $this->input->post('id');
        $this->M_admin->crud($table,'MENU_ID', $id, array('MENU_NAME', 'MENU_LINK','FILE_NAME','MENU_PARENT'));
    }

    public function menuchild($id) {

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sidx = $_POST['sidx'] ;
        $sord = $_POST['sord'] ;

        $count = $this->M_admin->getCountListMenuChild($id);
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

        $result['Data'] = $this->M_admin->getListMenuChild($req_param);
        echo json_encode($result);
    }

}
