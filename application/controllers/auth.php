<?php

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->session->sess_destroy();
        $this->load->view('user/v_login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . "auth");
    }

    public function timeout()
    {
        $session_id = $this->session->userdata('name');
        if ($session_id == '' or $session_id == NULL) {
            $status = 'expired';
        } else {
            $status = 'success';
        }
        $data['status'] = $status;
        $this->status = $status;
        $this->load->view('templates/interval', $data);
    }

    /*public function login()
    {
        $this->load->model('M_user');
        $username = strtoupper($this->security->xss_clean($this->input->post('username')));
        $pwd = MD5($this->security->xss_clean($this->input->post('pwd')));

        //Returns TRUE if every character in text is either a letter or a digit, FALSE otherwise.
        if (ctype_alnum($username)) {
            $rc = $this->M_user->getUserPwd($this->security->xss_clean($username), $pwd)->result();
            if (count($rc) == 1 AND $rc[0]->PASSWD == $pwd) {
                $sessions = array(
                    'd_user_id' => $rc[0]->USER_ID,
                    'd_user_name' => $rc[0]->USER_NAME,
                    'd_nik' => $rc[0]->NIK,
                    'd_email' => $rc[0]->EMAIL
                );

                //Set session
                $this->session->set_userdata($sessions);

                $profs = $this->M_user->getUserProfile($rc[0]->USER_ID);
                if (count($profs) == 0) {
                    $this->session->set_userdata("d_user_id", "");
                    $this->session->set_userdata('d_message', "You don't have profile. <br>Please contact your administrator !");

                    echo json_encode(array('success' => true, 'msg' => "You don't have profile. <br>Please contact your administrator !"));
                } elseif (count($profs) == 1) {
                    foreach ($profs as $k => $v) {
                        $prof_id = $k;
                        $prof_name = $v;
                    }
                    $this->session->set_userdata('d_prof_id', $prof_id);
                    $this->session->set_userdata('d_prof_name', $prof_name);
                }
                //echo json_encode(array('success'=>true,'msg'=>"You will be direct .. !"));
                $data['success'] = true;
                $data['msg'] = "You will be direct .. !";
                echo json_encode($data);
                // redirect("/home");
            } else {
                $rc = $this->M_user->getLists("USER_NAME='" . strtoupper($username) . "'");
                if (count($rc) > 0) {
                    // $this->session->set_userdata('d_message', "Password is wrong !");
                    echo json_encode(array('msg' => "Username / Password salah !"));
                } else {
                    //$this->session->set_userdata('d_message', "User belum terdaftar !");
                    echo json_encode(array('msg' => "User belum terdaftar !"));
                }
            }

        } else {
            echo json_encode(array('msg' => "Disallow character"));
        }
    }*/
    
    public function login()
    {
        $this->load->model('M_user');
        $username = strtoupper($this->security->xss_clean($this->input->post('username')));
        $password = $this->security->xss_clean($this->input->post('pwd'));
        $pwd_md5 = MD5($this->security->xss_clean($this->input->post('pwd')));
        
        //Returns TRUE if every character in text is either a letter or a digit, FALSE otherwise.
        if (ctype_alnum($username)) {
            
            /* call login function */
            $sql = "SELECT login('".strtoupper($username)."','".$pwd_md5."') result from dual";
            $rc = $this->M_user->db->query($sql)->result_array();
            
            if(count($rc) > 0) {
                $str_result = $rc[0]['RESULT'];
                $retfsplit = explode("|", $str_result);
                
                if ($retfsplit[2]=="LDAP")  { /* USER LDAP */
                    
                    /* load LDAP Class */
                    $this->load->model('Ldap_connection');
                    
                    /* Open LDAP Connection */
                    $auth = $this->Ldap_connection->Open($username, $password);
                                        
                    if ($auth == 1) { /* authentifikasi LDAP Telkom berhasil */
                   	  
                   	  $rc = $this->M_user->getUserPwd($this->security->xss_clean($username), $pwd_md5)->result_array();
                   	  $this->setUserSession($rc[0]);
                   	  $this->checkUserProfile($rc[0]['USER_ID']);
                   	  
                      echo json_encode(array('success' => true, 'msg' => "You will be direct .. !"));  
                    }else {
                      echo json_encode(array('success' => false, 'msg' => "User/Password tidak terdaftar di LDAP"));
                    }
                }else { /* NOT LDAP, USER NON KARYAWAN */
                    
                    if( empty($retfsplit[0]) or $retfsplit[1] != "0" ) { /* if user_id == 0 or user_id == "" */ 
                        echo json_encode(array('success' => false, 'msg' => $retfsplit[2]));    
                    }else {
                        
                        $rc = $this->M_user->getUserPwd($this->security->xss_clean($username), $pwd_md5)->result_array();
                   	    $this->setUserSession($rc[0]);
                   	    $this->checkUserProfile($rc[0]['USER_ID']);
                   	    
                   	    echo json_encode(array('success' => true, 'msg' => "You will be direct .. !"));
                   	    
                    }
                    
                }
                                
            }
            
        } else {
            echo json_encode(array('success' => false, 'msg' => "Disallow character"));
        }
    }
    
    
    public function checkUserProfile($user_id) {
        $profs = $this->M_user->getUserProfile($user_id);

        if (count($profs) == 0) {
            $this->session->set_userdata("d_user_id", "");
            $this->session->set_userdata('d_message', "You don't have profile. <br>Please contact your administrator !");

            echo json_encode(array('success' => false, 'msg' => "You don't have profile. <br>Please contact your administrator !"));
            exit;
        } elseif (count($profs) == 1) {
            foreach ($profs as $k => $v) {
                $prof_id = $k;
                $prof_name = $v;
            }
            $this->session->set_userdata('d_prof_id', $prof_id);
            $this->session->set_userdata('d_prof_name', $prof_name);
        }
        
    }
    
    public function setUserSession($data_user) {
        
        $sessions = array(
            'd_user_id' => $data_user['USER_ID'],
            'd_user_name' => $data_user['USER_NAME'],
            'd_nik' => $data_user['NIK'],
            'd_email' => $data_user['EMAIL']
        );

        //Set session
        $this->session->set_userdata($sessions);
    }
    
    public function profile()
    {
        $this->load->view('templates/interval');
    }


}
