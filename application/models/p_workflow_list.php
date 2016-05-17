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
        $SEQUENCE_NO = $this->input->post('SEQUENCE_NO') ? $this->input->post('SEQUENCE_NO') : "null";
        $VALID_FROM = $this->input->post('VALID_FROM');
        $VALID_TO = $this->input->post('VALID_TO') ? $this->input->post('VALID_TO') : '';

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
            case 'edit':
                try {
                    $sql = "UPDATE P_W_CHART_PROC SET P_WORKFLOW_ID = ".$P_WORKFLOW_ID.",
                                                      P_PROCEDURE_ID_PREV = ".$P_PROCEDURE_ID_PREV.",
                                                      P_PROCEDURE_ID_NEXT = ".$P_PROCEDURE_ID_NEXT.",
                                                      P_PROCEDURE_ID_ALT = ".$P_PROCEDURE_ID_ALT.",
                                                      IMPORTANCE_LEVEL = '".$IMPORTANCE_LEVEL."',
                                                      F_INIT = '".$F_INIT."',
                                                      SEQUENCE_NO = ".$SEQUENCE_NO.",
                                                      VALID_FROM = to_date('" . $VALID_FROM . "','dd/mm/yyyy'),
                                                      VALID_TO = case when '" . $VALID_TO . "' = '' then null else to_date('" . $VALID_TO . "','dd/mm/yyyy') end,
                                                      UPDATE_DATE = SYSDATE,
                                                      UPDATE_BY = '".$UPDATED_BY."' WHERE P_W_CHART_PROC_ID = ".$id_;                    
                    // print_r($sql);
                    // exit;

                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'Daftar Aliran Prosedur Berhasil Diupdate';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
                
            case 'del':
                try {
                    $this->db->where('P_W_CHART_PROC_ID', $id_);
                    $this->db->delete('P_W_CHART_PROC');
                    
                    $result['success'] = true;
                    $result['message'] = 'Daftar Aliran Prosedur Dihapus';
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                break;
        }
        
        return $result;

    }

    function crud_daemon() {

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        $P_W_CHART_PROC_ID = $this->input->post('P_W_CHART_PROC_ID');
        $DAEMON_NAME = $this->input->post('DAEMON_NAME');
        $EXPRESSION_RULE = $this->input->post('EXPRESSION_RULE');
        $DESCRIPTION = $this->input->post('DESCRIPTION');
        $VALID_FROM = $this->input->post('VALID_FROM');
        $VALID_TO = $this->input->post('VALID_TO') ? $this->input->post('VALID_TO') : '';
        
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATED_BY = $this->session->userdata('d_user_name');

        
        $result = array();
        
        switch ($oper) {
            case 'add':
                try {
                    $P_W_DAEMON_PROC_ID = gen_id('P_W_DAEMON_PROC_ID', 'P_W_DAEMON_PROC');
                    $sql = "INSERT INTO P_W_DAEMON_PROC (P_W_DAEMON_PROC_ID, 
                                                    P_W_CHART_PROC_ID, 
                                                    DAEMON_NAME, 
                                                    EXPRESSION_RULE, 
                                                    VALID_FROM, 
                                                    VALID_TO, 
                                                    DESCRIPTION,                                                     
                                                    CREATE_DATE, 
                                                    CREATE_BY, 
                                                    UPDATE_DATE, 
                                                    UPDATE_BY)
                                VALUES (".$P_W_DAEMON_PROC_ID.",
                                        ".$P_W_CHART_PROC_ID.",
                                        '".$DAEMON_NAME."',
                                        '".$EXPRESSION_RULE."',
                                        to_date('" . $VALID_FROM . "','dd/mm/yyyy'),
                                        case when '" . $VALID_TO . "' = '' then null else to_date('" . $VALID_TO . "','dd/mm/yyyy') end,
                                        '".$DESCRIPTION."',
                                        SYSDATE,
                                        '".$CREATED_BY."',
                                        SYSDATE,
                                        '".$UPDATED_BY."'
                            )";
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'Daemon Berhasil Ditambahkan';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'edit':
                
                try {
                    
                    $sql = "UPDATE P_W_DAEMON_PROC
                            SET P_W_CHART_PROC_ID = ".$P_W_CHART_PROC_ID.",
                                DAEMON_NAME = '".$DAEMON_NAME."',                                
                                EXPRESSION_RULE = '".$EXPRESSION_RULE."',
                                VALID_FROM = to_date('" . $VALID_FROM . "','dd/mm/yyyy'),
                                                      VALID_TO = case when '" . $VALID_TO . "' = '' then null else to_date('" . $VALID_TO . "','dd/mm/yyyy') end,
                                DESCRIPTION = '".$DESCRIPTION."',
                                UPDATE_DATE = SYSDATE,
                                UPDATE_BY = '".$UPDATED_BY."'
                            WHERE P_W_DAEMON_PROC_ID = ".$id_;
                    
                    $this->db->query($sql);
                    
                    $result['success'] = true;
                    $result['message'] = 'Daemon Berhasil Diupdate';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'del':
                try {
                    $this->db->where('P_W_DAEMON_PROC_ID', $id_);
                    $this->db->delete('P_W_DAEMON_PROC');
                    
                    $result['success'] = true;
                    $result['message'] = 'Daemon Berhasil Dihapus';
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                break;
        }
        
        return $result;
    }

    public function getWorkflow() {
        $result = array();
        $sql = $this->db->query('SELECT * FROM P_WORKFLOW');
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;

    }

    public function getWorkflowNew($ids) {
        $result = array();
        $sql = $this->db->query('SELECT * FROM P_WORKFLOW WHERE P_WORKFLOW_ID = '.$ids);
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;

    }

    public function getMonitoring($id, $search, $tmp){
        $result = array();
        $sql = $this->db->query("SELECT * FROM TABLE(F_MONITOR_TIPRO(".$id.", '".$search."')) WHERE WF_MONITOR LIKE '".$tmp."%' ");
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;
    }

    public function getRqstType() {
        $sql = "SELECT P_RQST_TYPE_ID, CODE FROM P_RQST_TYPE";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getOrderStatus() {
        $sql = "SELECT P_ORDER_STATUS_ID, CODE FROM P_ORDER_STATUS";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getReference() {
        $sql = "SELECT  REFERENCE_NAME, 
                        P_REFERENCE_LIST_ID AS CONTRACT_TYPE_ID
                FROM    P_REFERENCE_LIST 
                WHERE   P_REFERENCE_TYPE_ID = 15";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function crud_invoice() {

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        //post t_customer_order
        $T_CUSTOMER_ORDER_ID = $this->input->post('T_CUSTOMER_ORDER_ID'); 

        $ORDER_NO = $this->input->post('ORDER_NO'); 
        // $P_RQST_TYPE_ID = $this->input->post('P_RQST_TYPE_ID'); 
        $P_RQST_TYPE_ID = 1; 
        // $P_ORDER_STATUS_ID = $this->input->post('P_ORDER_STATUS_ID'); 
        $P_ORDER_STATUS_ID = 1; 
        // $ORDER_DATE = $this->input->post('ORDER_DATE'); sysdate
        $DESCRIPTION = '';

        $T_INVOICE_ID = $this->input->post('T_INVOICE_ID'); 
        $INVOICE_NO = $this->input->post('INVOICE_NO'); 
        $CONTRACT_TYPE_ID = $this->input->post('CONTRACT_TYPE_ID'); 
        $CONTRACT_NO = $this->input->post('CONTRACT_NO'); 
        $P_MP_PKS_ID = $this->input->post('P_MP_PKS_ID') ? $this->input->post('P_MP_PKS_ID') : "null"; 
        $CUST_PGL_ID = $this->input->post('CUST_PGL_ID') ? $this->input->post('CUST_PGL_ID') : "null"; 
        $MITRA_NAME = $this->input->post('MITRA_NAME'); 
        $MITRA_ADDRESS = $this->input->post('MITRA_ADDRESS'); 
        $MITRA_PIC = $this->input->post('MITRA_PIC'); 
        $PIC_PHONE = $this->input->post('PIC_PHONE'); 
        $MITRA_NPWP = $this->input->post('MITRA_NPWP'); 
        $INVOICE_AMOUNT = $this->input->post('INVOICE_AMOUNT'); 
        $INVOICE_DATE = $this->input->post('INVOICE_DATE'); 
        $VAT_AMOUNT = $this->input->post('VAT_AMOUNT') ? $this->input->post('VAT_AMOUNT') : "null";
        
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATED_BY = $this->session->userdata('d_user_name');

        
        $result = array();
        
        switch ($oper) {
            case 'add':
                try {
                    $cust_order_id = gen_id('T_CUSTOMER_ORDER_ID', 'T_CUSTOMER_ORDER');
                    $sql = "INSERT INTO T_CUSTOMER_ORDER (  T_CUSTOMER_ORDER_ID, 
                                                            ORDER_NO, 
                                                            P_RQST_TYPE_ID, 
                                                            P_ORDER_STATUS_ID, 
                                                            ORDER_DATE, 
                                                            DESCRIPTION, 
                                                            CREATION_DATE, 
                                                            CREATED_BY, 
                                                            UPDATED_DATE, 
                                                            UPDATED_BY )
                                VALUES (".$cust_order_id.",
                                        LPAD(T_CUSTOMER_ORDER_SEQ.NEXTVAL, 10, '0'),
                                        ".$P_RQST_TYPE_ID.",
                                        ".$P_ORDER_STATUS_ID.",
                                        SYSDATE,
                                        '".$DESCRIPTION."',
                                        SYSDATE,
                                        '".$CREATED_BY."',
                                        SYSDATE,
                                        '".$UPDATED_BY."'
                            )";
                    
                    $dt = $this->db->query($sql);

                    if($dt){
                        $invoice_id = gen_id('T_INVOICE_ID', 'T_INVOICE');
                        $sql_invoice = "INSERT INTO T_INVOICE ( T_INVOICE_ID, 
                                                        T_CUSTOMER_ORDER_ID, 
                                                        INVOICE_NO, 
                                                        INVOICE_DATE,
                                                        CONTRACT_TYPE_ID, 
                                                        CONTRACT_NO, 
                                                        P_MP_PKS_ID, 
                                                        CUST_PGL_ID, 
                                                        MITRA_NAME, 
                                                        MITRA_ADDRESS, 
                                                        MITRA_PIC, 
                                                        PIC_PHONE, 
                                                        MITRA_NPWP, 
                                                        INVOICE_AMOUNT, 
                                                        VAT_AMOUNT, 
                                                        CREATION_DATE, 
                                                        CREATED_BY, 
                                                        UPDATED_DATE, 
                                                        UPDATED_BY )
                                VALUES (".$invoice_id.",
                                        ".$cust_order_id.",
                                        '".$INVOICE_NO."',
                                        to_date('" . $INVOICE_DATE . "','yyyy/mm/dd'),
                                        ".$CONTRACT_TYPE_ID.",
                                        '".$CONTRACT_NO."',
                                        ".$P_MP_PKS_ID.",
                                        ".$CUST_PGL_ID.",
                                        '".$MITRA_NAME."',
                                        '".$MITRA_ADDRESS."',
                                        '".$MITRA_PIC."',
                                        '".$PIC_PHONE."',
                                        '".$MITRA_NPWP."',
                                        ".$INVOICE_AMOUNT.",
                                        ".$VAT_AMOUNT.",
                                        SYSDATE,
                                        '".$CREATED_BY."',
                                        SYSDATE,
                                        '".$UPDATED_BY."'
                            )";

                        $this->db->query($sql_invoice);
                    }
                    
                    $result['success'] = true;
                    $result['message'] = 'Invoice Berhasil Ditambahkan';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'edit':
                
                try {
                    
                    $sql = "UPDATE T_CUSTOMER_ORDER
                            SET P_RQST_TYPE_ID = ".$P_RQST_TYPE_ID.", 
                                P_ORDER_STATUS_ID =  ".$P_ORDER_STATUS_ID.", 
                                DESCRIPTION = '".$DESCRIPTION."', 
                                UPDATED_DATE = SYSDATE, 
                                UPDATED_BY = '".$UPDATED_BY."'
                            WHERE T_CUSTOMER_ORDER_ID = ".$T_CUSTOMER_ORDER_ID." ";
                    
                    $this->db->query($sql);

                    if(empty($T_INVOICE_ID)){
                        $invoice_id = gen_id('T_INVOICE_ID', 'T_INVOICE');
                        $sql_invoice = "INSERT INTO T_INVOICE ( T_INVOICE_ID, 
                                                        T_CUSTOMER_ORDER_ID, 
                                                        INVOICE_NO, 
                                                        INVOICE_DATE,
                                                        CONTRACT_TYPE_ID, 
                                                        CONTRACT_NO, 
                                                        P_MP_PKS_ID, 
                                                        CUST_PGL_ID, 
                                                        MITRA_NAME, 
                                                        MITRA_ADDRESS, 
                                                        MITRA_PIC, 
                                                        PIC_PHONE, 
                                                        MITRA_NPWP, 
                                                        INVOICE_AMOUNT, 
                                                        VAT_AMOUNT, 
                                                        CREATION_DATE, 
                                                        CREATED_BY, 
                                                        UPDATED_DATE, 
                                                        UPDATED_BY )
                                VALUES (".$invoice_id.",
                                        ".$T_CUSTOMER_ORDER_ID.",
                                        '".$INVOICE_NO."',
                                        to_date('" . $INVOICE_DATE . "','yyyy/mm/dd'),
                                        ".$CONTRACT_TYPE_ID.",
                                        '".$CONTRACT_NO."',
                                        ".$P_MP_PKS_ID.",
                                        ".$CUST_PGL_ID.",
                                        '".$MITRA_NAME."',
                                        '".$MITRA_ADDRESS."',
                                        '".$MITRA_PIC."',
                                        '".$PIC_PHONE."',
                                        '".$MITRA_NPWP."',
                                        ".$INVOICE_AMOUNT.",
                                        ".$VAT_AMOUNT.",
                                        SYSDATE,
                                        '".$CREATED_BY."',
                                        SYSDATE,
                                        '".$UPDATED_BY."'
                            )";

                        $this->db->query($sql_invoice);
                    }else{
                        $sql_invoice = "UPDATE T_INVOICE
                                SET T_CUSTOMER_ORDER_ID = ".$T_CUSTOMER_ORDER_ID.", 
                                    INVOICE_NO = '".$INVOICE_NO."', 
                                    INVOICE_DATE = to_date('" . $INVOICE_DATE . "','yyyy/mm/dd'), 
                                    CONTRACT_TYPE_ID = ".$CONTRACT_TYPE_ID.", 
                                    CONTRACT_NO = '".$CONTRACT_NO."',
                                    P_MP_PKS_ID = ".$P_MP_PKS_ID.",
                                    CUST_PGL_ID = ".$CUST_PGL_ID.", 
                                    MITRA_NAME = '".$MITRA_NAME."', 
                                    MITRA_ADDRESS = '".$MITRA_ADDRESS."', 
                                    MITRA_PIC = '".$MITRA_PIC."', 
                                    PIC_PHONE = '".$PIC_PHONE."', 
                                    MITRA_NPWP = '".$MITRA_NPWP."', 
                                    INVOICE_AMOUNT = ".$INVOICE_AMOUNT.", 
                                    VAT_AMOUNT = ".$VAT_AMOUNT.", 
                                    UPDATED_DATE = SYSDATE, 
                                    UPDATED_BY = '".$UPDATED_BY."'
                            WHERE T_INVOICE_ID = ".$T_INVOICE_ID." ";
                    
                    $this->db->query($sql_invoice);
                    }
                    
                    $result['success'] = true;
                    $result['message'] = 'Invoice Berhasil Diupdate';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'del':
                try {
                    $this->db->where('T_CUSTOMER_ORDER_ID', $id_);
                    $this->db->delete('T_INVOICE');

                    $this->db->where('T_CUSTOMER_ORDER_ID', $id_);
                    $this->db->delete('T_CUSTOMER_ORDER');
                    
                    $result['success'] = true;
                    $result['message'] = 'Invoice Berhasil Dihapus';
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                break;
        }
        
        return $result;
    }

    function crud_contract_reg() {

        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');

        //post t_customer_order
        $T_CUSTOMER_ORDER_ID = $this->input->post('T_CUSTOMER_ORDER_ID'); 

        $ORDER_NO = $this->input->post('ORDER_NO'); 
        $P_RQST_TYPE_ID = 2; 
        $P_ORDER_STATUS_ID = 1; 
        // $ORDER_DATE = $this->input->post('ORDER_DATE'); 
        
        $T_CONTRACT_REG_ID = $this->input->post('T_CONTRACT_REG_ID'); 
        $PGL_ID = $this->input->post('PGL_ID'); 
        $P_LOCATION_ID = $this->input->post('P_LOCATION_ID'); 
      
        $CONTRACT_NO = $this->input->post('CONTRACT_NO'); 
        $VALID_FROM = $this->input->post('VALID_FROM'); 
        $VALID_TO = $this->input->post('VALID_TO') ? $this->input->post('VALID_TO') : ''; 
        $DESCRIPTION = $this->input->post('DESCRIPTION');
        
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATED_BY = $this->session->userdata('d_user_name');

        
        $result = array();
        
        switch ($oper) {
            case 'add':
                try {
                    $cust_order_id = gen_id('T_CUSTOMER_ORDER_ID', 'T_CUSTOMER_ORDER');
                    $sql = "INSERT INTO T_CUSTOMER_ORDER (  T_CUSTOMER_ORDER_ID, 
                                                            ORDER_NO, 
                                                            P_RQST_TYPE_ID, 
                                                            P_ORDER_STATUS_ID, 
                                                            ORDER_DATE, 
                                                            CREATION_DATE, 
                                                            CREATED_BY, 
                                                            UPDATED_DATE, 
                                                            UPDATED_BY )
                                VALUES (".$cust_order_id.",
                                        LPAD(T_CUSTOMER_ORDER_SEQ.NEXTVAL, 10, '0'),
                                        ".$P_RQST_TYPE_ID.",
                                        ".$P_ORDER_STATUS_ID.",
                                        SYSDATE,
                                        SYSDATE,
                                        '".$CREATED_BY."',
                                        SYSDATE,
                                        '".$UPDATED_BY."'
                            )";
                    
                    $dt = $this->db->query($sql);

                    if($dt){
                        $t_contract_reg_id = gen_id('T_CONTRACT_REG_ID', 'T_CONTRACT_REGISTRATION');
                        $sql_reg = "INSERT INTO T_CONTRACT_REGISTRATION ( T_CONTRACT_REG_ID, 
                                                                T_CUSTOMER_ORDER_ID, 
                                                                PGL_ID, 
                                                                P_LOCATION_ID, 
                                                                CONTRACT_NO, 
                                                                VALID_FROM, 
                                                                VALID_TO, 
                                                                DESCRIPTION, 
                                                                CREATION_DATE, 
                                                                CREATED_BY, 
                                                                UPDATED_DATE, 
                                                                UPDATED_BY )
                                VALUES (".$t_contract_reg_id.",
                                        ".$cust_order_id.",
                                        ".$PGL_ID.",
                                        ".$P_LOCATION_ID.",
                                        '".$CONTRACT_NO."',
                                         to_date('" . $VALID_FROM . "','yyyy/mm/dd'),
                                         case when '" . $VALID_TO . "' = '' then null else to_date('" . $VALID_TO . "','yyyy/mm/dd') end,
                                        '".$DESCRIPTION."',
                                        SYSDATE,
                                        '".$CREATED_BY."',
                                        SYSDATE,
                                        '".$UPDATED_BY."'
                            )";

                        $this->db->query($sql_reg);
                    }
                    
                    $result['success'] = true;
                    $result['message'] = 'Kontrak Berhasil Ditambahkan';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'edit':
                
                try {
                    
                    $sql = "UPDATE T_CUSTOMER_ORDER
                            SET P_RQST_TYPE_ID = ".$P_RQST_TYPE_ID.", 
                                P_ORDER_STATUS_ID =  ".$P_ORDER_STATUS_ID.", 
                                UPDATED_DATE = SYSDATE, 
                                UPDATED_BY = '".$UPDATED_BY."'
                            WHERE T_CUSTOMER_ORDER_ID = ".$T_CUSTOMER_ORDER_ID." ";
                    
                    $this->db->query($sql);

                    if(empty($T_CONTRACT_REG_ID)){
                        $t_contract_reg_id = gen_id('T_CONTRACT_REG_ID', 'T_CONTRACT_REGISTRATION');
                        $sql_reg = "INSERT INTO T_CONTRACT_REGISTRATION ( T_CONTRACT_REG_ID, 
                                                                T_CUSTOMER_ORDER_ID, 
                                                                PGL_ID, 
                                                                P_LOCATION_ID, 
                                                                CONTRACT_NO, 
                                                                VALID_FROM, 
                                                                VALID_TO, 
                                                                DESCRIPTION, 
                                                                CREATION_DATE, 
                                                                CREATED_BY, 
                                                                UPDATED_DATE, 
                                                                UPDATED_BY )
                                VALUES (".$t_contract_reg_id.",
                                        ".$T_CUSTOMER_ORDER_ID.",
                                        ".$PGL_ID.",
                                        ".$P_LOCATION_ID.",
                                        '".$CONTRACT_NO."',
                                         to_date('" . $VALID_FROM . "','yyyy/mm/dd'),
                                         case when '" . $VALID_TO . "' = '' then null else to_date('" . $VALID_TO . "','yyyy/mm/dd') end,
                                        '".$DESCRIPTION."',
                                        SYSDATE,
                                        '".$CREATED_BY."',
                                        SYSDATE,
                                        '".$UPDATED_BY."'
                            )";
                        $this->db->query($sql_reg);
                    }else{
                        $sql_reg = "UPDATE T_CONTRACT_REGISTRATION
                                SET T_CUSTOMER_ORDER_ID = ".$T_CUSTOMER_ORDER_ID.", 
                                    PGL_ID = ".$PGL_ID.",
                                    P_LOCATION_ID = ".$P_LOCATION_ID.",
                                    CONTRACT_NO = '".$CONTRACT_NO."',
                                    VALID_FROM = to_date('" . $VALID_FROM . "','yyyy/mm/dd'), 
                                    VALID_TO = case when '" . $VALID_TO . "' = '' then null else to_date('" . $VALID_TO . "','yyyy/mm/dd') end,
                                    DESCRIPTION = '".$DESCRIPTION."',
                                    UPDATED_DATE = SYSDATE, 
                                    UPDATED_BY = '".$UPDATED_BY."'
                            WHERE T_CONTRACT_REG_ID = ".$T_CONTRACT_REG_ID." ";
                    
                    $this->db->query($sql_reg);
                    }
                    
                    $result['success'] = true;
                    $result['message'] = 'Kontrak Berhasil Diupdate';
                    
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                
                break;
            case 'del':
                try {
                    $this->db->where('T_CUSTOMER_ORDER_ID', $id_);
                    $this->db->delete('T_CONTRACT_REGISTRATION');

                    $this->db->where('T_CUSTOMER_ORDER_ID', $id_);
                    $this->db->delete('T_CUSTOMER_ORDER');
                    
                    $result['success'] = true;
                    $result['message'] = 'Kontrak Berhasil Dihapus';
                }catch(Exception $e) {
                    $result['success'] = false;
                    $result['message'] = $e->getMessage();
                }
                break;
        }
        
        return $result;
    }

}