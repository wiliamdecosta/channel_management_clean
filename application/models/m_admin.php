<?php

class M_admin extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('sequence');
    }


    //fungsi ini digunakan melakukan create, update, dan delete yang nantinya akan dipanggil di controller
    function crud($table, $key, $id, $arr)
    {
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');
        $count = count($arr);
        //  print_r($count);
        for ($i = 0; $i < $count; $i++) {
            $data[$arr[$i]] = $this->input->post($arr[$i]);

        }
        // print_r($data);
        //exit();
        switch ($oper) {
            case 'add':
                $new_id = gen_id($key, $table);
                $this->db->set($key, $new_id);
                $this->db->insert($table, $data);
                break;
            case 'edit':
                $this->db->where($key, $id_);
                $this->db->update($table, $data);
                //$sql = "UPDATE ".$table." SET ";
                //$qs = $this->db->query($sql);
                break;
            case 'del':
                $this->db->where($key, $id_);
                $this->db->delete($table);
                break;
        }
    }

    public function getTreeMenu()
    {
        $result = array();
        $sql = "SELECT * FROM APP_MENU ORDER BY MENU_ID ";
        $qs = $this->db->query($sql);

        if ($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }

    public function getTreeMenuByID($id)
    {
        $result = array();
        $sql = "SELECT MENU_ID,MENU_PARENT,MENU_NAME FROM APP_MENU WHERE MENU_PARENT =" . $id . "ORDER BY MENU_ID";
        $qs = $this->db->query($sql);

        if ($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }

    public function cekMenuProfile($menu_id, $prof_id)
    {
        $qs = $this->db->get_where('APP_MENU_PROFILE', array('MENU_ID' => $menu_id, 'PROF_ID' => $prof_id));
        return $qs;
    }

    public function insMenuProf()
    {

        $menu_id = $this->input->post('check_val');
        $menu_id2 = $this->input->post('uncheck_val');

        $prof_id = $this->input->post('prof_id');


        $this->db->trans_begin();
        if ($prof_id != "" || $prof_id != null) {
            //$this->delMenuProf($prof_id);

            $user = $this->session->userdata('d_user_name');

            // Check List
            if($menu_id){
                for ($i = 0; $i < count($menu_id); $i++) {
                    $ck = $this->Mfee->checkDuplicated("APP_MENU_PROFILE", array('MENU_ID' => $menu_id[$i], 'PROF_ID' => $prof_id));
                    if ($ck == 0) {
                        $new_id = gen_id("APP_MENU_PROFILE_ID", "APP_MENU_PROFILE");
                        $data = array("APP_MENU_PROFILE_ID" => $new_id,
                            "MENU_ID" => $menu_id[$i],
                            "PROF_ID" => $prof_id,
                            "CREATED_BY" => $user,
                            "UPDATED_BY" => $user
                        );
                        $this->db->set('CREATION_DATE', "SYSDATE", FALSE);
                        $this->db->set('UPDATE_DATE', "SYSDATE", FALSE);
                        $this->db->insert("APP_MENU_PROFILE", $data);


                        // For privilege attr
                        $sql = " DECLARE " .
                            "  v_result VARCHAR2(500); " .
                            "  BEGIN " .
                            "  marfee.INSERT_PRIVILEGE(:params1,:params2, :v_result); END;";

                        $params = array(
                            array('name' => ':params1', 'value' => $new_id, 'type' => SQLT_INT, 'length' => 20),
                            array('name' => ':params2', 'value' => $user, 'type' => SQLT_CHR, 'length' => 32),
                        );

                        $stmt = oci_parse($this->db->conn_id, $sql);

                        foreach ($params as $p) {
                            oci_bind_by_name($stmt, $p['name'], $p['value'], $p['length']);
                        }
                        $message = '';
                        oci_bind_by_name($stmt, ':v_result', $message, 120);

                        ociexecute($stmt);
                        // return $message;
                    }


                }
            }

            if($menu_id2){
                // Uncheck List (Delete if exist)
                for ($a = 0; $a < count($menu_id2); $a++) {
                    $ck = $this->Mfee->checkDuplicated("APP_MENU_PROFILE", array('MENU_ID' => $menu_id2[$a], 'PROF_ID' => $prof_id));
                    if ($ck > 0) {


                        // Delete P_APP_RMDIS_OBJECT
                        /*$this->db->where("MENU_ID", $menu_id2[$a]);
                        $this->db->where("PROF_ID", $prof_id);
                        $q = $this->db->get('APP_MENU_PROFILE')->row_array(1);
                        $app_menu_profile_id = $q['APP_MENU_PROFILE_ID'];


                        $this->db->where("APP_MENU_PROFILE_ID", $app_menu_profile_id);
                        $this->db->delete("P_APP_RMDIS_OBJECT");*/


                        // Delete Uncheck
                        $this->db->where("MENU_ID", $menu_id2[$a]);
                        $this->db->where("PROF_ID", $prof_id);
                        $this->db->delete("APP_MENU_PROFILE");


                    }
                }
            }

            // $qs = "INSERT INTO APP_MENU_PROFILE (APP_MENU_PROFILE_ID,MENU_ID,PROF_ID,CREATION_DATE,CREATED_BY,UPDATE_DATE,UPDATED_BY)(SELECT APP_MENU_PROFILE_SEQ.NEXTVAL , MENU_ID,".$prof_id.",SYSDATE,'".$user."',SYSDATE,'".$user."' FROM APP_MENU WHERE MENU_ID IN (".$menu_ids."))" ;
            // $this->db->query($qs);


        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

        } else {
           // echo json_encode('SUKSES');
            $this->db->trans_commit();
        }


    }

    public function delMenuProf($prof_id)
    {
        $qs = "DELETE APP_MENU_PROFILE WHERE PROF_ID = " . $prof_id;
        $this->db->query($qs);
    }

    function crud_user()
    {
        $oper = $this->input->post('oper');
        $id_ = $this->input->post('id');
        $key = 'USER_ID';
        $table = 'APP_USERS';

        $FULL_NAME = strtoupper($this->input->post('FULL_NAME'));
        $USER_NAME = strtoupper($this->input->post('USER_NAME'));
        $EMAIL = strtolower($this->input->post('EMAIL'));
        $LOKER = $this->input->post('LOKER');
        $ADDR_STREET = $this->input->post('ADDR_STREET');
        $ADDR_CITY = $this->input->post('ADDR_CITY');
        $CONTACT_NO = $this->input->post('CONTACT_NO');
        $PASSWD = MD5($this->input->post('PASSWD'));
        $IS_EMPLOYEE = $this->input->post('IS_EMPLOYEE');
        $PROF_ID = $this->input->post('PROF_NAME');


        $P_USER_STATUS_ID = "1";
        if ($IS_EMPLOYEE == 'N' and $PROF_ID == 3) { //khusus C2BI
            /* khusus non karyawan dan C2BI, user akan menentukan passwordnya sendiri ketika masuk halaman submit profile. 
                halaman submit profile akan dikirimkan ke email user ketika sudah mapping user mitra
                oleh admin.
                
                password non-karyawan diset dengan settingan di bawah ini(agar sulit ditebak).
            */
            $PASSWD = md5('apaajaboleh987654321!@#$%^&*(');
            $P_USER_STATUS_ID = "NULL";
        }


        switch ($oper) {
            case 'add':
                $new_id = gen_id($key, $table);
                //  $this->db->set($key,$new_id);
                $qs = "INSERT INTO APP_USERS(USER_ID,FULL_NAME,USER_NAME,EMAIL,LOKER,ADDR_STREET,ADDR_CITY,CONTACT_NO,PASSWD, IS_EMPLOYEE, P_USER_STATUS_ID) VALUES(
                        '" . $new_id . "',
                        '" . $FULL_NAME . "',
                        '" . $USER_NAME . "',
                        '" . $EMAIL . "',
                        '" . $LOKER . "',
                        '" . $ADDR_STREET . "',
                        '" . $ADDR_CITY . "',
                        '" . $CONTACT_NO . "',
                        '" . $PASSWD . "',
                        '" . $IS_EMPLOYEE . "',
                        " . $P_USER_STATUS_ID . "
                        )";
                $this->db->query($qs);
                if ($this->db->affected_rows() == 1) {
                    // Insert Privilege
                    $this->db->insert("APP_USER_PROFILE", array('USER_ID' => $new_id, 'PROF_ID' => $PROF_ID));
                }
                break;
            case 'edit':
                $this->db->where($key, $id_);
                $qs = "UPDATE APP_USERS SET
                         FULL_NAME = '" . $FULL_NAME . "',
                         EMAIL = '" . $EMAIL . "',
                         LOKER = '" . $LOKER . "',
                         ADDR_STREET = '" . $ADDR_STREET . "',
                         ADDR_CITY = '" . $ADDR_CITY . "',
                         CONTACT_NO = '" . $CONTACT_NO . "',
                         IS_EMPLOYEE = '" . $IS_EMPLOYEE . "'
                       WHERE USER_ID = " . $id_;
                $this->db->query($qs);
                if ($this->db->affected_rows() == 1) {
                    // Edit Privilege
                    $this->load->model('Mfee');
                    $ck = $this->Mfee->checkDuplicated('APP_USER_PROFILE', array('USER_ID' => $id_));
                    if ($ck > 0) {
                        // do edit
                        $this->db->where('USER_ID', $id_);
                        $this->db->update('APP_USER_PROFILE', array('PROF_ID' => $PROF_ID));
                    } else {
                        // insert privilege
                        $this->db->insert("APP_USER_PROFILE", array('USER_ID' => $id_, 'PROF_ID' => $PROF_ID));
                    }

                }
                break;
            case 'del':

                $this->db->where($key, $id_);
                $this->db->delete('P_USER_ATTRIBUTE');

                $this->db->where($key, $id_);
                $this->db->delete('T_USER_LEGAL_DOC');

                $this->db->where($key, $id_);
                $this->db->delete('APP_USER_C2BI');

                $this->db->where($key, $id_);
                $this->db->delete($table);
                break;
        }

    }

    public function resetPwd($uid, $user_name)
    {
        $qs = "UPDATE APP_USERS SET PASSWD = '" . $user_name . "' WHERE USER_ID=" . $uid;
        $this->db->query($qs);

    }

    public function getPrivilegeMenu($app_menu_profile_id)
    {
        $result = array();
        $sql = "SELECT a.P_APP_OBJECT_TYPE_ID, b.P_APP_RMDIS_OBJECT_ID, a.CODE, nvl(b.IS_ACTIVE,'N') AS IS_ACTIVE,
                b.CREATION_DATE, b.CREATED_BY, b.UPDATE_DATE, b.UPDATED_BY
                FROM P_APP_OBJECT_TYPE a
                LEFT JOIN P_APP_RMDIS_OBJECT b ON a.P_APP_OBJECT_TYPE_ID = b.P_APP_OBJECT_TYPE_ID
                AND b.APP_MENU_PROFILE_ID = " . $app_menu_profile_id;
        $qs = $this->db->query($sql);

        if ($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }

    public function insRmdisObject($item)
    {
        $qs = "INSERT INTO P_APP_RMDIS_OBJECT (P_APP_RMDIS_OBJECT_ID,APP_MENU_PROFILE_ID,P_APP_OBJECT_TYPE_ID,IS_ACTIVE,CREATION_DATE,CREATED_BY,UPDATE_DATE,UPDATED_BY) VALUES(" . $item['P_APP_RMDIS_OBJECT_ID'] . " , " . $item['APP_MENU_PROFILE_ID'] . "," . $item['P_APP_OBJECT_TYPE_ID'] . ",'" . $item['IS_ACTIVE'] . "',SYSDATE,'" . $this->session->userdata('d_user_name') . "',SYSDATE,'" . $this->session->userdata('d_user_name') . "')";
        $this->db->query($qs);
    }

    public function updRmdisObject($item)
    {
        $qs = "UPDATE P_APP_RMDIS_OBJECT
                SET IS_ACTIVE = '" . $item['IS_ACTIVE'] . "',
                UPDATE_DATE = SYSDATE,
                UPDATED_BY = '" . $this->session->userdata('d_user_name') . "'
                WHERE P_APP_RMDIS_OBJECT_ID = " . $item['P_APP_RMDIS_OBJECT_ID'];

        $this->db->query($qs);
    }

    public function getListProfile()
    {
        $this->db->order_by("PROF_NAME", "ASC");
        $q = $this->db->get('APP_PROFILE');
        return $q->result_array();
    }

}