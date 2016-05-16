<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller
{

    private $head = "Invoice";

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        checkAuth();
        $this->load->model('M_jqGrid', 'jqGrid');
        //$this->load->model('T_invoice');
    }


    public function index() {
        redirect("/");
    }

    public function rincian_invoice(){
        $title = "Monitoring Invoice";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);
        
        $this->load->view('invoice/rincian_invoice');
    }

}
