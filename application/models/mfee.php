<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mfee extends CI_Model
{

    public function getCCbySEGMEN($segmen)
    {
        $q = "SELECT NIP_NAS ID,STANDARD_NAME NAME FROM cbase_dives_2016@DWHMART_AON WHERE SEGMEN = '".$segmen."' ORDER BY STANDARD_NAME ASC ";
        $sql = $this->db->query($q);
        return $sql;
    }

    public function getMitraByCC($ccid)
    {
        $q = "SELECT  DISTINCT a.PGL_ID ID,a.PGL_NAME NAME FROM CUST_PGL a,p_map_mit_cc b WHERE b.ID_CC = ".$ccid." AND a.PGL_ID = b.PGL_ID  ";
        $sql = $this->db->query($q);
        return $sql;
    }
    public function getLokasisewaByMitra($mitra)
    {
        $q = "SELECT LOKASI NAME,P_MP_LOKASI_ID ID FROM P_MP_LOKASI a,P_MAP_MIT_CC b WHERE b.PGL_ID = '".$mitra."' AND a.P_MAP_MIT_CC_ID = b.P_MAP_MIT_CC_ID";
        $sql = $this->db->query($q);
        return $sql;
    }

    public function checkDuplicateND($ten_id,$nd) {
        $this->db->where('ND',$nd);
        $this->db->where('TEN_ID',$ten_id);
        $query = $this->db->get('TEN_ND');

        return  $query->num_rows();

    }

    public function checkDuplicate($table,$field,$value) {
        $this->db->where($field,$value);
        $query = $this->db->get($table);

        return  $query->num_rows();

    }


}