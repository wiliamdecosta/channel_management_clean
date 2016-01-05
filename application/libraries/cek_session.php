<?php
	
Class Cek_session {	
    public function __construct() {

    }
    public function cek_ses() {
		$CI =& get_instance();
		if($CI->session->userdata('d_user_id')=="" || $CI->session->userdata('d_prof_id')=="") {
				redirect("auth");
		}
    }
}