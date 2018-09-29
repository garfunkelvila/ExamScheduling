<?php
	include_once "../../util_dbHandler.php";
	include_once("../util_check_session.php");
?>
<div class="views" id="view-3">
	<h4 class="w3-border-bottom w3-border-blue">Subjects</h4>
	<div class="w3-container">
		<form name="frmAddSubject" onsubmit="return addSubject()">
			<select class="w3-input" name="optCourse" onchange="checkOptLevel(this); loadSubjects(this.value)">
				<option value="-">Select a course</option>
				<?php
					$stmt = null;
					$stmt = $conn->prepare("CALL `select_courses_with_total`(?);");
					$stmt->bind_param("s",$_SESSION["ID"]);
					$stmt->execute();
					$tResult = $stmt->get_result();
					if ($tResult->num_rows > 0) {
						while ($tRow = $tResult->fetch_assoc()) {
							?><option value="<?php echo $tRow["CourseCode"]; ?>"><?php echo $tRow["Name"]; ?></option><?php
						}
					}
				?>
			</select>
			<select class="w3-input" name="optLevel" onchange="checkOptLevel(this)">
				<option value="-">Select a level</option>
				<option value="1">First Year</option>
				<option value="2">Second Year</option>
				<option value="3">Third Year</option>
				<option value="4">Fourth Year</option>
				<option value="5">Fifth Year</option>
			</select>
			<select class="w3-input" name="optMajor">
				<option value="0">Minor</option>
				<option value="1">Major</option>
			</select>
			<input class="w3-input" name="strSubjectName" required="" type="text" placeholder="Name">
			<input class="w3-input" name="strSubjectCode" required="" type="text" placeholder="Code">
			<button class="w3-button my-blue">Add</button>
		</form>
		<script type="text/javascript">
			function checkOptCourse(e){
				if(e !== undefined){
					if (e.value == "-"){
						e.setCustomValidity("Please select a course");
						return false;
					}
					else{
						e.setCustomValidity("");
						return true;
					}
				}
				return false;
			}
			function checkOptLevel(e){
				if(e !== undefined){
					if (e.value == "-"){
						e.setCustomValidity("Please select a level");
						return false;
					}
					else{
						e.setCustomValidity("");
						return true;
					}
				}
				return false;
			}
			
			function addSubject(){
			//FORM
			if (checkOptLevel(document.frmAddSubject.optCourse) == false) return false;
			if (checkOptLevel(document.frmAddSubject.optLevel) == false) return false;

			var subjCourse = document.frmAddSubject.optCourse.value;
			var subjNameValue = document.frmAddSubject.strSubjectName.value;
			var subjCodeValue = document.frmAddSubject.strSubjectCode.value;
			var subjLevelValue = document.frmAddSubject.optLevel.value;
			var isMajor = document.frmAddSubject.optMajor.value;

			$.ajax({
				url: "m_subj/ajax_json_insert_subject.php",
				dataType: "json",
				data: {
					name: subjNameValue,
					code: subjCodeValue,
					level: subjLevelValue,
					courseId: subjCourse,
					isMajor: isMajor
				},
				success: function(response){
					alert(response["result"]);
					if(response.sucess){
						loadSubjects();
						document.frmAddSubject.strSubjectName.value = '';
						document.frmAddSubject.strSubjectCode.value = '';
					}
				}
			});
			return false;
		}
		</script>
		<hr>
		<div id="subjectContainer"></div>
	</div>
	<div class="w3-center w3-margin">
		<button class="w3-button my-blue" onclick="switchView('2')">Back</button>
		<button class="w3-button my-blue" onclick="switchView('4')" id="nextBtn" disabled="">Next</button>
	</div>
</div>
<script type="text/javascript">
	function loadSubjects(){
		$.ajax({
			url: "init/ajax_fragment_table_subjects.php",
			data: { id: document.frmAddSubject.optCourse.value },
			success: function(response){
				$("#subjectContainer").html(response);
				countSubjects();
			}
		});
		return false;
	}
	loadSubjects();
	function refreshYearContent(year){
		loadSubjects();//Just a bypass to make the other script work			
		return false;
	}
	function countSubjects(){
		if ($('.subject').length > 0){
			$('#nextBtn').prop('disabled', false);
		}
		else{
			$('#nextBtn').prop('disabled', true);
		}
	}
	//---------------------------------------------
	function btnEditSubj(id){
		document.getElementById("subj-view-" + id).style.display = "none";
		document.getElementById("subj-edit-" + id).style.display = "table-row";
	}
	function btnDeleteSubj(id,year){
		if (confirm("Are you sure?")) {
			$.ajax({
				url: "m_subj/ajax_json_delete_subject.php",
				dataType: "json",
				data: { q: id },
				success: function(response){
					if(response.sucess){
						alert(response["result"]);
						refreshYearContent(year);
					}
					else{
						alert(response["result"]);
					}
				}
			});
		}
		return false;
	}
	function btnApplyEditSubj(id,year){
		$.ajax({
			url: "m_subj/ajax_json_update_subject.php",
			dataType: "json",
			data: {
				subjName: $("#txbSubjName-" + id).val(),
				subjCode: $("#txbSubjCode-" + id).val(),
				subjMajr: $("#cmbMajor-" + id).val(),
				q: id
			},
			success: function(response){
				if(response.sucess){
					alert(response["result"]);
					refreshYearContent(year);
				}
				else{
					alert(response["result"]);
				}
			}
		});
		return false;
	}
	function btnCancelEditSubj(id){
		document.getElementById("subj-view-" + id).style.display = "table-row";
		document.getElementById("subj-edit-" + id).style.display = "none";
	}
</script>