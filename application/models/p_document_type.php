<?php

class P_document_type extends CI_Model
{

    function __construct() {
        parent::__construct();

        $this->load->helper('sequence');
    }

    function crud_document_type() {

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $P_DOCUMENT_TYPE_ID = $this->input->post('P_DOCUMENT_TYPE_ID');
        $DOC_NAME = $this->input->post('DOC_NAME');
        $DISPLAY_NAME = $this->input->post('DISPLAY_NAME');
        $LISTING_NO = $this->input->post('LISTING_NO');
        $TDOC = $this->input->post('TDOC');
        $TCTL = $this->input->post('TCTL');
        $TUSER = $this->input->post('TUSER');
        $PACKAGE_NAME = $this->input->post('PACKAGE_NAME');
        $F_PROFILE = $this->input->post('F_PROFILE');
        $PROFILE_SOURCE = $this->input->post('PROFILE_SOURCE');
        $F_APP_FRAUD_ENGINE = $this->input->post('F_APP_FRAUD_ENGINE');
        $DESCRIPTION = $this->input->post('DESCRIPTION');
        
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATED_BY = $this->session->userdata('d_user_name');
        
        $result = array();
        
        switch ($oper) {
            case 'add':
                try {
                    $P_DOCUMENT_TYPE_ID = gen_id('P_DOCUMENT_TYPE_ID', 'P_DOCUMENT_TYPE');
                    $sql = "INSERT INTO P_DOCUMENT_TYPE(P_DOCUMENT_TYPE_ID, DOC_NAME, DISPLAY_NAME, OWNER, LISTING_NO, TDOC, TCTL, TUSER, PACKAGE_NAME, F_PROFILE, PROFILE_SOURCE, F_APP_FRAUD_ENGINE, DESCRIPTION, CREATION_DATE, CREATED_BY, UPDATED_DATE, UPDATED_BY )
                                VALUES(".$P_DOCUMENT_TYPE_ID.",'".$DOC_NAME."','".$DISPLAY_NAME."',' ',".$LISTING_NO.",'".$TDOC."','".$TCTL."','".$TUSER."','".$PACKAGE_NAME."','".$F_PROFILE."', '".$PROFILE_SOURCE."','".$F_APP_FRAUD_ENGINE."','".$DESCRIPTION."',SYSDATE,'".$CREATED_BY."',SYSDATE,'".$UPDATED_BY."')";
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'Jenis Workflow Berhasil Ditambahkan';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'edit':
                
                try {
                    
                    $sql = "UPDATE P_DOCUMENT_TYPE
                            SET DOC_NAME = '".$DOC_NAME."',
                                DISPLAY_NAME = '".$DISPLAY_NAME."',
                                LISTING_NO = ".$LISTING_NO.",
                                TDOC = '".$TDOC."',
                                TCTL = '".$TCTL."',
                                TUSER = '".$TUSER."',
                                PACKAGE_NAME = '".$PACKAGE_NAME."',
                                F_PROFILE = '".$F_PROFILE."',
                                PROFILE_SOURCE = '".$PROFILE_SOURCE."',
                                F_APP_FRAUD_ENGINE = '".$F_APP_FRAUD_ENGINE."',
                                DESCRIPTION = '".$DESCRIPTION."',
                                UPDATED_DATE = SYSDATE,
                                UPDATED_BY = '".$UPDATED_BY."'
                            WHERE P_DOCUMENT_TYPE_ID = ".$id_;
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'Jenis Workflow Berhasil Diupdate';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'del':
                try {
                    $this->db->where('P_DOCUMENT_TYPE_ID', $id_);
                    $this->db->delete('P_DOCUMENT_TYPE');
                    
                    $result['success'] = true;
                    $result['message'] = 'Jenis Workflow Berhasil Dihapus';
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                break;
        }
        
        return $result;
    }
    
    function getReferenceList($code) {
        $sql = "SELECT REFERENCE_LIST_CODE FROM V_P_REFERENCE_LIST WHERE 
                    REFERENCE_TYPE_CODE = '".$code."'";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}