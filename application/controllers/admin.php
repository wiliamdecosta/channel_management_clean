<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    private $head = "Admin System";
	
	function __construct() {
		parent::__construct();
		
		//Load Library Cek Session
		$this->load->library('cek_session');
        $this->cek_session->cek_ses();

        $this->load->helper('breadcrumb');

		$this->load->model('M_profiling');
		$this->load->model('M_user');
		$this->load->model('M_admin');
        $this->load->model('M_jqGrid', 'jqGrid');

	}

	public function index() {
		redirect("/");
	}
	
	public function menu() {
        //BreadCrumb
        $title = $_POST['title'];
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

		$this->load->view('admin/list_menu');
	}
    public function profile() {
        //BreadCrumb
        $title = $_POST['title'];
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('admin/list_profile');
    }

	public function gridmenu() {
        $page = intval($_REQUEST['page']) ; // Page
        $limit = intval($_REQUEST['rows']) ; // Number of record/page
        $sidx = $_REQUEST['sidx'] ; // Field name
        $sord = $_REQUEST['sord'] ; // Asc / Desc

        $table = "APP_MENU"; // *

        //JqGrid Parameters
        $req_param = array (
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
            "or_where_not_in"=>null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null
        );

        // Filter Table *
        $req_param['where'] = array('MENU_PARENT'=> 0);

        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if($page == 0){
            $result['page'] = 1;
        }else{
            $result['page'] = $page ;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function gridProfile() {
        $page = intval($_REQUEST['page']) ; // Page
        $limit = $_REQUEST['rows'] ; // Number of record/page
        $sidx = $_REQUEST['sidx'] ; // Field name
        $sord = $_REQUEST['sord'] ; // Asc / Desc

        $table = "APP_PROFILE"; // *

        //JqGrid Parameters
        $req_param = array (
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
            "or_where_not_in"=>null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null
        );

        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1);

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

    public function menuCRUD(){
        $table = "APP_MENU";
        $this->jqGrid->crud($table,'MENU_ID', array('MENU_NAME','MENU_PARENT', 'MENU_ICON','MENU_DESC'));
    }

    public function crud_profile(){
        $table = "APP_PROFILE";
        $id = $this->input->post('id');
        $this->jqGrid->crud($table,'PROF_ID', $id, array('PROF_NAME','PROF_DESC'));
    }

    public function crud_detail(){
        $table = "APP_MENU";
        $id = $this->input->post('id');
        $this->jqGrid->crud($table,'MENU_ID', $id, array('MENU_NAME', 'MENU_LINK','FILE_NAME','MENU_PARENT'));
    }

    public function gridMenuchild() {
        $id = $this->input->post('parent_id');
        $page = intval($_REQUEST['page']) ; // Page
        $limit = intval($_REQUEST['rows']) ; // Number of record/page
        $sidx = $_REQUEST['sidx'] ; // Field name
        $sord = $_REQUEST['sord'] ; // Asc / Desc

        $table = "APP_MENU"; // *

        //JqGrid Parameters
        $req_param = array (
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
            "or_where_not_in"=>null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null
        );

        // Filter Table *
        $req_param['where'] = array('MENU_PARENT'=> $id);

        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $this->parent_id = $id;
        if($page == 0){
            $result['page'] = 1;
        }else{
            $result['page'] = $page ;
        }
        ($page == 0 ?  $result['page']= 1: $page );
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function menuTree(){
        $data['prof_id'] = $this->input->post('prof_id');
        $this->load->view('admin/menu_tree',$data);
    }
    public function getMenuTreeJson($prof_id){
        $result = $this->M_admin->getTreeMenu();
        $i = 0;
        $data = array();
        foreach($result as $menu){

            $tmp = array(
                'id' => $menu->MENU_ID,
                'parentid' => $menu->MENU_PARENT,
                'text' => $menu->MENU_NAME,
                'value' =>$menu->MENU_ID,
                'expanded' =>true

            );

            //Cek count di tabel menu profile untuk menu_id , jika >0 maka checked true
            $profile_id = $prof_id;
            $tmpCount = $this->M_admin->cekMenuProfile($menu->MENU_ID,$profile_id)->result_array;

            $countMenu = count($tmpCount);

            if($countMenu > 0){
                $tmp = array_merge($tmp, array('checked' => true));
            }

            $data[$i] = $tmp;
            $i=$i+1;

        }
        echo json_encode($data);
    }

    public function updateProfile(){
        $menu_id = $this->input->post('check_val');
        $prof_id = $this->input->post('prof_id');

        if($prof_id != "" || $prof_id != null){
            // delete app menu profile where id profile = ...
            $this->M_admin->delMenuProf($prof_id);

            if (!empty($menu_id)) {
                $menu_ids = implode(",", $menu_id);
                $this->M_admin->insMenuProf($menu_ids,$prof_id);
            }

        }
        $this->menuTree();
    }

    public function user() {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('admin/list_user');
    }
    public function gridUser() {
        $page = intval($_REQUEST['page']) ; // Page
        $limit = intval($_REQUEST['rows']) ; // Number of record/page
        $sidx = $_REQUEST['sidx'] ; // Field name
        $sord = $_REQUEST['sord'] ; // Asc / Desc

        $table = "V_USER"; // *

        //JqGrid Parameters
        $req_param = array (
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
            "or_where_not_in"=>null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null
        );

        // Filter Table *
        $req_param['where_not_in']['field'] = ('NIK');
        $req_param['where_not_in']['value'] = array('DEV','ADMIN');

        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if($page == 0){
            $result['page'] = 1;
        }else{
            $result['page'] = $page ;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function crud_user(){
        $this->M_admin->crud_user();
    }

    public function resetPWD(){
        $uid = $this->input->post('user_id');
        $nik = md5(strtolower($this->input->post('nik')));
        $this->M_admin->resetPwd($uid,$nik);
        if($this->db->affected_rows() > 0){
            echo "Password berhasil direset";
        }else{
            echo "Update Gagal";
        }
    }
}
