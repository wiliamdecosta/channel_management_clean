<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mapping_user_mitra extends CI_Controller
{

    private $head = "Mapping User Mitra";

    function __construct()
    {
        parent::__construct();

        checkAuth();
        $this->load->model('M_user');
        $this->load->model('M_jqGrid', 'jqGrid');
    }

    public function index()
    {
        redirect("/");
    }
    
    public function map() {
        //BreadCrumb
        $title = $_POST['title'];
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);
        
        $this->load->view('admin/mapping_user_mitra');
    }
    
    public function gridUser()
    {

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "SELECT a.USER_ID,a.USER_NAME,a.EMAIL,a.LOKER,a.ADDR_STREET,
                    a.ADDR_CITY,a.CONTACT_NO,a.PASSWD,a.FULL_NAME,a.P_USER_STATUS_ID,
                    a.EXPIRED_USER,a.EXPIRED_PWD,a.FAIL_PWD,a.EMPLOYEE_NO,a.IS_EMPLOYEE,
                    a.IP_ADDRESS,a.IS_NEW_USER,a.LAST_LOGIN_TIME, c.PGL_NAME, c.PGL_ID
                    FROM APP_USERS a
                    LEFT JOIN APP_USER_C2BI b ON a.USER_ID = b.USER_ID
                    LEFT JOIN CUST_PGL c ON b.PGL_ID = c.PGL_ID";

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
        $req_param['where'] = array("nvl(a.IS_EMPLOYEE, 'N') = 'N'",
                                    "a.USER_NAME NOT IN('DEV','ADMIN')");

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
    
    public function gridLovCustPGL() {

        $page = intval($this->input->post('current')) ;
        $limit = $this->input->post('rowCount');
        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');

        $searchPhrase = $this->input->post('searchPhrase');

        $query = "SELECT * FROM CUST_PGL";

        $req_param = array (
            "table" => $query,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
			"search" => $searchPhrase
        );

        $req_param['where'] = array();
        
        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(upper(pgl_name) LIKE upper('%".$searchPhrase."%'))";
        }
        

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        if( $count > 0 && !empty($limit) ) {
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

		if ($page == 0) {
            $result['current'] = 1;
        } else {
            $result['current'] = $page;
        }

        $result['total'] = $count;
        $result['rowCount'] = $limit;
        $result['success'] = true;
        $result['message'] = 'Berhasil';
        $result['rows'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);
    }
    
    public function savemitra() {
        $data = array('success' => false, 'message' => '');
        
        $items = json_decode($this->input->post('items'), true);
        $user_id = $items['user_id'];
        $user_email = $items['user_email'];
        $pgl_id = $items['pgl_id'];
        
        
        $sql = "SELECT COUNT(1) totalcount FROM APP_USER_C2BI
                    WHERE USER_ID = ".$user_id;
		$query = $this->M_user->db->query($sql);
		$row = $query->row_array();
		
		if($row['TOTALCOUNT'] > 0) { //update
		    $sql = "UPDATE APP_USER_C2BI
		                SET PGL_ID = ".$pgl_id."
		                WHERE USER_ID = ".$user_id;
		    $this->M_user->db->query($sql);
		    
		    $data['success'] = true;
		    $data['message'] = 'Data Mitra User berhasil diupdate';
		    echo json_encode($data);
		    exit;
		}else { //insert and send email
		    $sql = "INSERT INTO APP_USER_C2BI(USER_ID, PGL_ID) VALUES(".$user_id.",".$pgl_id.")";
		    $this->M_user->db->query($sql);
            
            $itemadmin = $this->M_user->getUserItem( $this->session->userdata('d_user_id') );
            $itemuser = $this->M_user->getUserItem( $user_id );
            
            $subject = "Konfirmasi User (Channel Management)";
            $content = "User Anda telah terdaftar pada Aplikasi Channel Management. Silahkan klik link berikut untuk mengisi profil dan password Anda : <br><br>";
            $content .= "<strong>Username : ".$itemuser['USER_NAME']."</strong><br><br>";
            $content .= site_url('submit_profile/page/'.base64_encode($user_id.'|'.$itemadmin['USER_ID'].'|'.$itemadmin['EMAIL']));
            $content .= "<br><br>";
            
            $this->sendMail($user_email, $subject, $content);
            
            $data['success'] = true;
		    $data['message'] = 'Data Mitra User berhasil ditambahkan dan email telah dikirim';
            echo json_encode($data);
		}
		
        
    }
    
    public function sendMail($email_tujuan, $subject, $content) {
        
        $sql = "  BEGIN ".
               "  marfee.p_send_mail_html(:params1, :params2, :params3, :params4, :params5, :params6, :params7, :params8); END;";

        $params = array(
            array('name' => ':params1', 'value' => 'tos_admin@telkom.co.id', 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params2', 'value' => $email_tujuan, 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params3', 'value' => '', 'type' => SQLT_CHR, 'length' => 32),
            array('name' => ':params4', 'value' => '', 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params5', 'value' => $subject, 'type' => SQLT_CHR, 'length' => 500),
            array('name' => ':params6', 'value' => '', 'type' => SQLT_CHR, 'length' => 32),
            array('name' => ':params7', 'value' => $content, 'type' => SQLT_CHR, 'length' => 500),
            array('name' => ':params8', 'value' => 'smtp.telkom.co.id', 'type' => SQLT_CHR, 'length' => 32)
        );
        // Bind the output parameter

        $stmt = oci_parse($this->M_user->db->conn_id,$sql);

        foreach($params as $p){
            // Bind Input
            oci_bind_by_name($stmt,$p['name'], $p['value'], $p['length']);
        }

        ociexecute($stmt);
    }
    
    
    public function deletemitra() {
        $data = array('success' => false, 'message' => '');
        
        $items = json_decode($this->input->post('items'), true);
        $user_id = $items['user_id'];
        
        $sql = "DELETE FROM APP_USER_C2BI
                    WHERE USER_ID = ".$user_id;
		$query = $this->M_user->db->query($sql);
		
		$data['success'] = true;
		$data['message'] = "Data mitra berhasil dihapus";
		
		echo json_encode($data);
		exit;
    }
}