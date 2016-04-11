<?php

class P_workflow_list extends CI_Model
{

    function __construct() {
        parent::__construct();

        $this->load->helper('sequence');
    }

    function crud_workflow_list() {

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $P_WORKFLOW_ID = $this->input->post('P_WORKFLOW_ID');
        $DOC_NAME = $this->input->post('DOC_NAME');
        $DISPLAY_NAME = $this->input->post('DISPLAY_NAME');
        $P_DOCUMENT_TYPE_ID = $this->input->post('P_DOCUMENT_TYPE_ID');
        $P_PROCEDURE_ID_START = $this->input->post('P_PROCEDURE_ID_START');
        $IS_ACTIVE = $this->input->post('IS_ACTIVE');
        $DESCRIPTION = $this->input->post('DESCRIPTION');
        
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATED_BY = $this->session->userdata('d_user_name');

        
        $result = array();
        
        switch ($oper) {
            case 'add':
                try {
                    $P_WORKFLOW_ID = gen_id('P_WORKFLOW_ID', 'P_WORKFLOW');
                    $sql = "INSERT INTO P_WORKFLOW (P_WORKFLOW_ID, 
                                                    DOC_NAME, 
                                                    DISPLAY_NAME, 
                                                    P_DOCUMENT_TYPE_ID, 
                                                    P_PROCEDURE_ID_START, 
                                                    IS_ACTIVE, 
                                                    DESCRIPTION, 
                                                    CREATION_DATE, 
                                                    CREATED_BY, 
                                                    UPDATED_DATE, 
                                                    UPDATED_BY )
                                VALUES (".$P_WORKFLOW_ID.",
                                        '".$DOC_NAME."',
                                        '".$DISPLAY_NAME."',
                                        ".$P_DOCUMENT_TYPE_ID.",
                                        ".$P_PROCEDURE_ID_START.",
                                        '".$IS_ACTIVE."',
                                        '".$DESCRIPTION."',
                                        SYSDATE,
                                        '".$CREATED_BY."',
                                        SYSDATE,
                                        '".$UPDATED_BY."'
                            )";
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'Daftar Workflow Berhasil Ditambahkan';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'edit':
                
                try {
                    
                    $sql = "UPDATE P_WORKFLOW
                            SET DOC_NAME = '".$DOC_NAME."',
                                DISPLAY_NAME = '".$DISPLAY_NAME."',
                                P_DOCUMENT_TYPE_ID = ".$P_DOCUMENT_TYPE_ID.",
                                P_PROCEDURE_ID_START = ".$P_PROCEDURE_ID_START.",
                                IS_ACTIVE = '".$IS_ACTIVE."',
                                DESCRIPTION = '".$DESCRIPTION."',
                                UPDATED_DATE = SYSDATE,
                                UPDATED_BY = '".$UPDATED_BY."'
                            WHERE P_WORKFLOW_ID = ".$id_;
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'Daftar Workflow Berhasil Diupdate';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'del':
                try {
                    $this->db->where('P_WORKFLOW_ID', $id_);
                    $this->db->delete('P_WORKFLOW');
                    
                    $result['success'] = true;
                    $result['message'] = 'Daftar Workflow Berhasil Dihapus';
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                break;
        }
        
        return $result;
    }

    function getDocumentType() {
        $sql = "SELECT P_DOCUMENT_TYPE_ID, DOC_NAME AS DOCUMENT_TYPE_CODE FROM P_DOCUMENT_TYPE";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function getProcedure() {
        $sql = "SELECT P_PROCEDURE_ID, PROC_NAME AS PROCEDURE_CODE FROM P_PROCEDURE";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function crud_chart_proc_prev(){
        $P_WORKFLOW_ID = $this->input->post('P_WORKFLOW_ID');
        $P_PROCEDURE_ID_PREV = $this->input->post('P_PROCEDURE_ID_PREV');
        $P_PROCEDURE_ID_NEXT = $this->input->post('P_PROCEDURE_ID_NEXT') ? $this->input->post('P_PROCEDURE_ID_NEXT') : "null";
        $P_PROCEDURE_ID_ALT = $this->input->post('P_PROCEDURE_ID_ALT') ? $this->input->post('P_PROCEDURE_ID_ALT') : "null";
        $IMPORTANCE_LEVEL = $this->input->post('IMPORTANCE_LEVEL');
        $F_INIT = $this->input->post('F_INIT');
        $SEQUENCE_NO = $this->input->post('SEQUENCE_NO') ? $this->input->post('P_PROCEDURE_ID_NEXT') : "null";
        $VALID_FROM = $this->input->post('VALID_FROM');
        $VALID_TO = $this->input->post('VALID_TO') ? $this->input->post('P_PROCEDURE_ID_ALT') : '';

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATED_BY = $this->session->userdata('d_user_name');

        $result = array();
        switch ($oper) {
            case 'add':
                try {
                    $P_W_CHART_PROC_ID = gen_id('P_W_CHART_PROC_ID', 'P_W_CHART_PROC');

                    $sql = "INSERT INTO P_W_CHART_PROC (P_W_CHART_PROC_ID,
                                                        P_WORKFLOW_ID, 
                                                        P_PROCEDURE_ID_PREV,
                                                        P_PROCEDURE_ID_NEXT,
                                                        P_PROCEDURE_ID_ALT,
                                                        IMPORTANCE_LEVEL,
                                                        F_INIT,
                                                        SEQUENCE_NO,
                                                        VALID_FROM,
                                                        VALID_TO,
                                                        CREATE_DATE, 
                                                        CREATE_BY, 
                                                        UPDATE_DATE, 
                                                        UPDATE_BY )
                                VALUES (".$P_W_CHART_PROC_ID.",
                                        ".$P_WORKFLOW_ID.",
                                        ".$P_PROCEDURE_ID_PREV.",
                                        ".$P_PROCEDURE_ID_NEXT.",
                                        ".$P_PROCEDURE_ID_ALT.",
                                        '".$IMPORTANCE_LEVEL."',
                                        '".$F_INIT."',
                                        ".$SEQUENCE_NO.",
                                        to_date('" . $VALID_FROM . "','dd/mm/yyyy'),
                                        case when '" . $VALID_TO . "' = '' then null else to_date('" . $VALID_TO . "','dd/mm/yyyy') end,
                                        SYSDATE,
                                        '".$CREATED_BY."',
                                        SYSDATE,
                                        '".$UPDATED_BY."'
                            )";
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'Daftar Aliran Prosedur Berhasil Ditambahkan';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
        }
        
        return $result;

    }

}