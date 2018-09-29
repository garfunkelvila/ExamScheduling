<?php
	include_once "../../util_dbHandler.php";
	include_once("../util_check_session.php");

	$deptName = isset($_COOKIE['deptName']) ? $_COOKIE['deptName'] : '';
	$deptAccr = isset($_COOKIE['deptAccr']) ? $_COOKIE['deptAccr'] : '';
?>
<div class="views" id="view-5">
	<h4 class="w3-border-bottom w3-border-blue">Sections</h4>
	<div class="w3-container">
		<form name="frmSections" onsubmit="return addSection()">
			<select class="w3-input" id="optCourse" onchange="fillYearOptions();">
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
			<select class="w3-input" name="optYear" id="optYearContainer" onchange="fillSubjectOptions()">
				<option value="-">-Year level-</option>
			</select>
			<select class="w3-input" name="optSubject" id="optSubjectContainer">
				<option value="-">-Subject-</option>
			</select>
			<!-- -->
			<input class="w3-input" type="text" id="e1" name="txbProfId" style="text-transform: capitalize;" placeholder="Professor Name" required="" oninput="toggleProctorChooser()">
			<div id="prof-Filler" class="w3-dropdown-content w3-bar-block w3-border">Loading</div>
			<label class="w3-input" id="v1" style="display: none;"><div id="lblName" style="display: inline;"></div> <a href="#" onclick="editProctor()" class="w3-tiny w3-text-blue">[Edit]</a></label>
			<!-- -->
			<input class="w3-input" style="text-transform: capitalize;" id="txbSectCode" maxlength="1" required="" type="text" placeholder="Section">
			<button class="w3-button my-blue">Add</button>
		</form>
		<script type="text/javascript">
			function fillYearOptions(){
				fillSubjectOptions();
				$.ajax({
					url: "init/ajax_fragment_option_year.php",
					data: {
						id: $("#optCourse").val()
					},
					success: function(response){
						$('#optYearContainer').html(response);
						loadSections();
					}
				});
			}
			function fillSubjectOptions(){
				$.ajax({
					url: "m_sect/ajax_fragment_options_subjects.php",
					data: {
						year: $("#optYearContainer").val(),
						course: $("#optCourse").val()
					},
					success: function(response){
						$('#optSubjectContainer').html(response);
					}
				});
			}
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
						alert(response["result"]);
						if(response.sucess){
							loadSections();
							$("#txbSectCode").val('');
						}
					}
				});
				return false;
			}
			fillYearOptions('-');
		</script>
		<hr>
		<div id="sectionContainer" style="width: 100%">
		</div>
	</div>
	<div class="w3-center w3-margin">
		<button class="w3-button my-blue" onclick="switchView('4')">Back</button>
		<button class="w3-button my-blue" onclick="finish('<?php echo $deptName; ?>','<?php echo $deptAccr; ?>')">Finish</button>
	</div>
	<script type="text/javascript">
		function loadSections(){
			$.ajax({
				url: "init/ajax_fragment_table_sections.php",
				data: { id: $("#optCourse").val() },
				success: function(response){
					$("#sectionContainer").html(response);
					countSubjects();
				}
			});
			return false;
		}
		loadSections();
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
					alert(response["result"]);
					if(response.sucess){
						loadSections();
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
					alert(response["result"]);
					if(response.sucess){
						loadSections();
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
	</script>
</div>