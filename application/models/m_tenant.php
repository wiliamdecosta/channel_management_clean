<?php
class M_tenant extends CI_Model {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getLists($cond="") {
	    $result = array();
		$sql = "SELECT TEN_ID, NCLI, TEN_NAME, TEN_ADDR, TEN_CONTACT_NO, SUM(JML_ND) JML_ND, SUM(JML_NONPOTS) JML_NONPOTS FROM (".
                        " SELECT A.TEN_ID, A.NCLI, A.TEN_NAME, A.TEN_ADDR, A.TEN_CONTACT_NO, COUNT(B.ND) JML_ND, 0 JML_NONPOTS ".
			" FROM CUST_TEN A, TEN_ND B WHERE A.TEN_ID=B.TEN_ID(+) ".
			" GROUP BY A.TEN_ID, A.NCLI, A.TEN_NAME, A.TEN_ADDR, A.TEN_CONTACT_NO".
                        " UNION SELECT A.TEN_ID, A.NCLI, A.TEN_NAME, A.TEN_ADDR, A.TEN_CONTACT_NO, 0 JML_ND, COUNT(B.ACCOUNT_NUM) JML_NONPOTS ".
			" FROM CUST_TEN A, TEN_ND_NONPOTS B WHERE A.TEN_ID=B.TEN_ID(+) ".
			" GROUP BY A.TEN_ID, A.NCLI, A.TEN_NAME, A.TEN_ADDR, A.TEN_CONTACT_NO".
                        ") ";
		if($cond!='') $sql .= " WHERE ".$cond;
                $sql .= " GROUP BY TEN_ID, NCLI, TEN_NAME, TEN_ADDR, TEN_CONTACT_NO";

		$q = $this->db->query($sql);
		if($q->num_rows() > 0) $result = $q->result();
		return $result;
    }

	public function getFromPgl($pgl_id) {
	    $result = array();
		$sql = "SELECT A.TEN_ID, A.NCLI, A.TEN_NAME, A.TEN_ADDR, A.TEN_CONTACT_NO, COUNT(C.ND) JML_ND ".
			" FROM CUST_TEN A, PGL_TEN B, TEN_ND C ".
			" WHERE A.TEN_ID=B.TEN_ID AND A.TEN_ID=C.TEN_ID(+) AND B.PGL_ID=".$pgl_id;
		$sql .= " GROUP BY A.TEN_ID, A.NCLI, A.TEN_NAME, A.TEN_ADDR, A.TEN_CONTACT_NO";
		$sql .= " ORDER BY A.TEN_NAME";
		$q = $this->db->query($sql);
		if($q->num_rows() > 0) $result = $q->result();
		return $result;
    }

    public function getND($ten_id) {
	    $result = array();
		$sql = "SELECT * FROM TEN_ND WHERE TEN_ID=".$ten_id;
		$q = $this->db->query($sql);
		if($q->num_rows() > 0) $result = $q->result();
		return $result;
    }

    public function getNDNP($ten_id) {
	    $result = array();
		$sql = "SELECT * FROM TEN_ND_NONPOTS WHERE TEN_ID=".$ten_id;
		$q = $this->db->query($sql);
		if($q->num_rows() > 0) $result = $q->result();
		return $result;
    }

    public function getTenUsage($period, $pgl_id=0, $ten_id=0) {
	    $result = array();
		$sql = "SELECT D.* FROM PGL_TEN B, TEN_ND C, TEN_USAGE D".
			" WHERE D.PERIOD='".$period."' AND D.ND=C.ND AND C.TEN_ID=B.TEN_ID AND B.PGL_ID=".$pgl_id." AND B.TEN_ID=".$ten_id;
		$sql .= " ORDER BY D.ND";
		$q = $this->db->query($sql);
		if($q->num_rows() > 0) $result = $q->result();
		return $result;
    }

