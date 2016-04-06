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
            $result = $sql->resultresult();
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
                FROM V_DOC
				";
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
                                 lokasi_id,
								 periode) 
                          values(doc_inc_id.nextval,
                                 '".$data['doc_type']."',
                                 '/default_path',
                                 sysdate,
                                 '".$data['userid']."',
                                 '".$data['nama']."',
                                 '".$data['desc']."',
                                 '".$data['bahasa']."',
                                 '".$data['lokasi_pks']."','
                                 ".$data['doc_period']."')";
		$this->db->query($sql);
        
    }
	
	public function insertNewTemplate($data1, $data2){

		$sql = "insert into TEMPLATE_MASTER (TEMPLATE_ID,
                                 CONTENT_TEMPLATE,
                                 TEMPLATE_NAME
								 ) 
                          values(TEMP_MSTR_INC_ID.nextval,
                                 :data2,
                                 :data1
                                 )";
		$parse = OCIParse($this->db->conn_id, $sql);
		OCIBindByName($parse, ':data1', $data1 );
        OCIBindByName($parse, ':data2', $data2 );
		OCIExecute($parse);       
    }
	public function setNewTemplate($data1, $data2, $data3){

		$sql = "UPDATE TEMPLATE_MASTER
					SET CONTENT_TEMPLATE = :data2, VARIABLE_TEMPLATE = :data3 
						WHERE TEMPLATE_ID = :data1";
		$parse = OCIParse($this->db->conn_id, $sql);
		$data3arr = implode(" ",$data3);
        OCIBindByName($parse, ':data1', $data1 );
        OCIBindByName($parse, ':data2', $data2 );
        OCIBindByName($parse, ':data3', $data3arr );
		OCIExecute($parse);
		print_r($data1);	
		print_r($data3arr);	
		print_r($data2);exit;		
    }
	public function table_location($lokasi_id='', $periode=''){
		$result = array();
        $q = "SELECT DOC_ID, DOC_TYPE_ID, DOC_NAME, FILE_PATH, DESCRIPTION, DOC_LANG_ID, DOC_TYPE_NAME, LANG, LOKASI_ID, PERIODE
                FROM V_DOC2
				where lokasi_id = nvl('".$lokasi_id."',lokasi_id)
				--and periode = nvl('".$periode."')
				";
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;
		
	}
	
	public function convert_lokasi(){
		$result = array();
        $q = "SELECT P_MP_LOKASI_ID, LOKASI
                FROM P_MP_LOKASI				
				";
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;
		
	}
	
	public function get_data_var_template($doc_name,$doc_id, $clob){
		$bulan=array("","Januari","Pebruari",
					"Maret","April","Mei","Juni","Juli",
					"Agustus","September","Oktober",
					"November","Desember");
		$sql = array("PERHITUNGAN_BILL_COLL"=>"
								select b.cc_name, c.periode, periode_minus(c.periode) periode_min, b.AM_NAME, SEGMENT, SEGMENT_NAME
                                from p_mp_lokasi a
                                 join v_map_mit_cc b
                                 on a.p_map_mit_cc_id = b.p_map_mit_cc_id 
                                 join v_doc2 c 
                                 on a.p_mp_lokasi_id = c.lokasi_id
                                where c.doc_id = $doc_id
                                and rownum = 1 "
								);
		
		 $q = $sql[$doc_name];
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $result = $sql->result();
			
		 foreach ($result as $content){
			$clob = str_replace('(NAMA_CC)',$content->CC_NAME,$clob);
			$clob = str_replace('(BULAN)',$bulan[substr($content->PERIODE,-2)*1],$clob);
			$clob = str_replace('(TAHUN)',substr($content->PERIODE,0,4),$clob);
			$clob = str_replace('(BULAN-1)',$bulan[substr($content->PERIODE_MIN,-2)*1],$clob);
			$clob = str_replace('(NAMA_AM)',$content->AM_NAME,$clob);
			$clob = str_replace('(JABATAN_EAM_SAM)',' ',$clob);
			$clob = str_replace('(NAMA_SEGMENT)',$content->SEGMENT_NAME,$clob);

		 }
		$result = $clob;
        return $result;
		
	}
	
	public function load_temp(){
		$result = array();
        $q = "SELECT *
                FROM TEMPLATE_MASTER			
				";
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;		
	}
	
	public function get_var_content($data){
		$result = array();
        $q = "SELECT DISTINCT VARIABLE_NAME 
					FROM TEMPLATE_VARIABLE WHERE TABLE_NAME = ".$data;
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $ret = $sql->result();

        return $ret;		
	}
	
	public function get_var_templates($data){
		$result = array();
        $q = "SELECT DISTINCT VARIABLE_TEMPLATE
                    FROM TEMPLATE_MASTER WHERE TEMPLATE_ID = '".$data."' ";
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $ret = $sql->result();

        return $ret;		
	}
	
	public function get_var_tbl_name(){
		$result = array();
        $q = "SELECT DISTINCT TABLE_NAME 
					FROM TEMPLATE_VARIABLE			
				";
        $sql = $this->db->query($q);
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;		
	}
	
	public function get_contents($data){
        $sql = "SELECT CONTENT_TEMPLATE
                FROM TEMPLATE_MASTER			
					WHERE TEMPLATE_ID = :data";
		$parse = OCIParse($this->db->conn_id, $sql);
		OCIBindByName($parse, ':data', $data );
		OCIExecute($parse);
		
		while (OCIFetchInto($parse,$arr,OCI_ASSOC)) {
				if(isset($arr["CONTENT_TEMPLATE"])){
				if($arr["CONTENT_TEMPLATE"]){
					$ret = $arr["CONTENT_TEMPLATE"]->load();
				} 
				} else $ret = "";
			}
		
        return $ret;	
	}
	
	public function deleteTempfromTable($data1){
		$sql1 = "DELETE FROM TEMPLATE_MASTER WHERE TEMPLATE_ID = ".$data1;
		$this->db->query($sql1);
	}
	

  }
