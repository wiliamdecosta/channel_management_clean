<?php
class M_parameter extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->helper('sequence');
    }
    function crud_batchType(){
        $oper=$this->input->post('oper');
        $id_=$this->input->post('id');
        $array_edit = array('CODE' => $this->input->post('CODE'),
            'IS_ACTIVE' => $this->input->post('IS_ACTIVE'),
            'IS_BATCH_REPORT' => $this->input->post('IS_BATCH_REPORT'),
            'UPDATE_DATE' => "SYSDATE",
            'UPDATE_BY' => $this->session->userdata('d_user_name')
        );
        switch ($oper) {
            case 'add':
                $new_id = gen_id('P_BATCH_TYPE_ID','P_BATCH_TYPE');
                $this->db->query("INSERT INTO P_BATCH_TYPE(P_BATCH_TYPE_ID,CODE,IS_ACTIVE,IS_BATCH_REPORT,CREATION_DATE,CREATED_BY,UPDATE_DATE,UPDATE_BY)
                                    VALUES($new_id,
                                            '".$this->input->post('CODE')."',
                                            '".$this->input->post('IS_ACTIVE')."',
                                            '".$this->input->post('IS_BATCH_REPORT')."',
                                            SYSDATE,
                                            '".$this->session->userdata('d_user_name')."',
                                            SYSDATE,
                                            '".$this->session->userdata('d_user_name')."'
                                            )");
                break;
            case 'edit':
                $this->db->query("UPDATE P_BATCH_TYPE SET
                                    CODE = '".$this->input->post('CODE')."',
                                    IS_ACTIVE = '".$this->input->post('IS_ACTIVE')."',
                                    IS_BATCH_REPORT = '".$this->input->post('IS_BATCH_REPORT')."',
                                    UPDATE_DATE = SYSDATE,
                                    UPDATE_BY = '".$this->session->userdata('d_user_name')."'
                                    WHERE
                                    P_BATCH_TYPE_ID = ".$id_ );
                break;
            case 'del':
                $this->db->where('P_BATCH_TYPE_ID',$id_);
                $this->db->delete('P_BATCH_TYPE');
                break;
        }

    }
	
	
	function crud_reference(){
        $oper=$this->input->post('oper');
        $id_=$this->input->post('id');
        $array_edit = array('CODE' => $this->input->post('CODE'),
            'REFERENCE_NAME' => $this->input->post('REFERENCE_NAME'),
            'DESCRIPTION' => $this->input->post('DESCRIPTION')
        );
        switch ($oper) {
            case 'add':
                $new_id = gen_id('P_REFERENCE_TYPE_ID','P_REFERENCE_TYPE');
                $this->db->query("INSERT INTO P_REFERENCE_TYPE(P_REFERENCE_TYPE_ID,CODE,REFERENCE_NAME,DESCRIPTION,CREATION_DATE,CREATED_BY,UPDATED_DATE,UPDATED_BY)
                                    VALUES($new_id,
                                            '".$this->input->post('CODE')."',
                                            '".$this->input->post('REFERENCE_NAME')."',
                                            '".$this->input->post('DESCRIPTION')."',
                                            SYSDATE,
                                            '".$this->session->userdata('d_user_name')."',
                                            SYSDATE,
                                            '".$this->session->userdata('d_user_name')."'
                                            )");
                break;
            case 'edit':
                $this->db->query("UPDATE P_REFERENCE_TYPE SET
                                    CODE = '".$this->input->post('CODE')."',
                                    REFERENCE_NAME = '".$this->input->post('REFERENCE_NAME')."',
                                    DESCRIPTION = '".$this->input->post('DESCRIPTION')."',
                                    UPDATED_DATE = SYSDATE,
                                    UPDATED_BY = '".$this->session->userdata('d_user_name')."'
                                    WHERE
                                    P_REFERENCE_TYPE_ID = ".$id_ );
                break;
            case 'del':
                $this->db->where('P_REFERENCE_TYPE_ID',$id_);
                $this->db->delete('P_REFERENCE_TYPE');
                break;
        }

    }	
	
	function crud_reference_list(){
		$parent_id = $this->input->post('PARENT_ID');
        $oper=$this->input->post('oper');
        $id_=$this->input->post('id');
        $array_edit = array('CODE' => $this->input->post('CODE'),
            'REFERENCE_NAME' => $this->input->post('REFERENCE_NAME'),
			'LISTING_NO' => $this->input->post('LISTING_NO'),
            'DESCRIPTION' => $this->input->post('DESCRIPTION')
        );
        switch ($oper) {
            case 'add':
                $new_id = gen_id('P_REFERENCE_LIST_ID','P_REFERENCE_LIST');
                $this->db->query("INSERT INTO P_REFERENCE_LIST(P_REFERENCE_LIST_ID,P_REFERENCE_TYPE_ID,CODE,REFERENCE_NAME,LISTING_NO,DESCRIPTION,CREATION_DATE,CREATED_BY,UPDATED_DATE,UPDATED_BY)
                                    VALUES(".$new_id.",".$parent_id.",
                                            '".$this->input->post('CODE')."',
                                            '".$this->input->post('REFERENCE_NAME')."',
											'".$this->input->post('LISTING_NO')."',
                                            '".$this->input->post('DESCRIPTION')."',
                                            SYSDATE,
                                            '".$this->session->userdata('d_user_name')."',
                                            SYSDATE,
                                            '".$this->session->userdata('d_user_name')."'
                                            )");
                break;
            case 'edit':
                $this->db->query("UPDATE P_REFERENCE_LIST SET
                                    CODE = '".$this->input->post('CODE')."',
                                    REFERENCE_NAME = '".$this->input->post('REFERENCE_NAME')."',
									LISTING_NO = '".$this->input->post('LISTING_NO')."',
                                    DESCRIPTION = '".$this->input->post('DESCRIPTION')."',
                                    UPDATED_DATE = SYSDATE,
                                    UPDATED_BY = '".$this->session->userdata('d_user_name')."'
                                    WHERE
                                    P_REFERENCE_LIST_ID = ".$id_ );
                break;
            case 'del':
                $this->db->where('P_REFERENCE_LIST_ID',$id_);
                $this->db->delete('P_REFERENCE_LIST');
                break;
        }

    }	
    
    
    function crud_user_attribute_type(){
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');
        
        switch ($oper) {
            case 'add':
                $new_id = gen_id('P_USER_ATTRIBUTE_TYPE_ID','P_USER_ATTRIBUTE_TYPE');
                $this->db->query("INSERT INTO P_USER_ATTRIBUTE_TYPE(P_USER_ATTRIBUTE_TYPE_ID,CODE,VALID_FROM,VALID_TO, DESCRIPTION,CREATION_DATE,CREATED_BY,UPDATED_DATE,UPDATED_BY)
                                    VALUES($new_id,
                                            '".$this->input->post('CODE')."',
                                            to_date('".$this->input->post('VALID_FROM')."','dd/mm/yyyy'),
                                            to_date('".$this->input->post('VALID_TO')."','dd/mm/yyyy'),
                                            '".$this->input->post('DESCRIPTION')."',
                                            SYSDATE,
                                            '".$this->session->userdata('d_user_name')."',
                                            SYSDATE,
                                            '".$this->session->userdata('d_user_name')."'
                                            )");
                break;
            case 'edit':
                $this->db->query("UPDATE P_USER_ATTRIBUTE_TYPE SET
                                    CODE = '".$this->input->post('CODE')."',
                                    VALID_FROM = to_date('".$this->input->post('VALID_FROM')."','dd/mm/yyyy'),
                                    VALID_TO = to_date('".$this->input->post('VALID_TO')."','dd/mm/yyyy'),
                                    DESCRIPTION = '".$this->input->post('DESCRIPTION')."',
                                    UPDATED_DATE = SYSDATE,
                                    UPDATED_BY = '".$this->session->userdata('d_user_name')."'
                                    WHERE
                                    P_USER_ATTRIBUTE_TYPE_ID = ".$id_ );
                break;
            case 'del':
                $this->db->where('P_USER_ATTRIBUTE_TYPE_ID',$id_);
                $this->db->delete('P_USER_ATTRIBUTE_TYPE');
                break;
        }

    }	
    
    
    function crud_user_attribute_list(){
        $parent_id = $this->input->post('PARENT_ID');
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');
        
        switch ($oper) {
            case 'add':
                $new_id = gen_id('P_USER_ATTRIBUTE_LIST_ID','P_USER_ATTRIBUTE_LIST');
                $this->db->query("INSERT INTO P_USER_ATTRIBUTE_LIST(P_USER_ATTRIBUTE_LIST_ID,P_USER_ATTRIBUTE_TYPE_ID, CODE, NAME, VALID_FROM,VALID_TO, DESCRIPTION,CREATION_DATE,CREATED_BY,UPDATED_DATE,UPDATED_BY)
                                    VALUES(".$new_id.",".$parent_id.",
                                            '".$this->input->post('CODE')."',
                                            '".$this->input->post('NAME')."',
                                            to_date('".$this->input->post('VALID_FROM')."','dd/mm/yyyy'),
                                            to_date('".$this->input->post('VALID_TO')."','dd/mm/yyyy'),
                                            '".$this->input->post('DESCRIPTION')."',
                                            SYSDATE,
                                            '".$this->session->userdata('d_user_name')."',
                                            SYSDATE,
                                            '".$this->session->userdata('d_user_name')."'
                                            )");
                break;
            case 'edit':
                $this->db->query("UPDATE P_USER_ATTRIBUTE_LIST SET
                                    CODE = '".$this->input->post('CODE')."',
                                    NAME = '".$this->input->post('NAME')."',
                                    VALID_FROM = to_date('".$this->input->post('VALID_FROM')."','dd/mm/yyyy'),
                                    VALID_TO = to_date('".$this->input->post('VALID_TO')."','dd/mm/yyyy'),
                                    DESCRIPTION = '".$this->input->post('DESCRIPTION')."',
                                    UPDATED_DATE = SYSDATE,
                                    UPDATED_BY = '".$this->session->userdata('d_user_name')."'
                                    WHERE
                                    P_USER_ATTRIBUTE_LIST_ID = ".$id_ );
                break;
            case 'del':
                $this->db->where('P_USER_ATTRIBUTE_LIST_ID',$id_);
                $this->db->delete('P_USER_ATTRIBUTE_LIST');
                break;
        }

    }	
}