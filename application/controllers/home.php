<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct() {
		parent::__construct();

        checkAuth();
		$this->load->model('M_profiling');
		$this->load->model('M_user');
	}

	public function index()
	{
        $menu = "";
        $result = $this->M_profiling->getMenuByProf($this->session->userdata("d_prof_id"),0);

        foreach($result as $datas){
            $data[$datas->MENU_PARENT][] = $datas;

            $menu = $this->get_menu($data);

        }

        $this->menu = $menu;

        $this->load->view('templates/header');
        $this->load->view('home/index');
        $this->load->view('templates/footer');
	}

    function get_menu($data, $parent = 0) {
        if (isset($data[$parent])) {
            $html = "";
            //$i++;
            foreach ($data[$parent] as $v) {
                $child = $this->get_menu($data, $v->MENU_ID);
                $html .= "<li class='setting_nav' id='".$v->FILE_NAME."' href='".site_url($v->MENU_LINK)."'>";
                $html .= "<a href='#' class='dropdown-toggle'>";
                if($v->MENU_ICON == ""){
                   $html .= '<i class="menu-icon fa fa-caret-right"></i>';
                }else{
                    $html .= '<i class="'.$v->MENU_ICON.'"></i>';
                }

                $html .= '<span class="menu-text">'.$v->MENU_NAME.'</span>';

                if($child){
                   $html .= '<b class="arrow fa fa-angle-down"></b>';
                }
                $html .=  '</a>';
                $html .= '<b class="arrow"></b>';
                if ($child) {
                    //$i--;
                    $html .= '<ul class="submenu">';
                    $html .= $child;
                  //  $html .= '</ul>';
                }
                $html .= '</li>';

            }
            $html .= '</ul>';
            return $html;
        } else {
            return false;
        }
    }
	
	public function setprofile() {
		$this->load->model("M_user");
		$profs = $this->M_user->getUserProfile($this->session->userdata("d_user_id"));
		$this->load->view('v_set_profile', array("profs"=>$profs));
	}
	
	public function setprofiledo() {
		if(isset($_POST['login'])) {
			$this->load->model("M_user");
			$profs = $this->M_user->getUserProfile($this->session->userdata("d_user_id"));
			$this->session->set_userdata('d_prof_id', $_POST['prof_id']);
			$this->session->set_userdata('d_prof_name', $profs[ $_POST['prof_id'] ]);
			
			// save menu to session
			$this->setmenus($_POST['prof_id']);
		}
		redirect("/home");
	}
	
	public function setmenus($prof_id) {
		$this->load->model('M_profiling');
		$d_menus = "";
		$d_menus .= "<ul class='sf-menu'>";
		$d_menus .= "<li><a href='".site_url("")."'><img src='".image_asset_url("home_icon.png")."' width='20' style='margin-top:-5px; margin-bottom:-5px;' /> Home</a>";
		$d_menus .= "</li>";
		foreach($this->M_profiling->getMenuByProf($prof_id,0) as $k => $v) {
			$d_menus .= "<li><a href='".site_url($v->MENU_LINK)."'>".$v->MENU_NAME."</a>";
			$d_menus .= $this->setsubmenu($this->M_profiling, $prof_id, $v->MENU_ID);
			$d_menus .= "</li>";
		}
		$d_menus .= "</ul>";
		$i=0; $fixlen = 600;
		while(strlen($d_menus) >0) {
			$this->session->set_userdata('d_menus_'.$i, substr($d_menus,0,$fixlen) );
			
			$d_menus = substr($d_menus,$fixlen,strlen($d_menus)-$fixlen);
			$i++;
		}
	}
	
	private function setsubmenu($objprof, $prof_id, $parent) {
		$d_sub_menu = "";
		$sub = $objprof->getMenuByProf($prof_id, $parent);
		if(count($sub) > 0) {
			$d_sub_menu .= "<ul>";
			foreach($sub as $k => $v) {
				$d_sub_menu .= "<li><a href='".site_url($v->MENU_LINK)."'>".$v->MENU_NAME."</a>";
				$d_sub_menu .= $this->setsubmenu($objprof, $prof_id,$v->MENU_ID);
				$d_sub_menu .= "</li>";
			}
			$d_sub_menu .= "</ul>";
		}
		return $d_sub_menu;
	}

    public function download(){
        $this->load->helper('download');
        $path = base_url()."application/third_party/doc_pks/tes.pdf";
      //  die($path);
        $data = file_get_contents($path); // Read the file's contents
        $name = 'pks_doc.pdf';
        force_download($name, $data);
    }
}
