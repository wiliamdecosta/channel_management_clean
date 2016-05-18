<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cm extends CI_Controller {
    private $head = "Marketing Fee";

	function __construct() {
		parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        checkAuth();

		$this->load->model('M_cm','cm');
        $this->load->model('M_jqGrid', 'jqGrid');

        // Semua req harus lewat ajax
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
	}

    public function listTenant() {
        $id = $this->input->post("id_mitra");
        $result = $this->cm->getListTenant($id);

        $option = "";
        foreach($result as $content){
            $option  .= "<option value=".$content->TEN_ID.">".$content->TEN_NAME."</option>";
        }
        echo $option;
    }

    public function rinta() {
        $title = $_POST['title'];
        //BreadCrumb
        $bc = array($this->head,$title);
        $this->breadcrumb = getBreadcrumb($bc);

        // prof id 3 = C2BI User
        if($this->session->userdata('d_prof_id') == 3) {
            $result['result'] = $this->cm->getPglListByID($this->session->userdata('d_user_id'));
        } else {
            $result['result'] = $this->cm->getPglList();
        }
        $this->load->view('channel_mgm/rinta',$result);
    }
    public function viewRinta() {
        $data['period'] = $this->input->post('tahun')."".$this->input->post('bulan');
        $data['pgl_id'] = $this->input->post('pengelola');
        $data['ten_id'] = $this->input->post('tenant');
        $this->load->view('channel_mgm/detail_rinta',$data);
    }

    public function gridRinta($period,$pgl_id,$ten_id) {
        $sidx = $_POST['sidx'] ;
        $sord = $_POST['sord'] ;
        $page = intval($_REQUEST['page']) ;
        $limit = $_REQUEST['rows'] ;

        $req_param = array (
            "sort_by" => $sidx,
            "page" => $page,
            "rows" => $limit,
            "sord" => $sord,
            "search" => $_REQUEST['_search'],
            "search_field" => isset($_REQUEST['searchField'])?$_REQUEST['searchField']:null,
            "search_operator" => isset($_REQUEST['searchOper'])?$_REQUEST['searchOper']:null,
            "search_str" => isset($_REQUEST['searchString'])?$_REQUEST['searchString']:null,
            "ten_id" => $ten_id,
            "pgl_id" => $pgl_id,
            "period" => $period
        );

        $row = $this->cm->getRintaCount($req_param);
        $count= $row[0]->COUNT;

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages)
            $page = $total_pages;

        // Parameter yang akan dikirim ke view untuk kebutuhan jqGrid
        $result['page'] = $page;
        $result['total'] = $total_pages;
        $result['records'] = $count;


        $result['Data'] = $this->cm->getRinta($req_param)->result_array();

        echo json_encode($result);

    }

    // Sheet Output
    public function rintasheet($pgl_id, $ten_id, $period) {
        // Set unlimited usage memory for big data
        ini_set('memory_limit', '-1');
        // Sheet
        $this->load->library("phpexcel");
        $filename = "rinta_".$pgl_id.$ten_id."_".$period.".xls";
        $this->phpexcel->getProperties()->setCreator("PT Telekomunikasi Indonesia, Tbk")
            ->setLastModifiedBy("PT Telekomunikasi Indonesia, Tbk")
            ->setTitle("REPORT")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Rincian Tagihan");
        $this->phpexcel->setActiveSheetIndex(0);
        $sh = & $this->phpexcel->getActiveSheet();
        $sh->setCellValue('A1', 'ND')
            ->setCellValue('B1', 'NAMA PLG')
            ->setCellValue('C1', 'ABONEMEN')
            ->setCellValue('D1', 'KREDIT')
            ->setCellValue('E1', 'DEBET')
            ->setCellValue('F1', 'LOKAL')
            ->setCellValue('G1', 'INTERLOKAL')
            ->setCellValue('H1', 'SLJJ')
            ->setCellValue('I1', 'SLI007')
            ->setCellValue('J1', 'SLI001')
            ->setCellValue('K1', 'SLI008')
            ->setCellValue('L1', 'SLI009')
            ->setCellValue('M1', 'TELKOM GLOBAL 017')
            ->setCellValue('N1', 'TELKOMNET INSTAN')
            ->setCellValue('O1', 'TELKOMSAVE')
            ->setCellValue('P1', 'STB')
            ->setCellValue('Q1', 'STB TSL')
            ->setCellValue('R1', 'STB EXL')
            ->setCellValue('S1', 'STB HCP')
            ->setCellValue('T1', 'STB INM')
            ->setCellValue('U1', 'STB OTHERS')

            ->setCellValue('V1', 'EXPENSE SLI')
            ->setCellValue('W1', 'EXPENSE IN')
            ->setCellValue('X1', 'PAY_TV')

            ->setCellValue('Y1', 'JAPATI')
            ->setCellValue('Z1', 'SPEEDY USAGE')
            ->setCellValue('AA1', 'NON JASTEL')
            ->setCellValue('AB1', 'ISDN DATA')
            ->setCellValue('AC1', 'ISDN VOICE')
            ->setCellValue('AD1', 'KONTEN')
            ->setCellValue('AE1', 'PORTWHOLESALES')
            ->setCellValue('AF1', 'METERAI')
            ->setCellValue('AG1', 'PPN')

            ->setCellValue('AH1', 'LAIN LAIN')

            ->setCellValue('AI1', 'TOTAL RINCIAN')
            ->setCellValue('AJ1', 'GRAND TOTAL')

            ->setCellValue('AK1', 'KURS')

            ->setCellValue('AL1', 'STATUS BAYAR')
            ->setCellValue('AM1', 'TGL BAYAR')

            ->setCellValue('AN1', 'DIVISI')
            ->setCellValue('AO1', 'M4L')

        ;

        $sh->getStyle('A1:AM1')->getFont()->setBold(TRUE);
        $sh->getColumnDimension('A')->setAutoSize(TRUE);
        $sh->getColumnDimension('B')->setAutoSize(TRUE);
        $sh->getColumnDimension('C')->setAutoSize(TRUE);
        $sh->getColumnDimension('D')->setAutoSize(TRUE);
        $sh->getColumnDimension('E')->setAutoSize(TRUE);
        $sh->getColumnDimension('F')->setAutoSize(TRUE);
        $sh->getColumnDimension('G')->setAutoSize(TRUE);
        $sh->getColumnDimension('H')->setAutoSize(TRUE);
        $sh->getColumnDimension('I')->setAutoSize(TRUE);
        $sh->getColumnDimension('J')->setAutoSize(TRUE);
        $sh->getColumnDimension('K')->setAutoSize(TRUE);
        $sh->getColumnDimension('L')->setAutoSize(TRUE);
        $sh->getColumnDimension('M')->setAutoSize(TRUE);
        $sh->getColumnDimension('N')->setAutoSize(TRUE);
        $sh->getColumnDimension('O')->setAutoSize(TRUE);
        $sh->getColumnDimension('P')->setAutoSize(TRUE);
        $sh->getColumnDimension('Q')->setAutoSize(TRUE);
        $sh->getColumnDimension('R')->setAutoSize(TRUE);
        $sh->getColumnDimension('S')->setAutoSize(TRUE);
        $sh->getColumnDimension('T')->setAutoSize(TRUE);
        $sh->getColumnDimension('U')->setAutoSize(TRUE);
        $sh->getColumnDimension('V')->setAutoSize(TRUE);
        $sh->getColumnDimension('W')->setAutoSize(TRUE);
        $sh->getColumnDimension('X')->setAutoSize(TRUE);
        $sh->getColumnDimension('Y')->setAutoSize(TRUE);
        $sh->getColumnDimension('Z')->setAutoSize(TRUE);
        $sh->getColumnDimension('AA')->setAutoSize(TRUE);
        $sh->getColumnDimension('AB')->setAutoSize(TRUE);
        $sh->getColumnDimension('AC')->setAutoSize(TRUE);
        $sh->getColumnDimension('AD')->setAutoSize(TRUE);
        $sh->getColumnDimension('AE')->setAutoSize(TRUE);
        $sh->getColumnDimension('AF')->setAutoSize(TRUE);
        $sh->getColumnDimension('AG')->setAutoSize(TRUE);
        $sh->getColumnDimension('AH')->setAutoSize(TRUE);
        $sh->getColumnDimension('AI')->setAutoSize(TRUE);
        $sh->getColumnDimension('AJ')->setAutoSize(TRUE);
        $sh->getColumnDimension('AK')->setAutoSize(TRUE);
        $sh->getColumnDimension('AL')->setAutoSize(TRUE);
        $sh->getColumnDimension('AM')->setAutoSize(TRUE);
        $sh->getColumnDimension('AN')->setAutoSize(TRUE);
        $sh->getColumnDimension('AO')->setAutoSize(TRUE);
        $sh->getStyle('A1:AM1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('A1:AM1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $sh->getStyle('A1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('B1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('D1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('E1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('F1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('G1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('I1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('J1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('K1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('L1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('M1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('N1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('O1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('P1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('Q1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('R1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('S1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('T1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('U1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('V1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('W1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('X1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('Y1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('Z1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AA1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AB1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AC1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AD1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AE1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AF1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AG1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AH1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AI1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AJ1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AK1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AL1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AM1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AN1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AO1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AO1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $x = 2;
        $dt = $this->cm->excelRinta($period, $pgl_id, $ten_id);
        $no = 1;
        foreach($dt as $k => $r) {
            $sh->getCell('A'.$x)->setValueExplicit($r->ND1, PHPExcel_Cell_DataType::TYPE_STRING);
            $sh->setCellValue('B'.$x, @$r->NOM);
            $sh->setCellValue('C'.$x, @$r->ABONEMEN);
            $sh->setCellValue('D'.$x, @$r->MNT_TCK_C);
            $sh->setCellValue('E'.$x, @$r->MNT_TCK_D);
            $sh->setCellValue('F'.$x, @$r->LOKAL);
            $sh->setCellValue('G'.$x, @$r->INTERLOKAL);
            $sh->setCellValue('H'.$x, @$r->SLJJ);
            $sh->setCellValue('I'.$x, @$r->SLI007);
            $sh->setCellValue('J'.$x, @$r->SLI001);
            $sh->setCellValue('K'.$x, @$r->SLI008);
            $sh->setCellValue('L'.$x, @$r->SLI009);
            $sh->setCellValue('M'.$x, @$r->SLI_017);
            $sh->setCellValue('N'.$x, @$r->TELKOMNET_INSTAN);
            $sh->setCellValue('O'.$x, @$r->TELKOMSAVE);
            $sh->setCellValue('P'.$x, @$r->STB);
            //add STB
            $sh->setCellValue('Q'.$x, @$r->STB_TSL);
            $sh->setCellValue('R'.$x, @$r->STB_EXL);
            $sh->setCellValue('S'.$x, @$r->STB_HCP);
            $sh->setCellValue('T'.$x, @$r->STB_INM);
            $sh->setCellValue('U'.$x, @$r->STB_OTHERS);
            // End
            $sh->setCellValue('V'.$x, @$r->EXPENSE_SLI);
            $sh->setCellValue('W'.$x, @$r->EXPENSE_IN);
            $sh->setCellValue('X'.$x, @$r->PAY_TV);

            $sh->setCellValue('Y'.$x, @$r->JAPATI);
            $sh->setCellValue('Z'.$x, @$r->USAGE_SPEEDY);
            $sh->setCellValue('AA'.$x, @$r->NON_JASTEL);
            $sh->setCellValue('AB'.$x, @$r->ISDN_DATA);
            $sh->setCellValue('AC'.$x, @$r->ISDN_VOICE);
            $sh->setCellValue('AD'.$x, @$r->KONTEN);
            $sh->setCellValue('AE'.$x, @$r->PORTWHOLESALES);
            $sh->setCellValue('AF'.$x, @$r->METERAI);
            $sh->setCellValue('AG'.$x, @$r->PPN);

            $sh->setCellValue('AH'.$x, @$r->LAIN_LAIN);

            $sh->setCellValue('AI'.$x, @$r->TOTAL);
            $sh->setCellValue('AJ'.$x, @$r->GRAND_TOTAL);

            $sh->getCell('AK'.$x)->setValueExplicit($r->KURS, PHPExcel_Cell_DataType::TYPE_STRING);

            $sh->getCell('AL'.$x)->setValueExplicit($r->STATUS_PEMBAYARAN, PHPExcel_Cell_DataType::TYPE_STRING);
            $sh->getCell('AM'.$x)->setValueExplicit($r->TGL_BYR, PHPExcel_Cell_DataType::TYPE_STRING);

            $sh->getCell('AN'.$x)->setValueExplicit($r->DIVISI, PHPExcel_Cell_DataType::TYPE_STRING);
            $sh->getCell('AO'.$x)->setValueExplicit($r->FLAG, PHPExcel_Cell_DataType::TYPE_STRING);

            $no++;
            $x++;
            //if($x==8000) break;
        }
        $sh->getStyle('A2:A'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('B2:B'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('C2:C'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('D2:D'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('E2:E'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('F2:F'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('G2:G'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('H2:H'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('I2:I'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('J2:J'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('K2:K'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('L2:L'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('M2:M'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('N2:N'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('O2:O'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('P2:P'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('Q2:Q'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('R2:R'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('S2:S'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('T2:T'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('U2:U'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('V2:V'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('W2:W'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('X2:X'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('Y2:Y'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('Z2:Z'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AA2:AA'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AB2:AB'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AC2:AC'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AD2:AD'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AE2:AE'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AF2:AF'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AG2:AG'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AH2:AH'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $sh->getStyle('AI2:AI'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AJ2:AJ'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AK2:AK'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AL2:AL'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AM2:AM'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AN2:AM'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AO2:AM'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AO2:AM'.$x)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $sh->getStyle('C2'.':AJ'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);
        $sh->getStyle('A'.$x.':AO'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('A'.$x.':AO'.$x)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $sh->setCellValue('A'.$x, 'TOTAL');
        //$sh->setCellValue('B'.$x, "=SUM(B2:B".($x-1).")");
        //$sh->getStyle('B'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);
        $sh->setCellValue('C'.$x, "=SUM(C2:C".($x-1).")");
        $sh->getStyle('C'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('D'.$x, "=SUM(D2:D".($x-1).")");
        $sh->getStyle('D'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('E'.$x, "=SUM(E2:E".($x-1).")");
        $sh->getStyle('E'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('F'.$x, "=SUM(F2:F".($x-1).")");
        $sh->getStyle('F'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('G'.$x, "=SUM(G2:G".($x-1).")");
        $sh->getStyle('G'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('H'.$x, "=SUM(H2:H".($x-1).")");
        $sh->getStyle('H'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('I'.$x, "=SUM(I2:I".($x-1).")");
        $sh->getStyle('I'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('J'.$x, "=SUM(J2:J".($x-1).")");
        $sh->getStyle('J'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('K'.$x, "=SUM(K2:K".($x-1).")");
        $sh->getStyle('K'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('L'.$x, "=SUM(L2:L".($x-1).")");
        $sh->getStyle('L'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('M'.$x, "=SUM(M2:M".($x-1).")");
        $sh->getStyle('M'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('N'.$x, "=SUM(N2:N".($x-1).")");
        $sh->getStyle('N'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('O'.$x, "=SUM(O2:O".($x-1).")");
        $sh->getStyle('O'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('P'.$x, "=SUM(P2:P".($x-1).")");
        $sh->getStyle('P'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('Q'.$x, "=SUM(Q2:Q".($x-1).")");
        $sh->getStyle('Q'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('R'.$x, "=SUM(R2:R".($x-1).")");
        $sh->getStyle('R'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('S'.$x, "=SUM(S2:S".($x-1).")");
        $sh->getStyle('S'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('T'.$x, "=SUM(T2:T".($x-1).")");
        $sh->getStyle('T'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('U'.$x, "=SUM(U2:U".($x-1).")");
        $sh->getStyle('U'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('V'.$x, "=SUM(V2:V".($x-1).")");
        $sh->getStyle('V'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('W'.$x, "=SUM(W2:W".($x-1).")");
        $sh->getStyle('W'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('X'.$x, "=SUM(X2:X".($x-1).")");
        $sh->getStyle('X'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('Y'.$x, "=SUM(Y2:Y".($x-1).")");
        $sh->getStyle('Y'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('Z'.$x, "=SUM(Z2:Z".($x-1).")");
        $sh->getStyle('Z'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AA'.$x, "=SUM(AA2:AA".($x-1).")");
        $sh->getStyle('AA'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AB'.$x, "=SUM(AB2:AB".($x-1).")");
        $sh->getStyle('AB'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AC'.$x, "=SUM(AC2:AC".($x-1).")");
        $sh->getStyle('AC'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AD'.$x, "=SUM(AD2:AD".($x-1).")");
        $sh->getStyle('AD'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AE'.$x, "=SUM(AE2:AE".($x-1).")");
        $sh->getStyle('AE'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AF'.$x, "=SUM(AF2:AF".($x-1).")");
        $sh->getStyle('AF'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AG'.$x, "=SUM(AG2:AG".($x-1).")");
        $sh->getStyle('AG'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AH'.$x, "=SUM(AH2:AH".($x-1).")");
        $sh->getStyle('AH'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AI'.$x, "=SUM(AI2:AI".($x-1).")");
        $sh->getStyle('AI'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AJ'.$x, "=SUM(AJ2:AJ".($x-1).")");
        $sh->getStyle('AJ'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AK'.$x, "");
        $sh->getStyle('AK'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AL'.$x, "");
        $sh->getStyle('AL'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('AM'.$x, "");
        $sh->getStyle('AM'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('A'.$x, '');


        $sh->getStyle('A'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('B'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('C'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('D'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('E'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('F'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('G'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('H'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('I'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('J'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('K'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('L'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('M'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('N'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('O'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('P'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('Q'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('R'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('S'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('T'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('U'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('V'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('W'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('X'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('Y'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('Z'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AA'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AB'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AC'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AD'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AE'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AF'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AG'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AH'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $sh->getStyle('AI'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AJ'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AK'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AL'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AM'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AN'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('AO'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $sh->getStyle('AO'.$x)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('A'.$x.':AM'.$x)->getFont()->setBold(TRUE);

        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save(dirname(__FILE__).'/../third_party/report/'.$filename);
        // Write file to the browser
       // $objWriter->save('php://output');
        //redirect($this->config->config['base_url'].'application/third_party/report/'.$filename, 'location', 301);
        $data['redirect'] = "true";
        $data['redirect_url'] = $this->config->config['base_url'].'application/third_party/report/'.$filename;

        echo json_encode($data);
    }
	
	public function fastels()
    {

        $data['pgl_id'] = $this->input->post('mitra');
        $data['period'] = $this->input->post('period');
        $this->load->view('channel_mgm/fastel', $data);
    }
	
	public function gridDatin()
    {
        $pgl_id = $this->input->post('pgl_id'); //261
        $periode = $this->input->post('tahun') . "" . $this->input->post('bulan');

        $page = intval($_REQUEST['page']); // Page
        $limit = intval($_REQUEST['rows']); // Number of record/page
        $sidx = $_REQUEST['sidx']; // Field name
        $sord = $_REQUEST['sord']; // Asc / Desc

        $table = "V_CUST_RINTA_NP";

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

        //$req_param['where'] = array('BILL_PRD' => $periode);
        $req_param['where'] = array('BILL_PRD' => $periode,
                                    'PGL_ID' => $pgl_id);


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
	
	public function fastelsheet($pgl_id, $period) {
        // Set unlimited usage memory for big data
        ini_set('memory_limit', '-1');
        // Sheet
        $this->load->library("phpexcel");
        $filename = "Rinta_NP_".$pgl_id."_".$period.".xls";
        $this->phpexcel->getProperties()->setCreator("PT Telekomunikasi Indonesia, Tbk")
            ->setLastModifiedBy("PT Telekomunikasi Indonesia, Tbk")
            ->setTitle("REPORT")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Rincian Tagihan Non Pots");
        $this->phpexcel->setActiveSheetIndex(0);
        $sh = & $this->phpexcel->getActiveSheet();
        $sh->setCellValue('A1', 'NO AKUN')
            ->setCellValue('B1', 'DIVISI')
            ->setCellValue('C1', 'SID')
            ->setCellValue('D1', 'Nama Produk')
            ->setCellValue('E1', 'Alamat')
            ->setCellValue('F1', 'Abonemen')
            ->setCellValue('G1', 'Diskon')
            ->setCellValue('H1', 'Restitusi')
            ->setCellValue('I1', 'Lain - lain')
            ->setCellValue('J1', 'Flag Bayar')
        ;

        $sh->getStyle('A1:J1')->getFont()->setBold(TRUE);
        $sh->getColumnDimension('A')->setAutoSize(TRUE);
        $sh->getColumnDimension('B')->setAutoSize(TRUE);
        $sh->getColumnDimension('C')->setAutoSize(TRUE);
        $sh->getColumnDimension('D')->setAutoSize(TRUE);
        $sh->getColumnDimension('E')->setAutoSize(TRUE);
        $sh->getColumnDimension('F')->setAutoSize(TRUE);
        $sh->getColumnDimension('G')->setAutoSize(TRUE);
        $sh->getColumnDimension('H')->setAutoSize(TRUE);
        $sh->getColumnDimension('I')->setAutoSize(TRUE);
        $sh->getColumnDimension('J')->setAutoSize(TRUE);

		
        $sh->getStyle('A1:J1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('A1:J1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
        $sh->getStyle('A1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('B1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('D1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('E1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('F1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('G1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('I1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('J1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        $x = 2;
        $dt = $this->cm->excelFastel($period, $pgl_id);
        $no = 1;
        foreach($dt as $k => $r) {
            $sh->getCell('A'.$x)->setValueExplicit($r->ACCOUNT_NUM, PHPExcel_Cell_DataType::TYPE_STRING);
            $sh->setCellValue('B'.$x, @$r->DIVISI_OP);
            $sh->setCellValue('C'.$x, @$r->PRODUCT_LABEL);
            $sh->setCellValue('D'.$x, @$r->PRODUCT_NAME);
            $sh->setCellValue('E'.$x, @$r->ADDRESS_NAME);
            $sh->setCellValue('F'.$x, @$r->ABONDEMEN);
            $sh->setCellValue('G'.$x, @$r->DISCOUNT);
            $sh->setCellValue('H'.$x, @$r->RESTITUSI);
            $sh->setCellValue('I'.$x, @$r->LAIN_LAIN);
            $sh->setCellValue('J'.$x, @$r->FLAG_BYR);
            $no++;
            $x++;
            //if($x==8000) break;
        }
		$x--;
        $sh->getStyle('A2:A'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('B2:B'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('C2:C'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('D2:D'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('E2:E'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('F2:F'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('G2:G'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('H2:H'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('I2:I'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('J1:J'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('K1:K'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$x++;
        $sh->setCellValue('B'.$x, 'TOTAL');     

        $sh->setCellValue('E'.$x, "=SUM(F2:E".($x-1).")");
        $sh->getStyle('E'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('F'.$x, "=SUM(G2:F".($x-1).")");
        $sh->getStyle('F'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('G'.$x, "=SUM(H2:G".($x-1).")");
        $sh->getStyle('G'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);

        $sh->setCellValue('H'.$x, "=SUM(I2:H".($x-1).")");
        $sh->getStyle('H'.$x)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED0);
        $sh->setCellValue('A'.$x, '');

        $sh->getStyle('A'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('B'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('C'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('D'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('E'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('F'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('G'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('H'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('I'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('E'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('F'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('G'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('H'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('I'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('J'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('K'.$x)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('A'.$x.':I'.$x)->getFont()->setBold(TRUE);
		$x++;
		$sh->getStyle('A'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('B'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('C'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('D'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('E'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('F'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('G'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('H'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('I'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $sh->getStyle('J'.$x)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save(dirname(__FILE__).'/../third_party/report/'.$filename);
        // Write file to the browser
       // $objWriter->save('php://output');
        //redirect($this->config->config['base_url'].'application/third_party/report/'.$filename, 'location', 301);
        $data['redirect'] = "true";
        $data['redirect_url'] = $this->config->config['base_url'].'application/third_party/report/'.$filename;

        echo json_encode($data);
    }

}