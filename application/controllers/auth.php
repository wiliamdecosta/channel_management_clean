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

    public function login()
    {
        $this->load->model('M_user');
        $nik = strtoupper($this->security->xss_clean($this->input->post('nik')));
        $pwd = MD5($this->security->xss_clean($this->input->post('pwd')));

        //Returns TRUE if every character in text is either a letter or a digit, FALSE otherwise.
        if (ctype_alnum($nik)) {
            $rc = $this->M_user->getUserPwd($this->security->xss_clean($nik), $pwd)->result();
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
                $rc = $this->M_user->getLists("NIK='" . strtoupper($nik) . "'");
                if (count($rc) > 0) {
                    // $this->session->set_userdata('d_message', "Password is wrong !");
                    echo json_encode(array('msg' => "Password is wrong !"));
                } else {
                    //$this->session->set_userdata('d_message', "User belum terdaftar !");
                    echo json_encode(array('msg' => "User belum terdaftar !"));
                }
            }

        } else {
            echo json_encode(array('msg' => "Disallow character"));
        }
    }

    public function profile()
    {
        $this->load->view('templates/interval');
    }


}
