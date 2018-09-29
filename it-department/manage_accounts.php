<!DOCTYPE html>
<?php
	include_once "../util_dbHandler.php";
	include_once("util_check_session.php");

	$dev = isset($_GET['dev']) && $_GET['dev'] == '1' ? true : false;
?>
<html>
<head>
	<title>Manage accounts</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<?php include_once "fragment_header.php" ?>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<div class="w3-hide-small">
				<img  src="/images/sys-logo.png" style="width: 100%">
				<br>
				<br>
				<hr>
			</div>
			<?php
				if ($dev){
					?><button class="w3-button my-blue" style="width: 100%;" onclick="showPopup('m_acct/popup_register_student.php')" type="button">Student registration wizard</button>
					<button class="w3-button my-blue" style="width: 100%;" onclick="showPopup('m_acct/popup_register_guardian.php')" type="button">Guardian registration wizard</button>
					<em>Please register the student first before their parent.</em><?php 
				}
			 ?>
		</div>
		<div class="w3-rest w3-container" style="min-height: 7in;">
			<form class="w3-card-4 w3-padding w3-container w3-margin " onsubmit="return registerUser();" style="max-width: 4in;">
				<h5 class="w3-border-bottom w3-border-blue">Register User</h5>
				<select class="my-input-1" id="optType" onchange="validateType()">
					<option value="-">-Select account type-</option>
					<?php 
						$stmt = null;
						$stmt = $conn->prepare("SELECT * FROM `users_access_types` ORDER BY `Level` ASC;");
						$stmt->execute();
						$accessResult = $stmt->get_result();
						$x = 1;
						if ($accessResult->num_rows > 0) {
							while ($accesssRow = $accessResult->fetch_assoc()) {
								if (!$dev && ($accesssRow["Id"] == '3' || $accesssRow["Id"] == '4'))
									continue;
								?><option value="<?php echo $accesssRow["Id"] ?>"><?php echo $accesssRow["Name"] ?></option><?php
							}
						}
					?>
				</select>
				<div style="display: table;">
					<div style="display: table-cell;"><input class="my-input-1" style="text-transform: capitalize;"  type="text" id="fName" placeholder="First name" required="" oninput="loginIdFiller()"></div>
					<div style="display: table-cell;"><input class="my-input-1" style="text-transform: capitalize;" type="text" id="mName" placeholder="Middle name"></div>
					<div style="display: table-cell;"><input class="my-input-1" style="text-transform: capitalize;" type="text" id="lName" placeholder="Family name" required="" oninput="loginIdFiller()"></div>
				</div>
				<input class="my-input-1" type="text" id="strIdNumber" placeholder="ID Number" required="" onblur="validateIdNumber()">
				<em>The default password is abcd1234</em>
				<div class="w3-right">
					<button class="my-button my-blue w3-section w3-hoverable" type="submit" onclick="validateIdNumber()">Register</button>
				</div>
			</form>
			<?php include_once "m_acct/fragment_registered_accounts.php" ?>
		</div>
	</div>
	<?php include_once "fragment_footer.php" ?>
	<script type="text/javascript">
		function showPopup(dir, name){
			//second parameter helps prevents duplication of window
			openwindow = window.open(dir, 'popup_wizzard', "toolbar=no, location=yes, scrollbars=yes, resizable=yes, width=600, height=700");
			openwindow.focus();
		}
		function loginIdFiller(){
			if($("#optType").val() == '4')
				$("#strIdNumber").val($("#fName").val().toLowerCase() + $("#lName").val().toLowerCase());
		}
		function validateAll(){
			validateType();
			validateIdNumber();
		}

		function validateType(){
			if ($("#optType").val() == '-'){
				$("#optType").get(0).setCustomValidity("Please select account type");
				return false;
			}
			else{
				$("#optType").get(0).setCustomValidity("");
				return true;
			}
		}
		function validateIdNumber(){
			if($("#optType").val() == '4'){
				$("#strIdNumber").get(0).setCustomValidity("");
				return true; //Bypass
			}

			var id = $("#strIdNumber").val();
			var idl = id.length;
			var isValid = true;

			if (idl < 4){
				isValid = false;
			}

			for (var i = 0; i < idl; i++) {
				if (isNaN(id[i]) && id[i] != "-"){6
					isValid = false;
					break;
				}
			}

			if (isValid == false){
				$("#strIdNumber").get(0).setCustomValidity("Invalid ID number");
				return false;
			}
			else{
				$("#strIdNumber").get(0).setCustomValidity("");
				return true;
			}
		}
		function registerUser(){
			if (!validateType()) return false;
			if (!validateIdNumber()) return false;

			$.ajax({
				url: "m_acct/ajax_json_register_user.php",
				dataType: "json",
				data: {
					idNumber: $("#strIdNumber").val(),
					fName: $("#fName").val(),
					mName: $("#mName").val(),
					lName: $("#lName").val(),
					uType: $("#optType").val()
				},
				success: function(response){
					alert(response.result);
					if(response.sucess){
						//RELOAD TABLE
						search($("#txbSearch").val());
						$("#strIdNumber").val('');
						$("#fName").val('');
						$("#mName").val('');
						$("#lName").val('');
						$("#optType").val('-');
						$("#optType").get(0).setCustomValidity("");
						$("#strIdNumber").get(0).setCustomValidity("");
					}
				}
			});
			return false;
		}
	</script>
</body>
</html>