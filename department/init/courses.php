<?php
	include_once "../../util_dbHandler.php";
	include_once("../util_check_session.php");
?>
<div class="views" id="view-2">
	<h4 class="w3-border-bottom w3-border-blue">Courses</h4>
	<div class="w3-container">
		<form name="frmNameDept" onsubmit="return addCourse()">
			<input class="w3-input" id="strCourseName" required="" type="text" placeholder="Name">
			<input class="w3-input" id="strAcronym" required="" type="text" placeholder="Accronym">
			<input class="w3-input" id="chrCode" required="" maxlength="1" type="text" placeholder="Code">
			<button class="w3-button my-blue">Add</button>
		</form>
		<hr>
		<div style="display: table; width: 100%" id="courseContainer">
			
		</div>
	</div>
	<div class="w3-center w3-margin">
		<button class="w3-button my-blue" onclick="switchView('1')">Back</button>
		<button class="w3-button my-blue" onclick="switchView('3')" disabled="" id="nextBtn">Next</button>
	</div>
</div>
<script type="text/javascript">
	function addCourse(){
		$.ajax({
			url: "m_subj/ajax_json_insert_course.php",
			dataType: "json",
			data: {
				strCourseName: $("#strCourseName").val(),
				strAcronym: $("#strAcronym").val(),
				chrCode: $("#chrCode").val()
			},
			success: function(response){
				alert(response["result"]);
				if (response.sucess){
					$("#strCourseName").val(''),
					$("#strAcronym").val(''),
					$("#chrCode").val('')
					fillTable();
				}
			}
		});
		return false;
	}

	function btnDeleteCourse(code){
		if(confirm("Are you sure you want to delete course?"))
			$.ajax({
				url: "m_subj/ajax_json_delete_course.php",
				dataType: "json",
				data: { code: code },
				success: function(response){
					alert(response["result"]);
					if (response.sucess){
						fillTable();
					}
				}
			});
		return false;
	}

	function fillTable(){
		$.ajax({
			url: "init/ajax_fragment_table_course.php",
			success: function(response){
				$("#courseContainer").html(response);
				countCourse();
			}
		});
		return false;
	}
	
	function countCourse(){
		if ($('.course').length > 0){
			$('#nextBtn').prop('disabled', false);
		}
		else{
			$('#nextBtn').prop('disabled', true);
		}
	}
	fillTable();
</script>