<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Workflow_parameter extends CI_Controller
{

    private $head = "Workflow Parameter";

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        checkAuth();
        $this->load->model('M_jqGrid', 'jqGrid');
        $this->load->model('P_document_type');
        $this->load->model('P_workflow_list');
        $this->load->model('P_procedure');
        $this->load->model('P_procedure_files');
        $this->load->model('P_procedure_role');
        $this->load->model('Workflow','workflow');
    }


    public function index() {
        redirect("/");
    }


    public function document_type() {

        $title = "Daftar Jenis Workflow";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $result = array();
        $result['menu_id'] = $this->uri->segment(3);
        $this->load->view('workflow_parameter/document_type', $result);
    }

    public function grid_document_type() {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "SELECT * FROM P_DOCUMENT_TYPE";

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

        // Filter Table *
        $req_param['where'] = array();

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        //print_r($row);exit;
        //$count = count($row);

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


        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);

    }

    public function crud_document_type() {
        $result = $this->P_document_type->crud_document_type();

        echo json_encode($result);
        exit;
    }

    function html_select_options_reference_list($code = '') {
        try {

		    $items = $this->P_document_type->getReferenceList($code);
		    echo '<select>';
            foreach($items  as $item ){
                echo '<option value="'.$item['REFERENCE_LIST_CODE'].'">'.$item['REFERENCE_LIST_CODE'].'</option>';
            }
            echo '</select>';
            exit;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    /* Daftar Workflow */
    public function workflow_list() {

        $title = "Daftar Workflow";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $result = array();
        $result['menu_id'] = $this->uri->segment(3);
        $this->load->view('workflow_parameter/workflow_list', $result);
    }

    public function grid_workflow() {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "SELECT * FROM V_WORKFLOW";

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

        // Filter Table *
        $req_param['where'] = array();

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        // print_r($row);exit;
        //$count = count($row);

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


        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);

    }

    public function crud_workflow_list() {
        $result = $this->P_workflow_list->crud_workflow_list();

        echo json_encode($result);
        exit;
    }

    function html_select_options_doc_type() {
        try {

            $items = $this->P_workflow_list->getDocumentType();
            echo '<select>';
            foreach($items  as $item ){
                echo '<option value="'.$item['P_DOCUMENT_TYPE_ID'].'">'.$item['DOCUMENT_TYPE_CODE'].'</option>';
            }
            echo '</select>';
            exit;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    function html_select_options_procedure() {
        try {

            $items = $this->P_workflow_list->getProcedure();
            echo '<select>';
            foreach($items  as $item ){
                echo '<option value="'.$item['P_PROCEDURE_ID'].'">'.$item['PROCEDURE_CODE'].'</option>';
            }
            echo '</select>';
            exit;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    /* End Daftar Workflow*/


    /* P_procedure */

    public function procedure() {

        $result = array();
        $result['menu_id'] = $this->uri->segment(3) == "" ? $this->input->post('menu_id') : $this->uri->segment(3);
        $this->load->view('workflow_parameter/procedure', $result);
    }

    public function grid_procedure() {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "SELECT * FROM P_PROCEDURE";

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

        // Filter Table *
        $req_param['where'] = array();

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        //print_r($row);exit;
        //$count = count($row);

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


        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);

    }

    public function crud_procedure() {
        $result = $this->P_procedure->crud_procedure();

        echo json_encode($result);
        exit;
    }


    public function grid_procedure_files() {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $p_procedure_id = $this->input->post('procedure_id');
        $table = "SELECT * FROM P_PROCEDURE_FILES";

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

        // Filter Table *
        $req_param['where'] = array('p_procedure_id = '.$p_procedure_id);

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        //print_r($row);exit;
        //$count = count($row);

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


        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);

    }

    public function crud_procedure_files() {
        $result = $this->P_procedure_files->crud_procedure_files();

        echo json_encode($result);
        exit;
    }


    public function grid_procedure_role() {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $p_procedure_id = $this->input->post('procedure_id');
        $table = "SELECT a.P_PROCEDURE_ROLE_ID,
                        a.P_PROCEDURE_ID,
                        a.P_APP_ROLE_ID,
                        a.F_ROLE,
                        to_char(a.VALID_FROM,'yyyy-mm-dd') VALID_FROM,
                        to_char(a.VALID_TO, 'yyyy-mm-dd') VALID_TO,
                        a.UPDATED_DATE,
                        a.UPDATED_BY,
                        a.CREATED_BY,
                        a.CREATION_DATE,
                        b.PROF_NAME
                    FROM P_PROCEDURE_ROLE a
                    LEFT JOIN APP_PROFILE b ON a.P_APP_ROLE_ID = b.PROF_ID";

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

        // Filter Table *
        $req_param['where'] = array('a.p_procedure_id = '.$p_procedure_id);

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        //print_r($row);exit;
        //$count = count($row);

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


        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);

    }

    public function crud_procedure_role() {
        $result = $this->P_procedure_role->crud_procedure_role();

        echo json_encode($result);
        exit;
    }

    /** chart proc **/
    public function chart_proc() {

        $title = "Daftar Workflow";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $result = array();
        $result['menu_id'] = $this->uri->segment(3);
        $this->load->view('workflow_parameter/chart_proc', $result);
    }

    public function grid_workflow_list() {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "SELECT * FROM V_WF_WORKFLOW_LIST";

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

        // Filter Table *
        $req_param['where'] = array();

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        // print_r($row);exit;
        //$count = count($row);

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


        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);

    }

    public function gridChartProcPrev() {

        $id = $this->input->post('P_WORKFLOW_ID');
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "V_WF_CHART_PREV";

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

        $req_param['where'] = array('P_WORKFLOW_ID' => $id);

        //$req_param['field'] = array();
        //$req_param['value'] = array();

        $count = $this->jqGrid->countAll($req_param);
        //print_r($row);exit;
        //$count = count($row);

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

        $this->parent_id = $id;
        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function crud_chart_proc_prev() {
        $result = $this->P_workflow_list->crud_chart_proc_prev();

        echo json_encode($result);
        exit;
    }

    public function gridChartProcNext(){

        $id_prev = $this->input->post('P_PROCEDURE_ID_PREV');
        $id = $this->input->post('P_WORKFLOW_ID');
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "V_WF_CHART_NEXT";

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

        $req_param['where'] = array('P_PROCEDURE_ID_PREV' => $id_prev, 'P_WORKFLOW_ID' => $id);

        //$req_param['field'] = array();
        //$req_param['value'] = array();

        $count = $this->jqGrid->countAll($req_param);
        //print_r($row);exit;
        //$count = count($row);

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

        $this->parent_id = $id;
        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function grid_daemon() {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $p_w_chart_proc_id = $this->input->post('p_w_chart_proc_id');
        $table = "SELECT * FROM P_W_DAEMON_PROC";

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

        // Filter Table *
        $req_param['where'] = array('P_W_CHART_PROC_ID = '.$p_w_chart_proc_id);

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        //print_r($row);exit;
        //$count = count($row);

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


        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);

    }

    public function crud_daemon() {
        $result = $this->P_workflow_list->crud_daemon();

        echo json_encode($result);
        exit;
    }
    /** end chart proc **/

    public function grid_customer_order() {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = empty($_REQUEST['sidx']) ? "t_customer_order_id" : $_REQUEST['sidx'];
        $sord = empty($_REQUEST['sord']) ? "ASC" : $_REQUEST['sord'];

        //$table = "SELECT * FROM T_CUSTOMER_ORDER";
        $table = "SELECT * FROM V_CUSTOMER_ORDER";
        $t_customer_order_id = $this->input->post('t_customer_order_id');
        $p_w_proc_id = $this->input->post('p_w_proc_id');

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => isset($_REQUEST['_search']) ? $_REQUEST['_search'] : null,
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        // Filter Table *
        $req_param['where'] = array();
        if(!empty($t_customer_order_id)) {
            $req_param['where'][] = 'T_CUSTOMER_ORDER_ID = '.$t_customer_order_id;
        }

        if(!empty($p_w_proc_id)) {
            $req_param['where'][] = 'P_W_PROC_ID = '.$p_w_proc_id;
        }

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        //print_r($row);exit;
        //$count = count($row);

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


        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);
    }


    public function setCustomerOrder() {
        $t_customer_order_id = $this->input->post('t_customer_order_id');
        $order_no = $this->input->post('order_no');
        $user_name = $this->session->userdata("d_user_name");

        $sql = "UPDATE T_CUSTOMER_ORDER
                SET ORDER_NO = '".$order_no."',
                UPDATED_DATE = sysdate,
                UPDATED_BY = '".$user_name."'
                WHERE T_CUSTOMER_ORDER_ID = ".$t_customer_order_id;

        $this->jqGrid->db->query($sql);
        $data['success'] = true;
        $data['msg'] = 'Data berhasil diupdate';

        echo json_encode($data);
    }

    /** monitoring **/
    public function monitoring(){
        $title = "Monitoring";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $result['result'] = $this->P_workflow_list->getWorkflow();
        $this->load->view('workflow_parameter/monitoring',$result);
    }

    public function processMonitoring(){

        $p_workflow_id = $this->input->post('p_workflow_id');
        $skeyword = $this->input->post('skeyword');

        $result = $this->P_workflow_list->getMonitoring($p_workflow_id, $skeyword,'H');
        foreach ($result as $rowH) {
            $exp = explode('|', $rowH->WF_MONITOR);
            if($exp[0] == 'H'){
                $data['header'] = $exp;
            }

        }

        $data['p_workflow_id'] = $p_workflow_id;
        $data['skeyword'] = $skeyword;

        $this->load->view('workflow_parameter/monitoring_grid',$data);

    }

    public function getMonProcess(){
        $page = intval($this->input->post('current')) ;
        $limit = $this->input->post('rowCount');
        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');

        $p_workflow_id = $this->input->post('p_workflow_id');
        $skeyword = $this->input->post('skeyword');

        $result = $this->P_workflow_list->getMonitoring($p_workflow_id, $skeyword,'D');

        $data = array();
        $hasil = array();
        $no = 1;
        foreach ($result as $row) {
            $exp = explode('|', $row->WF_MONITOR);
            if($exp[0] == 'D'){
                $tmp = array();

                for($i=0; $i<count($exp); $i++){
                    if($i==0){
                        $tmp = array("urutan" => $no);
                    }
                    $tmp = array_merge($tmp, array("data".$i => $exp[$i]));
                }

                if ($page == 0) {
                    $hasil['current'] = 1;
                } else {
                    $hasil['current'] = $page;
                }

                $jmlCount[] = $tmp;

                if($hasil['current'] == 1){
                    $start = $hasil['current'];
                    $end = $limit;
                }else{
                    $end = ($limit * $hasil['current']);
                    $start = $end - ($limit - 1);
                }
                // print_r($start);
                // exit;
                if(($tmp['urutan'] >= $start) && ($tmp['urutan'] <= $end)){
                    $data[] = $tmp;
                }

                $hasil['total'] = count($jmlCount);
                $hasil['rowCount'] = $limit;
                $hasil['success'] = true;
                $hasil['message'] = 'Berhasil';
                $hasil['rows'] = $data;

            }

            $no++;
        }

        echo(json_encode($hasil));
        exit;
    }
    /** end monitoring **/

    /* Invoice */
    public function invoice() {

        $result = array();
        $result['menu_id'] = $this->uri->segment(3);
        $this->load->view('workflow_parameter/invoice', $result);
    }

    public function grid_invoice() {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "SELECT * FROM V_INVOICE";

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

        // Filter Table *
        $req_param['where'] = array('P_ORDER_STATUS_ID = 1');

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        // print_r($row);exit;
        //$count = count($row);

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


        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);

    }

    function html_select_options_rqst_type() {
        try {

            $items = $this->P_workflow_list->getRqstType();
            echo '<select>';
            foreach($items  as $item ){
                echo '<option value="'.$item['P_RQST_TYPE_ID'].'">'.$item['CODE'].'</option>';
            }
            echo '</select>';
            exit;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    function html_select_options_order_status() {
        try {

            $items = $this->P_workflow_list->getOrderStatus();
            echo '<select>';
            foreach($items  as $item ){
                echo '<option value="'.$item['P_ORDER_STATUS_ID'].'">'.$item['CODE'].'</option>';
            }
            echo '</select>';
            exit;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    function html_select_options_reference() {
        try {

            $items = $this->P_workflow_list->getReference();
            echo '<select>';
            foreach($items  as $item ){
                echo '<option value="'.$item['CONTRACT_TYPE_ID'].'">'.$item['REFERENCE_NAME'].'</option>';
            }
            echo '</select>';
            exit;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function doc_type() {
        try {
            $sql = "select * from p_legal_doc_type";
            $query = $this->workflow->db->query($sql);
            $items = $query->result_array();

            echo '<select>';
            foreach ($items as $item) {
                echo '<option value="'.$item['P_LEGAL_DOC_TYPE_ID'].'"> '.$item['CODE'].' </option>';
            }
            echo '</select>';
            exit;
        }catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function crud_invoice() {
        $result = $this->P_workflow_list->crud_invoice();

        echo json_encode($result);
        exit;
    }

    public function submitWF() {
        $doc_type_id = 1;
        $t_customer_order_id = $this->input->post('T_CUSTOMER_ORDER_ID');
        $username = $this->session->userdata('d_user_name');

        try {

            $sql = "  BEGIN ".
                            "  p_first_submit_engine(:i_doc_type_id, :i_cust_req_id, :i_username, :o_result_code, :o_result_msg ); END;";



            $stmt = oci_parse($this->workflow->db->conn_id, $sql);

            //  Bind the input parameter
            oci_bind_by_name($stmt, ':i_doc_type_id', $doc_type_id);
            oci_bind_by_name($stmt, ':i_cust_req_id', $t_customer_order_id);
            oci_bind_by_name($stmt, ':i_username', $username);

            // Bind the output parameter
            oci_bind_by_name($stmt, ':o_result_code', $code);
            oci_bind_by_name($stmt, ':o_result_msg', $msg, 20000);

            ociexecute($stmt);

            $data['success'] = true;
            $data['error_code'] = $code;
            $data['error_message'] = $msg;

        } catch( Exception $e ) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }

        echo json_encode($data);
    }

    public function grid_legaldoc() {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "SELECT a.*, b.CODE as LEGAL_DOC_DESC FROM t_cust_order_legal_doc a
                 LEFT JOIN p_legal_doc_type b ON a.P_LEGAL_DOC_TYPE_ID = b.P_LEGAL_DOC_TYPE_ID";

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

        // Filter Table *
        $req_param['where'] = array('a.T_CUSTOMER_ORDER_ID = '.$this->input->post('t_customer_order_id'));

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        // print_r($row);exit;
        //$count = count($row);

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


        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);

    }
    /*end Invoice*/

}
