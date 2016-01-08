<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skema_bisnis extends CI_Controller {

    private $head = "Marketing Fee";
    private $folder = "skema_bisnis";

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

        $this->load->view($this->folder.'/filter_skema_bisnis', $result);
    }

    public function createSkema() {
        $this->load->view($this->folder.'/create_skema');
    }
    
    public function createSkemaDetailProduk() {
        $this->load->view($this->folder.'/create_skema_detail_produk');
    }
    
    public function createSkemaBlended() {
        $this->load->view($this->folder.'/create_skema_blended');
    }
    
    public function createSkemaRC100() {
        $this->load->view($this->folder.'/create_skema_rc_100');
    }
    
    public function createSkemaRCGreater100() {
        $this->load->view($this->folder.'/create_skema_rc_greater_100');
    }
    
    public function createSkemaPAYG() {
        $this->load->view($this->folder.'/create_skema_payg');
    }
    
    public function createSkemaPaygPositiveGrowth() {
        $this->load->view($this->folder.'/create_skema_payg_positive_growth');
    }
    
    public function createSkemaPaygNegativeGrowth() {
        $this->load->view($this->folder.'/create_skema_payg_negative_growth');
    }
    
    public function calculateMF(){
        $this->load->view($this->folder.'/calculate_mf');
    }

    public function createBARekon(){
        $this->load->view($this->folder.'/create_ba_rekon');
    }

    public function createPerhitunganBillco(){
        $this->load->view($this->folder.'/create_perhitungan_billco');
    }

    public function createNPK(){
        $this->load->view($this->folder.'/create_npk');
    }
    
    public function evaluasiMitra(){
        $this->load->view($this->folder.'/evaluasi_mitra');
    }
}