<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{

    private $head = "Admin System";

    function __construct()
    {
        parent::__construct();

        checkAuth();

        $this->load->model('M_profiling');
        $this->load->model('M_user');
        $this->load->model('M_admin');
        $this->load->model('M_jqGrid', 'jqGrid');
        $this->load->model('Gen_id');

    }

    public function index()
    {
        redirect("/");
    }

    public function menu()
    {
        //BreadCrumb
        $title = $_POST['title'];
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('admin/list_menu');
    }

    public function profile()
    {
        //BreadCrumb
        $title = $_POST['title'];
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('admin/list_profile');
    }

    public function gridmenu()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "APP_MENU"; // *

        //JqGrid Parameters
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
        $req_param['where'] = array('MENU_PARENT' => 0);

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

    public function gridProfile()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = $_REQUEST['rows']; // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "APP_PROFILE"; // *

        //JqGrid Parameters
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

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function menuCRUD()
    {
        $table = "APP_MENU";
        $this->jqGrid->crud($table, 'MENU_ID', array('MENU_NAME', 'MENU_PARENT', 'MENU_ICON', 'MENU_DESC'));
    }

    public function crud_profile()
    {
        $table = "APP_PROFILE";
        $this->jqGrid->crud($table, 'PROF_ID', array('PROF_NAME', 'PROF_DESC'));
    }

    public function crud_detail()
    {
        $table = "APP_MENU";
        $this->jqGrid->crud($table, 'MENU_ID', array('MENU_NAME', 'MENU_LINK', 'FILE_NAME', 'MENU_PARENT'));
    }

    public function gridMenuchild()
    {
        $id = $this->input->post('parent_id');
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "APP_MENU"; // *

        //JqGrid Parameters
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
        $req_param['where'] = array('MENU_PARENT' => $id);

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

        $this->parent_id = $id;
        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
      //  ($page == 0 ? $result['page'] = 1 : $page);
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function menuTree()
    {
        $data['prof_id'] = $this->input->post('prof_id');
        $this->load->view('admin/menu_tree', $data);
    }

    public function getMenuTreeJson($prof_id)
    {
        $result = $this->M_admin->getTreeMenu();
        $i = 0;
        $data = array();
        foreach ($result as $menu) {

            $tmp = array(
                'id' => $menu->MENU_ID,
                'parentid' => $menu->MENU_PARENT,
                'text' => $menu->MENU_NAME,
                'value' => $menu->MENU_ID,
                'expanded' => true

            );

            //Cek count di tabel menu profile untuk menu_id , jika >0 maka checked true
            $profile_id = $prof_id;
            $tmpCount = $this->M_admin->cekMenuProfile($menu->MENU_ID, $profile_id)->result_array;

            $countMenu = count($tmpCount);

            if ($countMenu > 0) {
                $tmp = array_merge($tmp, array('checked' => true));
                $tmp = array_merge($tmp, array('app_menu_profile_id' => $tmpCount[0]['APP_MENU_PROFILE_ID']));
            }else {
                $tmp = array_merge($tmp, array('app_menu_profile_id' => ''));
            }

            $data[$i] = $tmp;
            $i = $i + 1;

        }
        echo json_encode($data);
    }

    public function updateProfile()
    {
        $menu_id = $this->input->post('check_val');
        $prof_id = $this->input->post('prof_id');

        if ($prof_id != "" || $prof_id != null) {
            // delete app menu profile where id profile = ...
            $this->M_admin->delMenuProf($prof_id);

            if (!empty($menu_id)) {
                $menu_ids = implode(",", $menu_id);
                $this->M_admin->insMenuProf($menu_ids, $prof_id);
            }

        }
        $this->menuTree();
    }

    public function user()
    {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('admin/list_user');
    }

    public function gridUser()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "APP_USERS"; // *

        //JqGrid Parameters
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
        $req_param['where_not_in']['field'] = ('NIK');
        $req_param['where_not_in']['value'] = array('DEV', 'ADMIN');

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

    public function crud_user()
    {
        $this->M_admin->crud_user();
    }

    public function resetPWD()
    {
        $uid = $this->input->post('user_id');
        $nik = md5(strtolower($this->input->post('nik')));
        $this->M_admin->resetPwd($uid, $nik);
        if ($this->db->affected_rows() > 0) {
            echo "Password berhasil direset";
        } else {
            echo "Update Gagal";
        }
    }
    
    public function getPrivilegeMenuTable() {
        
        $app_menu_profile_id = $this->input->post('app_menu_profile_id');
        $arr_privilege_menu  = $this->M_admin->getPrivilegeMenu($app_menu_profile_id);
        
        $strOutput = "";
        
        echo '<form method="post" id="form-privelege" action="'.site_url('admin/setPrivilegeMenu').'">';
        echo '<table width="100%" class="table table-striped table-bordered">';
        echo '<tr>
                <th>No</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Tgl Pembuatan</th>
                <th>Dibuat Oleh</th>
                <th>Tgl Update</th>
                <th>Diupdate Oleh</th>
              </tr>';
        
        $no=1;
        foreach($arr_privilege_menu as $item) {
            
            $options = array('Y' => 'ACTIVE',
                            'N' => 'NOT ACTIVE');
            
            echo '<tr>';
                echo '<td>'.$no++.'</td>';
                echo '<td><label>'.$item->CODE.'</label></td>';
                echo '<td>'.form_dropdown('opt_status[]', $options, $item->IS_ACTIVE).'</td>';
                echo '<td><label>'.$item->CREATION_DATE.'</label></td>';
                echo '<td><label>'.$item->CREATED_BY.'</label></td>';
                echo '<td><label>'.$item->UPDATE_DATE.'</label></td>';
                echo '<td><label>'.$item->UPDATED_BY.'</label>'.form_hidden('object_type_id[]', $item->P_APP_OBJECT_TYPE_ID).' '.form_hidden('app_rmdis_object_id[]', $item->P_APP_RMDIS_OBJECT_ID).' '.form_hidden('app_menu_profile_id[]', $app_menu_profile_id).'</td>';
            echo '</tr>';        
        }
        
        echo '</table>';
        echo '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'">';
        echo '</form>';
        
        
    }
    
    public function setPrivilegeMenu() {
            
        $object_type_id = $this->input->post('object_type_id');
        $opt_status = $this->input->post('opt_status');
        $p_app_rmdis_object_id = $this->input->post('app_rmdis_object_id');
        $p_app_menu_profile_id = $this->input->post('app_menu_profile_id');
        
        $return_id = "";
        foreach($object_type_id as $idx => $p_app_object_type_id) {
            if($p_app_rmdis_object_id[$idx] == "") {
                //eksekusi insert    
                $ins_array = array( 'P_APP_RMDIS_OBJECT_ID' => $this->Gen_id->generate_id('P_APP_RMDIS_OBJECT_ID','P_APP_RMDIS_OBJECT')->N,
                                    'APP_MENU_PROFILE_ID' => $p_app_menu_profile_id[$idx],
                                    'P_APP_OBJECT_TYPE_ID' => $p_app_object_type_id,
                                    'IS_ACTIVE' => $opt_status[$idx]);
                $this->M_admin->insRmdisObject($ins_array);
            }else {
                //eksekusi update
                $upd_array = array('P_APP_RMDIS_OBJECT_ID' => $p_app_rmdis_object_id[$idx],
                                    'IS_ACTIVE' => $opt_status[$idx]);
                $this->M_admin->updRmdisObject($upd_array); 
            }
            
            $return_id = $p_app_menu_profile_id[$idx];
        }
        echo $return_id;
    }
}
