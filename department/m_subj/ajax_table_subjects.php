<?php
	include "../../util_dbHandler.php";
	$locale = 'en_US';
?>
<div id="subjectListContainer">
	<h3 id="vc" style="display: block;"><?php
		$stmt = null;
		$stmt = $conn->prepare("SELECT `Name`,`Acronym` FROM `courses` WHERE `Course Code` = ?;");
		$stmt->bind_param('s', $_REQUEST['id']);
		$stmt->execute();
		$sResult = $stmt->get_result();
		$sRow = $sResult->fetch_row();
		echo $sRow[0]
	?><div style="display: inline;">
		<button title="Edit subject" class="my-button w3-hover-green" onclick="btnEditCourse()" type="button">
			<i class="far fa-edit" aria-hidden="true"></i>
		</button><button title="Delete subject" class="my-button w3-hover-red w3-hover-text-white" onclick="btnDeleteCourse()" type="button">
			<i class="far fa-trash-alt" aria-hidden="true"></i>
		</button>
	</div></h3>
	<h3 id="ec" style="display: none;"><form onsubmit="return btnComitEditCourse()">
		<input class="my-input-1" type="text" placeholder="Name" id="txbCourseName" style="width: 8in" required="" value="<?php echo $sRow[0]; ?>"><br>
		<input class="my-input-1" type="text" placeholder="Acronym" id="txbCourseAccr" style="width: 2in" required="" value="<?php echo $sRow[1]; ?>">
		<button title="Commit edit" class="my-button w3-hover-green" type="submit">
			<i class="fas fa-check" aria-hidden="true"></i>
		</button><button title="Cancel edit" class="my-button w3-hover-red w3-hover-text-white" onclick="btnCancelEditCourse()" type="button">
			<i class="fas fa-ban" aria-hidden="true"></i>
		</button>
	</form></h3>
	<script type="text/javascript">
		function btnEditCourse(){
			document.getElementById("vc").style.display = "none";
			document.getElementById("ec").style.display = "block";
		}
		function btnCancelEditCourse(){
			document.getElementById("vc").style.display = "block";
			document.getElementById("ec").style.display = "none";
		}
		function btnComitEditCourse(){
			$.ajax({
				url: "m_subj/ajax_json_update_course.php",
				dataType: "json",
				data: {
					code: '<?php echo $_REQUEST['id']; ?>',
					name: $("#txbCourseName").val(),
					acronym: $("#txbCourseAccr").val()
				},
				success: function(response){
					if (response.sucess){
						alert(response["result"]);
						location.reload();
					}
					else{
						alert(response["result"]);
					}
				}
			});
			return false;
		}
		function btnDeleteCourse(){
			if (confirm("Are you sure you want to delete this course?") == true){
				$.ajax({
					url: "m_subj/ajax_json_delete_course.php",
					dataType: "json",
					data: {
						code: '<?php echo $_REQUEST['id']; ?>'
						},
					success: function(response){
						if (response.sucess){
							alert(response["result"]);
							location.reload();
						}
						else{
							alert(response["result"]);
						}
					}
				});
			}
			return false;
		}
	</script>
	<form name="frmAddSubject" class="w3-card w3-padding w3-margin" method="POST" onsubmit="return addSubject()" style="max-width: 4in;">
		<h5 class="w3-border-bottom w3-border-blue">Add a subject</h5>
		<input class="my-input-1" type="text" name="strSubjectName" placeholder="Subject Name" required="">
		<input class="my-input-1" type="text" name="strSubjectCode" placeholder="Subject Code" required="">
		<select class="my-input-1" name="optLevel" onchange="checkOptLevel(this)">
			<option value="-">Select a level</option>
			<option value="1">First Year</option>
			<option value="2">Second Year</option>
			<option value="3">Third Year</option>
			<option value="4">Fourth Year</option>
			<option value="5">Fifth Year</option>
		</select>
		<select class="my-input-1" name="optMajor" id="majorContainer">
			<option value="0">Minor</option>
			<option value="1">Major</option>
		</select>
		<button class="my-button my-blue w3-section">Add</button>
	</form>
	<script type="text/javascript">
		//-- Add Subject codes ----------------------------------------
		//-- Uses inline php -- dont transfer?
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
			if (checkOptLevel(document.frmAddSubject.optLevel) == false) return false;
			//if (checkOptDept(document.frmAddSubject.optDepartment) == false) return false;
			//if (checkOptCourse(document.frmAddSubject.optCourse) == false) return false;

			var subjNameValue = document.frmAddSubject.strSubjectName.value;
			var subjCodeValue = document.frmAddSubject.strSubjectCode.value;
			var subjLevelValue = document.frmAddSubject.optLevel.value;
			//var subjDeptValue = document.frmAddSubject.optDepartment.value;
			//var subjCourValue = document.frmAddSubject.optCourse.value;
			var isMajor = document.frmAddSubject.optMajor.value;

			$.ajax({
				url: "m_subj/ajax_json_insert_subject.php",
				dataType: "json",
				data: {
					name: subjNameValue,
					code: subjCodeValue,
					level: subjLevelValue,
					courseId: '<?php echo $_REQUEST['id']; ?>',
					isMajor: isMajor
				},
				success: function(response){
					if(response.sucess){
						alert(response["result"]);
						//location.reload();
						refreshYearContent(subjLevelValue);
					}
					else{
						alert(response["result"]);
					}
				}
			});
			return false;
		}

		function refreshYearContent(year){
			var e = document.getElementById('year-' + year);
			if (typeof(e) == 'undefined' || e == null) {
				location.reload();
			}
			else{
				$.ajax({
					url: "m_subj/ajax_fragment_subjects_items.php",
					data: {
						level: year,
						id: '<?php echo $_REQUEST['id']; ?>'
					},
					success: function(response){
						$('#year-' + year).html(response);
					}
				});
			}							
			return false;
		}
	</script>
	<div id="subjects_container">
		<?php
			$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

			$stmt = null;
			$stmt = $conn->prepare("SELECT DISTINCT `Year Level` FROM `subjects` WHERE `Course Code` = ? ORDER BY `Year Level` ASC");
			$stmt->bind_param('s', $_REQUEST['id']);
			$stmt->execute();
			$lvlResult = $stmt->get_result();
			if ($lvlResult->num_rows > 0) {
				while ($lvlRow = $lvlResult->fetch_assoc()) {
					?><b><?php echo $nf->format($lvlRow['Year Level']) ?> Year</b><?php
					?><div class="w3-border-blue w3-border-top w3-container" id="year-<?php echo $lvlRow['Year Level']?>" style="display: table; width: 100%; max-width: 8in;">
						<?php include "ajax_fragment_subjects_items.php"; ?>
					</div><?php
				}
			}
			else{
				?>No subjects to show<?php
			}
		?>
	</div>
	<script type="text/javascript">
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
</div>