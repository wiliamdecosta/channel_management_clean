<?php
class M_jqGrid extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->helper('sequence');
    }

    public function get_data($param) {
        if($param['search'] != null && $param['search'] === 'true'){
            $wh = "UPPER(".$param['search_field'].")";
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
            $this->db->where($wh);
        }

        ($param['where'] != null && $param['where'] != '' ? $this->db->where($param['where']): '' );
        ($param['where_in'] != null &&   $param['where_in'] != '' ? $this->db->where_in($param['where_in']['field'],$param['where_in']['value']) : '');
        ($param['where_not_in'] != null && $param['where_not_in'] != '' ? $this->db->where_not_in($param['where_not_in']['field'],$param['where_not_in']['value']) : '');

        ($param['limit'] != null ? $this->db->limit($param['limit']['end'], $param['limit']['start']) : '');
        ($param['sort_by'] != null ? $this->db->order_by($param['sort_by'], $param['sord']) : '');

         $qs = $this->db->get($param['table']);
         return $qs;

    }

    public function get_data_join($param) {
        if($param['search'] != null && $param['search'] === 'true'){
            $wh = "UPPER(".$param['search_field'].")";
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
            $this->db->where($wh);
        }

        if($param['where'] != null && $param['where'] != ''){
            $this->db->where($param['where']);
        }

        ($param['where'] != null && $param['where'] != '' ? $this->db->where($param['where']): '' );
        ($param['where_in'] != null ? $this->db->where_in($param['where_in']['field'],$param['where_in']['value']) : '');
        ($param['where_not_in'] != null ? $this->db->where_not_in($param['where_not_in']['field'],$param['where_not_in']['value']) : '');

        ($param['limit'] != null ? $this->db->limit($param['limit']['end'], $param['limit']['start']) : '');
        ($param['sort_by'] != null ? $this->db->order_by($param['sort_by'], $param['sord']) : '');

        $this->db->select($param['select']);
        $this->db->from($param['table']);
        $this->db->join($param['join_table'],$param['join_cond'],$param['join_operator']);

        $qs =  $this->db->get();
        return $qs;

    }

    // Fungsi CRUD JqGrid
    function crud($table, $key, $arr){
        $oper=$this->input->post('oper');
        $id_=$this->input->post('id');
        $count=count($arr);
        //  print_r($count);
        for($i=0;$i<$count;$i++){
            $data[$arr[$i]]=$this->input->post($arr[$i]);

        }
        switch ($oper) {
            case 'add':
                $new_id = gen_id($key,$table);
                $this->db->set($key,$new_id);
                $this->db->insert($table,$data);
                break;
            case 'edit':
                $this->db->where($key,$id_);
                $this->db->update($table, $data);
                break;
            case 'del':
                $this->db->where($key,$id_);
                $this->db->delete($table);
                break;
        }

    }

    public function get_data2($param) {
        $db2 = $this->load->database('default2', TRUE);
        //$wh = "";
        if($param['search'] != null && $param['search'] === 'true'){
            $wh = "UPPER(".$param['search_field'].")";
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
            $db2->where($wh);
        }

        $count_field = count($param['field']);
        if($count_field > 0){
            for($i=0; $i<$count_field; $i++){
                $db2->where($param['field'][$i],$param['value'][$i]);
            }
        }
        // print_r($count_field);
        // exit();
        ($param['limit'] != null ? $db2->limit($param['limit']['end'], $param['limit']['start']) : '');
        ($param['sort_by'] != null ? $db2->order_by($param['sort_by'], $param['sord']) : '');

        // Custome Code digunakan untuk manipulasi query
        if(isset($param['custom_code'])){
            if($param['custom_code'] != null && $param['custom_code'] != ''){
                switch ($param['custom_code']) {

                    case "user":
                        $db2->select('USER_ID, NIK, USER_NAME,EMAIL,LOKER,ADDR_STREET,ADDR_CITY,CONTACT_NO,PROF_NAME');
                        $db2->from('APP_USERS');
                        $db2->join('APP_PROFILE', 'APP_USERS.PROF_ID = APP_PROFILE.PROF_ID','LEFT');

                        $qs = $db2->get();
                        return $qs;
                        break;

                    default :
                        //  $wh = "";
                }
            }
        }else{
            $qs = $db2->get($param['table']);
            return $qs;
        }

    }

    public function countAll($param){
        if($param['search'] != null && $param['search'] === 'true'){
            $wh = "UPPER(".$param['search_field'].")";
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
            $this->db->where($wh);
        }

        ($param['where'] != null && $param['where'] != '' ? $this->db->where($param['where']): '' );
        ($param['where_in'] != null ? $this->db->where_in($param['where_in']['field'],$param['where_in']['value']) : '');
        ($param['where_not_in'] != null ? $this->db->where_not_in($param['where_not_in']['field'],$param['where_not_in']['value']) : '');


        ($param['limit'] != null ? $this->db->limit($param['limit']['end'], $param['limit']['start']) : '');
        ($param['sort_by'] != null ? $this->db->order_by($param['sort_by'], $param['sord']) : '');


        $qs = $this->db->count_all_results($param['table']);
        return $qs;

    }





}