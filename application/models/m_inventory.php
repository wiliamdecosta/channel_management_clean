<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_inventory extends CI_Model
{
    public function editStok()
    {
        $item_id = intval($this->input->post('form_list_item'));
        $qty = abs(intval($this->input->post('qty')));

        $action = $this->input->post('action');

        $qty_stok = intval($this->getQty($item_id));

        if ($action == "tambah") {
            //Update Status Qty Inventory
            $this->db->trans_begin();

            $this->db->where('P_INVENTORY_ID', $item_id);
            $this->db->set('QTY', ($qty_stok + $qty));
            $this->db->set('UPDATE_DATE', "SYSDATE", FALSE);
            $this->db->set('UPDATE_BY', $this->session->userdata('d_user_name'));
            $this->db->update('P_INVENTORY');

            // Insert Log
            $new_id = gen_id('INVENTORY_LOG_ID', 'INVENTORY_LOG');
            $data = array('INVENTORY_LOG_ID' => intval($new_id),
                'P_INVENTORY_ID' => $item_id,
                'QTY' => $qty,
                'DESCRIPTION' => 'Tambah Stok'
            );
            $this->db->set('UPDATED_DATE', "SYSDATE", FALSE);
            $this->db->set('UPDATED_BY', $this->session->userdata('d_user_name'));
            $this->db->insert('INVENTORY_LOG', $data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $status['success'] = true;
                $status['message'] = "Stok berhasil ditambah";
                echo json_encode($status);
                $this->db->trans_commit();
            }

        } elseif ($action == "kurang") {
            //Update Status Qty Inventory
            $this->db->trans_begin();

            if (($qty_stok - $qty) < 0) {
                $status["success"] = false;
                $status["message"] = "Maksimal pengurangan stok adalah " . $qty_stok . "!";
                echo json_encode($status);
                return false;
            } else {
                $this->db->trans_begin();
                $this->db->where('P_INVENTORY_ID', $item_id);
                $this->db->set('QTY', ($qty_stok - $qty));
                $this->db->set('UPDATE_DATE', "SYSDATE", FALSE);
                $this->db->set('UPDATE_BY', $this->session->userdata('d_user_name'));
                $this->db->update('P_INVENTORY');

                // Insert Log
                $new_id = gen_id('INVENTORY_LOG_ID', 'INVENTORY_LOG');
                $data = array('INVENTORY_LOG_ID' => $new_id,
                    'P_INVENTORY_ID' => $item_id,
                    'QTY' => $qty,
                    'DESCRIPTION' => 'Kurangi Stok'
                );
                $this->db->set('UPDATED_DATE', "SYSDATE", FALSE);
                $this->db->set('UPDATED_BY', $this->session->userdata('d_user_name'));
                $this->db->insert('INVENTORY_LOG', $data);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $status['success'] = true;
                    $status['message'] = "Stok berhasil dikurangi";
                    echo json_encode($status);
                    $this->db->trans_commit();
                }
            }

        } else {
            $status['success'] = false;
            $status['message'] = "Error action!!";
            echo json_encode($status);
        }
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

    public function crud_item()
    {
        $oper = $this->input->post('oper');
        $ITEM_NAME = ucfirst(trim($this->input->post('ITEM_NAME')));
        $QTY = abs($this->input->post('QTY'));

        $table = "P_INVENTORY";
        $pk = "P_INVENTORY_ID";

        $new_id = gen_id($pk, $table);

        if ($oper == "add") {
            $data = array('P_INVENTORY_ID' => intval($new_id),
                'ITEM_NAME' => $ITEM_NAME,
                'QTY' => $QTY
            );
            $check = $this->Mfee->checkDuplicated($table, array('ITEM_NAME' => $ITEM_NAME));
            if ($check > 0) {
                $status["success"] = false;
                $status["message"] = "No PKS sudah ada !";
                echo json_encode($status);
            } else {
                $this->db->set('CREATED_DATE', "SYSDATE", FALSE);
                $this->db->set('CREATED_BY', $this->session->userdata('d_user_name'));
                $this->db->insert($table, $data);
                if ($this->db->affected_rows() > 0) {
                    $status["success"] = true;
                    $status["message"] = "Data berhasil ditambahkan";
                } else {
                    $status["success"] = false;
                    $status["message"] = "error !";
                }
            }

        }

    }

    public function getListStatusReq()
    {
        $this->db->where('P_REFERENCE_TYPE_ID', 7); // PO STATUS
        $this->db->where('P_REFERENCE_LIST_ID <>', 18); // WAITING
        return $this->db->get('P_REFERENCE_LIST')->result_array();
    }

    public function updateStatusReq()
    {
        $oper = $this->input->post('oper');
        $id = (int)$this->input->post('id');
        $P_INVENTORY_ID = (int)$this->input->post('P_INVENTORY_ID');
        $STATUS = (int)($this->input->post('STATUS'));
        $NOTE = trim(ucfirst($this->input->post('NOTE')));


        $QTY = abs($this->input->post('ORDER_QTY'));

        $qty_stok = intval($this->getQty($P_INVENTORY_ID));

        if($oper == "edit"){
            if($STATUS == 19){// Approved
                $this->db->where('PURCHASE_ORDER_ID', $id);
                $this->db->set('STATUS',$STATUS);
                $this->db->set('NOTE',$NOTE);
                $this->db->set('UPDATED_DATE',"SYSDATE",FALSE);
                $this->db->set('UPDATED_BY',$this->session->userdata('d_user_name'));
                $this->db->update('PURCHASE_ORDER');
            }
            elseif($STATUS == 20){ // Reject
                $this->db->where('PURCHASE_ORDER_ID', $id);
                $this->db->set('STATUS',$STATUS);
                $this->db->set('NOTE',$NOTE);
                $this->db->set('UPDATED_DATE',"SYSDATE",FALSE);
                $this->db->set('UPDATED_BY',$this->session->userdata('d_user_name'));
                $this->db->update('PURCHASE_ORDER');

                // Update Stok
                $this->db->where('P_INVENTORY_ID', $P_INVENTORY_ID);
                $this->db->set('QTY', ($qty_stok + $QTY));
                $this->db->set('UPDATE_DATE', "SYSDATE", FALSE);
                $this->db->set('UPDATE_BY', 'SYSTEM');
                $this->db->update('P_INVENTORY');

            }

        }

    }


}