    public function getTenUsageStatis($pgl_id="", $ten_id="", $cf_id="") {
	    $result = array();
		$sql = "SELECT D.*, B.PGL_ID, E.CF_NAME, G.PGL_NAME, F.TEN_NAME ".
                        " FROM PGL_TEN B, TEN_USAGE_ETC D, COM_FEE E, Cust_TEN F, CUST_PGL G ".
			" WHERE D.PERIOD='999999' AND D.CF_ID=E.CF_ID ".
                        " AND D.TEN_ID=B.TEN_ID AND B.TEN_ID=F.TEN_ID AND B.PGL_ID=G.PGL_ID ";
                if($pgl_id!="") $sql .= " AND B.PGL_ID=".$pgl_id." ";
                if($ten_id!="") $sql .= " AND B.TEN_ID=".$ten_id." ";
                if($cf_id!="") $sql .= " AND D.CF_ID=".$cf_id." ";
                $sql .= " ORDER BY D.ND";
                //echo $sql;
		$q = $this->db->query($sql);
		if($q->num_rows() > 0) $result = $q->result();
		return $result;
    }

    public function getCountNP($cond="") {
	    $result = array();
		$sql = "SELECT * FROM (SELECT A.TEN_ID, A.NCLI, A.TEN_NAME, A.TEN_ADDR, A.TEN_CONTACT_NO, COUNT(B.ND) JML_ND ".
			" FROM CUST_TEN A, TEN_ND B, TEN_ND_NONPOTS C WHERE A.TEN_ID=B.TEN_ID(+) ".
			" GROUP BY A.TEN_ID, A.NCLI, A.TEN_NAME, A.TEN_ADDR, A.TEN_CONTACT_NO) ";
		if($cond!='') $sql .= " WHERE ".$cond;
		$q = $this->db->query($sql);
		if($q->num_rows() > 0) $result = $q->result();
		return $result;
    }

    public function insertTenUsageStatis($ten_id, $cf_id, $cf_nom) {
            $sql = "INSERT INTO TEN_USAGE_ETC(PERIOD, TEN_ID, CF_ID, CF_NOM) ".
                    "VALUES('999999', ".$ten_id.", ".$cf_id.", ".$cf_nom.")";
            $q = $this->db->query($sql);
    }

    public function updateTenUsageStatis($ten_id, $cf_id, $cf_nom) {
            $sql = "UPDATE TEN_USAGE_ETC SET CF_NOM=".$cf_nom." ".
                    "WHERE PERIOD='999999' AND TEN_ID=".$ten_id." AND CF_ID=".$cf_id." ";
            $q = $this->db->query($sql);
    }

    public function removeTenUsageStatis($ten_id, $cf_id) {
            $sql = "DELETE FROM TEN_USAGE_ETC ".
                    "WHERE PERIOD='999999' AND TEN_ID=".$ten_id." AND CF_ID=".$cf_id." ";
            $q = $this->db->query($sql);
    }

    public function insert($ncli, $ndos, $ten_name, $ten_addr, $ten_contact_no) {
	    $new_id = $this->getNewTenId();
	    $sql = "INSERT INTO CUST_TEN(TEN_ID, NCLI, TEN_NAME, TEN_ADDR, TEN_CONTACT_NO) ".
	    	"VALUES(".$new_id.", '".$ncli."', '".$ten_name."', '".$ten_addr."', '".$ten_contact_no."') ";
		$q = $this->db->query($sql);
		return $new_id;
    }

    public function update($ten_id, $ncli, $ndos, $ten_name, $ten_addr, $ten_contact_no) {
	    $sql = "UPDATE CUST_TEN SET NCLI='".$ncli."', TEN_NAME='".$ten_name."', TEN_ADDR='".
	    	$ten_addr."', TEN_CONTACT_NO='".$ten_contact_no."' WHERE TEN_ID=".$ten_id;
		$q = $this->db->query($sql);
    }

    public function remove($ten_id) {
	    $sql = "DELETE FROM CUST_TEN WHERE TEN_ID=".$ten_id;
		$q = $this->db->query($sql);
		$sql = "DELETE FROM PGL_TEN WHERE TEN_ID=".$ten_id;
		$q = $this->db->query($sql);
		$sql = "DELETE FROM TEN_ND WHERE TEN_ID=".$ten_id;
		$q = $this->db->query($sql);
    }

    private function getNewTenId() {
		$q = $this->db->query("SELECT MAX(TEN_ID)+1 N FROM CUST_TEN");
		foreach($q->result() as $r) $n = $r->N;
		if ($n=='' || $n=='0') $n=1;
		return $n;
	}

