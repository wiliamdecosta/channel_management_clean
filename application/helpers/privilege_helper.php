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
        $status = $CI->db->get();
        //

         if($status->num_rows() > 0) {
             foreach($status->result() as $prv){
                 $result[$prv->CODE] = $prv->STATUS;
             }
          //  $result = $status->result();
        }else{
            $result = 'N';
        }

       /* if($status->num_rows() > 0) {
            $result = $status->row()->IS_ACTIVE;
        }else{
            $result = 'N';
        }*/
       // return $result;

       // echo "<pre>";
        /*if(isset($result[7])){
        print_r($result[7]);
            exit;
        }else{
            print_r('N');
            exit;
        }*/


        return $result;
    }

}