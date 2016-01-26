<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Managementmitra extends CI_Controller
{

    private $head = "Marketing Fee";
    private $folder = "managementmitra";

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('encrypt');
        checkAuth();
        $this->load->helper('download');

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

        $this->load->model('M_cm', 'cm');
        if ($this->session->userdata('d_prof_id') == 3) {
            $result['result'] = $this->cm->getPglListByID($this->session->userdata('d_user_id'));
        } else {
            $result['result'] = $this->cm->getPglList();
        }

        $this->load->view($this->folder . '/filter_mitra', $result);
    }

    public function detailMitra()
    {
        $this->load->view($this->folder . '/detail_mitra');
    }

    public function dokPKS()
    {

        $result['result'] = $this->db->get_where('DOC', array('DOC_TYPE_ID' => '1'))->result();

        $this->load->view($this->folder . '/dok_pks', $result);
    }

    public function dokNPK()
    {

        $result['result'] = $this->db->get_where('DOC', array('DOC_TYPE_ID' => '2'))->result();

        $this->load->view($this->folder . '/dok_npk', $result);
    }

    public function fastel()
    {
        $this->load->view($this->folder . '/fastel');
    }

    public function dokKontrak()
    {

        $result['result'] = $this->db->get_where('DOC', array('DOC_TYPE_ID' => '3'))->result();

        $this->load->view($this->folder . '/dok_kontrak', $result);
    }

    public function evaluasiMitra()
    {

        $result['result'] = $this->db->get_where('DOC', array('DOC_TYPE_ID' => '4'))->result();

        $this->load->view($this->folder . '/evaluasi_mitra', $result);
    }

    public function downloadDokPKS()
    {
        $data = file_get_contents(base_url('')); // Read the file's contents
        $name = 'myphoto.jpg';

        force_download($name, $data);
    }

    public function listCC()
    {
        $this->load->model('mfee');
        $segmen = $this->input->post('segmen');
        $result = $this->mfee->getCCbySEGMEN($segmen);

        $option = "";

        foreach ($result as $content) {
            $option .= "<option value=" . $content->ID . ">" . $content->NAME . "</option>";
        }
        echo $option;


    }


}