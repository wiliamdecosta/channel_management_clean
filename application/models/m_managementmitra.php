<?php

class M_managementmitra extends CI_Model
{

    function __construct()
    {
        parent::__construct();

    }

    public function getFastel($param)
    {
        $db2 = $this->load->database('default2', TRUE);
        //$this->db->protect_identifiers();
        $db2->_protect_identifiers = false;
        if ($param['search'] != null && $param['search'] === 'true') {
            $wh = "UPPER(" . $param['search_field'] . ")";
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
                        $wh .= " = '" . $param['search_str']."'";
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
            $db2->where($wh);
        }


        ($param['limit'] != null ? $db2->limit($param['limit']['end'], $param['limit']['start']) : '');
        ($param['sort_by'] != null ?$db2->order_by($param['sort_by'], $param['sord']) : '');

        //$db2->where('b.nd',1);
        $db2->where('C.PGL_ID',$param['pgl_id']);

        $sql = "b.nd nd1,A.* ".
            " FROM CUST_RINTA PARTITION(PERIOD_".$param['period'].") A".
            " INNER JOIN TEN_ND B ON B.ND=A.ND".
            " INNER JOIN PGL_TEN C ON C.TEN_ID=B.TEN_ID";

//        $sql = "SELECT b.nd nd1,A.* ".
//            " FROM CUST_RINTA PARTITION(PERIOD_".$param['period'].") A, TEN_ND B WHERE A.ND(+)=B.ND AND B.TEN_ID=".$param['ten_id'];
        $db2->select($sql);
        $qs = $db2->get();
        return $qs;

    }


    public function excelRinta($period, $pgl_id, $ten_id)
    {
        $db2 = $this->load->database('default2', TRUE);
        $result = array();
        $sql = "SELECT b.nd nd1,A.* FROM CUST_RINTA PARTITION(PERIOD_" . $period . ") A, TEN_ND B WHERE A.ND(+)=B.ND AND B.TEN_ID=" . $ten_id;

        $qs = $db2->query($sql);
        if ($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }


}