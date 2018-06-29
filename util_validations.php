<?php
	function isNotEmpty($q){
		$i = str_replace(' ', '', $q);
		$i = str_replace('.', '', $i);
		$i = str_replace('-', '', $i);
		return ctype_alnum($i);
	}

	#Will be used for transactions for redundancy
	#databse should have redundancy too
	function isAdmin() : bool{
		if(!isset($_SESSION["ID"]) && $LoggedInAccesID != "1"){
			return false;
		}
		else{
			return true;
		}
	}
?>