<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_attribute extends CI_Controller {

    private $head = "User Attribute";

	function __construct() {
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        checkAuth();
        $this->load->model('M_jqGrid', 'jqGrid');
	}

	public function index()
	{
		redirect("/");
	}
    
    public function gridUserAttribute() {

        $user_id = $this->input->post('user_id');
        $p_user_attribute_id = $this->input->post('p_user_attribute_id');

        $page = intval($this->input->post('current')) ;
        $limit = $this->input->post('rowCount');
        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');

        $searchPhrase = $this->input->post('searchPhrase');

        $query = "SELECT a.p_user_attribute_id, a.user_id, a.p_user_attribute_type_id,
                       a.p_user_attribute_list_id, a.user_attribute_value, a.valid_from,
                       a.valid_to, a.description, b.code type_code, c.code list_code,
                       c.NAME list_name, a.creation_date, a.created_by, a.updated_date, a.updated_by
                  FROM p_user_attribute a LEFT JOIN p_user_attribute_type b
                       ON a.p_user_attribute_type_id = b.p_user_attribute_type_id
                       LEFT JOIN p_user_attribute_list c
                       ON a.p_user_attribute_list_id = c.p_user_attribute_list_id";

        $req_param = array (
            "table" => $query,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
			"search" => $searchPhrase
        );
    
        if(!empty($user_id)) {
            $req_param['where'][] = "a.user_id = ".$user_id;
        }

        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(upper(a.user_attribute_value) LIKE upper('%".$searchPhrase."%') OR upper(b.code) LIKE upper('%".$searchPhrase."%') OR upper(c.code) LIKE upper('%".$searchPhrase."%') OR upper(c.name) LIKE upper('%".$searchPhrase."%'))";
        }

        if(!empty($p_user_attribute_id)) {
            $req_param['where'][] = "a.p_user_attribute_id = ".$p_user_attribute_id;
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


    public function crudUserAttribute($action) {

        $items = json_decode($this->input->post('items'), true);
        $result = array();


        if($action == 'create' or $action == 'update') {
            $errorMsg = array();
            if(empty($items['P_USER_ATTRIBUTE_TYPE_ID'])) {
                $errorMsg[] = "- Attribute Type Harus Diisi";
            }
            if(empty($items['USER_ATTRIBUTE_VALUE'])) {
                $errorMsg[] = "- Attribute Value Harus Diisi";
            }
            if(empty($items['VALID_FROM'])) {
                $errorMsg[] = "- Valid From Harus Diisi";
            }

            if(count($errorMsg) > 0) {
                $result['success'] = false;
                $result['message'] = join("<br>", $errorMsg);
                echo json_encode($result);
                exit;
            }
        }


        switch ($action) {

            case 'create' :
                try {
                    $new_id = gen_id('P_USER_ATTRIBUTE_ID','P_USER_ATTRIBUTE');
                    $db_result = $this->db->query_custom(
                        "INSERT INTO P_USER_ATTRIBUTE(P_USER_ATTRIBUTE_ID, USER_ID, P_USER_ATTRIBUTE_TYPE_ID, P_USER_ATTRIBUTE_LIST_ID, USER_ATTRIBUTE_VALUE, VALID_FROM, VALID_TO, DESCRIPTION, CREATION_DATE, CREATED_BY, UPDATED_DATE, UPDATED_BY)
                        VALUES(".$new_id.",
                        ".$items['USER_ID'].",
                        ".$items['P_USER_ATTRIBUTE_TYPE_ID'].",
                        ".(empty($items['P_USER_ATTRIBUTE_LIST_ID']) ? "NULL" : $items['P_USER_ATTRIBUTE_LIST_ID']).",
                        '".$items['USER_ATTRIBUTE_VALUE']."',
                        ".(empty($items['VALID_FROM']) ? "NULL" : "to_date('".$items['VALID_FROM']."','dd/mm/yyyy')").",
                        ".(empty($items['VALID_TO']) ? "NULL" : "to_date('".$items['VALID_TO']."','dd/mm/yyyy')").",
                        '".$items['DESCRIPTION']."',
                        SYSDATE,
                        '".$this->session->userdata('d_user_name')."',
                        SYSDATE,
                        '".$this->session->userdata('d_user_name')."'
                        )"
                    );
                    
                    if($db_result != 1) {
                        throw new Exception('Terjadi Duplikasi Data');    
                    }
                                                                        
                    $result['success'] = true;
                    $result['message'] = 'Data User Attribute Berhasil Ditambahkan';
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
            break;

            case 'update':
                try {
                    
                    $db_result = $this->db->query_custom(
                        "UPDATE P_USER_ATTRIBUTE
                            SET P_USER_ATTRIBUTE_TYPE_ID = ".$items['P_USER_ATTRIBUTE_TYPE_ID'].",
                            P_USER_ATTRIBUTE_LIST_ID = ".(empty($items['P_USER_ATTRIBUTE_LIST_ID']) ? "NULL" : $items['P_USER_ATTRIBUTE_LIST_ID']).",
                            USER_ATTRIBUTE_VALUE = '".$items['USER_ATTRIBUTE_VALUE']."',
                            VALID_FROM = to_date('".$items['VALID_FROM']."','dd/mm/yyyy'),
                            VALID_TO = ".(empty($items['VALID_TO']) ? "NULL" : "to_date('".$items['VALID_TO']."','dd/mm/yyyy')").",
                            DESCRIPTION = '".$items['DESCRIPTION']."',
                            UPDATED_DATE = SYSDATE,
                            UPDATED_BY = '".$this->session->userdata('d_user_name')."'
                         WHERE P_USER_ATTRIBUTE_ID = ".$items['P_USER_ATTRIBUTE_ID']."
                    ");
                    
                    if($db_result != 1) {
                        throw new Exception('Terjadi Duplikasi Data');
                    }
                    
                    $result['success'] = true;
                    $result['message'] = 'Data User Attribute Berhasil Diupdate';
                }catch (Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
            break;

            case 'destroy' :
                try {

                    if (!is_array($items)){
                        $result['success'] = true;
                        $result['message'] = '1 Data Berhasil Dihapus';

                        $this->db->where('P_USER_ATTRIBUTE_ID',$items);
                        $this->db->delete('P_USER_ATTRIBUTE');
                    }else {
                        foreach($items as $val) {
                            $this->db->where('P_USER_ATTRIBUTE_ID',$val);
                            $this->db->delete('P_USER_ATTRIBUTE');
                        }
                        $result['success'] = true;
                        $result['message'] = count($items).' Data Berhasil Dihapus';
                    }

                }catch (Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
            break;
        }

        echo json_encode($result);
    }


    public function gridLovUserAttributeType() {

        $p_user_attribute_type_id = $this->input->post('p_user_attribute_type_id');

        $page = intval($this->input->post('current')) ;
        $limit = $this->input->post('rowCount');
        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');

        $searchPhrase = $this->input->post('searchPhrase');

        $query = "SELECT * FROM P_USER_ATTRIBUTE_TYPE";

        $req_param = array (
            "table" => $query,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
			"search" => $searchPhrase
        );

        $req_param['where'] = array();
        
        if(!empty($p_user_attribute_type_id)) {
            $req_param['where'][] = "p_user_attribute_type_id = ".$p_user_attribute_type_id;
        }
        
        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(upper(code) LIKE upper('%".$searchPhrase."%') OR upper(description) LIKE upper('%".$searchPhrase."%'))";
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
    
    public function gridLovUserAttributeList() {

        $p_user_attribute_list_id = $this->input->post('p_user_attribute_list_id');
        $p_user_attribute_type_id = $this->input->post('p_user_attribute_type_id');

        $page = intval($this->input->post('current')) ;
        $limit = $this->input->post('rowCount');
        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');

        $searchPhrase = $this->input->post('searchPhrase');

        $query = "SELECT * FROM P_USER_ATTRIBUTE_LIST";

        $req_param = array (
            "table" => $query,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
			"search" => $searchPhrase
        );
        
        $req_param['where'] = array();
        
        if(!empty($p_user_attribute_list_id)) {
            $req_param['where'][] = "p_user_attribute_list_id = ".$p_user_attribute_list_id;
        }
        
        if(!empty($p_user_attribute_type_id)) {
            $req_param['where'][] = "p_user_attribute_type_id = ".$p_user_attribute_type_id;
        }
        
        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(upper(code) LIKE upper('%".$searchPhrase."%') OR upper(name) LIKE upper('%".$searchPhrase."%') OR upper(description) LIKE upper('%".$searchPhrase."%'))";
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
    
}