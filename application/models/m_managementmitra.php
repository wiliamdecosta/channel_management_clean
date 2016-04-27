<?php

class M_managementmitra extends CI_Model
{

    function __construct()
    {
        parent::__construct();

    }

    public function getFastel($param)
    {
        $db2 = $this->load->database('default2', TRUE);
        //$this->db->protect_identifiers();
        $db2->_protect_identifiers = false;
        if ($param['search'] != null && $param['search'] === 'true') {
            $wh = "UPPER(" . $param['search_field'] . ")";
            switch ($param['search_operator']) {
                case "bw": // begin with
                    $wh .= " LIKE UPPER('" . $param['search_str'] . "%')";
                    break;
                case "ew": // end with
                    $wh .= " LIKE UPPER('%" . $param['search_str'] . "')";
                    break;
                case "cn": // contain %param%
                    $wh .= " LIKE UPPER('%" . $param['search_str'] . "%')";
                    break;
                case "eq": // equal =
                    if (is_numeric($param['search_str'])) {
                        $wh .= " = '" . $param['search_str'] . "'";
                    } else {
                        $wh .= " = UPPER('" . $param['search_str'] . "')";
                    }
                    break;
                case "ne": // not equal
                    if (is_numeric($param['search_str'])) {
                        $wh .= " <> " . $param['search_str'];
                    } else {
                        $wh .= " <> UPPER('" . $param['search_str'] . "')";
                    }
                    break;
                case "lt":
                    if (is_numeric($param['search_str'])) {
                        $wh .= " < " . $param['search_str'];
                    } else {
                        $wh .= " < '" . $param['search_str'] . "'";
                    }
                    break;
                case "le":
                    if (is_numeric($param['search_str'])) {
                        $wh .= " <= " . $param['search_str'];
                    } else {
                        $wh .= " <= '" . $param['search_str'] . "'";
                    }
                    break;
                case "gt":
                    if (is_numeric($param['search_str'])) {
                        $wh .= " > " . $param['search_str'];
                    } else {
                        $wh .= " > '" . $param['search_str'] . "'";
                    }
                    break;
                case "ge":
                    if (is_numeric($param['search_str'])) {
                        $wh .= " >= " . $param['search_str'];
                    } else {
                        $wh .= " >= '" . $param['search_str'] . "'";
                    }
                    break;
                default :
                    $wh = "";
            }
            $db2->where($wh);
        }


        ($param['limit'] != null ? $db2->limit($param['limit']['end'], $param['limit']['start']) : '');
        ($param['sort_by'] != null ? $db2->order_by($param['sort_by'], $param['sord']) : '');

        //$db2->where('b.nd',1);
        $db2->where('C.PGL_ID', $param['pgl_id']);

        $sql = "b.nd nd1, b.AKTIF, b.ADDRESS,b.CREATED_DATE,b.VALID_FROM," .
            " decode(d.flag,2,'M4L',1,'SIN','MARKETING_FEE') flag, " .
            " A.* " .
            " FROM CUST_RINTA PARTITION(PERIOD_" . $param['period'] . ") A" .
            " INNER JOIN TEN_ND B ON B.ND=A.ND" .
            " INNER JOIN PGL_TEN C ON C.TEN_ID=B.TEN_ID" .
            " LEFT JOIN CC_DATAREF@NONPOTS_OP D ON A.ND = D.P_NOTEL";

//        $sql = "SELECT b.nd nd1,A.* ".
//            " FROM CUST_RINTA PARTITION(PERIOD_".$param['period'].") A, TEN_ND B WHERE A.ND(+)=B.ND AND B.TEN_ID=".$param['ten_id'];
        $db2->select($sql);
        $qs = $db2->get();
        return $qs;

    }

