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

    public function get_column_name($tablename) {
        $result = array();
        $q = "select COLUMN_NAME, DATA_TYPE
              from user_tab_columns
              where table_name = '".$tablename."'
              and column_name not in ('CREATED_BY', 'CREATED_DATE')
              order by COLUMN_NAME asc ";
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;
    }

    public function get_doc_type() {
        $result = array();
        $q = "select LISTING_NO, CODE from P_REFERENCE_LIST
                where P_REFERENCE_TYPE_ID= 5 ";
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;
    }
     public function get_bahasa() {
        $result = array();
        $q = "select LISTING_NO, CODE from P_REFERENCE_LIST
                where P_REFERENCE_TYPE_ID= 6 ";
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;
    }

    public function get_data_template() {
        $result = array();
        $q = "SELECT DOC_ID, DOC_TYPE_ID, DOC_NAME, FILE_PATH, DESCRIPTION, UPDATE_DATE, UPDATE_BY, DOC_LANG_ID, DOC_TYPE_NAME, LANG
                FROM V_DOC ";
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;
    }
    
    public function add_Template($data){

		$sql = "insert into DOC (doc_id,
                                 doc_type_id,
                                 file_path,
                                 update_date,
                                 update_by,
                                 doc_name,
                                 description,
                                 --content,
                                 doc_lang_id,
                                 lokasi_id) 
                          values(doc_inc_id.nextval,
                                 '".$data['doc_type']."',
                                 '/default_path',
                                 sysdate,
                                 '".$data['userid']."',
                                 '".$data['nama']."',
                                 '".$data['desc']."',
                                 '".$data['bahasa']."',
                                 ".$data['lokasi_pks'].")";
		$this->db->query($sql);
        
    }


  }
