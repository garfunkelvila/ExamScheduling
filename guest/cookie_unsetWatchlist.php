<?php
	#Delete to watchlist
	if (isset($_COOKIE['watchlist'])){
		$json = json_decode($_COOKIE['watchlist']);

		$delIndex = array_search($_REQUEST['id'], $json);
		#unset($json[$delIndex]);
		array_splice($json, $delIndex, 1);


		setcookie("watchlist", json_encode($json), time() + 3600, '/');
	}
	#echo json_encode($json);
?>