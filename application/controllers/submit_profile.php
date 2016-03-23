<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Submit_profile extends CI_Controller {
	
	function __construct() {
	    date_default_timezone_set('Asia/Jakarta');
		parent::__construct();
	    $this->load->model('M_user');
	}

	public function page($encrypted_param = "") {
	    //id 18,17
	    //old password : a2ed39c417316adbd5cd1d0211a5d711
	    	    
	    $data = array();
	    $data['error_message'] = "";
	    
	    try {
    	    
    	    if(empty($encrypted_param)) {
    	        throw new Exception("Parameter URL tidak valid");
    	    }
    	    
    	    $decrypted_param = base64_decode($encrypted_param);
    	    $arr_param = explode("|",$decrypted_param);

    	    if(count($arr_param) != 3) {
    	        throw new Exception("Parameter URL tidak valid");
    	    }
    	    
    	    
    	    foreach($arr_param as $val) {
    	        if(empty($val)) {
    	            throw new Exception("Parameter URL tidak valid");
    	            break;
    	        }
    	    }
    	    
    	    if(!is_numeric($arr_param[0]) or !is_numeric($arr_param[1])) {
    	        throw new Exception("Parameter URL tidak valid");
    	        break;        
    	    }
    	    
    	    if(!$this->isValidEmail($arr_param[2])) {
    	        throw new Exception("Parameter URL tidak valid");
    	        break;
    	    }
    	    
    	    $data['user_id_mitra'] = $arr_param[0];
	        $data['user_id_admin'] = $arr_param[1];
	        $data['email_admin'] = $arr_param[2];
    	    
    	    $sql = "SELECT COUNT(1) AS TOTAL_COUNT FROM APP_USERS WHERE USER_ID IN(".$data['user_id_mitra'].",".$data['user_id_admin'].")";
	        $rc = $this->M_user->db->query($sql)->row_array();
	        
	        if($rc['TOTAL_COUNT'] != 2) {
    	        throw new Exception("Maaf, Mitra/Admin yang bersangkutan tidak terdaftar. Parameter URL tidak valid");
    	    }
    	    
    	    $sql = "SELECT COUNT(1) AS TOTAL_COUNT FROM T_USER_LEGAL_DOC WHERE USER_ID = ".$data['user_id_mitra'];
	        $rc = $this->M_user->db->query($sql)->row_array();
	        
	        if($rc['TOTAL_COUNT'] > 0) {
    	        throw new Exception("Maaf, Anda sudah pernah melakukan upload profile.");
    	    }
    	    
    	    $item_user = $this->M_user->getUserItem($data['user_id_mitra']);
    	    $data['USER_NAME'] = $item_user['USER_NAME'];
    	    
	    }catch(Exception $e) {
	        $data['error_message'] = $e->getMessage();
	    }
	    
	    $this->load->view('submit_profile/upload_profile', $data);
	    
    }
    
    
    public function upload_data() {
        
        $id_mitra = $this->input->post("id_mitra");
        $id_admin = $this->input->post("id_admin");
        $email_admin = $this->input->post("email_admin");
        
        $jenis_identitas = $this->input->post("jenis_identitas");
        $password = md5($this->input->post("user_password"));
        
        
        $data = array('success' => false, 'message' => '');
        
        if(empty($id_mitra) or empty($id_admin) or empty($email_admin)) {
            $data['message'] = 'Invalid Data Posting';
    	    echo json_encode($data);
            exit;
        }
        
        $sql = "SELECT COUNT(1) AS TOTAL_COUNT FROM T_USER_LEGAL_DOC WHERE USER_ID = ".$id_mitra;
	    $rc = $this->M_user->db->query($sql)->row_array();
	    
	    if($rc['TOTAL_COUNT'] > 0) {
    	    $data['message'] = 'Maaf, Anda sudah pernah melakukan upload profile.';
    	    echo json_encode($data);
            exit;
    	}
    	
        
        // Upload Process
        $config = array();
        $config['upload_path'] = './application/third_party/upload';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = '1048576';
        $config['overwrite'] = true;
        $config['file_name'] = "userprofile_".$id_mitra."_".$jenis_identitas."_".date("YmdHis");
        
        $this->load->library('upload');
        $this->upload->initialize($config);
        
        
        if (!$this->upload->do_upload("file_name")) {
            
            $data['message'] = $this->upload->display_errors();
            echo json_encode($data);
            exit;
        }else {
            
            $itemuser = $this->M_user->getUserItem($id_mitra);
            $itemadmin = $this->M_user->getUserItem($id_admin);
            
            $upload_result = $this->upload->data();
            $file_name = $config['file_name'].$upload_result['file_ext'];
            
            $sql = "INSERT INTO T_USER_LEGAL_DOC(T_USER_LEGAL_DOC_ID, USER_ID, JENIS_IDENTITAS, FILE_NAME, DESCRIPTION, CREATION_DATE, CREATED_BY)
                        VALUES(T_USER_LEGAL_DOC_SEQ.NEXTVAL, ".$id_mitra.",'".$jenis_identitas."', '".$file_name."', '', SYSDATE, '".$itemadmin['USER_NAME']."')";
            $this->M_user->db->query($sql);
            
            $sql = "UPDATE APP_USERS
                        SET PASSWD = '".$password."',
                        FAIL_PWD = NULL
                        WHERE USER_ID = ".$id_mitra;
            
            $this->M_user->db->query($sql);
            
            
            $email_to = $email_admin;
            $subject = 'Channel Management - User ID : '.$itemuser['USER_ID'].' ('.$itemuser['FULL_NAME'].') Just upload user profile successfully';
            $content = 'User dengan ID : '.$itemuser['USER_ID'].' telah berhasil mengupload data profile untuk aplikasi Channel Management. <br>
                            Silahkan cek validasi data profile pada link di bawah ini : <br>';
            
            $content .= site_url('submit_profile/cekprofile/'.base64_encode($itemuser['USER_ID'].'|'.$itemadmin['USER_ID'].'|'.$itemuser['EMAIL']));
            
                  
            $this->sendMail($subject, $content, $email_to);
            
            $data['success'] = true;
            $data['message'] = 'Data profile berhasil disimpan. Profile Anda akan divalidasi terlebih dahulu, silahkan menunggu respon email dari Admin. Terimakasih';
            
            echo json_encode($data);
            exit;
        }
        
    }
    
    
    public function cekprofile($encrypted_param = "") {
	    //id 18,17
	    //old password : a2ed39c417316adbd5cd1d0211a5d711
	    	    
	    $data = array();
	    $data['error_message'] = "";
	    
	    try {
    	    
    	    if(empty($encrypted_param)) {
    	        throw new Exception("Parameter URL tidak valid");
    	    }
    	    
    	    $decrypted_param = base64_decode($encrypted_param);
    	    $arr_param = explode("|",$decrypted_param);

    	    if(count($arr_param) != 3) {
    	        throw new Exception("Parameter URL tidak valid");
    	    }
    	    
    	    
    	    foreach($arr_param as $val) {
    	        if(empty($val)) {
    	            throw new Exception("Parameter URL tidak valid");
    	            break;
    	        }
    	    }
    	    
    	    if(!is_numeric($arr_param[0]) or !is_numeric($arr_param[1])) {
    	        throw new Exception("Parameter URL tidak valid");
    	        break;        
    	    }
    	    
    	    if(!$this->isValidEmail($arr_param[2])) {
    	        throw new Exception("Parameter URL tidak valid");
    	        break;
    	    }
    	    
    	    $data['user_id_mitra'] = $arr_param[0];
	        $data['user_id_admin'] = $arr_param[1];
	        $data['email_user'] = $arr_param[2];
    	    
    	    $sql = "SELECT COUNT(1) AS TOTAL_COUNT FROM APP_USERS WHERE USER_ID IN(".$data['user_id_mitra'].",".$data['user_id_admin'].")";
	        $rc = $this->M_user->db->query($sql)->row_array();
	        
	        if($rc['TOTAL_COUNT'] != 2) {
    	        throw new Exception("Maaf, Mitra/Admin yang bersangkutan tidak terdaftar. Parameter URL tidak valid");
    	    }
    	    
    	    
    	    $sql = "SELECT COUNT(1) AS TOTAL_COUNT FROM T_USER_LEGAL_DOC WHERE USER_ID IN(".$data['user_id_mitra'].")";
	        $rc = $this->M_user->db->query($sql)->row_array();
	        
	        if($rc['TOTAL_COUNT'] < 1) {
    	        throw new Exception("Maaf, Mitra yang bersangkutan tidak mengupload data profile atau telah dihapus");
    	    }
    	    
    	    $sql = "SELECT * FROM T_USER_LEGAL_DOC WHERE USER_ID = ".$data['user_id_mitra'];
    	    $qs = $this->db->query($sql)->row_array();
            
            
            $itemuser = $this->M_user->getUserItem($data['user_id_mitra']);
            if($itemuser['P_USER_STATUS_ID'] == '1') {
                throw new Exception("Maaf, User yang bersangkutan telah diaktivasi");    
            }
            
            $data['jenis_identitas'] = $qs['JENIS_IDENTITAS'];
            $data['file_name'] = $qs['FILE_NAME'];
            $data['user_name_mitra'] = $itemuser['USER_NAME'];
            $data['full_name_mitra'] = $itemuser['FULL_NAME'];
            
	    }catch(Exception $e) {
	        $data['error_message'] = $e->getMessage();
	    }
	    
	    $this->load->view('submit_profile/cek_profile', $data);
	    
    }
    
    public function cek_validasi_data() {
        $is_user_valid = $this->input->post("btn_user_valid");
        $is_user_not_valid  = $this->input->post("btn_user_not_valid");
        
        $user_id_mitra  = $this->input->post("id_mitra");
        $user_id_admin  = $this->input->post("id_admin");
        $email_user  = $this->input->post("email_user");
        
        $data = array('success' => false, 'message' => '');
        
        if(!empty($is_user_valid)) {
            $sql = "UPDATE APP_USERS SET
                         P_USER_STATUS_ID = 1
                       WHERE USER_ID = ".$user_id_mitra;
            $this->M_user->db->query($sql);            
            
            /*send email success. tambahkan keterangan username, password, dan link login.*/
            $itemadmin = $this->M_user->getUserItem($user_id_admin);
            
            $email_to = $email_user;
            $subject = 'Channel Management : User telah diaktifasi';
            $content = 'User Anda telah diaktifasi. Silahkan gunakan Username dan Password Anda untuk login pada aplikasi Channel Management. : <br><br>';
            $content .= base_url();
            $content .= '<br>';

            $this->sendMail($subject, $content, $email_to);

            $data['success'] = true;
            $data['message'] = 'Email telah dikirimkan ke User bersangkutan dan User telah Aktif.';
            
        }else if(!empty($is_user_not_valid)) {
            
            $sql = "UPDATE APP_USERS SET
                         P_USER_STATUS_ID = 4
                       WHERE USER_ID = ".$user_id_mitra;
            $this->M_user->db->query($sql);
            
            
            $sql = "DELETE FROM T_USER_LEGAL_DOC WHERE USER_ID = ".$user_id_mitra;
            $this->M_user->db->query($sql);
            
            
            $itemadmin = $this->M_user->getUserItem($user_id_admin);
            
            $email_to = $email_user;
            $subject = 'Channel Management : User Profile tidak valid';
            $content = 'User profile yang Anda kirimkan dinyatakan tidak valid oleh Administrator. Silahkan inputkan ulang user profile Anda dengan mengklik link di bawah ini : <br>';
            $content .= site_url('submit_profile/page/'.base64_encode($user_id_mitra.'|'.$user_id_admin.'|'.$itemadmin['EMAIL']));
                  
            $this->sendMail($subject, $content, $email_to);
            
            /* send email untuk upload profile ulang */
            $data['success'] = true;
            $data['message'] = 'Email telah dikirimkan dan User telah diminta untuk mengirimkan profile ulang.';
        }
        
        echo json_encode($data);
        exit;
    }
    
    
    public function isValidEmail($email){ 
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
    }
    
    public function sendMail($subject, $content, $email_to) {
        
        $sql = "  BEGIN ".
               "  p_send_mail_html(:params1, :params2, :params3, :params4, :params5, :params6, :params7, :params8); END;";

        $params = array(
            array('name' => ':params1', 'value' => 'tos_admin@telkom.co.id', 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params2', 'value' => $email_to, 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params3', 'value' => '', 'type' => SQLT_CHR, 'length' => 32),
            array('name' => ':params4', 'value' => '', 'type' => SQLT_CHR, 'length' => 100),
            array('name' => ':params5', 'value' => $subject, 'type' => SQLT_CHR, 'length' => 500),
            array('name' => ':params6', 'value' => '', 'type' => SQLT_CHR, 'length' => 32),
            array('name' => ':params7', 'value' => $content, 'type' => SQLT_CHR, 'length' => 1000),
            array('name' => ':params8', 'value' => 'smtp.telkom.co.id', 'type' => SQLT_CHR, 'length' => 32)
        );
        // Bind the output parameter

        $stmt = oci_parse($this->M_user->db->conn_id,$sql);

        foreach($params as $p){
            // Bind Input
            oci_bind_by_name($stmt,$p['name'], $p['value'], $p['length']);
        }

        ociexecute($stmt);
    }
    
}