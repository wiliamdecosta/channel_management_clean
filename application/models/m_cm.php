<?php
class M_cm extends CI_Model {

    function __construct() {
        parent::__construct();

//        $this->load->helper('sequence');

    }

	public function createBatch($mitra, $list_cc){
		$out_put = "Succes";
		// create batch
        $sql = "BEGIN " .
			"   MARFEE.pkg_proc_batch.create_batch_frm(:params1,:params2); END;";
        $params = array(
            array('name' => ':params1', 'value' => $list_cc, 'type' => SQLT_INT, 'length' => 6),
            array('name' => ':params2', 'value' => $mitra, 'type' => SQLT_INT, 'length' => 11)
        );
        // Bind the output parameter
		$stmt = oci_parse($this->db->conn_id, $sql);
        foreach ($params as $p) {
            // Bind Input
            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
        }
		ociexecute($stmt);
		die($sql);
		return $out_put ;	
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
	
	/*Enhance tunggakan 03-04-2017
	*/
	
	public function getTunggakanDt($param) {
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
            // $sql = "SELECT *
					// FROM V_DEBT_POST_SUM
					// WHERE I_PGL_ID = ".$param['pgl_id']." 
						  // AND PERIOD_COL <= '".$param['period']."'";
				
		$sql =	"SELECT IDNUMBER,NPER,
					CA,
					NIPNAS,
					BPNAME,
					PRODUK,
					UBIS ,
					SEGMEN ,
					SUBSEGMEN ,
					BISNIS_AREA ,
					DIVISI,
					WITEL,
					BILL_PERIOD,
					DUE_DATE,
					BILL_ELEMENT            ,
					ACCOUNT,
					BILL_AMOUNT
			  FROM trem_np_details
			 WHERE     cl_status = 'OPEN'
				   AND bill_type <> 'AN'
				   AND bill_element NOT LIKE 'Payment%'
				   AND BILL_PERIOD <= '".$param['period']."'
				   AND EXISTS
						  (SELECT *
							 FROM cust_rinta_np_mfee
							WHERE     pgl_id = ".$param['pgl_id']."
								  --AND ten_id = ".$param['ten_id']."
								  AND BILL_PRD = '".$param['period']."'
								  AND account_num = IDNUMBER) ";
						  
        }
        $sql2 = "SELECT * FROM ( ";
        $sql3 =	"SELECT ROWNUM RN,
					b.IDNUMBER,
				   a.NPER,
				   a.CA,
				   b.NIPNAS,
				   b.BPNAME,
				   b.PRODUK,
				   b.UBIS,
				   b.SEGMEN,
				   b.SUBSEGMEN,
				   b.BISNIS_AREA,
				   b.DIVISI,
				   b.WITEL,
				   a.BILL_PERIOD,
				   a.DUE_DATE,
				   a.BILL_ELEMENT,
				   a.ACCOUNT,
				   a.BILL_AMOUNT
			  FROM trem_np_details a, mybrains.p_partner@DBL_BILLCOST b
			 WHERE     a.cl_status = 'OPEN'
				   AND a.bill_type <> 'AN'
				   AND a.bill_element NOT LIKE 'Payment%'
				   AND a.BILL_PERIOD <= '".$param['period']."'
				   AND a.PARTNER = b.PARTNER
				   AND EXISTS
						  (SELECT 1
							 FROM cust_rinta_np_mfee x
							WHERE     x.pgl_id = ".$param['pgl_id']."
								  AND x.ten_id = ".$param['ten_id']."
								  AND x.BILL_PRD = '".$param['period']."'
								  AND x.account_num = b.IDNUMBER) ";
        $sql_where = ") WHERE RN BETWEEN $rowstart AND $rowend";

        $sql = $sql2." ".$sql3." ".$sql_where;
        if($wh != "" or $wh != null){
            $sql .= $wh;
        }
           // die($sql);
        $qs = $db2->query($sql);
        return $qs;

    }
	
