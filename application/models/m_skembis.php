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
        $this->db->where_not_in('CF_NAME', array('PPN','BPH_JASTEL'));
        return $this->db->get('COM_FEE')->result_array();

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


}