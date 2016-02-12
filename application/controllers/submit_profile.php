<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Submit_profile extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}

	public function page($encrypted_id) {
	    	    
	    $data = array();
	    $data['id'] = $encrypted_id;
	    
        $this->load->view('submit_profile/index', $data);
    }
    
}