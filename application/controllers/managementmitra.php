<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managementmitra extends CI_Controller {

    private $head = "Marketing Fee";
    private $folder = "managementmitra";

	function __construct() {
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        checkAuth();

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
	}

	public function index() {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

        // Fungsi dropdown tenant
        $this->load->model('M_cm','cm');
        if($this->session->userdata('d_prof_id') == 3) {
            $result['result'] = $this->cm->getPglListByID($this->session->userdata('d_user_id'));
        } else {
            $result['result'] = $this->cm->getPglList();
        }

        $this->load->view('global/filter_mitra',$result);
    }

    public function detailMitra() {
        $this->load->view($this->folder.'/detail_mitra');
    }
    public function dokPKS(){
        $this->load->view($this->folder.'/dok_pks');
    }




}