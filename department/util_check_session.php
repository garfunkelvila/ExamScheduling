<?php
	if(!isset($_SESSION["ID"])){
		header('Location: ../');
	}
	if ($LoggedInAccesID != "5"){
		header('Location: ../');
	}
?>