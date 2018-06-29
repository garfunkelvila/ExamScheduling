<?php
	if(!isset($_SESSION["ID"])){
		header('Location: ../');
	}
	if ($LoggedInAccesID != "1"){
		header('Location: ../');
	}
?>