<?php
	include "../util_dbHandler.php";

	$stmt = null;
	$q = str_replace(' ', '%', $_REQUEST['q']);
	$stmt = $conn->prepare("CALL `select_users`(?,?);");
	$stmt->bind_param('si', $q, $_REQUEST['accFilter']);
	$stmt->execute();
	$usersResult = $stmt->get_result();

	if ($usersResult->num_rows > 0) {
		while ($userRow = $usersResult->fetch_assoc()) {
			//$resultArray[] = $userRow;
			$dateAdded = new DateTime($userRow["Date Added"]);
			?>
			<div id="divView<?php echo $userRow['Id Number']; ?>" class="my-hover-light-grey w3-container" style="display: table-row;">
				<div style="display: table-cell; min-width: 2in;"><?php echo $userRow['First Name'] . " " . $userRow['Middle Name'] . " " . $userRow['Family Name'] ?></div>
				<div style="display: table-cell; width: 1.25in; min-width: 1.25in; text-align: center;"><?php echo $userRow["Id Number"] ?></div>
				<div style="display: table-cell; width: 2in"><?php echo $userRow["Access"] ?></div>
				<div style="display: table-cell; width: 2in"><?php echo $dateAdded->format("M d, Y"); ?></div>
				<div style="display: table-cell; width: 2in; white-space: nowrap;">
					<button title="Edit" id="btnEdit<?php echo $userRow['Id Number'] ?>"
						class="my-button w3-hover-green"
						type="button"
						onclick="btnEdit('<?php echo $userRow['Id Number'] ?>')">
							<i class="far fa-edit" aria-hidden="true"></i>
					</button>
					<button title="Delete" id="btnDelete<?php echo $userRow['Id Number'] ?>"
						class="my-button w3-hover-red w3-hover-text-white"
						type="button"
						onclick="btnDelete('<?php echo $userRow['Id Number'] ?>',' <?php echo $userRow['First Name'] . " " . $userRow['Middle Name'] . " " . $userRow['Family Name'] ?>')">
							<i class="far fa-trash-alt" aria-hidden="true"></i>
					</button>
					<?php
						$canViewEye = array('3','4');
						if(in_array($userRow["Access Id"], $canViewEye)){
							?>
								<button title="View" class="my-button w3-hover-green w3-hover-text-white" onclick="viewUser('<?php echo $userRow["Id Number"] ?>')" type="button">
									<i class="fas fa-eye" aria-hidden="true"></i>
								</button>
							<?php
						}

						if ($userRow["Access Id"] == 4){
							?>
								<button title="View printer friendly" class="my-button w3-hover-green w3-hover-text-white" type="button"
									onclick="openwindow = window.open('print_friendly_guardian_monitor.php?idNum=<?php echo $userRow["Id Number"]; ?>', 'Print', 'toolbar=no, location=yes, scrollbars=yes, resizable=yes, width=600, height=700'); openwindow.focus();">
									<i class="fas fa-print" aria-hidden="true"></i>
								</button>
							<?php
						}
					?>
					
					<?php
						$pass = getDefPassword($userRow['Id Number']);
						$stmt = null;
						$stmt = $conn->prepare("CALL `select_employee_login`(?,?);");
						$stmt->bind_param('ss', $userRow['Id Number'], $pass);
						$stmt->execute();
						$loginResult = $stmt->get_result();
						$loginRow = $loginResult->fetch_row();
						if ($loginResult->num_rows == 0){
							#if($userRow["Access Id"] == "1"){
								?>
									<button title="Reset Password" id="btnResetPass<?php echo $userRow['Id Number'] ?>"
										class="my-button w3-hover-red w3-hover-text-white"
										type="button"
										style=""
										onclick="resetPassword('<?php echo $userRow["Id Number"] ?>')">
										<i class="fas fa-refresh" aria-hidden="true"></i>
									</button>
								<?php
							#}
						}
					?>
				</div>
			</div>
			<form onsubmit="return btnCommitEdit('<?php echo $userRow['Id Number'] ?>')"
				class="my-pale-green w3-container"
				id="frmUser<?php echo $userRow['Id Number'] ?>"
				style="display: none;">
				<div style="min-width: 2in; display: table-cell;">
					<input 
						class="my-input-1" 
						type="text" 
						id="txbfName<?php echo $userRow["Id Number"] ?>" 
						value="<?php echo $userRow['First Name'] ?>"
						required=""
						placeholder="First Name">
					<input 
						class="my-input-1" 
						type="text" 
						id="txbmName<?php echo $userRow["Id Number"] ?>" 
						value="<?php echo $userRow['Middle Name'] ?>"
						placeholder="Middle Name">
					<input 
						class="my-input-1" 
						type="text" 
						id="txblName<?php echo $userRow["Id Number"] ?>" 
						value="<?php echo $userRow['Family Name'] ?>"
						required=""
						placeholder="Family Name">
				</div>
				<div style="display: table-cell; width: 1.25in; min-width: 1.25in; text-align: center;"><?php echo $userRow["Id Number"] ?></div>
				<div style="display: table-cell; width: 2in"><?php echo $userRow["Access"] ?></div>
				<div style="display: table-cell; width: 2in"><?php echo $dateAdded->format("M d, Y"); ?></div>
				<div style="display: table-cell; width: 2in; white-space: nowrap;">
					<button title="Commit edit" id="btnOk<?php echo $userRow['Id Number'] ?>"
						class="my-button w3-hover-green"
						type="submit"
						style="">
						<i class="fas fa-check" aria-hidden="true"></i>
					</button>
					<button title="Cancel edit" id="btnCancel<?php echo $userRow['Id Number'] ?>"
						class="my-button w3-hover-red w3-hover-text-white"
						type="button"
						style=""
						onclick="btnCancelEdit('<?php echo $userRow["Id Number"] ?>')">
						<i class="fas fa-ban" aria-hidden="true"></i>
					</button>
				</div>
			</form>
			<?php
		}

		//$json['sucess'] = true;
		//$json['result'] = $resultArray;
		//echo json_encode($json);
	}
	else{
		//$json['sucess'] = false;
		//$json['result'] = "Search for \"" . htmlspecialchars($_REQUEST['q']) . "\" resulted nothing";
		//echo json_encode($json);
	}
?>
<script type="text/javascript">
	function viewUser(id){
		//second parameter helps prevents duplication of window
		openwindow = window.open("popup_view_user_manage_accounts.php?idNum=" + id, "View User", "toolbar=no, location=yes, scrollbars=yes, resizable=yes, width=600, height=700");
		openwindow.focus();
	}
</script>