<?php
class M_cm extends CI_Model {

    function __construct() {
        parent::__construct();

//        $this->load->helper('sequence');

    }

	public function getPglList() {
        $result = array();
        $sql = $this->db->query('SELECT PGL_ID,PGL_NAME FROM CUST_PGL ORDER BY PGL_NAME');
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;

    }
    public function getPglListByID($user_id) {
        $result = array();
        $sql = "SELECT B.* FROM APP_USER_C2BI A, CUST_PGL B WHERE A.PGL_ID=B.PGL_ID AND A.USER_ID=".$user_id;
        $sql .= " ORDER BY B.PGL_NAME";
        $q = $this->db->query($sql);
        if($q->num_rows() > 0) {
            $result = $q->result();
        }
        return $result;

    }

    public function getListTenant($pgl_id) {
        $result = array();
        $q = "SELECT
            a.TEN_ID,
            a.TEN_NAME
            FROM CUST_TEN a,
            PGL_TEN b
            WHERE a.TEN_ID = b.TEN_ID
                    AND b.PGL_ID = ".$pgl_id."
            ORDER BY a.TEN_NAME ";
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;

    }

    public function getRinta($param) {
        $db2 = $this->load->database('default2', TRUE);
        $wh = "";
        if($param['search'] != null && $param['search'] === 'true'){
            $wh .= " AND UPPER(".$param['search_field'].")";
            switch ($param['search_operator']) {
                case "bw": // begin with
                    $wh .= " LIKE UPPER('".$param['search_str']."%')";
                    break;
                case "ew": // end with
                    $wh .= " LIKE UPPER('%".$param['search_str']."')";
                    break;
                case "cn": // contain %param%
                    $wh .= " LIKE UPPER('%".$param['search_str']."%')";
                    break;
                case "eq": // equal =
                    if(is_numeric($param['search_str'])) {
                        $wh .= " = ".$param['search_str'];
                    } else {
                        $wh .= " = UPPER('".$param['search_str']."')";
                    }
                    break;
                case "ne": // not equal
                    if(is_numeric($param['search_str'])) {
                        $wh .= " <> ".$param['search_str'];
                    } else {
                        $wh .= " <> UPPER('".$param['search_str']."')";
                    }
                    break;
                case "lt":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " < ".$param['search_str'];
                    } else {
                        $wh .= " < '".$param['search_str']."'";
                    }
                    break;
                case "le":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " <= ".$param['search_str'];
                    } else {
                        $wh .= " <= '".$param['search_str']."'";
                    }
                    break;
                case "gt":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " > ".$param['search_str'];
                    } else {
                        $wh .= " > '".$param['search_str']."'";
                    }
                    break;
                case "ge":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " >= ".$param['search_str'];
                    } else {
                        $wh .= " >= '".$param['search_str']."'";
                    }
                    break;
                default :
                    $wh = "";
            }

        }

        $pagenum = intval($param['page']);
        $rowsnum = intval($param['rows']);
        if($pagenum == 1)
        {
            $rowstart = $pagenum;
            $rowend = $rowsnum;
        }
        else if ($pagenum > 1)
        {
            $rowstart = (($pagenum - 1) * $rowsnum) + 1;
            $rowend = $rowstart + ($rowsnum - 1);
        }
        if($param['ten_id'] == ""){
            $sql = "SELECT b.nd nd1,A.* ".
                " FROM CUST_RINTA PARTITION(PERIOD_".$param['period'].") A, TEN_ND B, PGL_TEN C ".
                " WHERE C.TEN_ID(+)=B.TEN_ID AND B.ND(+)=A.ND AND C.PGL_ID=".$param['pgl_id'];
        }
        $sql2 = "SELECT * FROM ( ";
        $sql3 = "SELECT ROWNUM RN,b.nd nd1,A.* ".
            " FROM CUST_RINTA PARTITION(PERIOD_".$param['period'].") A, TEN_ND B WHERE A.ND(+)=B.ND AND B.TEN_ID=".$param['ten_id'];

        $sql_where = ") WHERE RN BETWEEN $rowstart AND $rowend";

        $sql = $sql2." ".$sql3." ".$sql_where;
        if($wh != "" or $wh != null){
            $sql .= $wh;
        }

        $qs = $db2->query($sql);
        return $qs;

    }
    public function getRintaCount($param) {
        $db2 = $this->load->database('default2', TRUE);
        $result = array();
        $wh = "";
        if($param['search'] != null && $param['search'] === 'true'){
            $wh .= " AND UPPER(".$param['search_field'].")";
            switch ($param['search_operator']) {
                case "bw": // begin with
                    $wh .= " LIKE UPPER('".$param['search_str']."%')";
                    break;
                case "ew": // end with
                    $wh .= " LIKE UPPER('%".$param['search_str']."')";
                    break;
                case "cn": // contain %param%
                    $wh .= " LIKE UPPER('%".$param['search_str']."%')";
                    break;
                case "eq": // equal =
                    if(is_numeric($param['search_str'])) {
                        $wh .= " = ".$param['search_str'];
                    } else {
                        $wh .= " = UPPER('".$param['search_str']."')";
                    }
                    break;
                case "ne": // not equal
                    if(is_numeric($param['search_str'])) {
                        $wh .= " <> ".$param['search_str'];
                    } else {
                        $wh .= " <> UPPER('".$param['search_str']."')";
                    }
                    break;
                case "lt":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " < ".$param['search_str'];
                    } else {
                        $wh .= " < '".$param['search_str']."'";
                    }
                    break;
                case "le":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " <= ".$param['search_str'];
                    } else {
                        $wh .= " <= '".$param['search_str']."'";
                    }
                    break;
                case "gt":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " > ".$param['search_str'];
                    } else {
                        $wh .= " > '".$param['search_str']."'";
                    }
                    break;
                case "ge":
                    if(is_numeric($param['search_str'])) {
                        $wh .= " >= ".$param['search_str'];
                    } else {
                        $wh .= " >= '".$param['search_str']."'";
                    }
                    break;
                default :
                    $wh = "";
            }

        }

        if($param['ten_id'] == ""){
            $sql = "SELECT b.nd nd1,A.* ".
                " FROM CUST_RINTA PARTITION(PERIOD_".$param['period'].") A, TEN_ND B, PGL_TEN C ".
                " WHERE C.TEN_ID(+)=B.TEN_ID AND B.ND(+)=A.ND AND C.PGL_ID=".$param['pgl_id'];
        }
        $sql2 = "SELECT COUNT(*) COUNT FROM ( ";
        $sql3 = "SELECT ROWNUM RN,b.nd nd1,A.* ".
            " FROM CUST_RINTA PARTITION(PERIOD_".$param['period'].") A, TEN_ND B WHERE A.ND(+)=B.ND AND B.TEN_ID=".$param['ten_id'].")";

        $sql = $sql2." ".$sql3;
        if($wh != "" or $wh != null){
            $sql .= $wh;
        }

        $qs = $db2->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;

    }
    public function excelRinta($period, $pgl_id, $ten_id){
        $db2 = $this->load->database('default2', TRUE);
        $result = array();
        $sql = "SELECT b.nd nd1,A.* FROM CUST_RINTA PARTITION(PERIOD_".$period.") A, TEN_ND B WHERE A.ND(+)=B.ND AND B.TEN_ID=".$ten_id;

        $qs = $db2->query($sql);
        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }

	
}