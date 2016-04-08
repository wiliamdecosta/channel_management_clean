<?php

class P_procedure_files extends CI_Model
{

    function __construct() {
        parent::__construct();

        $this->load->helper('sequence');
    }

    function crud_procedure_files() {

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $P_PROCEDURE_FILES_ID = $this->input->post('P_PROCEDURE_FILES_ID');
        $P_PROCEDURE_ID = $this->input->post('P_PROCEDURE_ID');
        $FILENAME = $this->input->post('FILENAME');
        $SEQUENCE_NO = $this->input->post('SEQUENCE_NO');
        
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATED_BY = $this->session->userdata('d_user_name');
        
        $result = array();
        
        switch ($oper) {
            case 'add':
                try {
                    $P_PROCEDURE_FILES_ID = gen_id('P_PROCEDURE_FILES_ID', 'P_PROCEDURE_FILES');
                    $sql = "INSERT INTO P_PROCEDURE_FILES(P_PROCEDURE_FILES_ID, P_PROCEDURE_ID, FILENAME, SEQUENCE_NO, CREATION_DATE, CREATED_BY, UPDATED_DATE, UPDATED_BY)
                                VALUES(".$P_PROCEDURE_FILES_ID.",".$P_PROCEDURE_ID.",'".$FILENAME."',".$SEQUENCE_NO.",SYSDATE, '".$CREATED_BY."', SYSDATE, '".$UPDATED_BY."')";
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'File Pekerjaan Workflow Berhasil Ditambahkan';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'edit':
                
                try {
                    
                    $sql = "UPDATE P_PROCEDURE_FILES
                            SET P_PROCEDURE_ID = ".$P_PROCEDURE_ID.",
                                FILENAME = '".$FILENAME."',
                                SEQUENCE_NO = ".$SEQUENCE_NO.",
                                UPDATED_DATE = SYSDATE,
                                UPDATED_BY = '".$UPDATED_BY."'
                            WHERE P_PROCEDURE_FILES_ID = ".$id_;
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'File Pekerjaan Workflow Berhasil Diupdate';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'del':
                try {
                    $this->db->where('P_PROCEDURE_FILES_ID', $id_);
                    $this->db->delete('P_PROCEDURE_FILES');
                    
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