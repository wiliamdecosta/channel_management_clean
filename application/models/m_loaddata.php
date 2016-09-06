<?php

class M_loaddata extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('sequence');
    }

    public function create_batch($period, $username, $batch_type)
    {
//        $result = array();
        $sql = " DECLARE " .
            "  v_result VARCHAR2(90); " .
            "  BEGIN " .
            "  marfee.create_batch(:params1,:params2,:params3, :v_result); END;";

        //$params =  array($period, $username, $batch_type);


        $params = array(
            array('name' => ':params1', 'value' => $period, 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params2', 'value' => $username, 'type' => SQLT_CHR, 'length' => 32),
            array('name' => ':params3', 'value' => $batch_type, 'type' => SQLT_CHR, 'length' => 1)
        );
        // Bind the output parameter


        $stmt = oci_parse($this->db->conn_id, $sql);

        foreach ($params as $p) {
            // Bind Input
            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }
        $message = '';
        oci_bind_by_name($stmt, ':v_result', $message, 32);

        ociexecute($stmt);
        return $message;

    }

    public function create_batch_nom($period, $username, $i_pgl_id)
    {
//        $result = array();
        $sql = " DECLARE " .
            "  v_result VARCHAR2(90); " .
            "  BEGIN " .
            "  marfee.create_batch_nom(:params1,:params2,:params3,:params4, :v_result); END;";



        $params = array(
            array('name' => ':params1', 'value' => $period, 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params2', 'value' => $username, 'type' => SQLT_CHR, 'length' => 32),
            array('name' => ':params3', 'value' => 8, 'type' => SQLT_INT, 'length' => 1),
            array('name' => ':params4', 'value' => $i_pgl_id, 'type' => SQLT_INT, 'length' => 32)
        );
        // Bind the output parameter


        $stmt = oci_parse($this->db->conn_id, $sql);

        foreach ($params as $p) {
            // Bind Input
            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }
        $message = '';
        oci_bind_by_name($stmt, ':v_result', $message, 32);

        ociexecute($stmt);
        return $message;

    }

    public function batchProcess($batch_id, $username)
    {
//        $result = array();
        $sql = " DECLARE " .
            "  v_result VARCHAR2(90); " .
            "  BEGIN " .
            "  PKG_PROC_BATCH.proc_batch(:params1,:params2, :v_result); END;";

        //$params =  array($period, $username, $batch_type);


        $params = array(
            array('name' => ':params1', 'value' => $batch_id, 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params2', 'value' => $username, 'type' => SQLT_CHR, 'length' => 32),
        );
        // Bind the output parameter


        $stmt = oci_parse($this->db->conn_id, $sql);

        foreach ($params as $p) {
            // Bind Input
            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }
        $message = '';
        oci_bind_by_name($stmt, ':v_result', $message, 32);
        ociexecute($stmt);
        return $message;

    }
	
		public function batchProcessDatin($batch_id,$username) {
		//        $result = array();
        $sql = " DECLARE ".
            "  v_result VARCHAR2(90); ".
            "  BEGIN ".
            "  PKG_PROC_BATCH.proc_datin_batch(:params1,:params2, :v_result);". 
            // "  PCKG_LOAD_DATIN.p_run_job_load_datin(:params3,:params2, :v_result1, :v_result2);". 
			"END;";

        //$params =  array($period, $username, $batch_type);


        $params = array(
            array('name' => ':params1', 'value' => $batch_id, 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params2', 'value' => $username, 'type' => SQLT_CHR, 'length' => 100),
            // array('name' => ':params3', 'value' => $periode, 'type' => SQLT_CHR, 'length' => 100),
        );
        // Bind the output parameter



        $stmt = oci_parse($this->db->conn_id,$sql);

        foreach($params as $p){
            // Bind Input
            oci_bind_by_name($stmt,$p['name'], $p['value'], $p['length']);
        }
        $message = '';
        oci_bind_by_name($stmt,':v_result',$message,32);
        ociexecute($stmt);
        return $message;

    }

    public function getLogProcess($param)
    {
        $wh = "";
        if ($param['search'] != null && $param['search'] === 'true') {
            $wh .= " AND UPPER(" . $param['search_field'] . ")";
            switch ($param['search_operator']) {
                case "bw": // begin with
                    $wh .= " LIKE UPPER('" . $param['search_str'] . "%')";
                    break;
                case "ew": // end with
                    $wh .= " LIKE UPPER('%" . $param['search_str'] . "')";
                    break;
                case "cn": // contain %param%
                    $wh .= " LIKE UPPER('%" . $param['search_str'] . "%')";
                    break;
                case "eq": // equal =
                    if (is_numeric($param['search_str'])) {
                        $wh .= " = " . $param['search_str'];
                    } else {
                        $wh .= " = UPPER('" . $param['search_str'] . "')";
                    }
                    break;
                case "ne": // not equal
                    if (is_numeric($param['search_str'])) {
                        $wh .= " <> " . $param['search_str'];
                    } else {
                        $wh .= " <> UPPER('" . $param['search_str'] . "')";
                    }
                    break;
                case "lt":
                    if (is_numeric($param['search_str'])) {
                        $wh .= " < " . $param['search_str'];
                    } else {
                        $wh .= " < '" . $param['search_str'] . "'";
                    }
                    break;
                case "le":
                    if (is_numeric($param['search_str'])) {
                        $wh .= " <= " . $param['search_str'];
                    } else {
                        $wh .= " <= '" . $param['search_str'] . "'";
                    }
                    break;
                case "gt":
                    if (is_numeric($param['search_str'])) {
                        $wh .= " > " . $param['search_str'];
                    } else {
                        $wh .= " > '" . $param['search_str'] . "'";
                    }
                    break;
                case "ge":
                    if (is_numeric($param['search_str'])) {
                        $wh .= " >= " . $param['search_str'];
                    } else {
                        $wh .= " >= '" . $param['search_str'] . "'";
                    }
                    break;
                default :
                    $wh = "";
            }

        }
        $result = array();

        $pagenum = intval($param['page']);
        $rowsnum = intval($param['rows']);
        if ($pagenum == 1) {
            $rowstart = $pagenum;
            $rowend = $rowsnum;
        } else if ($pagenum > 1) {
            $rowstart = (($pagenum - 1) * $rowsnum) + 1;
            $rowend = $rowstart + ($rowsnum - 1);
        }

        $sql2 = "SELECT * FROM ( ";
        $sql3 = "SELECT ROWNUM RN,a.CODE,a.COUNTER,TO_CHAR(a.LOG_DATE,'DD/MM/YYYY HH24:MI:SS') LOG_DATE,a.LOG_MSG,a.BATCH_ID FROM V_LOG_LOAD_PROCESS a WHERE a.BATCH_ID = " . $param['id'] . " ORDER BY " . $param['sort_by'] . " " . $param['sord'];
        $sql_where = ") WHERE RN BETWEEN $rowstart AND $rowend";
        $sql = $sql2 . " " . $sql3 . " " . $sql_where;
        if ($wh != "" or $wh != null) {
            $sql .= $wh;
        }

        $qs = $this->db->query($sql);
        if ($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }

    public function getCountLogProcess($id)
    {
        $result = array();
        $sql = "SELECT COUNT(*) COUNT FROM V_LOG_LOAD_PROCESS WHERE BATCH_ID = " . $id;
        $qs = $this->db->query($sql);

        if ($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }


    public function getCountJobControl($id)
    {
        $result = array();
        $sql = "SELECT COUNT(*) COUNT FROM JOB_CONTROL WHERE BATCH_CONTROL_ID = " . $id;
        $qs = $this->db->query($sql);

        if ($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }

    public function searchExpenseOLO($period, $ten_id)
    {
        $db2 = $this->load->database('default2', TRUE);
        $result = array();
        $sql = " select * from table(pack_seacrh_expense.p_seacrh_olo_expense_kp('" . $period . "','" . $ten_id . "')) ";
        $qs = $db2->query($sql);

        if ($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }

    public function searchExpenseSLI($period, $ten_id)
    {
        $db2 = $this->load->database('default2', TRUE);
        $result = array();
        $sql = " select * from table(pack_seacrh_expense.p_seacrh_sli_expense_kp('" . $period . "','" . $ten_id . "')) ";
        $qs = $db2->query($sql);

        if ($qs->num_rows() > 0) $result = $qs->result();
        return $result;

    }

    public function searchExpenseIN($period, $ten_id)
    {
        $db2 = $this->load->database('default2', TRUE);
        $result = array();
        $sql = " select * from table(pack_seacrh_expense.p_seacrh_IN_expense_kp('" . $period . "','" . $ten_id . "')) ";
        $qs = $db2->query($sql);

        if ($qs->num_rows() > 0) $result = $qs->result();
        return $result;

    }

    public function contohManggilRefCursor($period, $ten_id)
    {
        $db2 = $this->load->database('default2', TRUE);
        $sql = " DECLARE " .
            "  i_retrun VARCHAR2(90); " .
            "  BEGIN " .
            "  C2BI.pack_seacrh_expense.p_seacrh_olo_expense_bck(:params1,:params2, :i_retrun, :cursor); END;";

        $params = array(
            array('name' => ':params1', 'value' => $period, 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params2', 'value' => $ten_id, 'type' => SQLT_CHR, 'length' => 32)
        );
        // Bind the output parameter
        $stmt = oci_parse($db2->conn_id, $sql);
        foreach ($params as $p) {
            // Bind Input
            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }

        $cursor = oci_new_cursor($db2->conn_id);
        $message = '';
        oci_bind_by_name($stmt, ':i_retrun', $message, 32);
        oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

        oci_execute($stmt, OCI_DEFAULT);

        oci_execute($cursor, OCI_DEFAULT);

        // oci_fetch_all($cursor, $out, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_fetch_all($cursor, $res);
        print_r($res);
        exit();
        // return $message;

    }

    public function getNDList($ten_id)
    {
        $db2 = $this->load->database('default2', TRUE);
        if ($ten_id) {
            $db2->where("TEN_ID = $ten_id ");
        }

        $q = $db2->select('ROWNUM as ID,ND', FALSE)->from('TEN_ND')->get();


        return $q->result_array();

    }


}