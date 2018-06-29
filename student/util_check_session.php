<?php
	if(!isset($_SESSION["ID"])){
		header('Location: ../');
	}
	if ($LoggedInAccesID != "3"){
		header('Location: ../');
	}
?>