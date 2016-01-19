<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template extends CI_Controller
{

    private $head = "Template";
    private $folder = "template";

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('encrypt');
        checkAuth();
        $this->load->helper('download');
        $this->load->model('mcrud', 'crud');

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
    }

    public function index()
    {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('template/filter_template');
    }

    public function list_template()
    {
        $result['result'] = $this->db->get('V_DOC')->result();

        $this->load->view($this->folder . '/view_template', $result);
    }

    public function create_user()
    {
        $this->load->model('M_cm', 'cm');
        if ($this->session->userdata('d_prof_id') == 3) {
            $result['result'] = $this->cm->getPglListByID($this->session->userdata('d_user_id'));
        } else {
            $result['result'] = $this->cm->getPglList();
        }
        $this->load->view($this->folder . '/create_user', $result);
    }


}