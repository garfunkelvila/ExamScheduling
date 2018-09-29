<?php
	function getPassword($pass){
		return hash('sha384', hash('sha384',$_SESSION['ID']) . hash('sha384', $pass));
	}
	function getAdmPassword(){
		return hash('sha384', hash('sha384', 'admin') . hash('sha384', 'admin'));
	}
	function getDefPassword($idNum){
		return hash('sha384', hash('sha384', $idNum) . hash('sha384', 'abcd1234'));
	}
?>