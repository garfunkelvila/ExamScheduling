<?php
	include_once "../../util_dbHandler.php";
	$locale = 'en_US';
	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);
?>
<div id="subjectListContainer">
	<h3 style="display: block;"><?php
		$stmt = null;
		$stmt = $conn->prepare("SELECT `Name` FROM `courses` WHERE `Course Code` = ?;");
		$stmt->bind_param('s', $_REQUEST['id']);
		$stmt->execute();
		$sResult = $stmt->get_result();
		$sRow = $sResult->fetch_row();
		echo $sRow[0]
	?></h3>
	<form name="frmAddSection" class="w3-card w3-padding w3-margin" method="POST" onsubmit="return addSection()" style="max-width: 4in;">
		<h5 class="w3-border-bottom w3-border-blue">Add a section</h5>
		<select class="my-input-1" name="optYear" id="optYearContainer" onchange="fillSubjectOptions(this.value)">
			<option value="-">-Year level-</option>
			<?php
				$stmt = null;
				$stmt = $conn->prepare("SELECT DISTINCT(`Year Level`) as `yLvl` FROM `subjects` WHERE `Course Code` = ? ORDER BY `Year Level` ASC");
				$stmt->bind_param('s',$_REQUEST['id']);
				$stmt->execute();
				$departments = $stmt->get_result();
				if ($departments->num_rows > 0) {
					while ($deptRow = $departments->fetch_assoc()) {
						?><option value="<?php echo $deptRow['yLvl'] ?>"><?php echo $nf->format($deptRow['yLvl']) ?> Year</option><?php
					}
				}
				else{
					?><option value="-">No year to show</option><?php
				}
			?>
		</select>
		<select class="my-input-1" name="optSubject" id="optSubjectContainer">
		</select>
		<input class="my-input-1" type="text" id="e1" name="txbProfId" style="text-transform: capitalize;" placeholder="Professor Name" required="" oninput="toggleProctorChooser()">
			<div id="prof-Filler" class="w3-dropdown-content w3-bar-block w3-border">Loading</div>
		
		<label class="my-input-1" id="v1" style="display: none;"><div id="lblName" style="display: inline;"></div> <a href="#" onclick="editProctor()" class="w3-tiny w3-text-blue">[Edit]</a></label>
		<input class="my-input-1" type="text" id="txbSectCode" style="text-transform: capitalize;" placeholder="Section Code" required="" maxlength="1">
		<button class="my-button my-blue w3-section">Add</button>
	</form>
	<script type="text/javascript">
		function toggleProctorChooser(id) {
			if ($("#e1").val().length > 0){
				$("#prof-Filler").addClass("w3-show");
				fillSudgestions(id);
			}
			else{
				$("#prof-Filler").removeClass("w3-show");
			}
		}
		function fillSudgestions(id){
			//get textbox value
			var q = $("#e1").val();

			$.ajax({
				url: "m_sect/ajax_fragment_filtered_proctors_1.php",
				data: {q:q, id:id},
				success: function(response){
					$("#prof-Filler").html(response);
				}
			});
			return false;
		}
		function chooseProctor(pId,fName){
			$("#v1").toggle();
			$("#e1").toggle();
			$("#prof-Filler").removeClass("w3-show");
			$("#e1").val(pId);
			$("#lblName").html(fName);
		}
		function editProctor(){
			$("#v1").toggle();
			$("#e1").toggle();
		}
		function addSection(){
			$.ajax({
				url: "m_sect/ajax_json_insert_section.php",
				dataType: "json",
				data: {
					section: $("#txbSectCode").val(),
					subject: $("#optSubjectContainer").val(),
					profId: $("#e1").val()
				},
				success: function(response){
					if(response.sucess){
						alert(response["result"]);
						refreshYearContent($("#optYearContainer").val());
					}
					else{
						alert(response["result"]);
					}
				}
			});
			return false;
		}
		//-------------------------
		//fillSubjectOptions('-');

		function fillSubjectOptions(year){
			$.ajax({
				url: "m_sect/ajax_fragment_options_subjects.php",
				data: {
					year: year,
					course: '<?php echo $_REQUEST['id']; ?>'
				},
				success: function(response){
					$('#optSubjectContainer').html(response);
				}
			});
		}
		//-------------------------
		function refreshYearContent(year){
			var e = document.getElementById('year-' + year);
			if (typeof(e) == 'undefined' || e == null) {
				location.reload();
				return true;
			}
			else{
				$.ajax({
					url: "m_sect/ajax_fragment_sections_items.php",
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
		fillSubjectOptions($("#optYearContainer").val());
	</script>

	<div id="subjects_container">
		<?php
			$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);
			$stmt = null;
			$stmt = $conn->prepare("SELECT DISTINCT `Year Level` FROM `subjects` JOIN `classes` ON `subjects`.`Id` = `classes`.`Subject Id` WHERE `Course Code` = ? ORDER BY `Year Level` ASC");
			$stmt->bind_param('s', $_REQUEST['id']);
			$stmt->execute();
			$lvlResult = $stmt->get_result();
			if ($lvlResult->num_rows > 0) {
				while ($lvlRow = $lvlResult->fetch_assoc()) {
					?><b><?php echo $nf->format($lvlRow['Year Level']) ?> Year</b><?php
					?><div class="w3-border-blue w3-border-top w3-container" id="year-<?php echo $lvlRow['Year Level']; ?>" style="display: table; width: 100%; max-width: 8in"><?php include_once "ajax_fragment_sections_items.php"; ?></div><?php
				}
			}
			else{
				?>No sections to show<?php
			}
		?>
	</div>
	<script type="text/javascript">
		function editProctor2(id){
			$("#v-Prof-" + id).toggle();
			$("#e-Prof-" + id).toggle();
		}
		function chooseProctor2(cId,pId,year){
			$.ajax({
				url: "m_sect/ajax_json_update_section_prof.php",
				dataType: "json",
				data: {
					cId: cId,
					profId: pId
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
		function btnDeleteSection(id,year){
			$.ajax({
				url: "m_sect/ajax_json_delete_class.php",
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
			return false;
		}
		// PROFCTOR CHOOSER ------------------------------------
		function toggleProctorChooser2(id,year) {
			if ($("#txbCProf-" + id).val().length > 0){
				$("#prof-Filler-" + id).addClass("w3-show");
				fillSudgestions2(id,year);
			}
			else{
				$("#prof-Filler-" + id).removeClass("w3-show");
			}
		}
		function fillSudgestions2(id,year){
			var q = $("#txbCProf-" + id).val();

			$.ajax({
				url: "m_sect/ajax_fragment_filtered_proctors_2.php",
				data: {
					q: q,
					id: id,
					yearLvl: year
				},
				success: function(response){
					$("#prof-Filler-" + id).html(response);
				}
			});
			return false;
		}
		// REFRESHER !!! ------------------------------
	</script>
</div>