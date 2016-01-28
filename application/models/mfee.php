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
        $q = "SELECT DISTINCT(NAMA_MITRA) NAME,ID_MITRA ID FROM p_map_mit_cc WHERE ID_CC = ".$ccid;
        $sql = $this->db->query($q);
        return $sql;
    }
    public function getLokasisewaByMitra($mitra_name)
    {
        $q = "SELECT LOKASI_SEWA NAME,ID_MITRA ID FROM p_map_mit_cc WHERE NAMA_MITRA = '".$mitra_name."'";
        $sql = $this->db->query($q);
        return $sql;
    }


}