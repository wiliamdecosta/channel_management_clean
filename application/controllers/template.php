<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template extends CI_Controller
{

    private $head = "Marketing Fee";
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
		
		$this->load->model('M_template');
		$data = array();
		$this->db->set('order by doc_id desc');
		$result['result1'] = $this->M_template->table_location();
		$result['result2'] = $this->M_template->get_doc_type();
		$result['result3'] = $this->M_template->get_bahasa();
		$result['result4'] = $this->M_template->convert_lokasi();
        //$this->load->view('template/filter_template');
		$this->load->view('template/tab_template',$result);
    }

    public function create_template_new()
    {
		
        $this->load->view($this->folder . '/main_template');
    }

    public function data_template()
    {

        $this->load->view($this->folder . '/data_template');
    }

    public function variable_template()
    {
        $this->load->model('M_template');
        $result['result'] = $this->M_template->get_table_name();
        $this->load->view($this->folder . '/variable_template',$result);
    }
    public function get_column_name($tablename){
      $this->load->model('M_template');
      $result = $this->M_template->get_column_name($tablename);
      $table = "";
      foreach($result as $content){
          $table  .=
          "<tr id='tr".$content->COLUMN_NAME.$tablename."'>".
            "<td>".
              $content->COLUMN_NAME.
            "</td>".
            "<td>".
              $content->DATA_TYPE.
            "</td>".
            "<td>".
                "<a class='btn btn-xs btn-success addcol' onClick='javascript:move_to_variable(this);' data='".$content->COLUMN_NAME.'|'.$tablename."' id='add".$content->COLUMN_NAME."'>".
                  "<i class='ace-icon fa fa-plus smaller-100'></i>".
                "</a>".
                "<a class='btn btn-xs btn-danger delcol' onClick='javascript:move_to_variable(this);' style='display:none' data='".$content->COLUMN_NAME.'|'.$tablename."' id='del".$content->COLUMN_NAME."'>".
                  "<i class='ace-icon fa fa-minus smaller-100'></i>".
                "</a>".
            "</td>".
         "</tr>";
      }
	  
      echo $table;
	  
    }

    public function list_template()
    {
		$this->load->model('M_template');
		$data = array();
		$this->db->set('order by doc_id desc');
		$result['result1'] = $this->M_template->table_location();
		$result['result2'] = $this->M_template->get_doc_type();
		$result['result3'] = $this->M_template->get_bahasa();
		$result['result4'] = $this->M_template->convert_lokasi();
		
        $this->load->view($this->folder . '/view_template',$result);
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

	public function create_template()
		{
		$this->load->library('ckeditor');
		$this->load->library('ckfinder');
		$this->ckeditor->basePath = base_url().'assets/js/ckeditor/';
		$this->ckfinder->basePath = base_url().'assets/js/ckfinder/';
		$this->ckfinder->SetupCKeditor($this->ckeditor,base_url().'/assets/ckfinder/');
		$this->ckeditor->config['toolbar'] = array(
            array( 'Source','Save', 'NewPage', 'DocProps', 'Preview', 'Print', 'Templates', 'document',
			'-', 'Bold', 'Italic', 'Underline','Strike','Subscript','Superscript','RemoveFormat',
			'-','Cut','Copy','Paste','PasteText','PasteFromWord',
			'-','Undo','Redo','Find','Replace','SelectAll', 'Scayt',
			'-','NumberedList','BulletedList','Outdent','Indent','Blockquote','CreateDiv','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','BidiLtr','BidiRtl',
			'-','Link','Unlink','Anchor',
			'-','CreatePlaeholder','Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','Iframe','InsertPre',
			'-','Styles','Format','Font','FontSize',
			'-','TextColor','BGColor','UIColor','Maximize','ShowBlocks',
			'-','Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'
			));
		 $this->ckeditor->config['language'] = 'eng';
		 $this->ckeditor->config['filebrowserBrowseUrl'] = base_url().'assets/js/ckfinder/ckfinder.html';
		 $this->ckeditor->config['filebrowserImageBrowseUrl'] = base_url().'assets/js/ckfinder/ckfinder.html?type=Images';
		 $this->ckeditor->config['filebrowserFlashBrowseUrl'] = base_url().'assets/js/ckfinder/ckfinder.html?type=Flash';
		 $this->ckeditor->config['filebrowserUploadUrl'] = base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
		 $this->ckeditor->config['filebrowserImageUploadUrl'] = base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
		 $this->ckeditor->config['filebrowserFlashUploadUrl'] = base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
		$this->ckeditor->config['width'] = '80%';
		$this->ckeditor->config['height'] = '300px';

		 $this->ckfinder->SetupCKeditor($this->ckeditor,base_url().'/assets/ckfinder/');
		 $this->load->model('M_cm', 'cm');
		 $this->load->model('M_template');
        $result['result2'] = $this->M_template->get_table_name();
		$result['result1'] = $this->cm->parsingTemplate();		
		$result['result3'] = $this->M_template->load_temp();		
		
        $this->load->view($this->folder . '/create_new_template', $result);

	}
	public function parseBackTemplate(){
		$this->load->model('M_cm', 'cm');
		$data1 = $this->input->post('title1');
		$data2 = $this->input->post('title2');
		$data3 = $this->input->post('title3');
		$data4 = $this->input->post('title4');
		$data5 = $this->input->post('title5');
		$data6 = $this->input->post('title6');
		$this->cm->postDocTemp($data1,$data2,$data3,$data4,$data5,$data6);
	}
	
	public function saveNewTemplate(){
		$this->load->model('M_template', 'tm');
		$data1 = $this->input->post('t_name');
		$data2 = $this->input->post('t_content');
		$this->tm->insertNewTemplate($data1,$data2);
	}
	
	public function setUpdateTemplate(){
		$this->load->model('M_template', 'tm');
		$data1 = $this->input->post('t_name');
		$data2 = $this->input->post('t_content');
		$data3 = $this->input->post('var_c');
		$this->tm->setNewTemplate($data1,$data2,$data3);
	}
	
	
	public function addTemplate(){
		$this->load->model('M_template');
		$data = array();
		$data['nama'] = $this->input->post('nama');
		$data['desc'] = $this->input->post('desc');
		$data['userid'] = $this->input->post('userid');
		$data['bahasa'] = $this->input->post('bahasa');
		$data['lokasi_pks'] = $this->input->post('lokasi_pks');
		$data['doc_type'] = $this->input->post('doc_type');
		$data['doc_period'] = $this->input->post('doc_perd');
		$this->M_template->add_Template($data);
	}
	public function POST_idDOC(){
		$this->load->model('M_cm', 'cm');
		$this->load->model('M_template');
		$result = $this->input->post('id_doc');
		$res = $this->cm->selectFile($result);
		$result2 = $this->M_template->replace_contents($res);
		// $res = $this->M_template->get_data_var_template('PERHITUNGAN_BILL_COLL',$result,$res);
		echo $result2;
	}
	public function delete_DOC(){
		$this->load->model('M_cm', 'cm');
		$result = $this->input->post('id_doc');
		$res = $this->cm->deleteDOC($result);
	}
	
	public function update_Content(){
		$this->load->model('M_cm', 'cm');
		// decode base 64  // mar 28032016 
		$result1 = base64_decode($this->input->post('docx_contents'));
		$result2 = $this->input->post('idx');
		//print_r($result1);
		//print_r($result2);
		echo $result1;
		$res = $this->cm->updateDOC($result1, $result2);
	}
	
	// public function getDataTemplate(){
		// $this->load->model('M_cm', 'cm');
		// $result1 =$this->input->post('ID');		
		// $res = $this->cm->get_contents($result1);
		// echo $res;
	// }
	
	public function list_temp()
    {
		$this->load->model('M_template');
		$data = array();
		$this->db->set('order by doc_id desc');
		$result['result1'] = $this->M_template->table_location();
		$result['result2'] = $this->M_template->get_doc_type();
		$result['result3'] = $this->M_template->get_bahasa();
		$result['result4'] = $this->M_template->convert_lokasi();		
        // $data['pgl_id'] = $this->input->post('mitra');
        $this->load->view($this->folder . '/edit_document', $result);
    }
	public function get_data()
	{
		$this->load->model('m_template','mt');
		$result = $this->mt->load_temp();
		echo json_encode($result);
	}
	
	public function get_data_nm_id()
	{
		$this->load->model('m_template','mt');
		$result = $this->mt->load_temp_nm_id();
		echo json_encode($result);
	}
	
	public function get_content_template(){
		$this->load->model('M_template');
		$data = $this->input->post('id');
		$result= $this->M_template->get_contents($data);
		echo $result;
	}public function get_content_template_and_replace(){
		$this->load->model('M_template');
		$data = $this->input->post('id');
		$result= $this->M_template->get_contents($data);
		$result2 = $this->M_template->replace_contents($result);
		echo $result2;
	}
	public function delete_Temp(){
		$this->load->model('M_template');
		$data = $this->input->post('id_doc');
		$result= $this->M_template->deleteTempfromTable($data);
		echo $result;
	}
	
	public function get_variable_content(){
		$this->load->model('M_template');
		$data1 = $this->input->post('val_table');
		$data2 = $this->input->post('val_id');
		$result= $this->M_template->get_var_content($data1, $data2);
		echo json_encode($result);
		// echo $result;
	}
	public function get_content_variable(){
		$this->load->model('M_template');
		$data1 = $this->input->post('id');
		$result1 = $this->M_template->get_var_templates($data1);
		// print_r($result1);
		$result2 = $result1[0]->VARIABLE_TEMPLATE;
		// print_r($result2);
		$result = explode(' ',$result2);
		echo json_encode($result);
	}
	public function get_table_name_var(){
		$this->load->model('M_template');
		$result= $this->M_template->get_var_tbl_name();
		echo json_encode($result);
	}
	
	public function Name_Temp(){
		$this->load->model('M_template');
		$data1 = $this->input->post('id_doc');
		$result= $this->M_template->load_temp_name($data1);
		echo json_encode($result);
	}
	
	public function save_name(){
		$this->load->model('M_template');
		$data1 = $this->input->post('id_doc');
		$data2 = $this->input->post('nm_field');
		$result= $this->M_template->save_name_var_field($data1, $data2);
	}
	
	public function get_table_template(){
		$this->load->model('M_template');
		$this->load->model('M_template', 'tm');
		$data1 = $this->input->post('t_name');
		$data2 = "";
		$this->tm->insertNewTemplate($data1,$data2);
		$result['result3'] = $this->M_template->load_temp();
		$this->load->view($this->folder . '/table_create_new_template', $result);
		// echo $result;
	}
	public function get_table_temp(){
		$this->load->model('M_template');
		$this->load->model('M_template', 'tm');
		$result['result3'] = $this->M_template->load_temp();
		$this->load->view($this->folder . '/table_create_new_template', $result);
		// echo $result;
	}
	
	
}
