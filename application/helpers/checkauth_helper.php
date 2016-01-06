<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter

 * @package		CodeIgniter
 * @author		Gery

 **/

    function checkAuth() {
        $CI =& get_instance();
        if($CI->session->userdata('d_user_id')=="" || $CI->session->userdata('d_prof_id')=="") {
           return redirect("auth");
        }
    }