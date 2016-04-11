<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Parameter extends CI_Controller
{

    private $head = "Parameter";

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        checkAuth();
        $this->load->model('M_cm', 'cm');
        $this->load->model('M_param');
        $this->load->model('M_tenant');
        $this->load->model('M_jqGrid', 'jqGrid');
        $this->load->model('M_parameter');
        $this->load->model('Mfee');
    }


    public function index()
    {
        redirect("/");
    }

    public function batchType()
    {

        $title = "Batch Type";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('parameter/list_batchtype');
    }


    public function attribute_type()
    {

        $title = "Attribute Type";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('parameter/attribute_type');
    }

    public function mitra()
    {
        $title = "Mitra";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('parameter/mitra');
    }


    public function gridBatchType()
    {
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "P_BATCH_TYPE";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        $req_param['field'] = array();
        $req_param['value'] = array();

        $row = $this->jqGrid->get_data($req_param)->result_array();
        $count = count($row);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function crud_batchType()
    {
        $this->M_parameter->crud_batchType();
    }

    public function crud_profile()
    {
        // crud(tabel_name,field_id,key_unix,field yg mau di insert/update)
        $table = "APP_PROFILE";
        $id = $this->input->post('id');
        $this->jqGrid->crud($table, 'PROF_ID', $id, array('PROF_NAME', 'PROF_DESC'));
    }
    public function datin_main_page()
    {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);
        $this->load->view('parameter/uploaddatinmainpage', $result);
    }
    public function uploadDatin()
    {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $result['result'] = $this->cm->getPglList();
        $result['product'] = $this->M_param->getParamProducts();
        $this->load->view('parameter/uploaddatin', $result);
    }
    public function datinuploaddo()
    {
        $ten_id = $this->input->post("ten_id");
      //  $pu_action = $this->input->post("pu_action");
      //  $cprod = $this->input->post("cprod");
        //$file = $this->input->post("file");
        if ($ten_id != "") {
            // switch ($pu_action) {
            //     case 1:
            //         $this->M_tenant->NDBackupToCurrPeriod($ten_id);
            //         break;
            //     case 2:
            //         $this->M_tenant->NDBackupToPrevPeriod($ten_id);
            //         break;
            // }
            // Upload Process
            $config['upload_path'] = './application/third_party/upload';
            $config['allowed_types'] = 'xls|xlsx|csv';
            $config['max_size'] = '100000000';
            $config['overwrite'] = TRUE;
            $file_id = date("YmdHis");
            $config['file_name'] = "datin_" . $file_id;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload("filename")) {
                $error = $this->upload->display_errors();
                $data['status'] = "F";
                $data['msg'] = "<div class='alert alert-danger'>" . "
                      <button type='button' class='close' data-dismiss='alert'>
                        <i class='ace-icon fa fa-times'></i>
                      </button>
                          " . $error . "
                      <br />
                    </div>";
                echo json_encode($data);
            } else {
                // Do Upload
                $data = $this->upload->data();

                // Clear Temporary TEN_ND_TEMP by session ID
                //$username = $this->session->userdata('d_nik');
                //$this->M_tenant->clearTMPNDByUser($username);
                $cprod = 'a';
                // Parse file
                $this->datinuploadparse($data['file_name'], $data["file_ext"], $cprod, $ten_id, 0);
            }
        } else {
            $data['status'] = "F";
            $data['msg'] = "<div class='alert alert-danger'>" . "
                      <button type='button' class='close' data-dismiss='alert'>
                        <i class='ace-icon fa fa-times'></i>
                      </button>
                          Tenant belum dipilih
                      <br />
                    </div>";
            echo json_encode($data);
        }

    }

    public function datinuploadparse($file_name, $file_ext, $cprod, $ten_id = "", $confirm)
    {
        //error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
        error_reporting(0); 
        $this->load->library('phpexcel');

        if ($file_ext == ".xlsx") $readerType = 'Excel2007';
        elseif ($file_ext == ".xls") $readerType = 'Excel5';
        elseif ($file_ext == ".csv" || $file_ext == ".txt") $readerType = 'CSV';

        $reader = PHPExcel_IOFactory::createReader($readerType);
        $reader->setReadDataOnly(true);
        $phpexcel = $reader->load(APPPATH . 'third_party/upload/' . $file_name);
        $sh = $phpexcel->getActiveSheet();
        $highestRow = $sh->getHighestRow();
        $highestColumn = $sh->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

        if ($ten_id != "") {

                $username = $this->session->userdata('d_nik');
                $cekND = 0;
                //$batch_id = $this->M_tenant->getBatchID();
                $dataDatin = array();
                // $retStat='';
                // $retCount=0;
                $msgret = 'Duplicate Data on row';
                for ($row = 1; $row <= $highestRow; ++$row) {

                    $dataDatin['TEN_ID'] = $ten_id;
                    //$dataDatin['CUSTOMER_REF'] = $sh->getCellByColumnAndRow(0, $row)->getValue();
                    $dataDatin['ACCOUNT_NUM'] = $sh->getCellByColumnAndRow(0, $row)->getValue();
                    //$dataDatin['GL_ACCOUNT'] = $sh->getCellByColumnAndRow(2, $row)->getValue();
                    $dataDatin['PRODUCT_ID'] = $sh->getCellByColumnAndRow(1, $row)->getValue();
                    $dataDatin['USERID'] = $username;

                    $check = $this->M_tenant->insertDatin($dataDatin);
                   
                    if ($check > 0){
                        $msgret.= ' '.$row;
                        $cekND = 1;
                    }

                } // End Loop

                    if ($cekND > 0){
                        $data['status'] = "F";
                        $data['msg'] = $data['msg'] = "<div class='alert alert-danger'>" . "
                                                <button type='button' class='close' data-dismiss='alert'>
                                                    <i class='ace-icon fa fa-times'></i>
                                                </button>
                                                  ".$msgret."
                                                <br />
                                            </div>";
                    }else{
                        $data['status'] = "T";
                        $data['msg'] = $data['msg'] = "<div class='alert alert-success'>" . "
                                                <button type='button' class='close' data-dismiss='alert'>
                                                    <i class='ace-icon fa fa-times'></i>
                                                </button>
                                                  All records has been inserted successfully
                                                <br />
                                            </div>";
                    }
        
        }else{
                    $data['status'] = "F";
                    $data['msg'] = $data['msg'] = "<div class='alert alert-success'>" . "
                                                <button type='button' class='close' data-dismiss='alert'>
                                                    <i class='ace-icon fa fa-times'></i>
                                                </button>
                                                  Tenant belum dipilih
                                                <br />
                                            </div>";
        }
          echo json_encode($data);
    }

    public function datindel($ten_id, $nd)
    {
        $this->M_tenant->delNDTen($ten_id, $nd);
        redirect("/ten/nd/" . $ten_id);
    }


    public function uploadND()
    {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $result['result'] = $this->cm->getPglList();
        $result['product'] = $this->M_param->getParamProducts();
        $this->load->view('parameter/uploadnd', $result);
    }

    public function nduploaddo()
    {
        $ten_id = $this->input->post("ten_id");
        $pu_action = $this->input->post("pu_action");
        $cprod = $this->input->post("cprod");
        //$file = $this->input->post("file");
        if ($ten_id != "") {
            switch ($pu_action) {
                case 1:
                    $this->M_tenant->NDBackupToCurrPeriod($ten_id);
                    break;
                case 2:
                    $this->M_tenant->NDBackupToPrevPeriod($ten_id);
                    break;
            }
            // Upload Process
            $config['upload_path'] = './application/third_party/upload';
            $config['allowed_types'] = 'xls|xlsx|csv';
            $config['max_size'] = '100000000';
            $config['overwrite'] = TRUE;
            $file_id = date("YmdHis");
            $config['file_name'] = "nd_" . $file_id;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload("filename")) {
                $error = $this->upload->display_errors();
                $data['status'] = "F";
                $data['msg'] = "<div class='alert alert-danger'>" . "
											<button type='button' class='close' data-dismiss='alert'>
												<i class='ace-icon fa fa-times'></i>
											</button>
											    " . $error . "
											<br />
										</div>";
                echo json_encode($data);
            } else {
                // Do Upload
                $data = $this->upload->data();

                // Clear Temporary TEN_ND_TEMP by session ID
                $username = $this->session->userdata('d_nik');
                $this->M_tenant->clearTMPNDByUser($username);

                // Parse file
                $this->nduploadparse($data['file_name'], $data["file_ext"], $cprod, $ten_id, 0);
            }
        } else {
            $data['status'] = "F";
            $data['msg'] = "<div class='alert alert-danger'>" . "
											<button type='button' class='close' data-dismiss='alert'>
												<i class='ace-icon fa fa-times'></i>
											</button>
											    Tenant belum dipilih
											<br />
										</div>";
            echo json_encode($data);
        }

    }

    public function nduploadparse($file_name, $file_ext, $cprod, $ten_id = "", $confirm)
    {
        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
        $this->load->library('phpexcel');

        if ($file_ext == ".xlsx") $readerType = 'Excel2007';
        elseif ($file_ext == ".xls") $readerType = 'Excel5';
        elseif ($file_ext == ".csv" || $file_ext == ".txt") $readerType = 'CSV';


        $reader = PHPExcel_IOFactory::createReader($readerType);
        $reader->setReadDataOnly(true);
        $phpexcel = $reader->load(APPPATH . 'third_party/upload/' . $file_name);
        $sh = $phpexcel->getActiveSheet();
        $highestRow = $sh->getHighestRow();
        $highestColumn = $sh->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

        if ($ten_id != "") {

            if ($highestRow > 0) $this->M_tenant->clearNDTen($ten_id);
            $errmessage = '<h4>error :</h4> <br>';
            $msgcount = 0;
            $haha[] = '';
            if ($confirm <> 1) {
                for ($row = 2; $row <= $highestRow; ++$row) {
                    $nd = $sh->getCellByColumnAndRow(0, $row)->getValue();
                    $vf = $sh->getCellByColumnAndRow(1, $row)->getValue();
                    // $vt = $sh->getCellByColumnAndRow(2, $row)->getValue();

                    // Cek ND dan Valid From
                    if ($nd == '') {
                        $errmessage .= ' Row ke : ' . $row . ' ND tidak boleh kosong <br> ';
                        $msgcount += 1;
                    }
                    if ($vf == '') {
                        $errmessage .= ' Row ke : ' . $row . ' Valid From tidak boleh kosong <br> ';
                        $msgcount += 1;
                    }
                }
            }
            // Munculkan error di form view
            if ($msgcount > 0 && $confirm <> 1) {
                $data['status'] = "F";
                $data['msg'] = "<div class='alert alert-danger'>" . "
											<button type='button' class='close' data-dismiss='alert'>
												<i class='ace-icon fa fa-times'></i>
											</button>
											    " . $errmessage . "
											<br />
										</div>";
                echo json_encode($data);
                //echo "<br> <a href='".$url.'index.php/ten/ndupload'."'>Back To Upload Page</a>  |  <a href='".$uploadanyway.'1'."'>Upload Data Anyway</a>";

            } else {
                $username = $this->session->userdata('d_nik');
                $cekND = 0;
                $batch_id = $this->M_tenant->getBatchID();

                for ($row = 2; $row <= $highestRow; ++$row) {

                    $nd = $sh->getCellByColumnAndRow(0, $row)->getValue();
                    $vf = $sh->getCellByColumnAndRow(1, $row)->getValue();
                    $vt = $sh->getCellByColumnAndRow(2, $row)->getValue();

                    // Cek jika bukan CSV makan convert date Valid from dan Valid to || Format dd-mm-yyyy
                    if ($readerType <> 'CSV') {
                        $vfs = ($vf - 25569) * 86400;
                        $vf = gmdate("d-M-Y", $vfs);

                        if (trim($vt) != "") {
                            $vts = ($vt - 25569) * 86400;
                            $vt = gmdate("d-M-Y", $vts);
                        }
                    } else {
                        //Selain CSV gunakan format berikut
                        $vfs = str_replace('/', '-', $vf);
                        $vf = date('d-M-Y', strtotime($vfs));

                        if (trim($vt) != "") {
                            $vts = str_replace('/', '-', $vt);
                            $vt = date('d-M-Y', strtotime($vts));
                        }
                    }

                    if (trim($nd) != "") {
                        $status = $this->M_tenant->check_duplicateND($ten_id, str_replace("'", "", $nd), $vf, $vt, $cprod, $username, $batch_id);
                        $countND = 0;
                        if ($status == "SUCCESS") {
                            $countND = $countND + 1;
                        }
                    }
                } // End Loop
                // print_r($countND);
                //exit();

                //Insert ke batch_control jika $cekND > 0
                if ($countND > 0) {
                    $this->M_tenant->create_batch_expense($username, $batch_id);
                }


                // Cek TEN_ND_TEMP, Jika ada tulis ke notif
                $result = $this->M_tenant->getTenNDTemp();
                if ($result->num_rows() > 0) {
                    $rowTMP = $result->result();
                    foreach ($rowTMP as $row) {
                        if ($row->ERROR_CODE == '-1') {
                            $error = "Duplicate ND ! ";
                        } elseif ($row->ERROR_CODE == '-20000') {
                            $error = "Overlap ND ! ";
                        }
                        $msg[] = $row->ND . " -- " . $error;
                    }
                }
                //print_r($msg);
                //exit();
                // Implode
                if (count($msg) > 0) {
                    $msgs = implode("<br>", $msg);

                    $data['status'] = "F";
                    $data['msg'] = $data['msg'] = "<div class='alert alert-warning'>" . "
											<button type='button' class='close' data-dismiss='alert'>
												<i class='ace-icon fa fa-times'></i>
											</button>
											<b> Warning</b>
											<br>
											<br>
											  " . $msgs . "
                                            <br>
                                            <br>
											  <i> NB : Silahkan copy ND diatas untuk diupload ulang. </i>
											<br />
										</div>";
                    echo json_encode($data);
                } else {
                    $data['status'] = "T";
                    $data['msg'] = $data['msg'] = "<div class='alert alert-success'>" . "
                                                <button type='button' class='close' data-dismiss='alert'>
                                                    <i class='ace-icon fa fa-times'></i>
                                                </button>
                                                  All records has been inserted successfully
                                                <br />
                                            </div>";
                    echo json_encode($data);
                }
            }
        }

    }

    public function nddel($ten_id, $nd)
    {
        $this->M_tenant->delNDTen($ten_id, $nd);
        redirect("/ten/nd/" . $ten_id);
    }

    public function gridUserAttributeType()
    {
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "P_USER_ATTRIBUTE_TYPE";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        //$req_param['field'] = array();
        //$req_param['value'] = array();

        $count = $this->jqGrid->countAll($req_param);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function crud_user_attribute_type()
    {
        $this->M_parameter->crud_user_attribute_type();
    }


    public function gridUserAttributeList()
    {
        $id = $this->input->post('parent_id');
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "P_USER_ATTRIBUTE_LIST";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        $req_param['where'] = array('P_USER_ATTRIBUTE_TYPE_ID' => $id);

        //$req_param['field'] = array();
        //$req_param['value'] = array();

        $count = $this->jqGrid->countAll($req_param);
        //print_r($row);exit;
        //$count = count($row);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $this->parent_id = $id;
        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function crud_user_attribute_list()
    {
        $this->M_parameter->crud_user_attribute_list();
    }

    //Reference
    public function reference()
    {
        $title = "Reference";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $result['result'] = $this->cm->getPglList();
        $result['product'] = $this->M_param->getParamProducts();
        $this->load->view('parameter/reference');
    }


    public function gridReference()
    {
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "P_REFERENCE_TYPE";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        //$req_param['field'] = array();
        //$req_param['value'] = array();

        $row = $this->jqGrid->get_data($req_param)->result_array();
        //print_r($row);exit;
        $count = count($row);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function crud_reference()
    {
        $this->M_parameter->crud_reference();
    }

    public function gridReferenceList()
    {
        $id = $this->input->post('parent_id');
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "P_REFERENCE_LIST";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        $req_param['where'] = array('P_REFERENCE_TYPE_ID' => $id);

        //$req_param['field'] = array();
        //$req_param['value'] = array();

        $row = $this->jqGrid->get_data($req_param)->result_array();
        //print_r($row);exit;
        $count = count($row);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $this->parent_id = $id;
        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function crud_reference_list()
    {
        $this->M_parameter->crud_reference_list();
    }


    public function gridCustPGL()
    {
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

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
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        //$req_param['field'] = array();
        //$req_param['value'] = array();

        $count = $this->jqGrid->countAll($req_param);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function crud_cust_pgl()
    {
        $this->M_parameter->crud_cust_pgl();
    }


    public function gridCustTEN()
    {
        $id = $this->input->post('parent_id');
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "SELECT a.TEN_ID, a.NCLI, a.TEN_NAME, a.TEN_ADDR, a.TEN_CONTACT_NO, b.PGL_ID
                    FROM CUST_TEN a
                    LEFT JOIN PGL_TEN b ON a.TEN_ID = b.TEN_ID";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        // Filter Table *
        $req_param['where'] = array('b.PGL_ID = ' . $id);

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        //print_r($row);exit;
        //$count = count($row);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );


        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);

    }

    public function crud_cust_ten()
    {
        $this->M_parameter->crud_cust_ten();
    }

    public function gridTenND()
    {

        $id = $this->input->post('parent_id');
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "TEN_ND";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        // Filter Table *
        $req_param['where'] = array('TEN_ID' => $id);

        //$req_param['field'] = array();
        //$req_param['value'] = array();

        $count = $this->jqGrid->countAll($req_param);
        //print_r($row);exit;
        //$count = count($row);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $this->parent_id = $id;
        if ($page == 0) {
            $result['page'] = 1;
        } else {
            $result['page'] = $page;
        }
        //$result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    //PIC
    public function pic()
    {

        $title = "PIC";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $result['result'] = $this->cm->getPglList();
        $result['product'] = $this->M_param->getParamProducts();

        $this->load->view('parameter/pic');
    }


    public function gridPic()
    {
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

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
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        //$req_param['field'] = array();
        //$req_param['value'] = array();

        $row = $this->jqGrid->get_data($req_param)->result_array();
        //print_r($row);exit;
        $count = count($row);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function crud_pic()
    {
        $this->M_parameter->crud_pic();
    }


    //DAT_AM
    public function DAT_AM()
    {
        $title = "AM";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $result['result'] = $this->cm->getPglList();
        $result['product'] = $this->M_param->getParamProducts();

        $this->load->view('parameter/dat_am');
    }


    public function gridDAT_AM()
    {
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

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
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );


        //$req_param['field'] = array();
        //$req_param['value'] = array();

        $row = $this->jqGrid->get_data($req_param)->result_array();
        //print_r($row);exit;
        $count = count($row);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }


    public function crud_DAT_AM()
    {
        $this->M_parameter->crud_DAT_AM();
    }

    public function fastel()
    {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);


        // prof id 3 = C2BI User
        $this->load->model('M_cm', 'cm');
        if ($this->session->userdata('d_prof_id') == 3) {
            $result['result'] = $this->cm->getPglListByID($this->session->userdata('d_user_id'));
        } else {
            $result['result'] = $this->cm->getPglList();
        }

        $this->load->view('parameter/view_fastel', $result);

    }

    public function show_fastel()
    {
        $data['ten_id'] = $this->input->post("ten_id");
        $this->load->view('parameter/list_fastel', $data);
    }

    public function gridFastel()
    {
        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "TEN_ND";

        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        $req_param['where'] = array('TEN_ID' => $this->input->post("ten_id"));

        $row = $this->jqGrid->get_data($req_param)->result_array();
        //print_r($row);exit;
        $count = count($row);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);
    }

    public function crud_fastel()
    {
        $this->M_parameter->crud_fastel();
    }

    public function modalUploadFastel()
    {
        $upload_param = $this->input->post('upload_param');
        // 1 = upload, 2 = update

        if ($upload_param == 1) {
            $result['param_code'] = "Add Fastel";
        } else {
            $result['param_code'] = "Update Fastel";
        }

        $result['param_upload'] = $upload_param;
        $result['product'] = $this->M_param->getParamProducts();
        $this->load->view('parameter/upload_fastel', $result);
    }

    public function fastel_uploaddo()
    {
        $ten_id = $this->input->post("ten_id");
        $pu_action = $this->input->post("pu_action");
        $cprod = $this->input->post("cprod");
        $param_upload = $this->input->post("param_upload");

        if ($ten_id != "") {
            switch ($pu_action) {
                case 1:
                    $this->M_tenant->NDBackupToCurrPeriod($ten_id);
                    break;
                case 2:
                    $this->M_tenant->NDBackupToPrevPeriod($ten_id);
                    break;
            }
            // Upload Process
            $config['upload_path'] = './application/third_party/upload';
            $config['allowed_types'] = 'xls|xlsx|csv';
            $config['max_size'] = '100000000';
            $config['overwrite'] = TRUE;
            $file_id = date("YmdHis");
            $config['file_name'] = "fastel_" . $file_id;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload("filename")) {
                $error = $this->upload->display_errors();
                $data['status'] = "F";
                $data['msg'] = "<div class='alert alert-danger'>" . "
											<button type='button' class='close' data-dismiss='alert'>
												<i class='ace-icon fa fa-times'></i>
											</button>
											    " . $error . "
											<br />
										</div>";
                echo json_encode($data);
            } else {
                // Do Upload
                $data = $this->upload->data();
                // Clear Temporary TEN_ND_TEMP by session ID
                $username = $this->session->userdata('d_nik');
                $this->M_tenant->clearTMPNDByUser($username);

                // Parse file
                $this->fasteluploadparse($data['file_name'], $data["file_ext"], $cprod, $ten_id, $param_upload);
            }
        }

    }

    public function fasteluploadparse($file_name, $file_ext, $cprod, $ten_id = "", $param_upload)
    {
        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
        $this->load->library('phpexcel');

        if ($file_ext == ".xlsx") $readerType = 'Excel2007';
        elseif ($file_ext == ".xls") $readerType = 'Excel5';
        elseif ($file_ext == ".csv" || $file_ext == ".txt") $readerType = 'CSV';

        $reader = PHPExcel_IOFactory::createReader($readerType);
        $reader->setReadDataOnly(true);
        $phpexcel = $reader->load(APPPATH . 'third_party/upload/' . $file_name);
        $sh = $phpexcel->getActiveSheet();
        $highestRow = $sh->getHighestRow();
        $highestColumn = $sh->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

        // jika 2 = upload
        if ($param_upload == 2) {
            $this->M_parameter->deleteFastelByTenant($ten_id);
        }
        //print_r($this->db->last_query());
        //exit();
        for ($row = 1; $row <= $highestRow; ++$row) {
            $nd = $sh->getCellByColumnAndRow(0, $row)->getValue();
            $vf = $sh->getCellByColumnAndRow(1, $row)->getValue();
            $vt = $sh->getCellByColumnAndRow(2, $row)->getValue();

            // Cek jika bukan CSV makan convert date Valid from dan Valid to || Format dd-mm-yyyy
            if ($readerType <> 'CSV') {
                $vfs = ($vf - 25569) * 86400;
                $vf = gmdate("d-M-Y", $vfs);

                if (trim($vt) != "") {
                    $vts = ($vt - 25569) * 86400;
                    $vt = gmdate("d-M-Y", $vts);
                }
            } else {
                //Selain CSV gunakan format berikut
                $vfs = str_replace('/', '-', $vf);
                $vf = date('d-M-Y', strtotime($vfs));

                if (trim($vt) != "") {
                    $vts = str_replace('/', '-', $vt);
                    $vt = date('d-M-Y', strtotime($vts));
                }
            }

            // Insert ND
            $data = array(
                'TEN_ID' => $ten_id,
                'ND' => $nd,
                'CPROD' => $cprod,
                'CREATED_DATE' => date('d/M/Y'),
                'CREATED_BY' => $this->session->userdata('d_user_name')
            );

            $check = $this->Mfee->checkDuplicateND($ten_id, $nd);
            if ($check == 0) {
                $this->M_parameter->insertFastel($data);
            }
        }

        $data['success'] = true;
        $data['msg'] = "Upload Berhasil";
        echo json_encode($data);
    }

    public function gridMapMitraSegment()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : null;
        $sord = isset($_POST['sord']) ? $_POST['sord'] : null;

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

        $P_MAP_MIT_CC_ID = $this->input->post('P_MAP_MIT_CC_ID');
        if ($P_MAP_MIT_CC_ID) {
            $req_param['where'] = array('P_MAP_MIT_CC_ID' => $P_MAP_MIT_CC_ID);
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

    public function mitra_segment()
    {
        //BreadCrumb
        $title = $_POST['title'];
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('parameter/mitra_segment');
    }

    public function addmitra()
    {
        $data["action"] = $this->input->post("action");
        $this->load->view('parameter/mitra_form', $data);
    }

    public function editmitra()
    {
        $data["action"] = $this->input->post("action");
        $this->load->view('parameter/mitra_form', $data);
    }

    public function crud_detailmitra()
    {
        $this->M_parameter->crud_detailmitra();
    }

    public function mapping_mitra()
    {
        $this->load->view('parameter/mapping_mitra');
    }

    public function mapping_lokasi()
    {
        $data["p_map_mit_cc_id"] = $this->input->post("P_MAP_MIT_CC_ID");
        $this->load->view('parameter/mapping_lokasi', $data);
    }
    public function mapping_pic()
    {
        $data["P_MP_LOKASI_ID"] = $this->input->post("P_MP_LOKASI_ID");
        $data["p_map_mit_cc_id"] = $this->input->post("P_MAP_MIT_CC_ID");
        $this->load->view('parameter/mapping_pic', $data);
    }

    public function gridMapMitraLokasi()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : null;
        $sord = isset($_POST['sord']) ? $_POST['sord'] : null;

        $table = "P_MP_LOKASI";

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

        $P_MAP_MIT_CC_ID = $this->input->post('P_MAP_MIT_CC_ID');
        if ($P_MAP_MIT_CC_ID) {
            $req_param['where'] = array('P_MAP_MIT_CC_ID' => $P_MAP_MIT_CC_ID);
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

    public function gridMapPKS()
    {
        $P_MP_LOKASI_ID = $this->input->post('P_MP_LOKASI_ID');
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : null;
        $sord = isset($_POST['sord']) ? $_POST['sord'] : null;

        $table = "P_MP_PKS";

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

        $req_param['where'] = array('P_MP_LOKASI_ID' => $P_MP_LOKASI_ID);

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

    public function gridMapPIC()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $limit = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : null;
        $sord = isset($_POST['sord']) ? $_POST['sord'] : null;

        $table = "V_MP_PIC";

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

        $P_MP_LOKASI_ID = $this->input->post('P_MP_LOKASI_ID');
        if ($P_MP_LOKASI_ID) {
            $req_param['where'] = array('P_MP_LOKASI_ID' => $P_MP_LOKASI_ID);
        }
        $P_MP_PIC_ID = $this->input->post('P_MP_PIC_ID');
        if ($P_MP_PIC_ID) {
            $req_param['where'] = array('P_MP_PIC_ID' => $P_MP_PIC_ID);
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

    public function crud_lokasimitra(){
        $this->M_parameter->crud_lokasimitra();
    }
    public function crud_pks(){
        $this->M_parameter->crud_pks();
    }


    public function add_pic()
    {
        $data["action"] = $this->input->post("action");
        $data["P_MP_LOKASI_ID"] = $this->input->post("P_MP_LOKASI_ID");
        $this->load->view('parameter/mapping_pic_form', $data);
    }

    public function crud_pic_mapping(){
        $this->M_parameter->crud_mapping_pic();
    }

    public function edit_mapping_pic()
    {
        $data["action"] = $this->input->post("action");
        $data["P_MP_LOKASI_ID"] = $this->input->post("P_MP_LOKASI_ID");
        $this->load->view('parameter/mapping_pic_form', $data);
    }

	public function mapping_datin()
    {
        $title = "Mapping Datin";
        //BreadCrumb
        $bc = array($this->head, $title);
        $this->breadcrumb = getBreadcrumb($bc);
		$this->load->model('M_cm', 'cm');
		$result['result'] = $this->cm->mapDatinRequest();
        $this->load->view('parameter/map_datin',$result);
    }

	    public function gridCustMapDatin()
    {
		$ACCOUNT_NUM = $this->input->post('account_num');
		$ID_PGL = $this->input->post('pgl_id');

        $page = intval($_REQUEST['page']);
        $limit = $_REQUEST['rows'];
        $sidx = $_REQUEST['sidx'];
        $sord = $_REQUEST['sord'];

        $table = "SELECT DISTINCT a.PGL_ID PGID, a.ACCOUNT_NUM ANNM, a.VALID_UNTIL VU,
				a.CREATED_BY CB, a.UPDATE_BY UB, a.CREATION_DATE CD, a.VALID_FROM VF,
				a.UPDATE_DATE UD, a.P_MAP_DATIN_ACC_ID PMD
				FROM P_MAP_DATIN_ACC a
				WHERE a.PGL_ID ='". $ID_PGL ."' AND a.ACCOUNT_NUM = '". $ACCOUNT_NUM ."'";
        $req_param = array(
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "where" => null,
            "where_in" => null,
            "where_not_in" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
            "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
            "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
        );

        $count = $this->jqGrid->countAllQuery($req_param);

        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit * $page - ($limit - 1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_dataQuery($req_param);
        echo json_encode($result);

    }
	    public function crud_map_datin()
    {
        $this->M_parameter->crud_map_datin();
    }
	public function gridmapDatin() {

        $user_id = $this->input->post('user_id');
        $p_user_attribute_id = $this->input->post('p_user_attribute_id');

        $page = intval($this->input->post('current')) ;
        $limit = $this->input->post('rowCount');
        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');

        $searchPhrase = $this->input->post('searchPhrase');

        $query = "SELECT a.p_user_attribute_id, a.user_id, a.p_user_attribute_type_id,
                       a.p_user_attribute_list_id, a.user_attribute_value, a.valid_from,
                       a.valid_to, a.description, b.code type_code, c.code list_code,
                       c.NAME list_name, a.creation_date, a.created_by, a.updated_date, a.updated_by
                  FROM p_user_attribute a LEFT JOIN p_user_attribute_type b
                       ON a.p_user_attribute_type_id = b.p_user_attribute_type_id
                       LEFT JOIN p_user_attribute_list c
                       ON a.p_user_attribute_list_id = c.p_user_attribute_list_id";

        $req_param = array (
            "table" => $query,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
			"search" => $searchPhrase
        );

        if(!empty($user_id)) {
            $req_param['where'][] = "a.user_id = ".$user_id;
        }

        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(upper(a.user_attribute_value) LIKE upper('%".$searchPhrase."%') OR upper(b.code) LIKE upper('%".$searchPhrase."%') OR upper(c.code) LIKE upper('%".$searchPhrase."%') OR upper(c.name) LIKE upper('%".$searchPhrase."%'))";
        }

        if(!empty($p_user_attribute_id)) {
            $req_param['where'][] = "a.p_user_attribute_id = ".$p_user_attribute_id;
        }


        $count = $this->jqGrid->bootgrid_countAll($req_param);
        if( $count > 0 && !empty($limit) ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

		if ($page == 0) {
            $result['current'] = 1;
        } else {
            $result['current'] = $page;
        }

        $result['total'] = $count;
        $result['rowCount'] = $limit;
        $result['success'] = true;
        $result['message'] = 'Berhasil';
        $result['rows'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);
    }

//-----------------------------------------------------
    public function gridMapDatin_pgl() {

        $p_user_attribute_type_id = $this->input->post('P_PGL_ID');

        $page = intval($this->input->post('current')) ;
        $limit = $this->input->post('rowCount');
        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');

        $searchPhrase = $this->input->post('searchPhrase');

        $query = "SELECT * FROM cust_pgl";

        $req_param = array (
            "table" => $query,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
			"search" => $searchPhrase
        );

        $req_param['where'] = array();

        if(!empty($p_user_attribute_type_id)) {
            $req_param['where'][] = "PGL_ID = ".$p_user_attribute_type_id;
        }

        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(upper(PGL_NAME) LIKE upper('%".$searchPhrase."%') OR upper(PGL_ADDR) LIKE upper('%".$searchPhrase."%'))";
        }


        $count = $this->jqGrid->bootgrid_countAll($req_param);
        if( $count > 0 && !empty($limit) ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

		if ($page == 0) {
            $result['current'] = 1;
        } else {
            $result['current'] = $page;
        }

        $result['total'] = $count;
        $result['rowCount'] = $limit;
        $result['success'] = true;
        $result['message'] = 'Berhasil';
        $result['rows'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);
    }

	public function gridMapDatin_acc() {

        $ACCOUNT_NUM = $this->input->post('P_ACC_NUM');

        $page = intval($this->input->post('current')) ;
        $limit = $this->input->post('rowCount');
        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');

        $searchPhrase = $this->input->post('searchPhrase');

        $query = 	"SELECT ACCOUNT_NUM, CUSTOMER_REF FROM MV_LIS_ACCOUNT_NP";

        $req_param = array (
            "table" => $query,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
			"search" => $searchPhrase
        );

        $req_param['where'] = array();

        if(!empty($ACCOUNT_NUM)) {
            $req_param['where'][] = "ACCOUNT_NUM = ".$ACCOUNT_NUM;
        }

        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(upper(ACCOUNT_NUM) LIKE upper('%".$searchPhrase."%') OR upper(CUSTOMER_REF) LIKE upper('%".$searchPhrase."%'))";
        }


        $count = $this->jqGrid->bootgrid_countAll($req_param);
        if( $count > 0 && !empty($limit) ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

		if ($page == 0) {
            $result['current'] = 1;
        } else {
            $result['current'] = $page;
        }

        $result['total'] = $count;
        $result['rowCount'] = $limit;
        $result['success'] = true;
        $result['message'] = 'Berhasil';
        $result['rows'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);
    }

	public function list_Dynamic_Pengelola() {
        $id_pg = $this->input->post("id_pgl_grid");
		$id_acc = $this->input->post("form_nama_akun_code");
        $result = $this->cm->getListPglAcc($id_pg,$id_acc);

        $option = "";
        foreach($result as $content){
            $option  .= "<option value=".$content->PG.">".$content->PG."</option>";
        }
        echo $option;
    }
    
    public function gridLovAppProfile() {

        $page = intval($this->input->post('current')) ;
        $limit = $this->input->post('rowCount');
        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');

        $searchPhrase = $this->input->post('searchPhrase');

        $query = "SELECT * FROM APP_PROFILE";

        $req_param = array (
            "table" => $query,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
			"search" => $searchPhrase
        );

        $req_param['where'] = array();
        
        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(upper(prof_name) LIKE upper('%".$searchPhrase."%'))";
        }
        

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        if( $count > 0 && !empty($limit) ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

		if ($page == 0) {
            $result['current'] = 1;
        } else {
            $result['current'] = $page;
        }

        $result['total'] = $count;
        $result['rowCount'] = $limit;
        $result['success'] = true;
        $result['message'] = 'Berhasil';
        $result['rows'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);
    }

    public function gridLovDocumentType() {

        $page = intval($this->input->post('current')) ;
        $limit = $this->input->post('rowCount');
        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');

        $searchPhrase = $this->input->post('searchPhrase');

        $query = "SELECT P_DOCUMENT_TYPE_ID, DOC_NAME AS DOCUMENT_TYPE_CODE, DISPLAY_NAME FROM P_DOCUMENT_TYPE";

        $req_param = array (
            "table" => $query,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
            "search" => $searchPhrase
        );

        $req_param['where'] = array();
        
        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(upper(DOC_NAME) LIKE upper('%".$searchPhrase."%'))";
        }
        

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        if( $count > 0 && !empty($limit) ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['current'] = 1;
        } else {
            $result['current'] = $page;
        }

        $result['total'] = $count;
        $result['rowCount'] = $limit;
        $result['success'] = true;
        $result['message'] = 'Berhasil';
        $result['rows'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);
    }

    public function gridLovProcedure() {

        $page = intval($this->input->post('current')) ;
        $limit = $this->input->post('rowCount');
        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');

        $searchPhrase = $this->input->post('searchPhrase');

        $query = "SELECT P_PROCEDURE_ID, PROC_NAME AS PROCEDURE_CODE, DESCRIPTION, decode(IS_ACTIVE,'Y','YA','TIDAK') AS IS_ACTIVE FROM P_PROCEDURE";

        $req_param = array (
            "table" => $query,
            "sort_by" => $sort,
            "sord" => $dir,
            "limit" => null,
            "search" => $searchPhrase
        );

        $req_param['where'] = array();
        
        if(!empty($searchPhrase)) {
             $req_param['where'][] = "(upper(PROC_NAME) LIKE upper('%".$searchPhrase."%'))";
        }
        

        $count = $this->jqGrid->bootgrid_countAll($req_param);
        if( $count > 0 && !empty($limit) ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1); // do not put $limit*($page - 1)

        $req_param['limit'] = array(
            'start' => $start,
            'end' => $limit
        );

        if ($page == 0) {
            $result['current'] = 1;
        } else {
            $result['current'] = $page;
        }

        $result['total'] = $count;
        $result['rowCount'] = $limit;
        $result['success'] = true;
        $result['message'] = 'Berhasil';
        $result['rows'] = $this->jqGrid->bootgrid_get_data($req_param);
        echo json_encode($result);
    }
}
