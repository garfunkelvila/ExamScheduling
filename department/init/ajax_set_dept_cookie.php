<?php
	setcookie('deptName', $_REQUEST['deptName'], time() + (86400), "/"); // 86400 = 1 day
	setcookie('deptAccr', $_REQUEST['deptAccr'], time() + (86400), "/"); // 86400 = 1 day
?>