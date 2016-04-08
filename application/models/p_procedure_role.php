<?php

class P_procedure_role extends CI_Model
{

    function __construct() {
        parent::__construct();

        $this->load->helper('sequence');
    }

    function crud_procedure_role() {

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $P_PROCEDURE_ROLE_ID = $this->input->post('P_PROCEDURE_ROLE_ID');
        $P_PROCEDURE_ID = $this->input->post('P_PROCEDURE_ID');
        $P_APP_ROLE_ID = $this->input->post('P_APP_ROLE_ID');
        
        $F_ROLE = $this->input->post('F_ROLE');
        $VALID_FROM = $this->input->post('VALID_FROM');
        $VALID_TO = $this->input->post('VALID_TO');
        
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATED_BY = $this->session->userdata('d_user_name');
        
        $result = array();
        
        switch ($oper) {
            case 'add':
                try {
                    $P_PROCEDURE_ROLE_ID = gen_id('P_PROCEDURE_ROLE_ID', 'P_PROCEDURE_ROLE');
                    $sql = "INSERT INTO P_PROCEDURE_ROLE(P_PROCEDURE_ROLE_ID, P_PROCEDURE_ID, P_APP_ROLE_ID, F_ROLE, VALID_FROM, VALID_TO, CREATION_DATE, CREATED_BY, UPDATED_DATE, UPDATED_BY)
                                VALUES(".$P_PROCEDURE_ROLE_ID.",".$P_PROCEDURE_ID.",".$P_APP_ROLE_ID.",'".$F_ROLE."','".$VALID_FROM."','".$VALID_TO."', SYSDATE, '".$CREATED_BY."', SYSDATE, '".$UPDATED_BY."')";
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'Role Pekerjaan Workflow Berhasil Ditambahkan';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'edit':
                
                try {
                    
                    $sql = "UPDATE P_PROCEDURE_ROLE
                            SET P_APP_ROLE_ID = ".$P_APP_ROLE_ID.",
                            F_ROLE = '".$F_ROLE."',
                            VALID_FROM = to_date('".$VALID_FROM."','yyyy-mm-dd'),
                            VALID_TO = to_date('".$VALID_TO."','yyyy-mm-dd')
                            WHERE P_PROCEDURE_ROLE_ID = ".$id_;
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'Role Pekerjaan Workflow Berhasil Diupdate';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'del':
                try {
                    $this->db->where('P_PROCEDURE_ROLE_ID', $id_);
                    $this->db->delete('P_PROCEDURE_ROLE');
                    
                    $result['success'] = true;
                    $result['message'] = 'Role Pekerjaan Workflow Berhasil Dihapus';
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                break;
        }
        
        return $result;
    }
    

}