	public function clearPengelola($ten_id) {
	    $sql = "DELETE FROM PGL_TEN WHERE TEN_ID=".$ten_id;
		$q = $this->db->query($sql);
    }

    public function setPengelola($ten_id, $pgl_id) {
	    $sql = "INSERT INTO PGL_TEN(PGL_ID, TEN_ID) VALUES(".$pgl_id.", ".$ten_id.")";
		$q = $this->db->query($sql);
    }

    public function getPengelola($ten_id) {
	    $result = array();
	    $sql = "SELECT PGL_ID FROM PGL_TEN WHERE TEN_ID=".$ten_id;
		$q = $this->db->query($sql);
		if($q->num_rows() > 0) {
			foreach($q->result() as $k=>$v)
				array_push($result, $v->PGL_ID);
		}
		return $result;
    }


	// Data maintenance
	public function tenBackupToCurrPeriod() {
		$currperiod = date("Ym");
		$sql = "DELETE FROM PGL_TEN_HIST WHERE PERIOD='".$currperiod."'";
		$q = $this->db->query($sql);
		$sql = "INSERT INTO PGL_TEN_HIST(PERIOD, PGL_ID, TEN_ID) SELECT '".$currperiod."', PGL_ID, TEN_ID FROM PGL_TEN";
		$q = $this->db->query($sql);
	}

	public function tenBackupToPrevPeriod() {
		$currperiod = date("Ym");
		$prevperiod = ((int)$currperiod)-1;
		if(substr($prevperiod, 4,2)=="00") $prevperiod = (substr($currperiod,0,4)-1)."12";
		$sql = "DELETE FROM PGL_TEN_HIST WHERE PERIOD='".$prevperiod."'";
		$q = $this->db->query($sql);
		$sql = "INSERT INTO PGL_TEN_HIST(PERIOD, PGL_ID, TEN_ID) SELECT '".$prevperiod."', PGL_ID, TEN_ID FROM PGL_TEN";
		$q = $this->db->query($sql);
	}

	public function clearPglTen() {
		$sql = "DELETE FROM PGL_TEN";
		$q = $this->db->query($sql);
	}

	public function NDBackupToCurrPeriod($ten_id="") {
        $db2 = $this->load->database('default2', TRUE);
		$currperiod = date("Ym");
		if($ten_id=="")
			$sql = "DELETE FROM TEN_ND_HIST WHERE PERIOD='".$currperiod."'";
		else
			$sql = "DELETE FROM TEN_ND_HIST WHERE PERIOD='".$currperiod."' AND TEN_ID=".$ten_id;
        $db2->query($sql);

		if($ten_id=="")
			$sql = "INSERT INTO TEN_ND_HIST(PERIOD, TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD) ".
				" SELECT '".$currperiod."', TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD FROM TEN_ND";
		else
			$sql = "INSERT INTO TEN_ND_HIST(PERIOD, TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD) ".
				" SELECT '".$currperiod."', TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD FROM TEN_ND WHERE TEN_ID=".$ten_id;
		$db2->query($sql);
	}

	public function NDBackupToPrevPeriod($ten_id="") {
        $db2 = $this->load->database('default2', TRUE);
		$currperiod = date("Ym");
		$prevperiod = ((int)$currperiod)-1;
		if(substr($prevperiod, 4,2)=="00") $prevperiod = (substr($currperiod,0,4)-1)."12";
		if($ten_id=="")
			$sql = "DELETE FROM TEN_ND_HIST WHERE PERIOD='".$prevperiod."'";
		else
			$sql = "DELETE FROM TEN_ND_HIST WHERE PERIOD='".$prevperiod."' AND TEN_ID=".$ten_id;
        $db2->query($sql);

		if($ten_id=="")
			$sql = "INSERT INTO TEN_ND_HIST(PERIOD, TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD) ".
				"SELECT '".$prevperiod."', TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD FROM TEN_ND";
		else
			$sql = "INSERT INTO TEN_ND_HIST(PERIOD, TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD) ".
				"SELECT '".$prevperiod."', TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD FROM TEN_ND WHERE TEN_ID=".$ten_id;
        $db2->query($sql);
	}
    public function cekTenND($ten_id, $nd, $validfrom, $validto, $cprod) {
        $db2 = $this->load->database('default2', TRUE);
        $andvt = '';
        if($validto <> '' || $validto <> NULL){

            $andvt = "AND VALID_FROM = TO_DATE('".$validto."')";
        }

        if($validfrom <> '' || $validfrom <> NULL){

            $andvf = "AND VALID_FROM = TO_DATE('".$validfrom."')";
        }

        $sql = "SELECT * FROM TEN_ND_DEV
					WHERE TEN_ID = ".$ten_id."
					AND ND = '".$nd."'
					AND TO_CHAR(VALID_FROM,'DD-MM-YYYY') = '".$validfrom."'
					AND TO_CHAR(VALID_TO,'DD-MM-YYYY') = '".$validto."' ";
        $q = $db2->query($sql);
        //if($q->num_rows() > 0) $result = $q->result();
        return $q->num_rows();
    }