    public function getDatin($param)
    {
        $this->db->_protect_identifiers = false;
        if ($param['search'] != null && $param['search'] === 'true') {
            $wh = "UPPER(" . $param['search_field'] . ")";
            switch ($param['search_operator']) {
                case "bw": // begin with
                    $wh .= " LIKE UPPER('" . $param['search_str'] . "%')";
                    break;
                case "ew": // end with
                    $wh .= " LIKE UPPER('%" . $param['search_str'] . "')";
                    break;
                case "cn": // contain %param%
                    $wh .= " LIKE UPPER('%" . $param['search_str'] . "%')";
                    break;
                case "eq": // equal =
                    if (is_numeric($param['search_str'])) {
                        $wh .= " = '" . $param['search_str'] . "'";
                    } else {
                        $wh .= " = UPPER('" . $param['search_str'] . "')";
                    }
                    break;
                case "ne": // not equal
                    if (is_numeric($param['search_str'])) {
                        $wh .= " <> " . $param['search_str'];
                    } else {
                        $wh .= " <> UPPER('" . $param['search_str'] . "')";
                    }
                    break;
                case "lt":
                    if (is_numeric($param['search_str'])) {
                        $wh .= " < " . $param['search_str'];
                    } else {
                        $wh .= " < '" . $param['search_str'] . "'";
                    }
                    break;
                case "le":
                    if (is_numeric($param['search_str'])) {
                        $wh .= " <= " . $param['search_str'];
                    } else {
                        $wh .= " <= '" . $param['search_str'] . "'";
                    }
                    break;
                case "gt":
                    if (is_numeric($param['search_str'])) {
                        $wh .= " > " . $param['search_str'];
                    } else {
                        $wh .= " > '" . $param['search_str'] . "'";
                    }
                    break;
                case "ge":
                    if (is_numeric($param['search_str'])) {
                        $wh .= " >= " . $param['search_str'];
                    } else {
                        $wh .= " >= '" . $param['search_str'] . "'";
                    }
                    break;
                default :
                    $wh = "";
            }
            $this->db->where($wh);
        }


        ($param['limit'] != null ? $this->db->limit($param['limit']['end'], $param['limit']['start']) : '');
        ($param['sort_by'] != null ? $this->db->order_by($param['sort_by'], $param['sord']) : '');

        $this->db->where('BILL_PRD', $param['periode']);
        $this->db->where('PGL_ID', $param['pgl_id']);

        $qs = $this->db->get('V_FASTEL_DATIN');
        return $qs;

    }


