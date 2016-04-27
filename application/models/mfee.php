<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mfee extends CI_Model
{

    public function getCCbySEGMEN($segmen)
    {
        $q = "SELECT ID,CC NAME FROM MV_PARAM_SEGMENT_CC WHERE CODE_SGM = '" . $segmen . "' ORDER BY CC ASC ";
        $sql = $this->db->query($q);
        return $sql;
    }

    public function getCCbySEGMENPGL_ID($segmen)
    {
        $q = "SELECT ID,CC NAME FROM MV_PARAM_SEGMENT_CC
                WHERE ID IN
                (
                SELECT ID_CC FROM P_MAP_MIT_CC WHERE PGL_ID = " . $this->session->userdata('d_pgl_id') . "
                ) AND CODE_SGM = '" . $segmen . "'";
        $sql = $this->db->query($q);
        return $sql;
    }

    public function getMitraByCC($ccid)
    {
        $q = "SELECT  DISTINCT a.PGL_ID ID,a.PGL_NAME NAME FROM CUST_PGL a,p_map_mit_cc b WHERE b.ID_CC = " . $ccid . " AND a.PGL_ID = b.PGL_ID  ";
        $sql = $this->db->query($q);
        return $sql;
    }

    public function getMitraByCCPGL_ID($ccid)
    {
        $q = "SELECT  DISTINCT a.PGL_ID ID,a.PGL_NAME NAME
                FROM CUST_PGL a,p_map_mit_cc b
                WHERE b.PGL_ID = " . $this->session->userdata('d_pgl_id') . "
                         AND b.ID_CC = " . $ccid . " AND a.PGL_ID = b.PGL_ID";
        $sql = $this->db->query($q);
        return $sql;
    }

    public function getLokasisewaByMitra($mitra)
    {
        $q = "SELECT LOKASI NAME,P_MP_LOKASI_ID ID FROM P_MP_LOKASI a,P_MAP_MIT_CC b WHERE b.PGL_ID = '" . $mitra . "' AND a.P_MAP_MIT_CC_ID = b.P_MAP_MIT_CC_ID";
        $sql = $this->db->query($q);
        return $sql;
    }

    public function checkDuplicateND($ten_id, $nd)
    {
        $this->db->where('ND', $nd);
        $this->db->where('TEN_ID', $ten_id);
        $query = $this->db->get('TEN_ND');

        return $query->num_rows();

    }

    public function checkDuplicateND_NP($ten_id, $sid)
    {
        $this->db->where('PRODUCT_ID', $sid);
        $this->db->where('TEN_ID', $ten_id);
        $query = $this->db->get('TEN_ND_NP');

        return $query->num_rows();

    }

    public function checkDuplicate($table, $field, $value)
    {
        $this->db->where($field, $value);
        $query = $this->db->get($table);

        return $query->num_rows();

    }

    public function checkDuplicated($table, $field)
    {
        $this->db->where($field);
        $query = $this->db->get($table);

        return $query->num_rows();

    }


}