<?php
	if(!isset($_SESSION['ID'])){
		header('Location: ../');
	}
	if ($LoggedInAccesID != '6'){
		header('Location: ../');
	}
?>