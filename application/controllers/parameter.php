<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parameter extends CI_Controller {

    private $head = "Parameter";
	
	function __construct() {
		parent::__construct();

        checkAuth();
        $this->load->model('M_cm','cm');
        $this->load->model('M_param');
        $this->load->model('M_tenant');
        $this->load->model('M_jqGrid', 'jqGrid');
        $this->load->model('M_parameter');
	}

	public function index()
	{
		redirect("/");
	}
	
	public function batchType() {
        $title = "Batch Type";
        //BreadCrumb
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

		$this->load->view('parameter/list_batchtype');
	}
	
	public function reference() {
        $title = "Reference";
        //BreadCrumb
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);
		
		$result['result'] = $this->cm->getPglList();
        $result['product'] = $this->M_param->getParamProducts();
		$this->load->view('parameter/reference');
	}


    public function gridBatchType() {
        $page = intval($_REQUEST['page']) ;
        $limit = $_REQUEST['rows'] ;
        $sidx = $_REQUEST['sidx'] ;
        $sord = $_REQUEST['sord'] ;

        $table = "P_BATCH_TYPE";

        $req_param = array (
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null
        );

        $req_param['field'] = array();
        $req_param['value'] = array();

        $row = $this->jqGrid->get_data($req_param)->result_array();
        $count = count($row);

        if( $count >0 ) {
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

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }

    public function crud_batchType(){
        $this->M_parameter->crud_batchType();
    }

    public function crud_profile(){
        // crud(tabel_name,field_id,key_unix,field yg mau di insert/update)
        $table = "APP_PROFILE";
        $id = $this->input->post('id');
        $this->jqGrid->crud($table,'PROF_ID', $id, array('PROF_NAME','PROF_DESC'));
    }

    public function uploadND(){
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

        $result['result'] = $this->cm->getPglList();
        $result['product'] = $this->M_param->getParamProducts();
        $this->load->view('parameter/uploadnd',$result);
    }

    public function nduploaddo() {
        $ten_id = $this->input->post("ten_id");
        $pu_action = $this->input->post("pu_action");
        $cprod = $this->input->post("cprod");
        //$file = $this->input->post("file");
        if($ten_id!="") {
            switch($pu_action) {
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
            $config['max_size']	= '100000000';
            $config['overwrite']  = TRUE;
            $file_id = date("YmdHis");
            $config['file_name']  = "nd_".$file_id;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload("filename")) {
                $error = $this->upload->display_errors();
                $data['status'] = "F";
                $data['msg'] = "<div class='alert alert-danger'>"."
											<button type='button' class='close' data-dismiss='alert'>
												<i class='ace-icon fa fa-times'></i>
											</button>
											    ".$error."
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
                $this->nduploadparse($data['file_name'],$data["file_ext"],$cprod,$ten_id,0);
            }
        } else {
            $data['status'] = "F";
            $data['msg'] = "<div class='alert alert-danger'>"."
											<button type='button' class='close' data-dismiss='alert'>
												<i class='ace-icon fa fa-times'></i>
											</button>
											    Tenant belum dipilih
											<br />
										</div>";
            echo json_encode($data);
        }

    }

    public function nddel($ten_id, $nd) {
        $this->M_tenant->delNDTen($ten_id, $nd);
        redirect("/ten/nd/".$ten_id);
    }

    public function nduploadparse($file_name, $file_ext, $cprod, $ten_id="",$confirm) {
        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
        $this->load->library('phpexcel');

        if($file_ext==".xlsx") $readerType = 'Excel2007';
        elseif($file_ext==".xls") $readerType = 'Excel5';
        elseif($file_ext==".csv"||$file_ext==".txt") $readerType = 'CSV';


        $reader = PHPExcel_IOFactory::createReader($readerType);
        $reader->setReadDataOnly(true);
        $phpexcel = $reader->load(APPPATH.'third_party/upload/'.$file_name);
        $sh = $phpexcel->getActiveSheet();
        $highestRow = $sh->getHighestRow();
        $highestColumn = $sh->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

        if($ten_id!="") {

            if($highestRow>0) $this->M_tenant->clearNDTen($ten_id);
            $errmessage ='<h4>error :</h4> <br>';
            $msgcount =0;
            $haha[] ='';
            if( $confirm <> 1){
                for ($row = 2; $row <= $highestRow; ++$row) {
                    $nd = $sh->getCellByColumnAndRow(0, $row)->getValue();
                    $vf = $sh->getCellByColumnAndRow(1, $row)->getValue();
                    // $vt = $sh->getCellByColumnAndRow(2, $row)->getValue();

                    // Cek ND dan Valid From
                    if( $nd == ''){
                        $errmessage .= ' Row ke : '.$row.' ND tidak boleh kosong <br> ';
                        $msgcount +=1;
                    }
                    if( $vf == ''){
                        $errmessage .= ' Row ke : '.$row.' Valid From tidak boleh kosong <br> ';
                        $msgcount +=1;
                    }
                }
            }
            // Munculkan error di form view
            if($msgcount > 0 && $confirm <> 1){
                $data['status'] = "F";
                $data['msg'] = "<div class='alert alert-danger'>"."
											<button type='button' class='close' data-dismiss='alert'>
												<i class='ace-icon fa fa-times'></i>
											</button>
											    ".$errmessage."
											<br />
										</div>";
                echo json_encode($data);
                //echo "<br> <a href='".$url.'index.php/ten/ndupload'."'>Back To Upload Page</a>  |  <a href='".$uploadanyway.'1'."'>Upload Data Anyway</a>";

            }else{
                $username = $this->session->userdata('d_nik');
                $cekND = 0;
                $batch_id = $this->M_tenant->getBatchID();

                for ($row = 2; $row <= $highestRow; ++$row) {

                    $nd = $sh->getCellByColumnAndRow(0, $row)->getValue();
                    $vf = $sh->getCellByColumnAndRow(1, $row)->getValue();
                    $vt = $sh->getCellByColumnAndRow(2, $row)->getValue();

                    // Cek jika bukan CSV makan convert date Valid from dan Valid to || Format dd-mm-yyyy
                    if($readerType <> 'CSV'){
                        $vfs = ($vf - 25569) * 86400;
                        $vf = gmdate("d-M-Y", $vfs);

                        if(trim($vt)!="") {
                            $vts = ($vt - 25569) * 86400;
                            $vt = gmdate("d-M-Y", $vts);
                        }
                    }else{
                        //Selain CSV gunakan format berikut
                        $vfs = str_replace('/', '-', $vf);
                        $vf = date('d-M-Y', strtotime($vfs));

                        if(trim($vt)!="") {
                            $vts = str_replace('/', '-', $vt);
                            $vt = date('d-M-Y', strtotime($vts));
                        }
                    }

                    if(trim($nd)!="") {
                        $status =   $this->M_tenant->check_duplicateND($ten_id,str_replace("'", "", $nd), $vf, $vt, $cprod,$username,$batch_id);
                        $countND = 0;
                        if($status == "SUCCESS"){
                            $countND =  $countND+1;
                        }
                    }
                } // End Loop
                // print_r($countND);
                //exit();

                //Insert ke batch_control jika $cekND > 0
                if($countND > 0){
                    $this->M_tenant->create_batch_expense($username,$batch_id);
                }


                // Cek TEN_ND_TEMP, Jika ada tulis ke notif
                $result = $this->M_tenant->getTenNDTemp();
                if($result->num_rows() > 0){
                    $rowTMP = $result->result();
                    foreach($rowTMP as $row){
                        if($row->ERROR_CODE == '-1'){
                            $error = "Duplicate ND ! ";
                        }elseif($row->ERROR_CODE == '-20000'){
                            $error = "Overlap ND ! ";
                        }
                        $msg[] = $row->ND." -- ".$error;
                    }
                }
                //print_r($msg);
                //exit();
                // Implode
                if(count($msg)> 0){
                    $msgs = implode("<br>",$msg);

                    $data['status'] = "F";
                    $data['msg'] = $data['msg'] = "<div class='alert alert-warning'>"."
											<button type='button' class='close' data-dismiss='alert'>
												<i class='ace-icon fa fa-times'></i>
											</button>
											<b> Warning</b>
											<br>
											<br>
											  ".$msgs."
                                            <br>
                                            <br>
											  <i> NB : Silahkan copy ND diatas untuk diupload ulang. </i>
											<br />
										</div>";
                    echo json_encode($data);
                }else{
                    $data['status'] = "T";
                    $data['msg'] = $data['msg'] = "<div class='alert alert-success'>"."
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

	public function gridReference() {
        $page = intval($_REQUEST['page']) ;
        $limit = $_REQUEST['rows'] ;
        $sidx = $_REQUEST['sidx'] ;
        $sord = $_REQUEST['sord'] ;

        $table = "P_REFERENCE_TYPE";

        $req_param = array (
            "table" => $table,
            "sort_by" => $sidx,
            "sord" => $sord,
            "limit" => null,
            "field" => null,
			"where" => null,
			"where_in" => null,
			"where_not_in" => null,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null
        );

        //$req_param['field'] = array();
        //$req_param['value'] = array();

        $row = $this->jqGrid->get_data($req_param)->result_array();
		//print_r($row);exit;
        $count = count($row);

        if( $count >0 ) {
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

        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);

    }
	
	public function crud_reference(){
        $this->M_parameter->crud_reference();
    }
}
