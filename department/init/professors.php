<?php
	include_once "../../util_dbHandler.php";
	include_once("../util_check_session.php");
?>
<div class="views" id="view-4">
	<h4 class="w3-border-bottom w3-border-blue">Professors</h4>
	<div class="w3-container">
		<form name="frmNameDept" onsubmit="return registerProfessor()">
			<input class="w3-input" id="fName" required="" type="text" placeholder="First name">
			<input class="w3-input" id="mName" type="text" placeholder="Middle name">
			<input class="w3-input" id="lName" required="" type="text" placeholder="Family name">
			<input class="w3-input" id="idNumber" required="" type="text" placeholder="ID Number" oninput="validateIdNumber()">
			<button class="w3-button my-blue">Register</button>
		</form>
		<script type="text/javascript">
			function validateIdNumber(){
				var id = $("#idNumber").val();
				var idl = id.length;
				var isValid = true;
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
						alert(response.result);
						if(response.sucess){
							$("#idNumber").val('');
							$("#fName").val('');
							$("#lName").val('');
							$("#mName").val('');
						}
						refreshMyProfessors();
					}
				});
				return false;
			}
		</script>
	</div>
	<hr>
	<div style="display: table; width: 100%" id="profContainer">
	</div>
	<div class="w3-center w3-margin">
		<button class="w3-button my-blue" onclick="switchView('3')">Back</button>
		<button class="w3-button my-blue" onclick="switchView('5')" disabled="" id="nextBtn">Next</button>
	</div>
</div>
<script type="text/javascript">
	function btnEditProf(id){
			document.getElementById("prof-view-" + id).style.display = "none";
			document.getElementById("prof-edit-" + id).style.display = "table-row";
	}
	function btnCancelEditProf(id){
		document.getElementById("prof-view-" + id).style.display = "table-row";
		document.getElementById("prof-edit-" + id).style.display = "none";
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
				if (response.sucess){
					alert("Professor sucesfully edited.");
					refreshMyProfessors();
				}
				else{
					alert(response["result"]);
				}
			}
		});
	}
	function refreshMyProfessors(){
		$.ajax({
			url: "m_prof/ajax_fragment_table_professors.php",
			success: function(response){
				$("#profContainer").html(response);
				countProf();
			}
		});
	}
	function countProf(){
		if ($('.professor').length > 0){
			$('#nextBtn').prop('disabled', false);
		}
		else{
			$('#nextBtn').prop('disabled', true);
		}
	}
	refreshMyProfessors();
</script>