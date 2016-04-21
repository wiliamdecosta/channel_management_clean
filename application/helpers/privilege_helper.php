<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter
 * @package        CodeIgniter
 * @author        Gery
 * @created     04/14/2016
 **/

if (!function_exists('generatehtml')) {

    function getPrivilege($menu_id)
    {
        $CI =& get_instance();
        $CI->load->model('mfee');
        $CI->db->_protect_identifiers = false;

        $prof_id = $CI->session->userdata('d_prof_id');

        // Get APP_MENU_PROFILE_ID
        $CI->db->where('MENU_ID',$menu_id);
        $CI->db->where('PROF_ID',$prof_id);
        $row = $CI->db->get('APP_MENU_PROFILE')->row();
        $APP_MENU_PROFILE_ID = $row->APP_MENU_PROFILE_ID;


        // Get List Object
        $CI->db->select('a.P_APP_OBJECT_TYPE_ID OBJECT_ID');
        $CI->db->select('a.IS_ACTIVE STATUS');
        $CI->db->select('b.CODE');

        $CI->db->where('APP_MENU_PROFILE_ID',$APP_MENU_PROFILE_ID);
      //  $CI->db->where('P_APP_OBJECT_TYPE_ID',$object_type);
        $CI->db->from('P_APP_RMDIS_OBJECT a');
        $CI->db->join('P_APP_OBJECT_TYPE b', 'a.P_APP_OBJECT_TYPE_ID = b.P_APP_OBJECT_TYPE_ID');
        $status = $CI->db->get()->result();

        // Get List Object
        $arr_obj = $CI->db->get('P_APP_OBJECT_TYPE')->result_array();
        $obj = array();
        foreach($arr_obj as $row){
            $obj[$row['CODE']] = "N";
        }

        foreach ($status as $prv){
            $obj[$prv->CODE] = $prv->STATUS;
        }

        /*echo "<pre>";
        print_r($obj);*/
        // Free memory array
        $arr_obj = null;
        $status = null;


        return $obj;

    }

}