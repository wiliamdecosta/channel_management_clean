<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Code Igniter

* @package		CodeIgniter
* @author		Gery

**/
function gen_id($key,$table)
{
	$obj =& get_instance();
	$base_url = $obj->config->item('base_url');
    // You may need to load the model if it hasn't been pre-loaded
    $q = $obj->db->query("SELECT nvl(MAX($key),0)+1 id FROM $table");
    $row = $q->row(0);
    return $row->ID;

}

