<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_skembis extends CI_Model
{

    public function getComfeeByProduct()
    {
        $this->db->where('CF_TYPE', 'UDEF');
        return $this->db->get('COM_FEE')->result_array();

    }
    public function getCompfeeSMRY()
    {
        $this->db->where('CF_TYPE', 'SMRY');
        $this->db->where_not_in('CF_NAME', array('PPN','BHP_JASTEL','MARFEE_BEFORE_TAX'));
        return $this->db->get('COM_FEE')->result_array();

    }

    public function getSchmByID($id){
        $this->db->where('SCHM_FEE_ID', $id);
        return $this->db->get('V_SKEMBIS')->result_array();
    }

    public function createSkema($arrComp)
    {
        date_default_timezone_set('Asia/Jakarta');
        $table = "SCHM_FEE";
        $pgl_id = $this->input->post("form_pgl_id");
        $skema_id = $this->input->post("form_skembis_type");
        $CREATED_DATE = date('d-M-Y');
        $VALID_FROM = date('d-M-Y');
        $CREATED_BY = $this->session->userdata('d_user_name');

        $q = $this->db->query("SELECT nvl(MAX(SCHM_FEE_ID),0)+1 id FROM SCHM_FEE");
        $schm_id = $q->row(0)->ID;

        for ($i = 0; $i < count($arrComp); $i++) {
            $data = array('CF_ID' => $arrComp[$i]['CF_ID'],
                'SCHM_FEE_ID' => $schm_id,
                'PGL_ID' => $pgl_id,
                'METHOD_ID' => $skema_id,
                'PERCENTAGE' => $arrComp[$i]['VALUE'],
                'CREATED_BY' => $CREATED_BY,
                'CREATED_DATE' => $CREATED_DATE,
                'VALID_FROM' => $VALID_FROM
            );
            $this->db->insert($table,$data);
        }

        $smry = $this->getCompfeeSMRY();
        foreach ($smry as $smryfee) {
            $this->db->insert($table,array( 'SCHM_FEE_ID' => $schm_id,
                'CF_ID' => $smryfee['CF_ID'],
                'PGL_ID' => $pgl_id,
                'METHOD_ID' => $skema_id,
                'PERCENTAGE' => 0,
                'CREATED_BY' => $CREATED_BY,
                'CREATED_DATE' => $CREATED_DATE,
                'VALID_FROM' => $VALID_FROM)
            );

        }
    }

    public function clearSkemaByID($pgl_id,$SCHM_FEE_ID,$skema_id){
        $this->db->where('PGL_ID', $pgl_id);
        $this->db->where('SCHM_FEE_ID', $SCHM_FEE_ID);
        $this->db->where('METHOD_ID', $skema_id);
        $this->db->delete('SCHM_FEE');
    }

    public function editSkema($arrComp)
    {
        date_default_timezone_set('Asia/Jakarta');
        $table = "SCHM_FEE";
        $pgl_id = $this->input->post("PGL_ID");
        $SCHM_FEE_ID = $this->input->post("SCHM_FEE_ID");
        $skema_id = $this->input->post("METHOD_ID");

        $CREATED_DATE = date('d-M-Y');
        $VALID_FROM = date('d-M-Y');
        $CREATED_BY = $this->session->userdata('d_user_name');

        // Clear Skema before insert
        $this->clearSkemaByID($pgl_id,$SCHM_FEE_ID,$skema_id);

        for ($i = 0; $i < count($arrComp); $i++) {
            $data = array('CF_ID' => $arrComp[$i]['CF_ID'],
                'SCHM_FEE_ID' => $SCHM_FEE_ID,
                'PGL_ID' => $pgl_id,
                'METHOD_ID' => $skema_id,
                'PERCENTAGE' => $arrComp[$i]['VALUE'],
                'CREATED_BY' => $CREATED_BY,
                'CREATED_DATE' => $CREATED_DATE,
                'VALID_FROM' => $VALID_FROM
            );
            $this->db->insert($table,$data);
        }

        $smry = $this->getCompfeeSMRY();
        foreach ($smry as $smryfee) {
            $this->db->insert($table,array( 'SCHM_FEE_ID' => $SCHM_FEE_ID,
                    'CF_ID' => $smryfee['CF_ID'],
                    'PGL_ID' => $pgl_id,
                    'METHOD_ID' => $skema_id,
                    'PERCENTAGE' => 0,
                    'CREATED_BY' => $CREATED_BY,
                    'CREATED_DATE' => $CREATED_DATE,
                    'VALID_FROM' => $VALID_FROM)
            );

        }
    }

    private function cekNPK($pgl_id,$periode,$skema_id){
        $this->db->where(array('PGL_ID' => $pgl_id, 'PERIOD' => $periode, 'SCHM_FEE_ID'=>$skema_id));
        $query = $this->db->get('NPK_FEE');
        return $query;
    }

    public function calculateMF(){
        $this->db->_protect_identifiers = false;
        $pgl_id = $this->input->post('pgl_id');
        $skema_id = $this->input->post('skema_id');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $periode = $tahun."".$bulan;

        $this->db->trans_begin();

        // Cek apakah NPK nya sudah ada, jika belum insert
        $npk = $this->cekNPK($pgl_id,$periode,$skema_id);
        if($npk->num_rows() > 0){
           $npk_id = $npk->row_array(1)['NPK_FEE_ID'];
            $output['success'] = true;
            $output['message'] = 'Skema ';

        }else{
            // Insert ke NPK_FEE
            $npk_id = gen_id('NPK_FEE_ID', 'NPK_FEE');
            $data = array('NPK_FEE_ID' => intval($npk_id),
                'PGL_ID' => intval($pgl_id),
                'PERIOD' => $periode,
                'SCHM_FEE_ID' => $skema_id,
                'UPDATE_DATE' => date('d/M/Y'),
                'UPDATE_BY' =>$this->session->userdata('d_user_name')
            );
            $this->db->insert('NPK_FEE',$data);
        }

        // Calculate MF
        $sql = "  BEGIN ".
            "  PCKG_CAL_NPK_FEE.MAIN_CAL_NPK(:params1,:params2, :params3); END;";

        $params = array(
            array('name' => ':params1', 'value' => $periode, 'type' => SQLT_CHR, 'length' => 6),
            array('name' => ':params2', 'value' => $pgl_id, 'type' => SQLT_INT, 'length' => 11),
            array('name' => ':params3', 'value' => $npk_id, 'type' => SQLT_INT, 'length' => 11)
        );
        // Bind the output parameter

        $stmt = oci_parse($this->db->conn_id,$sql);
        foreach($params as $p){
            // Bind Input
            oci_bind_by_name($stmt,$p['name'], $p['value'], $p['length']);
        }

        ociexecute($stmt);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $output['success'] = true;
            $output['message'] = 'Proses Calculate berhasil !';
            echo json_encode($output);
            $this->db->trans_commit();
        }
    }

    public function getListSchmNPK($pgl_id,$periode){
        $this->db->select('SCHM_FEE_ID');
        $this->db->where('PGL_ID',$pgl_id);
        $this->db->where('PERIOD',$periode);
        $q = $this->db->get('NPK_FEE');

        $result = array();

        foreach ($q->result_array() as $row)
        {
           $result[] = $row['SCHM_FEE_ID'];
        }
        return $result;
    }

    public function addFlatSkema(){
        date_default_timezone_set('Asia/Jakarta');
        $table = "SCHM_FEE";
        $pgl_id = $this->input->post("form_pgl_id");
        $skema_id = $this->input->post("form_skembis_type");
        $flat_revenue = $this->input->post("flat_revenue");
        $CREATED_DATE = date('d-M-Y');
        $VALID_FROM = date('d-M-Y');
        $CREATED_BY = $this->session->userdata('d_user_name');

        $q = $this->db->query("SELECT nvl(MAX(SCHM_FEE_ID),0)+1 id FROM SCHM_FEE");
        $schm_id = $q->row(0)->ID;

        $data = array(
            'SCHM_FEE_ID' => $schm_id,
            'PGL_ID' => $pgl_id,
            'METHOD_ID' => $skema_id,
            'NET_REVENUE' => $flat_revenue,
            'CREATED_BY' => $CREATED_BY,
            'CREATED_DATE' => $CREATED_DATE,
            'VALID_FROM' => $VALID_FROM
        );
        $this->db->insert($table,$data);

        if ($this->db->affected_rows() > 0) {
            $datas["success"] = true;
            $datas["message"] = "Skema berhasil ditambahakan";
        } else {
            $datas["success"] = false;
            $datas["message"] = "Gagal menambah data";
        }
        echo json_encode($datas);
    }



}