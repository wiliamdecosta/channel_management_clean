<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Summary extends CI_Controller
{

    private $head = "Marketing Fee";
    private $folder = "summary";

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('encrypt');
        checkAuth();

        $this->load->model('mcrud', 'crud');

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $this->load->model('M_summary', 'db_summary');

    }

    public function index()
    {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('summary/filter_summary');
    }

    public function trend_mf()
    {
        $this->load->view($this->folder . '/trend_mf');
    }

    public function mitra()
    {
        $data['array_mitra'] = $this->db_summary->getSummaryMitra();
        $this->load->view($this->folder . '/mitra',$data);
    }

    public function inventory()
    {
        $this->load->view($this->folder . '/inventory');
    }


}