<?php
	if(!isset($_SESSION["ID"])){
		header('Location: ../');
	}
	if ($LoggedInAccesID != "2"){
		header('Location: ../');
	}
?>