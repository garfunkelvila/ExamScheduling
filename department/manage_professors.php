<!DOCTYPE html>
<?php
	include "../util_dbHandler.php";
	include("util_check_session.php");
?>
<html>
<head>
	<title>Manage professors</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
	<style type="text/css">
		/*Mozila recolors the invalid entry upon clearing via javascript. So it is needed*/
		@-moz-document url-prefix(){
			input:required {
				box-shadow:none!important;
			}
			input:invalid {
				box-shadow:0 0 3px red;
			} 
		}
	</style>
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<?php include "fragment_header.php" ?>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<div class="w3-hide-small">
				<img  src="/images/sys-logo.png" style="width: 100%">
				<br>
				<br>
				<hr>
			</div>

			<em class="w3-tiny" style="text-align: justify;">Please do take note that professors registered by you can only be seen by you.</em>
			<?php include 'fragment_starter_warning.php'; ?>
		</div>
		<div class="w3-rest w3-container">
			<h3>Professors manager</h3>
			<form name="frmAddSection" class="w3-card w3-padding" onsubmit="return registerProfessor()" style="max-width: 4in;">
				<h5 class="w3-border-bottom w3-border-blue">Register professor</h5>
				<input class="my-input-1" style="text-transform: capitalize;" type="text" id="fName" placeholder="First name" required="">
				<input class="my-input-1" style="text-transform: capitalize;" type="text" id="mName" placeholder="Middle name">
				<input class="my-input-1" style="text-transform: capitalize;" type="text" id="lName" placeholder="Family name" required="">
				<input class="my-input-1" style="text-transform: capitalize;" type="text" id="idNumber" placeholder="ID Number" required="" oninput="validateIdNumber()">
				<button class="my-button my-blue w3-section">Register</button>
				<em class="w3-tiny" style="display: inline-block;">The default password is abcd1234</em>
			</form>
			<script type="text/javascript">
				function validateIdNumber(){
					var id = $("#idNumber").val();
					var idl = id.length;
					var isValid = true;

					if (idl < 4){
						isValid = false;
					}
					
					for (var i = 0; i < idl; i++) {
						if (isNaN(id[i]) && id[i] != "-"){
							isValid = false;
							break;
						}
					}

					if (isValid == false){
						$("#idNumber").get(0).setCustomValidity("Invalid ID number");
						return false;
					}
					else{
						$("#idNumber").get(0).setCustomValidity("");
						return true;
					}
				}
				function registerProfessor(){
					if (validateIdNumber() == false) return false;
					$.ajax({
						url: "m_prof/ajax_json_insert_prof.php",
						dataType: "json",
						data: {
							idNumber : $("#idNumber").val(),
							fName : $("#fName").val(),
							lName : $("#lName").val(),
							mName : $("#mName").val()
						},
						success: function(response){
							if (response.sucess){
								alert(response.result);
								refreshMyProfessors();
							}
							else{
								alert(response["result"]);
							}
						}
					});
					return false;
				}
			</script>
			<div class="">
				<h5>My Professors</h5>
				<div class="w3-border-blue w3-border-top w3-container" style="width: 100%; display: table; max-width: 8in;" id="profContainer">
					<?php #include 'm_prof/ajax_fragment_table_professors.php'; ?>
				</div>
				<script type="text/javascript">
					function btnEditProf(id){
							document.getElementById("prof-view-" + id).style.display = "none";
							document.getElementById("prof-edit-" + id).style.display = "table-row";
					}
					function btnCancelEditProf(id){
						document.getElementById("prof-view-" + id).style.display = "table-row";
						document.getElementById("prof-edit-" + id).style.display = "none";
						$('#prof-edit-' + id)[0].reset();
					}
					function deleteProfessor(id){
						if (confirm("Are you sure?") == true) {
							$.ajax({
								url: "m_prof/ajax_json_delete_prof.php",
								dataType: "json",
								data: { idNumber : id },
								success: function(response){
									if (response.sucess){
										alert("Professor sucesfully deleted.");
										refreshMyProfessors();
									}
									else{
										alert(response["result"]);
									}
								}
							});
						}
						return false;
					}
					function editProfessor(id){
						$.ajax({
							url: "m_prof/ajax_json_update_prof.php",
							dataType: "json",
							data: {
								idNumber : id,
								fName : $("#pEditfName-" + id).val(),
								lName : $("#pEditlName-" + id).val(),
								mName : $("#pEditmName-" + id).val()
							},
							success: function(response){
								alert(response.result);
								if (response.sucess){
									$("#idNumber").val('');
									$("#fName").val('');
									$("#lName").val('');
									$("#mName").val('');
									refreshMyProfessors();
								}
							}
						});
					}
					function refreshMyProfessors(){
						$.ajax({
							url: "m_prof/ajax_fragment_table_professors.php",
							success: function(response){
								$("#profContainer").html(response);
							}
						});
					}
					refreshMyProfessors();
				</script>
			</div>
				<?php include 'm_prof/ajax_fragment_table_professors_no_dept.php'; ?>
		</div>
	</div>
	<?php #include "fragment_footer.php" ?>
</body>
</html>