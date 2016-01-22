<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mfee extends CI_Model
{

    public function getCCbySEGMEN($segmen)
    {
        $q = "SELECT NIP_NAS ID,STANDARD_NAME NAME FROM cbase_dives_2016@DWHMART_AON WHERE SEGMEN = '".$segmen."' ORDER BY STANDARD_NAME ASC ";
        $sql = $this->db->query($q)->result();
        return $sql;
    }

}