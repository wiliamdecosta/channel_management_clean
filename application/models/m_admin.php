<?php
class M_admin extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->helper('sequence');
    }


    //fungsi ini digunakan melakukan create, update, dan delete yang nantinya akan dipanggil di controller
    function crud($table, $key, $id, $arr){
        $oper=$this->input->post('oper');
        $id_=$this->input->post('id');
        $count=count($arr);
      //  print_r($count);
        for($i=0;$i<$count;$i++){
            $data[$arr[$i]]=$this->input->post($arr[$i]);

        }
       // print_r($data);
        //exit();
        switch ($oper) {
            case 'add':
                $new_id = gen_id($key,$table);
                $this->db->set($key,$new_id);
                $this->db->insert($table,$data);
                break;
            case 'edit':
                 $this->db->where($key,$id_);
                 $this->db->update($table, $data);
                //$sql = "UPDATE ".$table." SET ";
                //$qs = $this->db->query($sql);
                break;
            case 'del':
                $this->db->where($key,$id_);
                $this->db->delete($table);
                break;
        }
    }

    public function getTreeMenu() {
        $result = array();
        $sql = "SELECT * FROM APP_MENU ORDER BY MENU_ID ";
        $qs = $this->db->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }

    public function getTreeMenuByID($id) {
        $result = array();
        $sql = "SELECT MENU_ID,MENU_PARENT,MENU_NAME FROM APP_MENU WHERE MENU_PARENT =".$id."ORDER BY MENU_ID";
        $qs = $this->db->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }

    public function cekMenuProfile($menu_id,$prof_id) {
        $qs =  $this->db->get_where('APP_MENU_PROFILE',array('MENU_ID'=> $menu_id, 'PROF_ID' => $prof_id));
        return $qs;
    }

    public function insMenuProf($menu_id,$prof_id){
        $qs = "INSERT INTO APP_MENU_PROFILE (APP_MENU_PROFILE_ID,MENU_ID,PROF_ID,CREATION_DATE,CREATED_BY,UPDATE_DATE,UPDATED_BY)(SELECT APP_MENU_PROFILE_SEQ.NEXTVAL , MENU_ID,".$prof_id.",SYSDATE,'ADMIN',SYSDATE,'ADMIN' FROM APP_MENU WHERE MENU_ID IN (".$menu_id."))" ;
        $this->db->query($qs);
    }

    public function delMenuProf($prof_id){
        $qs = "DELETE APP_MENU_PROFILE WHERE PROF_ID = ".$prof_id;
        $this->db->query($qs);
    }

    function crud_user(){
        $oper=$this->input->post('oper');
        $id_=$this->input->post('id');
        $key = 'USER_ID';
        $table = 'APP_USERS';

        $FULL_NAME = strtoupper($this->input->post('FULL_NAME'));
        $USER_NAME = strtoupper($this->input->post('USER_NAME'));
        $EMAIL = strtolower($this->input->post('EMAIL'));
        $LOKER= $this->input->post('LOKER');
        $ADDR_STREET = $this->input->post('ADDR_STREET');
        $ADDR_CITY= $this->input->post('ADDR_CITY');
        $CONTACT_NO = $this->input->post('CONTACT_NO');
        $PASSWD = MD5($this->input->post('PASSWD'));
        $IS_EMPLOYEE = $this->input->post('IS_EMPLOYEE');
        
        $P_USER_STATUS_ID = "1";
        if($IS_EMPLOYEE == 'N') {
            /* khusus non karyawan, user akan menentukan passwordnya sendiri ketika masuk halaman submit profile. 
                halaman submit profile akan dikirimkan ke email user ketika sudah mapping user mitra
                oleh admin.
                
                password non-karyawan diset dengan settingan di bawah ini(agar sulit ditebak).
            */
            $PASSWD = md5('apaajaboleh987654321!@#$%^&*(');
            $P_USER_STATUS_ID = "NULL";
        }
        

        switch ($oper) {
            case 'add':
                $new_id = gen_id($key,$table);
              //  $this->db->set($key,$new_id);
                $qs = "INSERT INTO APP_USERS(USER_ID,FULL_NAME,USER_NAME,EMAIL,LOKER,ADDR_STREET,ADDR_CITY,CONTACT_NO,PASSWD, IS_EMPLOYEE, P_USER_STATUS_ID) VALUES(
                        '".$new_id."',
                        '".$FULL_NAME."',
                        '".$USER_NAME."',
                        '".$EMAIL."',
                        '".$LOKER."',
                        '".$ADDR_STREET."',
                        '".$ADDR_CITY."',
                        '".$CONTACT_NO."',
                        '".$PASSWD."',
                        '".$IS_EMPLOYEE."',
                        ".$P_USER_STATUS_ID."
                        )" ;
                $this->db->query($qs);
                break;
            case 'edit':
                $this->db->where($key,$id_);
                $qs = "UPDATE APP_USERS SET
                         FULL_NAME = '".$FULL_NAME."',
                         EMAIL = '".$EMAIL."',
                         LOKER = '".$LOKER."',
                         ADDR_STREET = '".$ADDR_STREET."',
                         ADDR_CITY = '".$ADDR_CITY."',
                         CONTACT_NO = '".$CONTACT_NO."',
                         IS_EMPLOYEE = '".$IS_EMPLOYEE."'
                       WHERE USER_ID = ".$id_;
                $this->db->query($qs);
                break;
            case 'del':
                
                $this->db->where($key,$id_);
                $this->db->delete('P_USER_ATTRIBUTE');
                
                $this->db->where($key,$id_);
                $this->db->delete('T_USER_LEGAL_DOC');
                
                $this->db->where($key,$id_);
                $this->db->delete('APP_USER_C2BI');
                
                $this->db->where($key,$id_);
                $this->db->delete($table);
                break;
        }

    }
    public function resetPwd($uid,$user_name){
        $qs = "UPDATE APP_USERS SET PASSWD = '".$user_name."' WHERE USER_ID=".$uid;
        $this->db->query($qs);

    }
	
	public function getPrivilegeMenu($app_menu_profile_id) {
        $result = array();
        $sql = "SELECT a.P_APP_OBJECT_TYPE_ID, b.P_APP_RMDIS_OBJECT_ID, a.CODE, nvl(b.IS_ACTIVE,'N') AS IS_ACTIVE,
                b.CREATION_DATE, b.CREATED_BY, b.UPDATE_DATE, b.UPDATED_BY
                FROM P_APP_OBJECT_TYPE a
                LEFT JOIN P_APP_RMDIS_OBJECT b ON a.P_APP_OBJECT_TYPE_ID = b.P_APP_OBJECT_TYPE_ID
                AND b.APP_MENU_PROFILE_ID = ".$app_menu_profile_id;
        $qs = $this->db->query($sql);

        if($qs->num_rows() > 0) $result = $qs->result();
        return $result;
    }
    
    public function insRmdisObject($item){
        $qs = "INSERT INTO P_APP_RMDIS_OBJECT (P_APP_RMDIS_OBJECT_ID,APP_MENU_PROFILE_ID,P_APP_OBJECT_TYPE_ID,IS_ACTIVE,CREATION_DATE,CREATED_BY,UPDATE_DATE,UPDATED_BY) VALUES(".$item['P_APP_RMDIS_OBJECT_ID']." , ".$item['APP_MENU_PROFILE_ID'].",".$item['P_APP_OBJECT_TYPE_ID'].",'".$item['IS_ACTIVE']."',SYSDATE,'".$this->session->userdata('d_user_name')."',SYSDATE,'".$this->session->userdata('d_user_name')."')" ;
        $this->db->query($qs);
    }
    
    public function updRmdisObject($item) {
        $qs = "UPDATE P_APP_RMDIS_OBJECT
                SET IS_ACTIVE = '".$item['IS_ACTIVE']."',
                UPDATE_DATE = SYSDATE,
                UPDATED_BY = '".$this->session->userdata('d_user_name')."'
                WHERE P_APP_RMDIS_OBJECT_ID = ".$item['P_APP_RMDIS_OBJECT_ID'];   
    
        $this->db->query($qs);
    }
	
}