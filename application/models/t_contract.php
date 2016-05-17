<?php

class T_contract extends CI_Model
{

    function __construct() {
        parent::__construct();

        $this->load->helper('sequence');
    }

    public function getPieChart(){
        $result = array();
        $sql = $this->db->query("select s01 as tahun,
                                        s02 as status,
                                        n01 as pct,
                                        n02 as jml_inv,
                                        n03 as total_jml_inv
                                from table(pack_report_kontrak.f_summary_grafik('".$this->session->userdata('d_user_name')."'))");
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;
    }

    public function getSumMonth(){
        $result = array();
        $sql = $this->db->query("select s01 as bulan,
                                 s02 as status,
                                 n02 as jml_inv,
                                 n03 as total_nilai_inv
                                from table(pack_report_kontrak.f_summary_current_month('".$this->session->userdata('d_user_name')."'))");
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;
    }

    public function getSumYear(){
        $result = array();
        $sql = $this->db->query("select s01 as tahun,
                                   s02 as bln_num,
                                   s03 as bln_char,
                                   s04 as status_input,
                                   n02 as jml_inv,
                                   n03 as total_nilai_inv,
                                   s05 as status_proses,
                                   n04 as jml_inv2,
                                   n05 as total_nilai_inv2,
                                   s05 as status_selesai,
                                   n06 as jml_inv3,
                                   n07 as total_nilai_inv3
                                from table(pack_report_kontrak.f_summary_current_year('".$this->session->userdata('d_user_name')."'))");
        if($sql->num_rows() > 0)
            $result = $sql->result();
        return $result;
    }
}