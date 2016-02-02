<?php
class Gen_id extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	public function generate_id($key,$table) {
        $q = $this->db->query("SELECT nvl(MAX($key),0)+1 N FROM $table");
        $row = $q->row(0);
        return $row;
    }

}