<?php
#OBSOLETE
	if(isset($_SESSION["ID"])){
		if($LoggedInAccesID == "1"){
			header('Location: admin/');
		}
		elseif ($LoggedInAccesID == "2"){
			header('Location: professor/');
		}
		elseif ($LoggedInAccesID == "3"){
			header('Location: student/');
		}
		elseif ($LoggedInAccesID == "4"){
			header('Location: guardian/');
		}
		elseif ($LoggedInAccesID == "5"){
			header('Location: department/');
		}
		else{
			header('Location: ../');
		}
	}
	else{
		header('Location: ../');
	}
?>