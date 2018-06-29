<?php
	#OBSOLETE
	include "../util_dbHandler.php";
	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

	$stmt = null;
	$stmt = $conn->prepare("SELECT DISTINCT `Year Level` FROM `subjects` WHERE `Course Code` = ? ORDER BY `Year Level` ASC");
	$stmt->bind_param('s',$_REQUEST['classId']);
	$stmt->execute();
	$lvlResult = $stmt->get_result();
	if ($lvlResult->num_rows > 0) {
		while ($lvlRow = $lvlResult->fetch_assoc()) {
			//------ SEPERATE YEAR LEVELS

			?><b class="w3-container" style="display: table-row;"><?php echo $nf->format($lvlRow['Year Level']) ?> Year</b><?php
			?><div style="display: table-row;">
				<div class="w3-border-blue w3-border-top" style="display: table-cell; max-width: 50%"><?php include "fragment_subjects_items.php"; ?></div>
				<div class="w3-border-blue w3-border-left" style="display: table-cell;"></div>
				<div class="w3-border-blue w3-border-top" style="display: table-cell; max-width: 50%"><?php include "fragment_sections_items.php"; ?></div>
			</div><?php
		}
	}
	else{

		?> No subjects to show <?php
	}
?>
<script type="text/javascript">
	function btnEditSubj(id){
		document.getElementById("subj-view-" + id).style.display = "none";
		document.getElementById("subj-edit-" + id).style.display = "table";
	}
	function btnDeleteSubj(id){
		$.ajax({
			url: "ajax_json_delete_subject.php",
			dataType: "json",
			data: { q: id },
			success: function(response){
				if(response.sucess){
					alert(response["result"]);
					loadSubjects('<?php echo $_REQUEST['classId']; ?>');
				}
				else{
					alert(response["result"]);
				}
			}
		});
		return false;
	}
	function btnApplyEditSubj(id){
		$.ajax({
			url: "ajax_json_update_subject.php",
			dataType: "json",
			data: {
				subjName: $("#txbSubjName-" + id).val(),
				subjCode: $("#txbSubjCode-" + id).val(),
				q: id
			},
			success: function(response){
				if(response.sucess){
					alert(response["result"]);
					loadSubjects('<?php echo $_REQUEST['classId']; ?>');
				}
				else{
					alert(response["result"]);
				}
			}
		});
		return false;
	}
	function btnCancelEditSubj(id){
		document.getElementById("subj-view-" + id).style.display = "table";
		document.getElementById("subj-edit-" + id).style.display = "none";
	}
	//------------------- CLASS FUNCTIONS
	function btnAddClass(subj){

		$.ajax({
			url: "ajax_json_insert_class.php",
			dataType: "json",
			data: {
				section: $("#txbSection-" + subj).val(),
				subject: subj
			},
			success: function(response){
				if(response.sucess){
					alert(response["result"]);
					//TODO: REFRESH SECTIONS
				}
				else{
					alert(response["result"]);
				}
			}
		});
		return false;
	}
	function btnDeleteClass(id){
		$.ajax({
			url: "ajax_json_delete_class.php",
			dataType: "json",
			data: { q: id },
			success: function(response){
				if(response.sucess){
					alert(response["result"]);
					//TODO: REFRESH SECTIONS
				}
				else{
					alert(response["result"]);
				}
			}
		});
		return false;
	}
</script>