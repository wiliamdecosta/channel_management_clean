<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_summary extends CI_Model
{

    public function getSummaryMitra()
    {
        return $this->db->get('V_SUMMARY_MITRA')->result_array();
    }

    public function getListMitraBySegment()
    {
        $q = "SELECT *
                    FROM V_MAP_MIT_CC
                    WHERE
                    ID_CC IN (SELECT ID FROM MV_PARAM_SEGMENT_CC WHERE CODE_SGM = '" . $this->input->post('segment') . "')
                    ORDER BY PGL_NAME";

        return $this->db->query($q)->result_array();
    }

    public function addListItem()
    {
        $item_id = intval($this->input->post('form_list_item'));
        $qty = intval($this->input->post('qty'));

        $table = "PURCHASE_ORDER";
        $pk = "PURCHASE_ORDER_ID";
        $am_id = intval($this->session->userdata('d_user_id'));
        $new_id = gen_id($pk, $table);


        $this->db->set($pk, intval($new_id));
        $this->db->set('CREATED_DATE', "SYSDATE", FALSE);
        $this->db->set('CREATED_BY', $this->session->userdata('d_user_name'));

        $data = array('ORDER_QTY' => $qty,
            'P_INVENTORY_ID' => $item_id,
            'P_DAT_AM' => $am_id,
            'STATUS' => 18 // Waiting (P_REFERENCE_LIST

        );

        // Cek Jumlah quantity & jumlah req
        $qty_stok = intval($this->getQty($item_id));
        $cekRequest = $this->cekRquest($item_id, $am_id);

        if ($qty > $qty_stok) {
            $status["success"] = false;
            $status["message"] = "Request tidak boleh melebihi stok !";
            echo json_encode($status);
            return false;
        }
        if ($cekRequest == 1) {
            $status["success"] = false;
            $status["message"] = "Anda telah melakukan request dengan item yang sama sebelumnya !";
            echo json_encode($status);
            return false;
        }

        $this->db->trans_begin();

        // Insert ke PO
        $this->db->insert($table, $data);

        //Update Status Qty Inventory
        $this->db->where('P_INVENTORY_ID', $item_id);
        $this->db->set('QTY', ($qty_stok - $qty));
        $this->db->set('UPDATE_DATE', "SYSDATE", FALSE);
        $this->db->set('UPDATE_BY', 'SYSTEM');
        $this->db->update('P_INVENTORY');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $status['success'] = true;
            $status['message'] = "Request berhasil disubmit";
            echo json_encode($status);
            $this->db->trans_commit();
        }
        return true;

    }

    public function getQty($item_id)
    {
        $this->db->where('P_INVENTORY_ID', $item_id);
        $query = $this->db->get('P_INVENTORY');

        if ($query->num_rows() > 0) {
            return $row = $query->row()->QTY;
        }

    }

    public function cekRquest($item_id, $am_id)
    {
        $this->db->where('P_INVENTORY_ID', $item_id);
        $this->db->where('P_DAT_AM', $am_id);
        $this->db->where('STATUS', 18);
        $query = $this->db->get('PURCHASE_ORDER');
        return $query->num_rows();
    }

    public function getTrendMFData()
    {
        $periode = $this->input->post('periode');
        $segments = $this->input->post('segment');
        $skema_id = $this->input->post('skema_id');


        $this->db->select('CODE_SGM');
        $this->db->select('PERIOD');
        $this->db->select_sum('FEE_TO_SHARE');

        if ($periode) {
            $period = explode(' - ', $periode);

            $where = "TO_DATE (PERIOD, 'YYYYMM') BETWEEN TO_DATE ($period[0], 'YYYYMM') AND TO_DATE ($period[1], 'YYYYMM')";
            $this->db->where($where);
        }
        if ($segments) {
            $this->db->where('CODE_SGM', $segments);
        }
        if ($skema_id) {
            $this->db->where('METHOD_ID', (int)$skema_id);
        }

        $this->db->group_by(array("CODE_SGM", "PERIOD"));
        $this->db->order_by("PERIOD");
        $q = $this->db->get('V_SUMMARY_MARFEE_NPK');

        return $q->result_array();
    }
}