	public function getTunggakanDtCount($param) {
		// die("sa");
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
            $sql =	"SELECT IDNUMBER,NPER,
					CA,
					NIPNAS,
					BPNAME,
					PRODUK,
					UBIS ,
					SEGMEN ,
					SUBSEGMEN ,
					BISNIS_AREA ,
					DIVISI,
					WITEL,
					BILL_PERIOD,
					DUE_DATE,
					BILL_ELEMENT            ,
					ACCOUNT,
					BILL_AMOUNT
			  FROM trem_np_details
			 WHERE     cl_status = 'OPEN'
				   AND bill_type <> 'AN'
				   AND bill_element NOT LIKE 'Payment%'
				   AND BILL_PERIOD <= '".$param['period']."'
				   AND EXISTS
						  (SELECT 1
							 FROM cust_rinta_np_mfee
							WHERE     pgl_id = ".$param['pgl_id']."
								  --AND ten_id = ".$param['ten_id']."
								  AND BILL_PRD = '".$param['period']."'
								  AND account_num = IDNUMBER) ";
        }
        $sql2 = "SELECT COUNT(*) COUNT FROM ( ";
        $sql3 =	"SELECT IDNUMBER,NPER,
					CA,
					NIPNAS,
					BPNAME,
					PRODUK,
					UBIS ,
					SEGMEN ,
					SUBSEGMEN ,
					BISNIS_AREA ,
					DIVISI,
					WITEL,
					BILL_PERIOD,
					DUE_DATE,
					BILL_ELEMENT            ,
					ACCOUNT,
					BILL_AMOUNT
			  FROM trem_np_details
			 WHERE     cl_status = 'OPEN'
				   AND bill_type <> 'AN'
				   AND bill_element NOT LIKE 'Payment%'
				   AND BILL_PERIOD <= '".$param['period']."'
				   AND EXISTS
						  (SELECT 1
							 FROM cust_rinta_np_mfee
							WHERE     pgl_id = ".$param['pgl_id']."
								  AND ten_id = ".$param['ten_id']."
								  AND BILL_PRD = '".$param['period']."'
								  AND account_num = IDNUMBER) )";
        // $sql_where = ") WHERE RN BETWEEN $rowstart AND $rowend";
		
        $sql = $sql2." ".$sql3;
        if($wh != "" or $wh != null){
            $sql .= $wh;
        }
        // die($sql);
        $qs = $db2->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;

    }
	/*batas dt tunggakan*/
	
	
	/*--DATA MY COIN--*/
		public function getMycoins($param) {
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
			// if($param['ten_id'] == ""){
				// $sql =  "SELECT ROWNUM RN, a.*
						   // FROM V_RINTA_COID a
						  // WHERE a.pgl_id =". $param['pgl_id']."
							    // AND a.DATA_SOURCE_ID = ". $param['dtsc_id']."
								// AND a.BULAN_TAGIH = '".$param['period']."'";
			// }
			
			$sql2 = "SELECT * FROM ( ";
			$sql3 =  "SELECT ROWNUM RN, a.*
						   FROM V_RINTA_COID a
						  WHERE a.pgl_id =". $param['pgl_id']."
							    AND a.DATA_SOURCE_ID = ". $param['dtsc_id']."
								AND a.BULAN_TAGIH = '".$param['period']."'";
			$sql_where = ") WHERE RN BETWEEN $rowstart AND $rowend";
			

			$sql = $sql2." ".$sql3." ".$sql_where;
			
			// die($sql);
			 
			if($wh != "" or $wh != null){
				$sql .= $wh;
			}
			  // die($sql);
			$qs = $db2->query($sql);
			return $qs;

		}
		
		public function getMycoinsCount($param) {
		// die("sa");
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
		
        $sql2 = "SELECT COUNT(*) COUNT FROM ( ";
        $sql3 =  "SELECT ROWNUM RN, a.*
						   FROM V_RINTA_COID a
						  WHERE a.pgl_id =". $param['pgl_id']."
							    AND a.DATA_SOURCE_ID = ". $param['dtsc_id']."
								AND a.BULAN_TAGIH = '".$param['period']."' )";

        $sql = $sql2." ".$sql3;
        if($wh != "" or $wh != null){
            $sql .= $wh;
        }
        // die($sql);
        $qs = $db2->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;

    }
		
	
	public function getIdeas($param) {
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
			// if($param['ten_id'] == ""){
				// $sql =  "SELECT ROWNUM RN, a.*
						   // FROM V_RINTA_COID a
						  // WHERE a.pgl_id =". $param['pgl_id']."
							    // AND a.DATA_SOURCE_ID = ". $param['dtsc_id']."
								// AND a.BULAN_TAGIH = '".$param['period']."'";
			// }
			
			$sql2 = "SELECT * FROM ( ";
			$sql3 =  "SELECT ROWNUM RN, a.*
						   FROM V_RINTA_COID_IDEAS a
						  WHERE a.pgl_id =". $param['pgl_id']."
							    AND a.DATA_SOURCE_ID = ". $param['dtsc_id']."
								AND a.BULAN_TAGIH = '".$param['period']."'";
			$sql_where = ") WHERE RN BETWEEN $rowstart AND $rowend";
			

			$sql = $sql2." ".$sql3." ".$sql_where;
			
			// die($sql);
			 
			if($wh != "" or $wh != null){
				$sql .= $wh;
			}
			  // die($sql);
			$qs = $db2->query($sql);
			return $qs;

		}
		
		public function getIdeasCount($param) {
		// die("sa");
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
		
        $sql2 = "SELECT COUNT(*) COUNT FROM ( ";
        $sql3 =  "SELECT ROWNUM RN, a.*
						   FROM V_RINTA_COID_IDEAS a
						  WHERE a.pgl_id =". $param['pgl_id']."
							    AND a.DATA_SOURCE_ID = ". $param['dtsc_id']."
								AND a.BULAN_TAGIH = '".$param['period']."' )";

        $sql = $sql2." ".$sql3;
        if($wh != "" or $wh != null){
            $sql .= $wh;
        }
         // die($sql);
        $qs = $db2->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;

    }
		
		
		
		
	/*--END--*/
	
	public function getTunggakan($param) {
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
            $sql = "SELECT *
					FROM V_DEBT_POST_SUM
					WHERE I_PGL_ID = ".$param['pgl_id']." 
						  AND PERIOD_COL <= '".$param['period']."'";
        }
        $sql2 = "SELECT * FROM ( ";
        $sql3 = "SELECT ROWNUM RN ,A.*
					FROM V_DEBT_POST_SUM A
					WHERE I_PGL_ID = ".$param['pgl_id']." 
						  AND PERIOD_COL <= '".$param['period']."' 
						  AND TEN_ID =".$param['ten_id'];
        $sql_where = ") WHERE RN BETWEEN $rowstart AND $rowend";

        $sql = $sql2." ".$sql3." ".$sql_where;
        if($wh != "" or $wh != null){
            $sql .= $wh;
        }
          // die($sql);
        $qs = $db2->query($sql);
        return $qs;

    }
	
	public function getTunggakanCount($param) {
		// die("sa");
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
            $sql = "SELECT *
				FROM V_DEBT_POST_SUM
				WHERE I_PGL_ID = ".$param['pgl_id']." 
					  AND PERIOD_COL <= '".$param['period']."'";
        }
        $sql2 = "SELECT COUNT(*) COUNT FROM ( ";
        $sql3 = "SELECT *
					FROM V_DEBT_POST_SUM
					WHERE I_PGL_ID = ".$param['pgl_id']." 
						  AND PERIOD_COL <= '".$param['period']."' 
						  AND TEN_ID =".$param['ten_id'].
				")";
        // $sql_where = ") WHERE RN BETWEEN $rowstart AND $rowend";
		
        $sql = $sql2." ".$sql3;
        if($wh != "" or $wh != null){
            $sql .= $wh;
        }
        // die($sql);
        $qs = $db2->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;

    }
		
	
	/*batas enhance  -- 03-4-2017*/

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
            $sql = "SELECT b.nd nd1,b.AKTIF,b.ADDRESS, decode(d.flag,2,'M4L',1,'SIN','MARKETING_FEE') flag,E.DIVISI, A.* ".
                " FROM CUST_RINTA PARTITION(PERIOD_".$param['period'].") A, TEN_ND B, PGL_TEN C, CC_DATAREF@NONPOTS_OP D,V_DIVISI_PT E ".
                " WHERE C.TEN_ID(+)=B.TEN_ID AND B.ND(+)=A.ND AND A.ND = D.P_NOTEL(+) AND A.NCLI = E.NCLI(+) AND C.PGL_ID=".$param['pgl_id'];
        }
        $sql2 = "SELECT * FROM ( ";
        $sql3 = "SELECT ROWNUM RN,b.nd nd1,b.AKTIF,b.ADDRESS,decode(d.flag,2,'M4L',1,'SIN','MARKETING_FEE') flag,E.DIVISI,A.* ".
            " FROM CUST_RINTA PARTITION(PERIOD_".$param['period'].") A, TEN_ND B, CC_DATAREF@NONPOTS_OP D,V_DIVISI_PT E WHERE A.ND(+)=B.ND AND A.ND = D.P_NOTEL(+) AND A.NCLI = E.NCLI(+) AND B.TEN_ID=".$param['ten_id'];

        $sql_where = ") WHERE RN BETWEEN $rowstart AND $rowend";

        $sql = $sql2." ".$sql3." ".$sql_where;
        if($wh != "" or $wh != null){
            $sql .= $wh;
        }
        // die($sql);
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
			
            $sql = "SELECT b.nd nd1,b.AKTIF, decode(d.flag,2,'M4L',1,'SIN','MARKETING_FEE') flag, A.* ".
                " FROM CUST_RINTA PARTITION(PERIOD_".$param['period'].") A, TEN_ND B, PGL_TEN C, CC_DATAREF@NONPOTS_OP D,V_DIVISI_PT E ".
                " WHERE C.TEN_ID(+)=B.TEN_ID AND B.ND(+)=A.ND AND A.ND = D.P_NOTEL(+) AND A.NCLI = E.NCLI(+) AND C.PGL_ID=".$param['pgl_id'];
        }
        $sql2 = "SELECT COUNT(*) COUNT FROM ( ";
        $sql3 = "SELECT ROWNUM RN,b.nd nd1,A.* ".
            " FROM CUST_RINTA PARTITION(PERIOD_".$param['period'].") A, TEN_ND B, CC_DATAREF@NONPOTS_OP D,V_DIVISI_PT E WHERE A.ND(+)=B.ND AND A.ND = D.P_NOTEL(+) AND A.NCLI = E.NCLI(+) AND B.TEN_ID=".$param['ten_id'].")";

        $sql = $sql2." ".$sql3;
        if($wh != "" or $wh != null){
            $sql .= $wh;
        }
        //die($sql);
        $qs = $db2->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;

    }
	
	/*--Excel Rinta Coin 3-13-2017 by RND--*/
	   public function excelRintaCoin($period, $pgl_id, $dtsc_id){
        $db2 = $this->load->database('default2', TRUE);
        $result = array();
       $sql =  "SELECT  a.*
						   FROM V_RINTA_COID a
						  WHERE a.pgl_id =". $pgl_id."
							    AND a.DATA_SOURCE_ID = ". $dtsc_id."
								AND a.BULAN_TAGIH = '".$period."' ";
        $qs = $db2->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }
	
	   public function excelRintaIdeas($period, $pgl_id, $dtsc_id){
        $db2 = $this->load->database('default2', TRUE);
        $result = array();
       $sql =  "SELECT  a.*
						   FROM V_RINTA_COID_IDEAS a
						  WHERE a.pgl_id =". $pgl_id."
							    AND a.DATA_SOURCE_ID = ". $dtsc_id."
								AND a.BULAN_TAGIH = '".$period."' ";
        $qs = $db2->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }
	
	
	
    public function excelRinta($period, $pgl_id, $ten_id){
        $db2 = $this->load->database('default2', TRUE);
        $result = array();
        $sql = "SELECT b.nd nd1,A.*,decode(d.flag,2,'M4L',1,'SIN','MARKETING_FEE') flag,E.DIVISI
                FROM
                CUST_RINTA PARTITION(PERIOD_".$period.") A,
                TEN_ND B, CC_DATAREF@NONPOTS_OP D,V_DIVISI_PT E
                WHERE A.ND(+)=B.ND AND A.ND = D.P_NOTEL(+) AND A.NCLI = E.NCLI(+) AND B.TEN_ID=".$ten_id;
        $qs = $db2->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }
	
	public function excelFastelTugPots($pgl_id, $ten_id, $period){
		
		$db2 = $this->load->database('default2', TRUE);
        $result = array();
        $sql = "SELECT *
				FROM V_DEBT_POST_SUM
				WHERE I_PGL_ID = ".$pgl_id." 
					  AND PERIOD_COL <= '".$period."' 
					  AND TEN_ID =".$ten_id;
        $qs = $db2->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }
	
		public function excelFastelTugDT($pgl_id, $ten_id, $period){
		$db2 = $this->load->database('default2', TRUE);
        $result = array();
          $sql =	"SELECT IDNUMBER,NPER,
					CA,
					NIPNAS,
					BPNAME,
					PRODUK,
					UBIS ,
					SEGMEN ,
					SUBSEGMEN ,
					BISNIS_AREA ,
					DIVISI,
					WITEL,
					BILL_PERIOD,
					DUE_DATE,
					BILL_ELEMENT            ,
					ACCOUNT,
					BILL_AMOUNT
			  FROM trem_np_details
			 WHERE     cl_status = 'OPEN'
				   AND bill_type <> 'AN'
				   AND bill_element NOT LIKE 'Payment%'
				   AND BILL_PERIOD <= '".$period."'
				   AND rownum <=10
				   AND EXISTS
				      (SELECT 1
						 FROM cust_rinta_np_mfee
							WHERE     pgl_id = ".$pgl_id."
								AND ten_id = ".$ten_id."
								AND BILL_PRD = '".$period."'
								AND account_num = IDNUMBER)
								  ";

		$qs = $db2->query($sql);
        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }

		public function excelFastel($period, $pgl_id){
        // $db2 = $this->load->database('default2', TRUE);
        $result = array();
        $sql = "SELECT ACCOUNT_NUM, DIVISI_OP, PRODUCT_LABEL, PRODUCT_NAME,
					ADDRESS_NAME, PRODUCT_MNY, ABONDEMEN,
					RESTITUSI, LAIN_LAIN, FLAG_BYR,CUST_NAME, PROD_PERIOD
					FROM V_CUST_RINTA_NP
						WHERE PGL_ID = ".$pgl_id." AND BILL_PRD = ".$period;

        $qs =$this->db->query($sql);
				if($qs->num_rows() > 0) $result = $qs->result();
				return $result;

		return $result;

    }
	
	// This Part Made By Zen
	public function parsingTemplate(){
		$result = array();
		$sql = "select Name, HashTag from HashTagTemplate";
		$qs = $this->db->query($sql);
		if($qs->num_rows() > 0) $result = $qs->result();
		return $result;
	}
	
	public function postDocTemp($data1, $data2, $data3, $data4, $data5, $data6){	
		$sql = "insert into DOC (doc_id,doc_type_id,file_path, update_date, update_by, doc_name, description,content,doc_lang_id) 
		values(doc_inc_id.nextval,1,'/default_path', sysdate,'".$data4."','".$data1."','".$data2."','".$data3."',".$data5.")";
		$this->db->query($sql);
	}
	
	public function TestInsert($data1,$data2,$data3){
		//$data2 = 4567;
		$sql = "insert into TestCI (test123, numnum) values ('".$data1."',".$data2.")";
		$this->db->query($sql);
	}
	public function mapDatinRequest(){
		$result = array();
        $sql = "SELECT PGL_NAME ,ACCOUNT_NAME
				FROM  CUST_PGL 
				FULL OUTER JOIN MV_LIS_ACCOUNT_NP 
				ON PGL_NAME = ACCOUNT_NUM";
		$sql .= " ORDER BY PGL_NAME";
        $q = $this->db->query($sql);
        if($q->num_rows() > 0) {
            $result = $q->result();
        }
	 return $result;
	}
	public function selectFile($data1){
        $sql = "SELECT CONTENT FROM DOC  
				WHERE DOC_ID = :data1";	
		$parse = OCIParse($this->db->conn_id, $sql);
		OCIBindByName($parse, ':data1', $data1 );
		OCIExecute($parse);
			// print_r($parse);
			
			while (OCIFetchInto($parse,$arr,OCI_ASSOC)){
				if(isset($arr["CONTENT"])){
				if($arr["CONTENT"]){
					$ret = $arr["CONTENT"]->load();
				} 
				} else $ret = ""; 
			} 
		
        return $ret;
	}
	public function deleteDOC($data1){
		$sql1 = "DELETE FROM V_DOC WHERE DOC_ID = ".$data1;
		$sql2 = "DELETE FROM DOC WHERE DOC_ID = ".$data1;
		$this->db->query($sql1);
		$this->db->query($sql2);
	}
	public function updateDOC($data1,$data2){
		$sql2 = "UPDATE DOC SET CONTENT = :data1 WHERE DOC_ID = :data2";
		// $this->db->query($sql2);
		
		$parse = OCIParse($this->db->conn_id, $sql2);
		OCIBindByName($parse, ':data1', $data1 );
		OCIBindByName($parse, ':data2', $data2 );
		OCIExecute($parse);
		// print_r($parse);
		print_r($data1);
		print_r("|");
		print_r($data2);
	}
	//End By Zen
    
    public function excelRintaFromNPK($period, $pgl_id){
        $db2 = $this->load->database('default2', TRUE);
        $result = array();
        $sql = "SELECT b.nd nd1,A.*,
                FROM CUST_RINTA PARTITION(PERIOD_".$period.") A, TEN_ND B, PGL_TEN C, CC_DATAREF@NONPOTS_OP D
                WHERE C.TEN_ID(+)=B.TEN_ID AND B.ND(+)=A.ND AND A.ND = D.P_NOTEL(+) AND C.PGL_ID=".$pgl_id;

        $qs = $db2->query($sql);
        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }
	
}