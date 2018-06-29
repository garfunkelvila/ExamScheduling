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
		?><div id="dlgChangePass" class="w3-modal" style="display: block;">
			<div class="w3-modal-content" style="max-width: 5in">
				<div class="w3-container" style="color: black">
					<p >Your account stil uses the default password, change password now?</p>
					<input type="checkbox" id="passDontShowAgain"> <label for="passDontShowAgain">Don't show again</label>
					<div class=" w3-margin w3-right">
						<button class="w3-btn my-blue" style="width: 1in;" onclick="window.location = 'change_password.php'; passChangeRoutine();">Yes</button>
						<button class="w3-btn my-blue" style="width: 1in;" onclick="document.getElementById('dlgChangePass').style.display='none'; passChangeRoutine();">No</button>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			function passChangeRoutine(){
				if ($("#passDontShowAgain").is(":checked")){
					//update user settings
					$.ajax({
						url: "../ajax_util_flip_changePassDialog.php"
					});
				}
			}
		</script><?php
	}
?>