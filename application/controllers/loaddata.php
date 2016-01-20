<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loaddata extends CI_Controller {

    private $head = "Management Data";

	function __construct() {
		parent::__construct();

        date_default_timezone_set('Asia/Jakarta');

        checkAuth();
		$this->load->model('M_loaddata', 'loadData');
		$this->load->model('M_admin');
        $this->load->model('M_jqGrid', 'jqGrid');

	}

	public function index()
	{
		redirect("/");
	}
	
	public function databulan() {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);
        //
		$this->load->view('loaddata/data_bulanan');
	}
	
	public function grid_databulanan() {
        $page = intval($_REQUEST['page']) ;
        $limit = $_REQUEST['rows'] ;
        $sidx = $_REQUEST['sidx'] ;
        $sord = $_REQUEST['sord'] ;

        $table = "V_SHOW_BATCH";

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

        //$req_param['field'] = array('P_BATCH_TYPE_ID');
       // $req_param['value'] = array(1);

        $req_param['where'] = array('P_BATCH_TYPE_ID' => 1);

        $row = $this->jqGrid->get_data($req_param)->result_array();
        $count = count($row);

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1);

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

    public function job_control() {
        $page = intval($_REQUEST['page']) ;
        $limit = $_REQUEST['rows'] ;
        $sidx = $_REQUEST['sidx'] ;
        $sord = $_REQUEST['sord'] ;

        $table = "V_JOB_CONTROL";

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

       //$req_param['field'] = array('BATCH_CONTROL_ID');
        //$req_param['value'] = array($_POST['batch_id']);

        $req_param['where'] = array('BATCH_CONTROL_ID' => $_POST['batch_id']);

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

        // Parameter yang akan dikirim ke view untuk kebutuhan jqGrid
        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;

        $result['Data'] = $this->jqGrid->get_data($req_param)->result_array();
        echo json_encode($result);
    }

    public function loadPeriod(){
        $this->load->view('loaddata/period');
    }

    public function createBatch(){
        $username = $this->session->userdata('d_user_nik');
        $tmpPeriod = $this->input->post('periode');
        $batch_type = $this->input->post('batch_type');
        $period = implode('#',$tmpPeriod);

        $result['data']= $this->loadData->create_batch($period,$username,$batch_type);
        json_encode($result);
    }

    public function processBatch(){
        $username = $this->session->userdata('d_user_nik');
        $batch_id = $this->input->post('batch_id');

        $result['data'] = $this->loadData->batchProcess($batch_id,$username);
        echo json_encode($result);
    }

    public function LogProcess($id) {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
        $sidx = $_POST['sidx'] ;
        $sord = $_POST['sord'] ;

        $count = $this->loadData->getCountLogProcess($id);
        $record= $count[0]->COUNT;

        $result['page'] = $page;
        $result['total'] = ceil($record/$rows);
        $result['records'] = $record;
        $result['sidx'] = $sidx;
        $result['sord'] = $sord;
        $result['id'] = $id;

        $req_param = array (
            "sort_by" => $sidx,
            "page" => isset($_POST['page']) ? intval($_POST['page']) : 1,
            "rows" => isset($_POST['rows']) ? intval($_POST['rows']) : 10,
            "sord" => $sord,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null,
            "id" => $id
        );

        $this->parent_id = $id;
        $result['Data'] = $this->loadData->getLogProcess($req_param);
        echo json_encode($result);
    }

    public function flagPayment(){
        $title = "Flag Pembayaran";
        //BreadCrumb
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

        $this->load->view('loaddata/flag_payment');

    }
    public function grid_flagPayment(){
        $page = intval($_REQUEST['page']) ;
        $limit = $_REQUEST['rows'] ;
        $sidx = $_REQUEST['sidx'] ;
        $sord = $_REQUEST['sord'] ;

        $table = "V_SHOW_BATCH";

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

        //$req_param['field'] = array('P_BATCH_TYPE_ID');
        //$req_param['value'] = array(2);

        $req_param['where'] = array('P_BATCH_TYPE_ID' => 2);



        $row = $this->jqGrid->get_data($req_param)->result_array();
        $count = count($row);

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;
        $start = $limit*$page - ($limit-1);

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

    public function cekExpense(){
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

        // prof id 3 = C2BI User
        $this->load->model('M_cm','cm');
        if($this->session->userdata('d_prof_id') == 3) {
            $result['result'] = $this->cm->getPglListByID($this->session->userdata('d_user_id'));
        } else {
            $result['result'] = $this->cm->getPglList();
        }
        $this->load->view('loaddata/cek_expense',$result);
    }
    public function cekExpenseView(){
        ini_set('max_execution_time', 0);

        $period = $this->input->post('tahun')."".$this->input->post('bulan');
        $pgl_id = $this->input->post('pengelola');
        $ten_id = $this->input->post('tenant');
        $expense = $this->input->post('expense');

        $data['period'] = $period;
        $data['pgl_id'] = $pgl_id;
        $data['ten_id'] = $ten_id;
        $data['expense'] = $expense;

        $startime = microtime(true);
        // Execute procedure cek expense

        switch ($expense) {
            case 'olo':
             $result = $this->loadData->searchExpenseOLO($period,$ten_id);
             $json_expense = json_encode($result);
                $filename = "expense_".$expense."_".$ten_id."_".$period.".json";
                $fp = fopen(dirname(__FILE__).'/../third_party/report/'.$filename, 'w');
                fwrite($fp, $json_expense);
                fclose($fp);
             $data['record'] = $json_expense;
        break;
            case 'sli':
             $result = $this->loadData->searchExpenseSLI($period,$ten_id);
                $json_expense = json_encode($result);
                $filename = "expense_".$expense."_".$ten_id."_".$period.".json";
                $fp = fopen(dirname(__FILE__).'/../third_party/report/'.$filename, 'w');
                fwrite($fp, $json_expense);
                fclose($fp);
                $data['record'] = $json_expense;
        break;
            case 'in':
            $result = $this->loadData->searchExpenseIN($period,$ten_id);
                $json_expense = json_encode($result);
                $filename = "expense_".$expense."_".$ten_id."_".$period.".json";
                $fp = fopen(dirname(__FILE__).'/../third_party/report/'.$filename, 'w');
                fwrite($fp, $json_expense);
                fclose($fp);
                $data['record'] = $json_expense;
        break;
            default:
                $result = $this->loadData->searchExpenseOLO($period,$ten_id);
                $json_expense = json_encode($result);
                $filename = "expense_".$expense."_".$ten_id."_".$period.".json";
                $fp = fopen(dirname(__FILE__).'/../third_party/report/'.$filename, 'w');
                fwrite($fp, $json_expense);
                fclose($fp);
                $data['record'] = $json_expense;

        }

        $endtime = microtime(true);
        $time = $endtime - $startime;
        $data['render_time'] = "Page render in ". number_format($time, 3, '.', '')." seconds";
        unset($json_expense);
        unset($fp);
        $this->load->view('loaddata/cek_expense_grid',$data);
    }

    public function gridCekExpense($param) {
        $page = intval($_REQUEST['page']) ;
        $limit = $_REQUEST['rows'] ;
        $sidx = $_REQUEST['sidx'] ;
        $sord = $_REQUEST['sord'] ;

        $table = 'V_SEARCH_EXPENSE';

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


        // Filter table. Jumlah array field harus sama dengan value.
        $req_param['field'] = array();
        $req_param['value'] = array();

        $row = $this->jqGrid->get_data2($req_param)->result_array();
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

        $result['Data'] = $this->jqGrid->get_data2($req_param)->result_array();
        echo json_encode($result);

    }
    // Sheet Output
    public function cekExpenseSheet($pgl_id, $ten_id, $period,$expense) {
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        // Set unlimited usage memory for big data
        ini_set('memory_limit', '-1');

       $var = null;
        // Sheet
        $this->load->library("phpexcel");
        $filename = "expense_".$expense."_".$ten_id."_".$period.".xls";
        $this->phpexcel->getProperties()->setCreator("PT Telekomunikasi Indonesia, Tbk")
            ->setLastModifiedBy("PT Telekomunikasi Indonesia, Tbk")
            ->setTitle("REPORT")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Expense");
        $this->phpexcel->setActiveSheetIndex(0);
        $sh = & $this->phpexcel->getActiveSheet();
        $sh->setCellValue('A1', 'ORIG NUMBER')
            ->setCellValue('B1', 'TERM NUMBER')
            ->setCellValue('C1', 'CALL START TIME')
            ->setCellValue('D1', 'CALL DURATION')
            ->setCellValue('E1', 'CURRENCY')
            ->setCellValue('F1', 'AMOUNT')
            ->setCellValue('G1', 'DESCRIPTION')
        ;
        $sh->getStyle('A1:G1') ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sh->getStyle('A1:G1')->getFont()->setBold(TRUE);
        $sh->getColumnDimension('A')->setAutoSize(TRUE);
        $sh->getColumnDimension('B')->setAutoSize(TRUE);
        $sh->getColumnDimension('C')->setAutoSize(TRUE);
        $sh->getColumnDimension('D')->setAutoSize(TRUE);
        $sh->getColumnDimension('E')->setAutoSize(TRUE);
        $sh->getColumnDimension('F')->setAutoSize(TRUE);
        $sh->getColumnDimension('G')->setAutoSize(TRUE);

        $x = 2;

        $expense_name = "expense_".$expense."_".$ten_id."_".$period.".json";
        $fp = fopen(dirname(__FILE__).'/../third_party/report/'.$expense_name, 'r') or die("Unable to open file!");
        $expense = json_decode(fread($fp, filesize(dirname(__FILE__).'/../third_party/report/'.$expense_name)));

        $dt = $expense;

        $no = 1;
        foreach($dt as $k => $r) {
            $sh->getCell('A'.$x)->setValueExplicit($r->ORG_L_NUMBER, PHPExcel_Cell_DataType::TYPE_STRING);
            $sh->getCell('B'.$x)->setValueExplicit($r->TRM_L_NUMBER, PHPExcel_Cell_DataType::TYPE_STRING);
            $sh->getCell('C'.$x)->setValueExplicit($r->CALL_START_TIME, PHPExcel_Cell_DataType::TYPE_STRING);
            $sh->setCellValue('D'.$x, @$r->CALL_DURATION);
            $sh->getCell('E'.$x)->setValueExplicit($r->CURRENCY_CODE, PHPExcel_Cell_DataType::TYPE_STRING);
            $sh->setCellValue('F'.$x, @$r->AMOUNT);
            $sh->getCell('G'.$x)->setValueExplicit($r->DESCRIPTION, PHPExcel_Cell_DataType::TYPE_STRING);


            $sh->getStyle('C'.$x) ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sh->getStyle('D'.$x) ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sh->getStyle('E'.$x) ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sh->getStyle('G'.$x) ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $no++;
            $x++;
        }

        $sh->getStyle('A'.$x.':AG'.$x)->getFont()->setBold(TRUE);

        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save(dirname(__FILE__).'/../third_party/report/'.$filename);

        unset($expense);
        unset($fp);
        unset($sh);
        $data['redirect'] = "true";
        $data['redirect_url'] = $this->config->config['base_url'].'application/third_party/report/'.$filename;

        echo json_encode($data);

    }

    // Create Batch ND
    public function batchND(){
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

        // prof id 3 = C2BI User
        $this->load->model('M_cm','cm');
        if($this->session->userdata('d_prof_id') == 3) {
            $result['result'] = $this->cm->getPglListByID($this->session->userdata('d_user_id'));
        } else {
            $result['result'] = $this->cm->getPglList();
        }

        $this->load->view('loaddata/create_batchnd',$result);

    }

    public function showND(){
        $ten_id = $this->input->post('ten_id');
        $data['ten_id'] = $ten_id;
        $result = $this->loadData->getNDList($ten_id);
        $data['record'] = json_encode($result);
        $this->load->view('loaddata/list_nd_grid',$data);
    }

    public function createBatchND(){
        $arrND = $this->input->post('arrND');
    }


}
