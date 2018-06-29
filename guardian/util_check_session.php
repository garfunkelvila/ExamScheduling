<?php
	if(!isset($_SESSION["ID"])){
		header('Location: ../');
	}
	if ($LoggedInAccesID != "4"){
		header('Location: ../');
	}
?>