	public function clearNDTen($ten_id="") {
        $db2 = $this->load->database('default2', TRUE);
		if($ten_id=="")
			$sql = "DELETE FROM TEN_ND";
		else
			$sql = "DELETE FROM TEN_ND WHERE TEN_ID=".$ten_id;
		$db2->query($sql);
	}

  public function clearDatinTen($ten_id="") {
        $db2 = $this->load->database('default2', TRUE);
		if($ten_id=="")
			$sql = "DELETE FROM TEN_ND_NP";
		else
			$sql = "DELETE FROM TEN_ND_NP WHERE TEN_ID=".$ten_id;
		$db2->query($sql);
	}

	public function delNDTen($ten_id, $nd) {
        $db2 = $this->load->database('default2', TRUE);
		$sql = "DELETE FROM TEN_ND WHERE TEN_ID=".$ten_id." AND ND='".$nd."'";
        $db2->query($sql);
	}

  public function insertDatin($data) {
  		$ret = 0;
  		$db2 = $this->load->database('default', TRUE);
  	   if(is_array($data)){

		$sql = "INSERT INTO TEN_ND_NP (TEN_ID, ACCOUNT_NUM, PRODUCT_ID, CREATED_BY, CREATED_DATE) VALUES
                                         ( ".$data['TEN_ID'].",
                                          '".$data['ACCOUNT_NUM']."',
                                          '".$data['PRODUCT_ID']."',
                                          '".$data['USERID']."', sysdate)";

        // if( !isset($data['ACCOUNT_NUM']) || $data['ACCOUNT_NUM'] == '' || $data['ACCOUNT_NUM'] == null){
        // 	$query = " SELECT count(*) CEK 
								// FROM ten_nd_np 
								// where ten_id = ".$data['TEN_ID']." 
								// AND account_num is null
								// AND product_id = '".$data['PRODUCT_ID']."' ";
        // } else {
        // 	$query = " SELECT count(*) CEK 
								// FROM ten_nd_np 
								// where ten_id = ".$data['TEN_ID']." 
								// AND account_num = '".$data['ACCOUNT_NUM']."'
								// AND product_id = '".$data['PRODUCT_ID']."' ";
        // }

        $query = " SELECT count(*) CEK 
								 FROM ten_nd_np 
								 where ten_id = ".$data['TEN_ID']." 
								 AND product_id = '".$data['PRODUCT_ID']."' ";

		$q = $this->db->query($query);

		/*$q = $this->db2->query(" SELECT insert_datin(".$data['TEN_ID'].",
                                          '".$data['ACCOUNT_NUM']."',
                                          '".$data['PRODUCT_ID']."',
                                          '".$data['USERID']."') as CEK from dual ");*/
		 $ce = 0;
		 foreach($q->result() as $r) {
                   $ce = $r->CEK;
                   }
        // return $ce;
        if($ce < 1){
        	 $db2->query($sql);
        	 $ret =  0;
        }else{
        	$ret = 1;
        }
       
      }
      return $ret;
  }

