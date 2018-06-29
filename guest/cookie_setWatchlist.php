<?php
	#Add to watchlist
	if (isset($_COOKIE['watchlist'])){
		#append
		$json = json_decode($_COOKIE['watchlist']);
		array_push($json, $_REQUEST['id']);
	}
	else{
		#Start a new one
		$json = array();
		array_push($json, $_REQUEST['id']);
	}
	setcookie("watchlist", json_encode($json), time() + 3600, '/');
?>