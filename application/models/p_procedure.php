<?php

class P_procedure extends CI_Model
{

    function __construct() {
        parent::__construct();

        $this->load->helper('sequence');
    }

    function crud_procedure() {

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $P_PROCEDURE_ID = $this->input->post('P_PROCEDURE_ID');
        $PROC_NAME = $this->input->post('PROC_NAME');
        $DISPLAY_NAME = $this->input->post('DISPLAY_NAME');
        $IS_ACTIVE = $this->input->post('IS_ACTIVE');
        $SEQNO = $this->input->post('SEQNO');
        $F_BEFORE = $this->input->post('F_BEFORE');
        $F_AFTER = $this->input->post('F_AFTER');
        $IS_SEND_SMS = $this->input->post('IS_SEND_SMS');
        $SMS_CONTENT = $this->input->post('SMS_CONTENT');
        $IS_SEND_EMAIL = $this->input->post('IS_SEND_EMAIL');
        $EMAIL_CONTENT = $this->input->post('EMAIL_CONTENT');
        $DESCRIPTION = $this->input->post('DESCRIPTION');
        
        $PARENT_ID = $this->input->post('PARENT_ID') ? $this->input->post('PARENT_ID') : "null";
        
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATED_BY = $this->session->userdata('d_user_name');
        
        $result = array();
        
        switch ($oper) {
            case 'add':
                try {
                    $P_PROCEDURE_ID = gen_id('P_PROCEDURE_ID', 'P_PROCEDURE');
                    $sql = "INSERT INTO P_PROCEDURE(P_PROCEDURE_ID, PROC_NAME, DISPLAY_NAME, SEQNO, F_AFTER, F_BEFORE, DESCRIPTION, IS_ACTIVE, UPDATED_DATE, UPDATED_BY, CREATED_BY, CREATION_DATE, IS_SEND_SMS, SMS_CONTENT, IS_SEND_EMAIL, EMAIL_CONTENT, PARENT_ID)
                                VALUES(".$P_PROCEDURE_ID.",'".$PROC_NAME."','".$DISPLAY_NAME."',".$SEQNO.",'".$F_AFTER."','".$F_BEFORE."','".$DESCRIPTION."','".$IS_ACTIVE."',SYSDATE, '".$UPDATED_BY."', '".$CREATED_BY."',SYSDATE, '".$IS_SEND_SMS."','".$SMS_CONTENT."','".$IS_SEND_EMAIL."','".$EMAIL_CONTENT."', ".$PARENT_ID." )";
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'Pekerjaan Workflow Berhasil Ditambahkan';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'edit':
                
                try {
                    
                    $sql = "UPDATE P_PROCEDURE
                            SET PROC_NAME = '".$PROC_NAME."',
                                DISPLAY_NAME = '".$DISPLAY_NAME."',
                                SEQNO = ".$SEQNO.",
                                F_AFTER = '".$F_AFTER."',
                                F_BEFORE = '".$F_BEFORE."',
                                DESCRIPTION = '".$DESCRIPTION."',
                                IS_ACTIVE = '".$IS_ACTIVE."',
                                UPDATED_DATE = SYSDATE,
                                UPDATED_BY = '".$UPDATED_BY."',
                                IS_SEND_SMS = '".$IS_SEND_SMS."',
                                SMS_CONTENT = '".$SMS_CONTENT."',
                                IS_SEND_EMAIL = '".$IS_SEND_EMAIL."',
                                EMAIL_CONTENT = '".$EMAIL_CONTENT."',
                                PARENT_ID = ".$PARENT_ID."
                            WHERE P_PROCEDURE_ID = ".$id_;
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'Pekerjaan Workflow Berhasil Diupdate';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'del':
                try {
                    $this->db->where('P_PROCEDURE_ID', $id_);
                    $this->db->delete('P_PROCEDURE');
                    
                    $result['success'] = true;
                    $result['message'] = 'Pekerjaan Workflow Berhasil Dihapus';
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                break;
        }
        
        return $result;
    }
    

}