<?php

class Workflow extends CI_Model
{

    function __construct() {
        parent::__construct();

        $this->load->helper('sequence');
    }

    public function getListInbox($user_name) {
        $sql = "SELECT * FROM TABLE(pack_task_profile.workflow_name('".$user_name."'))";
        $query = $this->db->query($sql);
        $rows = $query->result_array();

        return $rows;
    }

    public function getSummaryList($pdoc_type_id, $user_name) {
        $sql = "SELECT * FROM TABLE(pack_task_profile.workflow_summary_list (".$pdoc_type_id.",'".$user_name."')) 
                    WHERE p_w_doc_type_id = ".$pdoc_type_id;
        $query = $this->db->query($sql);
        $rows = $query->result_array();

        return $rows;
    }
}