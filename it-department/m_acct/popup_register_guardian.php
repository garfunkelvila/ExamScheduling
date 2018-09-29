<?php 
	include_once "../../util_dbHandler.php";
	

	$stmt = null;
	$stmt = $conn->prepare("CALL `insert_guardian_pre_reg_id`()");
	$stmt->execute();
	$tmpIdResult = $stmt->get_result();
	$tmpIdRow = $tmpIdResult->fetch_row();
	$tmpId = $tmpIdRow[0];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register a parent/guardian</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../../css/w3.css">
	<link rel="stylesheet" href="../../css/my.css">
	<link rel="stylesheet" href="../../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-container" style="max-width: 5in;">
		<div id="view-1">
			<h5>Register parent/guardian</h5>
			<form class="w3-card-4 w3-padding w3-container" onsubmit="return changeView('1','2');">
				
				<div style="display: table;">
					<div style="display: table-cell;"><input class="my-input-1" style="text-transform: capitalize;" type="text" id="fName" placeholder="First name" required="" onkeyup="loginIdFiller()"></div>
					<div style="display: table-cell;"><input class="my-input-1" style="text-transform: capitalize;" type="text" id="mName" placeholder="Middle name"></div>
					<div style="display: table-cell;"><input class="my-input-1" style="text-transform: capitalize;" type="text" id="lName" placeholder="Family name" required="" onkeyup="loginIdFiller()"></div>
				</div>
				<input class="my-input-1" type="text" id="strIdNumber" placeholder="Login ID" required="">
				<em class="w3-tiny" style="display: inline-block;">The default password is abcd1234</em>
				<div class="w3-right">
					<button class="my-button my-blue w3-section w3-hoverable" type="submit">Next</button>
				</div>
			</form>
		</div>
		<div id="view-2" style="display: none;">
			<h5>Students to monitor</h5>
			<div style="display: table; width: 100%" id="monitor-container">
				
			</div>
			<br>
			<div>
				<input
					class="my-input-1"
					type="text"
					id="txbGuardianId"
					placeholder="ID or Name"
					onkeyup="updateSudgestion()"
					onfocus="document.getElementById('sudgestions').style.display = 'table'">
				<div class="w3-card-2" id="sudgestions" style="display: none; background-color: white; position: absolute;">
				</div>
			</div>
			<em class="w3-tiny">Enter some part of name or ID number and click on the suggestion to add them.</em>
			<!-- ********************** -->
			<div class="w3-right">
				<button class="my-button my-blue w3-section w3-hoverable" type="submit" onclick="return changeView('2','1'); fillSubjContainer();">Back</button>
				<button class="my-button my-blue w3-section w3-hoverable" type="submit" onclick="return registerGuardian()">Register</button>
				<!--button onclick="fillSubjContainer();">asdsad</button-->
			</div>
			
			<div style="display: table; width: 100%" id="tblSubjContainer">
				
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		var tmpId = <?php echo $tmpId; ?>;
		window.onbeforeunload = function(){
			return "You haven't finished registering the parent/guardian. Do you want to leave without finishing?";
		}

		function loginIdFiller(){
			$("#strIdNumber").val($("#fName").val().toLowerCase() + $("#lName").val().toLowerCase())
		}

		function changeView(id,od){
			document.getElementById("view-" + id).style.display="none";
			document.getElementById("view-" + od).style.display="inline";
			return false;
		}
		/************************/

		function updateSudgestion(){
			if ($("#txbGuardianId").val().length < 1){
				$("#sudgestions").html("");
				return;
			};

			$.ajax({
				url: "popups/ajax_select_users_popup_register_guardian_pre_reg.php",
				dataType: "json",
				data: {
					q: $("#txbGuardianId").val(),
					idNum: tmpId
				},
				success: function(response){
					$("#sudgestions").html("");
					if(response.sucess){
						$.each(response.result, function(index, value){
							var midName = value['Middle Name'].length == 0 ? "" : value['Middle Name'] + " "; //Prevents double space
							var wholeName = value['First Name'] + " " + midName + value['Family Name'];

							$("#sudgestions").append("<a class='w3-button' style='text-align: left; display:table-row;' onclick=\"addStudent('" + value['Id Number'] + "')\">" + 
								"<div class='w3-container' style='display: table-cell;'>" + value['Id Number'] + "</div>" +
								"<div class='w3-container' style='display: table-cell;'>" + wholeName + "</div>" + 
								"</a>");
						});
					}
					else{
						//
					}
				}
			});
		}

		function fillSubjContainer(){
			$.ajax({
				url: "popups/fragment_table_pre_reg_guardian_monitor.php",
				data: { idNum: tmpId },
				success: function(response){
					$("#monitor-container").html("");
					$("#monitor-container").html(response);
				}
			});
			return false;
		}

		function registerGuardian(){
			$.ajax({
				url: "ajax_json_insert_guardian.php",
				dataType: "json",
				data: {
					tId: tmpId,
					idNumber: $("#strIdNumber").val(),
					fName: $("#fName").val(),
					mName: $("#mName").val(),
					lName: $("#lName").val()
				},
				success: function(response){
					if(response.sucess){
						window.onbeforeunload = null;
						if (confirm("Guardian sucesfully registered! View printer friendly version?") == true) {
							openwindow = window.open('print_friendly_guardian_monitor.php?idNum=' +  $("#strIdNumber").val(), 'Print', 'toolbar=no, location=yes, scrollbars=yes, resizable=yes, width=600, height=700');
							openwindow.focus();
						}
						if (confirm("Do you want to add more?") == true) {
							location.reload();
						} else {
							window.close();
						}
					}
					else{
						alert("ID number already exist, and is registered to " + response.result + ".");
					}
				}
			});
			return false;
		}
		function addStudent(q){
			$.ajax({
				url: "popups/insert_pre_reg_guardian_monitor.php",
				data: {
					studentId: q,
					tUserId: tmpId
				},
				success: function(response){
					fillSubjContainer();
					$("#txbGuardianId").val("");
					$("#sudgestions").html("");
					$("#txbGuardianId").focus();
				}
			});
			return false;
		}
		function removeStudent(e){
			$.ajax({
				url: "popups/ajax_delete_from_guardian_monitor_pre_reg.php",
				data: {
					monitorId: e
				},
				success: function(response){
					fillSubjContainer();
				}
			});
			return false;
		}
		fillSubjContainer();
	</script>
</body>
</html>