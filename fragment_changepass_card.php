<?php
	#check if can login using the default password
	$tpass = getPassword('abcd1234');
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_employee_login`(?,?);");
	$stmt->bind_param('ss', $_SESSION['ID'], $tpass);
	$stmt->execute();
	$tloginResult = $stmt->get_result();
	$loginRow = $tloginResult->fetch_row();

	#check if dialog is skipped
	$stmt = null;
	$stmt = $conn->prepare("SELECT `changePassDialog` FROM `users` WHERE `Id Number` = ?;");
	$stmt->bind_param('s', $_SESSION['ID']);
	$stmt->execute();
	$dlg = $stmt->get_result()->fetch_row()[0];
	if ($tloginResult->num_rows != 0 && $dlg == 0){
		?><a href="change_password.php" class="w3-card-4 w3-margin home-link" style="overflow: auto; height: 1.5in;">
			<header class="w3-container w3-red">
				<h6 style="">Change Password</h6>
			</header>
			<p class="w3-container">Your account stil uses the default password, click here to change password.</p>
		</a><?php
	}
?>