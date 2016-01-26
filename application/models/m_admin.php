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
        $qs =  $this->db->get_where('APP_MENU_PROFILE',array('MENU_ID'=>$menu_id, 'PROF_ID' => $prof_id));
        return $qs;
    }

    public function insMenuProf($menu_id,$prof_id){
        $new_id = gen_id('APP_MENU_PROFILE_ID','APP_MENU_PROFILE');
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

        $NIK = strtoupper($this->input->post('NIK'));
        $USER_NAME = strtoupper($this->input->post('USER_NAME'));
        $EMAIL = $this->input->post('EMAIL');
        $LOKER= $this->input->post('LOKER');
        $ADDR_STREET = $this->input->post('ADDR_STREET');
        $ADDR_CITY= $this->input->post('ADDR_CITY');
        $CONTACT_NO = $this->input->post('CONTACT_NO');
        $PASSWD = MD5($this->input->post('PASSWD'));

        switch ($oper) {
            case 'add':
                $new_id = gen_id($key,$table);
              //  $this->db->set($key,$new_id);
                $qs = "INSERT INTO APP_USERS(USER_ID,NIK,USER_NAME,EMAIL,LOKER,ADDR_STREET,ADDR_CITY,CONTACT_NO,PASSWD) VALUES(
                        '".$new_id."',
                        '".$NIK."',
                        '".$USER_NAME."',
                        '".$EMAIL."',
                        '".$LOKER."',
                        '".$ADDR_STREET."',
                        '".$ADDR_CITY."',
                        '".$CONTACT_NO."',
                        '".$PASSWD."'
                        )" ;
                $this->db->query($qs);
                break;
            case 'edit':
                $this->db->where($key,$id_);
                $qs = "UPDATE APP_USERS SET
                         USER_NAME = '".$USER_NAME."',
                         EMAIL = '".$EMAIL."',
                         LOKER = '".$LOKER."',
                         ADDR_STREET = '".$ADDR_STREET."',
                         ADDR_CITY = '".$ADDR_CITY."',
                         CONTACT_NO = '".$CONTACT_NO."'
                       WHERE USER_ID = ".$id_;
                $this->db->query($qs);
                break;
            case 'del':
                $this->db->where($key,$id_);
                $this->db->delete($table);
                break;
        }

    }
    public function resetPwd($uid,$nik){
        $qs = "UPDATE APP_USERS SET PASSWD = '".$nik."' WHERE USER_ID=".$uid;
        $this->db->query($qs);

    }
	
    
	
}