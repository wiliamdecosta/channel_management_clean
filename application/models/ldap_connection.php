<?php

class Ldap_connection extends CI_Model {
    
    var $Host;
    var $Authrealm;
	var $AuthResult;
	
    function __construct() {
        parent::__construct();
        $this->Host = "10.0.32.230";
		$this->Authrealm = "User Intranet Telkom ND";
		$this->AuthResult = 0;
    }
    
	function Open($_user_id, $_user_pwd) {

		if ($_user_id != "" && $_user_pwd != "") {
		    
			$ds = ldap_connect($this->Host);
			$r  = ldap_search($ds, " ", "uid=" . $_user_id);
			
			//var_dump($r);
			//die("vardump");
			
			if ($r) {
				
				$result = ldap_get_entries( $ds, $r);
				if (isset($result[0])) {
					try {
					    $rbind = @ldap_bind( $ds, $result[0]["dn"], $_user_pwd);
					    if($rbind) {
					        $this->AuthResult = 1;
					    }else {
					        $this->AuthResult = 0;
					    }
					    
					}catch(Exception $e) {
					    $this->AuthResult = 0;
					}
											
				}
			}else {
			    $this->AuthResult = 0;    
			}
		}
		
		return $this->AuthResult;
	}
	
	function getAuthResult() {
		return $this->AuthResult;
	}
}
?>