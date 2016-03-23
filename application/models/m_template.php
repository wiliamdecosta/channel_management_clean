<?php
class M_template extends CI_Model {

    function __construct() {
        parent::__construct();

    }

    public function get_table_name() {
        $result = array();
        $q = "select TABLE_NAME from user_tables
              where status = 'VALID'
              and table_name like 'TEN%'
              order by table_name asc ";
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;

    }




  }
