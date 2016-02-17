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

        $this->load->model('M_jqGrid', 'jqGrid');
        $this->load->model('M_managementmitra', 'm_mitra');
        $this->load->model('Mfee');

//        if (!$this->input->is_ajax_request()) {
//            exit('No direct script access allowed');
//        }
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
        $data['ccid'] = $this->input->post('ccid');
        $data['mitra'] = $this->input->post('mitra');
        $data['lokasisewa'] = $this->input->post('lokasisewa');
        $data['segment'] = $this->input->post('segment');
        $this->load->view($this->folder . '/detail_mitra', $data);
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

    public function fastels()
    {
        // Default periode current yyyymm
        $tahun = date("Y");
        $bulan = date("m");
        $data['periode'] = $tahun . "" . $bulan;

        $this->load->view($this->folder . '/fastel', $data);
    }

    public function gridFastel($temp_period, $pgl_id, $ten_id)
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        if ($this->input->post('searchField') == "ND1") {
            $s_field = "B.ND";
        } else {
            $s_field = $this->input->post('searchField');
        }

        if ($this->input->post('periode')) {
            $periode = $this->input->post('periode');
        } else {
            $periode = $temp_period;
        }

        //JqGrid Parameters
        $req_param = array(
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "ten_id" => $ten_id,
            "pgl_id" => $pgl_id,
            "period" => $periode,
            "search" => $this->input->post('_search'),
            "search_field" => ($s_field) ? $s_field : null,
            "search_operator" => ($this->input->post('searchOper')) ? $this->input->post('searchOper') : null,
            "search_str" => ($this->input->post('searchString')) ? ($this->input->post('searchString')) : null
        );


        // Get limit paging
        $count = $this->m_mitra->getFastel($req_param)->num_rows();
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->m_mitra->getFastel($req_param)->result_array();
        echo json_encode($result);

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

    public function listCC()
    {
        $this->load->model('mfee');
        $segmen = $this->input->post('segmen');
        $result = $this->mfee->getCCbySEGMEN($segmen);


        $option = "";
        if ($result->num_rows() > 0) {
            $option .= "<option value=''> Pilih CC </option>";
            foreach ($result->result() as $content) {
                $option .= "<option value=" . $content->ID . ">" . $content->NAME . "</option>";
            }
        } else {
            $option .= "<option value=''> Tidak ada CC </option>";
        }

        echo $option;


    }

    public function listMitra()
    {
        $this->load->model('mfee');
        $ccid = intval($this->input->post('ccid'));
        $result = $this->mfee->getMitraByCC($ccid);


        $option = "";
        if ($result->num_rows() > 0) {
            $option .= "<option value=''> Pilih Mitra </option>";
            foreach ($result->result() as $content) {
                $option .= "<option value='" . $content->ID . "'>" . $content->NAME . "</option>";
            }

        } else {
            $option .= "<option value=''> Tidak ada mitra </option>";
        }

        echo $option;


    }

    public function listLokasiSewa()
    {
        $this->load->model('mfee');
        $mitra = $this->input->post('mitra');
        $result = $this->mfee->getLokasisewaByMitra($mitra);

        $option = "";
        if ($result->num_rows() > 0) {
            $option .= "<option value=''> Pilih Lokasi Sewa </option>";
            foreach ($result->result() as $content) {
                $option .= "<option value='" . $content->ID . "'>" . $content->NAME . "</option>";

            }

        } else {
            $option .= "<option value=''> Tidak ada Lokasi Sewa </option>";
        }

        echo $option;


    }

    public function gridPIC()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "V_MAP_MIT_CC";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "or_where" => null,
            "or_where_in" => null,
            "or_where_not_in" => null,
            "search" => $this->input->post('_search'),
            "search_field" => ($this->input->post('searchField')) ? $this->input->post('searchField') : null,
            "search_operator" => ($this->input->post('searchOper')) ? $this->input->post('searchOper') : null,
            "search_str" => ($this->input->post('searchString')) ? ($this->input->post('searchString')) : null
        );

        // Filter Table *

        $segment = $this->input->post('segment');
        $ccid = $this->input->post('ccid');
        $mitra = $this->input->post('mitra');
        $lokasisewa = $this->input->post('lokasisewa');
        if ($segment) {
            $req_param['where'] = array('SEGMENT' => $segment);
        }
        if ($ccid) {
            $req_param['where'] = array('ID_CC' => $ccid);
        }
        if ($mitra) {
            $req_param['where'] = array('PGL_ID' => $mitra);
        }
        if ($lokasisewa) {
            $req_param['where'] = array('P_MP_LOKASI_ID' => $lokasisewa);
        }


        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function lovPIC()
    {
        $data['divID'] = $this->input->post('divID');
        $data['lov_target_id'] = $this->input->post('lov_target_id');
        $data['modal_id'] = $this->input->post('modal_id');
        $this->load->view('managementmitra/lov_pic', $data);
    }
    public function lovSegment()
    {
        $data['divID'] = $this->input->post('divID');
        $data['lov_target_id'] = $this->input->post('lov_target_id');
        $data['modal_id'] = $this->input->post('modal_id');
        $this->load->view('managementmitra/lov_segment', $data);
    }

    public function lovCC()
    {
        $data['divID'] = $this->input->post('divID');
        $data['lov_target_id'] = $this->input->post('lov_target_id');
        $data['modal_id'] = $this->input->post('modal_id');
        $data['cc_name'] = $this->input->post('cc_name');
        $this->load->view('managementmitra/lov_cc', $data);
    }
    public function lovMitra()
    {
        $data['divID'] = $this->input->post('divID');
        $data['lov_target_id'] = $this->input->post('lov_target_id');
        $data['modal_id'] = $this->input->post('modal_id');
        $this->load->view('managementmitra/lov_mitra', $data);
    }

    public function lovEAM()
    {
        $data['divID'] = $this->input->post('divID');
        $data['lov_target_id'] = $this->input->post('lov_target_id');
        $data['modal_id'] = $this->input->post('modal_id');
        $this->load->view('managementmitra/lov_eam', $data);
    }

    public function grid_lov_pic()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "P_PIC";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "or_where" => null,
            "or_where_in" => null,
            "or_where_not_in" => null,
            "search" => null,
            "search_field" => null,
            "search_operator" => null,
            "search_str" =>  null
        );

        if($this->input->post('_search') == "true"){
            $filter = json_decode($this->input->post('filters'));
            $req_param['search'] = "true";
            $req_param['search_field'] = $filter->rules[0]->field;
            $req_param['search_operator'] = $filter->rules[0]->op;
            $req_param['search_str'] = $filter->rules[0]->data;
        }

        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function grid_lov_eam()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "P_DAT_AM";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "or_where" => null,
            "or_where_in" => null,
            "or_where_not_in" => null,
            "search" => null,
            "search_field" => null,
            "search_operator" => null,
            "search_str" =>  null
        );

        if($this->input->post('_search') == "true"){
            $filter = json_decode($this->input->post('filters'));
            $req_param['search'] = "true";
            $req_param['search_field'] = $filter->rules[0]->field;
            $req_param['search_operator'] = $filter->rules[0]->op;
            $req_param['search_str'] = $filter->rules[0]->data;
        }

        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function grid_lov_cc()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "V_PARAM_SEGMENT_CC";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "or_where" => null,
            "or_where_in" => null,
            "or_where_not_in" => null,
            "search" => null,
            "search_field" => null,
            "search_operator" => null,
            "search_str" =>  null
        );

        $req_param["where"] = array("CODE_SGM" => $this->input->post("cc_name"));
        if($this->input->post('_search') == "true"){
            $filter = json_decode($this->input->post('filters'));
            $req_param['search'] = "true";
            $req_param['search_field'] = $filter->rules[0]->field;
            $req_param['search_operator'] = $filter->rules[0]->op;
            $req_param['search_str'] = $filter->rules[0]->data;
        }
        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }



    public function grid_lov_segment()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "SELECT DISTINCT(CODE_SGM) CODE_SGM, SEGMENT_NAME FROM MV_PARAM_SEGMENT_CC";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => null,
            "search_field" => null,
            "search_operator" =>  null,
            "search_str" =>  null
        );

        if($this->input->post('_search') == "true"){
            $filter = json_decode($this->input->post('filters'));
            $req_param['search'] = "true";
            $req_param['search_field'] = $filter->rules[0]->field;
            $req_param['search_operator'] = $filter->rules[0]->op;
            $req_param['search_str'] = $filter->rules[0]->data;
        }

        // Get limit paging
        $count = $this->jqGrid->countAllQuery($req_param);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_dataQuery($req_param);
        echo json_encode($result);

    }

    public function grid_lov_mitra()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "CUST_PGL";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "or_where" => null,
            "or_where_in" => null,
            "or_where_not_in" => null,
            "search" => null,
            "search_field" => null,
            "search_operator" => null,
            "search_str" =>  null
        );

        if($this->input->post('_search') == "true"){
            $filter = json_decode($this->input->post('filters'));
            $req_param['search'] = "true";
            $req_param['search_field'] = $filter->rules[0]->field;
            $req_param['search_operator'] = $filter->rules[0]->op;
            $req_param['search_str'] = $filter->rules[0]->data;
        }
        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function gridPKS()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "P_PKS";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "or_where" => null,
            "or_where_in" => null,
            "or_where_not_in" => null,
            "search" => $this->input->post('_search'),
            "search_field" => ($this->input->post('searchField')) ? $this->input->post('searchField') : null,
            "search_operator" => ($this->input->post('searchOper')) ? $this->input->post('searchOper') : null,
            "search_str" => ($this->input->post('searchString')) ? ($this->input->post('searchString')) : null
        );

        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function modalUploadPKS()
    {
        $this->load->view($this->folder . '/modal_upload_pks');
    }

    public function modalUploadKontrak()
    {
        $this->load->view($this->folder . '/modal_upload_kontrak');
    }

    public function pks_uploaddo()
    {
        $no_pks = trim(strtoupper($this->input->post("no_pks")));
        $doc_name = trim(strtoupper($this->input->post("doc_name")));
        $start_date_pks = $this->input->post("start_date_pks");
        $end_date_pks = $this->input->post("end_date_pks");
        $lokasi_pks = 5;

        if ($lokasi_pks != "") {
            // Upload Process
            $config['upload_path'] = './application/third_party/upload/pks';
            $config['allowed_types'] = 'docx|pdf';
            $config['max_size'] = '0';
            $config['overwrite'] = TRUE;
            $file_id = time();
            $config['file_name'] = str_replace(" ", "_", $doc_name) . "_" . $file_id;

            $this->load->library('upload');
            $this->upload->initialize($config);

            //cek duplicate
            $ck = $this->Mfee->checkDuplicate('P_PKS', 'DOC_NAME', $doc_name);

            if ($ck == 1) {

                $data['status'] = false;
                $data['msg'] = "<br><div class='alert alert-danger'>" . "
											<button type='button' class='close' data-dismiss='alert'>
												<i class='ace-icon fa fa-times'></i>
											</button> Dokumen sudah ada !
										</div>";
                echo json_encode($data);
            } else {
                if (!$this->upload->do_upload("filename")) {
                    $error = $this->upload->display_errors();
                    $data['status'] = "F";
                    $data['msg'] = "<br><div class='alert alert-danger'>" . "
											<button type='button' class='close' data-dismiss='alert'>
												<i class='ace-icon fa fa-times'></i>
											</button>
											    " . $error . "
										</div>";
                    echo json_encode($data);
                } else {
                    // Do Upload
                    $data = $this->upload->data();
                    $datas = array(
                        "NO_PKS" => $no_pks,
                        "DOC_NAME" => $doc_name,
                        "FILE_PATH" => $data['file_name'],
                        "PKS_START_DATE" => date('d/M/Y', strtotime($start_date_pks)),
                        "PKS_END_DATE" => date('d/M/Y', strtotime($end_date_pks)),
                        "UPDATE_DATE" => date('d/M/Y'),
                        "UPDATE_BY" => $this->session->userdata('d_user_name')
                    );

                    $this->m_mitra->insertPKS($datas);
                    $data['success'] = true;
                    $data['msg'] = "Upload Berhasil";
                    echo json_encode($data);

                }
            }

        }

    }

    public function kontrak_uploaddo()
    {
        $doc_name = trim(strtoupper($this->input->post("doc_name")));
        // Upload Process
        $config['upload_path'] = './application/third_party/upload/kontrak';
        $config['allowed_types'] = 'docx|pdf|doc|gif|jpg|png';
        $config['max_size'] = '0';
        $config['overwrite'] = TRUE;
        $file_id = time();
        $config['file_name'] = str_replace(" ", "_", $doc_name) . "_" . $file_id;

        $this->load->library('upload');
        $this->upload->initialize($config);

        //cek duplicate
        $ck = $this->Mfee->checkDuplicate('P_DOK_KONTRAK', 'DOC_NAME', $doc_name);

        if ($ck == 1) {

            $data['status'] = false;
            $data['msg'] = "Nama dokumen sudah ada !";
            echo json_encode($data);
        } else {
            if (!$this->upload->do_upload("filename")) {
                $error = $this->upload->display_errors();
                $data['status'] = "F";
                $data['msg'] =  $error ;
                echo json_encode($data);
            } else {
                // Do Upload
                $data = $this->upload->data();
                $datas = array(
                    "DOC_NAME" => $doc_name,
                    "FILE_PATH" => $data['file_name'],
                    "UPDATE_DATE" => date('d/M/Y'),
                    "UPDATE_BY" => $this->session->userdata('d_user_name')
                );

                $this->m_mitra->insertDokKontrak($datas);
                $data['success'] = true;
                $data['msg'] = "Upload Berhasil";
                echo json_encode($data);

            }
        }


    }

    public function downloadPKS($FILE_PATH)
    {
        //$FILE_PATH = $this->input->post('FILE_PATH');
        $data = file_get_contents("./application/third_party/upload/pks/" . $FILE_PATH);
        force_download($FILE_PATH, $data);
    }

        public function downloadDokKontrak($FILE_PATH)
    {
        $data = file_get_contents("./application/third_party/upload/kontrak/" . $FILE_PATH);
        force_download($FILE_PATH, $data);
    }

    public function crud_pks()
    {
        $this->m_mitra->crud_pks();
    }

    public function crud_kontrak()
    {
        $this->m_mitra->crud_kontrak();
    }

    public function gridDocKontrak()
    {
        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "P_DOK_KONTRAK";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "or_where" => null,
            "or_where_in" => null,
            "or_where_not_in" => null,
            "search" => $this->input->post('_search'),
            "search_field" => ($this->input->post('searchField')) ? $this->input->post('searchField') : null,
            "search_operator" => ($this->input->post('searchOper')) ? $this->input->post('searchOper') : null,
            "search_str" => ($this->input->post('searchString')) ? ($this->input->post('searchString')) : null
        );

        // Get limit paging
        $count = $this->jqGrid->countAll($req_param);
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1);

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function mitra_form(){
        $data["action"] = $this->input->post("action");
        $this->load->view('managementmitra/add_mitra',$data);
    }

    public function crud_detailmitra(){
        $return = $this->m_mitra->crud_detailmitra();
        if($return == 1){
            $data["success"] = true;
            $data["message"] = "Data berhasil ditambahakan";

        }else{
            $data["success"] = false;
            $data["message"] = "Gagal menambah data";
        }
        echo json_encode($data);
    }

}