    public function excelRinta($period, $pgl_id, $ten_id)
    {
        $db2 = $this->load->database('default2', TRUE);
        $result = array();
        $sql = "SELECT b.nd nd1,A.* FROM CUST_RINTA PARTITION(PERIOD_" . $period . ") A, TEN_ND B WHERE A.ND(+)=B.ND AND B.TEN_ID=" . $ten_id;

        $qs = $db2->query($sql);
        if ($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }

    public function insertPKS($data)
    {
        $this->db->_protect_identifiers = false;

        $new_id = gen_id('P_PKS_ID', 'P_PKS');
        $this->db->set('P_PKS_ID', $new_id);
        $this->db->insert('P_PKS', $data);
        return $this->db->affected_rows();

    }

    public function insertDokKontrak($data)
    {
        $this->db->_protect_identifiers = false;

        $new_id = gen_id('P_DOK_KONTRAK_ID', 'P_DOK_KONTRAK');
        $this->db->set('P_DOK_KONTRAK_ID', $new_id);
        $this->db->insert('P_DOK_KONTRAK', $data);
        return $this->db->affected_rows();

    }

    public function insertDokNPK($data)
    {
        $this->db->_protect_identifiers = false;

        $new_id = gen_id('P_NPK_ID', 'P_NPK');
        $this->db->set('P_NPK_ID', $new_id);
        $this->db->insert('P_NPK', $data);
        return $this->db->affected_rows();

    }

    public function insertDokEvaluasi($data)
    {
        $this->db->_protect_identifiers = false;

        $new_id = gen_id('P_DOK_EVALUASI_ID', 'P_DOK_EVALUASI');
        $this->db->set('P_DOK_EVALUASI_ID', $new_id);
        $this->db->insert('P_DOK_EVALUASI', $data);
        return $this->db->affected_rows();

    }

    public function crud_pks()
    {
        $this->db->_protect_identifiers = false;
        $oper = $this->input->post('oper');
        $id = $this->input->post('id');

        $form_doc_name = trim(ucfirst($this->input->post("form_doc_name")));
        $form_p_mp_pks_id = $this->input->post("form_p_mp_pks_id");
        $form_p_pks_id = $this->input->post("form_p_pks_id");
        $form_description = trim(ucfirst($this->input->post("form_description")));


        $CREATED_DATE = date('d/M/Y');
        $UPDATED_DATE = date('d/M/Y');
        $CREATED_BY = $this->session->userdata('d_user_name');
        $UPDATED_BY = $this->session->userdata('d_user_name');

        $table = "P_PKS";
        $pk = "P_PKS_ID";

        $datas = array();
        switch ($oper) {
            case 'add':

                $config['upload_path'] = './application/third_party/upload/pks';
                $config['allowed_types'] = 'docx|pdf|doc|xls|xlsx';
                $config['max_size'] = '0';
                $config['overwrite'] = TRUE;
                $file_id = time();
                $config['file_name'] = str_replace(" ", "_", $form_doc_name) . "_" . $file_id;

                $this->load->library('upload');
                $this->upload->initialize($config);


                if (!$this->upload->do_upload("filename")) {
                    $error = $this->upload->display_errors();
                    $datas['success'] = false;
                    $datas['message'] = $error;
                } else {
                    // Do Upload
                    $data = $this->upload->data();

                    $data = array(
                        "DOC_NAME" => $form_doc_name,
                        "DESCRIPTION" => $form_description,
                        "P_MP_PKS_ID" => $form_p_mp_pks_id,
                        "FILE_NAME" => $data['client_name'],
                        "FILE_PATH" => $data['file_name'],
                        'CREATED_BY' => $CREATED_BY,
                        'CREATED_DATE' => $CREATED_DATE,
                        'UPDATED_DATE' => $UPDATED_DATE,
                        'UPDATED_BY' => $UPDATED_BY

                    );
                    // Set New PK
                    $new_id = gen_id($pk, $table);
                    $this->db->set($pk, $new_id);

                    // DO Insert
                    $this->db->insert($table, $data);
                    if ($this->db->affected_rows() > 0) {
                        $datas["success"] = true;
                        $datas["message"] = "Data berhasil ditambahakan";

                    } else {
                        $datas["success"] = false;
                        $datas["message"] = "Gagal menambah data";

                    }
                }

                break;
            case 'edit':
                $data = array(
                    "DOC_NAME" => $form_doc_name,
                    "DESCRIPTION" => $form_description,
                    "P_MP_PKS_ID" => $form_p_mp_pks_id,
                    'UPDATED_DATE' => $UPDATED_DATE,
                    'UPDATED_BY' => $UPDATED_BY

                );

                $this->db->where($pk, $form_p_pks_id);
                $this->db->update($table, $data);
                if ($this->db->affected_rows() > 0) {
                    $datas["success"] = true;
                    $datas["message"] = "Edit data berhasil";
                } else {
                    $datas["success"] = false;
                    $datas["message"] = "Gagal edit data";

                }

                break;
            case 'del':
                $this->db->where($pk, $id);
                $this->db->delete($table);
                break;
        }
        echo json_encode($datas);

    }

    public function crud_kontrak()
    {

        $this->db->_protect_identifiers = false;
        $oper = $this->input->post('oper');
        $id = $this->input->post('id');

        $table = "P_DOK_KONTRAK";

        switch ($oper) {
            case 'add':

                break;
            case 'edit':

                break;
            case 'del':
                $this->db->where('P_DOK_KONTRAK_ID', $id);
                $this->db->delete($table);
                break;
        }

    }

    public function crud_npk()
    {

        $this->db->_protect_identifiers = false;
        $oper = $this->input->post('oper');
        $id = $this->input->post('id');

        $table = "P_NPK";

        switch ($oper) {
            case 'add':

                break;
            case 'edit':

                break;
            case 'del':
                $this->db->where('P_NPK_ID', $id);
                $this->db->delete($table);
                break;
        }

    }

    public function crud_evaluasi()
    {
        $this->db->_protect_identifiers = false;
        $oper = $this->input->post('oper');
        $id = $this->input->post('id');

        $table = "P_DOK_EVALUASI";

        switch ($oper) {
            case 'add':

                break;
            case 'edit':

                break;
            case 'del':
                $this->db->where('P_DOK_EVALUASI_ID', $id);
                $this->db->delete($table);
                break;
        }

    }

    public function crud_detailmitra()
    {
        $this->db->_protect_identifiers = false;

        $table = "P_MAP_MIT_CC";
        $pk = "P_MAP_MIT_CC_ID";

        //$segment = $this->input->post("segment_code");
        $cc_id = $this->input->post("cc_id");
        $mitra_id = $this->input->post("mitra_id");
        $pic_id = $this->input->post("pic_id");
        $contact = $this->input->post("contact");
        $eam_id = $this->input->post("eam_id");
        $lokasi_pks = $this->input->post("lokasi_pks");
        $action = $this->input->post("action");
        $CREATED_DATE = date('d/M/Y');
        $CREATED_BY = $this->session->userdata('d_user_name');


        $data = array('PGL_ID' => $mitra_id,
            'P_PIC_ID' => $pic_id,
            'P_CONTACT_TYPE_ID' => $contact,
            'P_DAT_AM_ID' => $eam_id,
            'ID_CC' => $cc_id,
            'CREATION_DATE' => $CREATED_DATE,
            'CREATE_BY' => $CREATED_BY
        );

        if ($action == "add") {
            $new_id = gen_id($pk, $table);
            $this->db->set($pk, $new_id);
            $this->db->insert($table, $data);
            if ($this->db->affected_rows() == 1) {

                $gen_lokasi_id = gen_id("P_MP_LOKASI_ID", "P_MP_LOKASI");
                $data_lokasi = array('P_MAP_MIT_CC_ID' => $new_id,
                    'LOKASI' => $lokasi_pks,
                    'CREATE_BY' => $CREATED_BY,
                    'CREATION_DATE' => $CREATED_DATE
                );

                $this->db->set("P_MP_LOKASI_ID", $gen_lokasi_id);
                $this->db->insert("P_MP_LOKASI", $data_lokasi);

                return $this->db->affected_rows();
            }

        } elseif ($action == "edit") {

        } else {
            echo "unknown";
        }
    }

    public function getMapPIC()
    {
        $lokasisewa = $this->input->post('lokasisewa');

        $this->db->where('P_MP_LOKASI_ID', $lokasisewa);
        $q = $this->db->get("V_MP_PIC");
        return $q;

    }

}