  public function insertTenND($ten_id, $nd, $validfrom, $validto, $cprod) {
        $db2 = $this->load->database('default2', TRUE);
        $sql = "INSERT INTO TEN_ND_DEV (TEN_ID, ND, VALID_FROM, VALID_TO, CPROD) VALUES (".$ten_id.",
																						'".$nd."',
																						TO_DATE('".$validfrom."','DD-MM-YYYY'),
																						TO_DATE('".$validto."','DD-MM-YYYY'),
																						'".$cprod."')";
        $db2->query($sql);
  }
        // ND Non POTS
        public function clearNDNPTen($ten_id="") {
		if($ten_id=="")
			$sql = "DELETE FROM TEN_ND_NONPOTS";
		else
			$sql = "DELETE FROM TEN_ND_NONPOTS WHERE TEN_ID=".$ten_id;
		$q = $this->db->query($sql);
	}

        public function delNDNPTen($ten_id, $acc_no) {
		$sql = "DELETE FROM TEN_ND_NONPOTS WHERE TEN_ID=".$ten_id." AND ACCOUNT_NUM='".$acc_no."'";
		$q = $this->db->query($sql);
	}

	public function insertTenNDNP($ten_id, $cust_reff, $acc_no, $gl_acc) {
		$sql = "INSERT INTO TEN_ND_NONPOTS(TEN_ID, CUSTOMER_REF, ACCOUNT_NUM, GL_ACCOUNT) ".
                        " VALUES(".$ten_id.", '".$cust_reff."', '".$acc_no."', '".$gl_acc."')";
		$q = $this->db->query($sql);
	}


	// Restore
	public function NDRestore($period, $ten_id="") {
		if($ten_id=="")
			$sql = "SELECT TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD FROM TEN_ND_HIST WHERE PERIOD='".$period."'";
		else
			$sql = "SELECT TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD FROM TEN_ND_HIST WHERE PERIOD='".$period."' AND TEN_ID=".$ten_id;
		$q = $this->db->query($sql);

		if($q->num_rows() > 0) {

			if($ten_id=="")
				$sql = "DELETE FROM TEN_ND";
			else
				$sql = "DELETE FROM TEN_ND WHERE TEN_ID=".$ten_id;
			$q = $this->db->query($sql);

			if($ten_id=="")
				$sql = "INSERT INTO TEN_ND(TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD) ".
					" SELECT TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD FROM TEN_ND_HIST WHERE PERIOD='".$period."'";
			else
				$sql = "INSERT INTO TEN_ND(TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD) ".
					" SELECT TEN_ID, ND, NCLI, NDOS, AKTIF, CPROD FROM TEN_ND_HIST WHERE PERIOD='".$period."' AND TEN_ID=".$ten_id;
			$q = $this->db->query($sql);

		}
	}

	public function NDHistPeriod($ten_id="") {
		if($ten_id=="")
			$sql = "SELECT DISTINCT PERIOD FROM TEN_ND_HIST";
		else
			$sql = "SELECT DISTINCT PERIOD FROM TEN_ND_HIST WHERE TEN_ID=".$ten_id;
		$q = $this->db->query($sql);
		if($q->num_rows() > 0) $result = $q->result();
		return $result;
	}


    public function check_duplicateND($ten_id,$nd, $vf, $vt, $cprod,$username,$batch_id,$cekND) {
        $db2 = $this->load->database('default2', TRUE);
        $sql = " DECLARE ".
            "  i_retrun VARCHAR2(90); ".
            "  BEGIN ".
            "  p_cheking_duplicate(:params1,:params2,:params3,:params4,:params5,:params6,:params7,:i_retrun); END;";

        $params = array(
            array('name' => ':params1', 'value' => $ten_id, 'type' => SQLT_INT, 'length' => 32),
            array('name' => ':params2', 'value' => $nd, 'type' => SQLT_CHR, 'length' => 32),
            array('name' => ':params3', 'value' => $cprod, 'type' => SQLT_INT, 'length' => 1),
            array('name' => ':params4', 'value' => $vf, 'type' => SQLT_CHR, 'length' => 32),
            array('name' => ':params5', 'value' => $vt, 'type' => SQLT_CHR, 'length' => 32),
            array('name' => ':params6', 'value' => $username, 'type' => SQLT_CHR, 'length' => 32),
            array('name' => ':params7', 'value' => $batch_id, 'type' => SQLT_INT, 'length' => 32)
        );
        // Bind the output parameter
        $stmt = oci_parse($db2->conn_id,$sql);

        foreach($params as $p){
            // Bind Input
            oci_bind_by_name($stmt,$p['name'], $p['value'], $p['length']);
        }
        $message = '';
        oci_bind_by_name($stmt,':i_retrun',$message,90);

        ociexecute($stmt);
        return $message;

    }

    public function getTenNDTemp() {
        $db2 = $this->load->database('default2', TRUE);
        $sql = "SELECT * FROM TEN_ND_TEMP";
        $q = $db2->query($sql);
        //if($q->num_rows() > 0) $result = $q->result();
        return $q;
    }
    public function clearTMPNDByUser($username="") {
        $db2 = $this->load->database('default2', TRUE);
        if($username=="")
            $sql = "DELETE FROM TEN_ND_TEMP";
        else
            $sql = "DELETE FROM TEN_ND_TEMP WHERE CREATED_BY='".$username."'";
        $db2->query($sql);
    }

    public function getBatchID(){
        $sql = "SELECT  BATCH_CONTROL_NEW_SEQ.NEXTVAL AS BATCH_ID FROM DUAL";
        $r = $this->db->query($sql);
        return $r->row()->BATCH_ID;
    }

    public function create_batch_expense($username,$batch_id) {
        $sql = "  BEGIN ".
            "  marfee.create_batch_expense(:params1,:params2); END;";

        $params = array(
            array('name' => ':params1', 'value' => $username, 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params2', 'value' => $batch_id, 'type' => SQLT_INT, 'length' => 32)

        );
        // Bind the output parameter

        $stmt = oci_parse($this->db->conn_id,$sql);

        foreach($params as $p){
            // Bind Input
            oci_bind_by_name($stmt,$p['name'], $p['value'], $p['length']);
        }
       // $message = '';
       // oci_bind_by_name($stmt,':v_result',$message,32);

        $r = ociexecute($stmt);
        return $r;

    }

    public function checkPeriod($batch_id){
        $sql = "SELECT  COUNT(*) AS COUNT FROM T_JOB_HAS_PERIOD WHERE BATCH_ID = ".$batch_id;
        $r = $this->db->query($sql);
        return $r->row()->COUNT;
    }

    public function createPeriod($period,$username,$batch_id) {
        $sql = " DECLARE ".
            "  v_result VARCHAR2(90); ".
            "  BEGIN ".
            "  marfee.insert_period_expense(:params1,:params2,:params3, :v_result); END;";

        $params = array(
            array('name' => ':params1', 'value' => $period, 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params2', 'value' => $username, 'type' => SQLT_CHR, 'length' => 32),
            array('name' => ':params3', 'value' => $batch_id, 'type' => SQLT_CHR, 'length' => 10)
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

    public function copyBatch($period,$username,$batch_id) {
        $sql = " DECLARE ".
            "  v_result VARCHAR2(90); ".
            "  BEGIN ".
            "  marfee.create_batch_copy_exp(:params1,:params2,:params3, :v_result); END;";

        $params = array(
            array('name' => ':params1', 'value' => $period, 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params2', 'value' => $username, 'type' => SQLT_CHR, 'length' => 32),
            array('name' => ':params3', 'value' => $batch_id, 'type' => SQLT_CHR, 'length' => 10)
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

    public function getListND($param) {
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
        $result = array();
        $db2 = $this->load->database('default2', TRUE);


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
        //$this->db->get('APP_MENU');

        $sql2 = "SELECT * FROM ( ";
        $sql3 = "SELECT ROWNUM RN,a.* FROM TEN_ND_ADD a WHERE a.BATCH_ID = ".$param['id']." ORDER BY ".$param['sort_by']." ". $param['sord'];
        $sql_where = ") WHERE RN BETWEEN $rowstart AND $rowend";
        $sql = $sql2." ".$sql3." ".$sql_where;
        if($wh != "" or $wh != null){
            $sql .= $wh;
        }

        $qs = $db2->query($sql);
        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }

    public function getCountListND($id) {
        $db2 = $this->load->database('default2', TRUE);
        $result = array();
        $sql = "SELECT COUNT(*) COUNT FROM TEN_ND_ADD WHERE BATCH_ID = ".$id;
        $qs = $db2->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }


}
