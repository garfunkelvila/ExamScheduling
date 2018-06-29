<!DOCTYPE html>
<?php
	include "../util_dbHandler.php";
	include("util_check_session.php");
?>
<html>
<head>
	<title>Manage exam schedules</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link href="../jquery-ui-1.12.1.custom/jquery-ui.css" rel="stylesheet" type="text/css"/>
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
		input[type="date"]::-webkit-input-placeholder{ 
			visibility: hidden !important;
		}
	</style>
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<script src="/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>

	<?php include "fragment_header.php" ?>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<div class="w3-hide-small">
				<img  src="/images/sys-logo.png" style="width: 100%">
				<br>
				<br>
				<hr>
			</div>
			<button class="w3-button my-blue" style="width: 100%" type="button" onclick="">Batch add wizzard</button>
			<br>
			<br>
			<?php
					$stmt = null;
					$stmt = $conn->prepare("SELECT COUNT(`Id`) FROM `exam_schedules`;");
					$stmt->execute();
					$bResult = $stmt->get_result();
					$bRow = $bResult->fetch_row();
					
					if ($bRow[0] > 0){
						$stmt = null;
						$stmt = $conn->prepare("SELECT `Bool Val` FROM `dbconfig` WHERE `Name` = 'Exam Visible';");
						$stmt->execute();
						$cResult = $stmt->get_result();
						$sRow = $cResult->fetch_row();

						if($sRow[0] == '0'){
							?>
							<!--form onsubmit="return false">
								<select class="w3-input" id="period">
									<option value="0">Please select period</option>
									<option value="Prelim">Prelim</option>
									<option value="Midterm">Midterm</option>
									<option value="Finals">Finals</option>
								</select>
							</form-->

							<div id="dlgPostSchedule" class="w3-modal">
								<div class="w3-modal-content" style="max-width: 5in">
									<header class="w3-container my-blue"> 
										<h5>Post exam schedules</h5>
									</header>
									<div class="w3-container">
										<p>
											<select class="w3-input" id="period">
												<option value="0">Click to select a period</option>
												<option value="Prelim">Prelim</option>
												<option value="Midterm">Midterm</option>
												<option value="Finals">Finals</option>
											</select>
										</p>
										<div class=" w3-margin w3-right">
											<!--button class="w3-btn my-blue" style="width: 1in;" onclick="window.location = '../log-out.php'">Yes</button-->
											<button class="w3-btn my-blue" style="width: 1in;" onclick="document.getElementById('dlgPostSchedule').style.display='none'">Post</button>
											<button class="w3-btn my-blue" style="width: 1in;" onclick="document.getElementById('dlgPostSchedule').style.display='none'">Cancel</button>
										</div>
									</div>
								</div>
							</div>

							<!--button class="w3-button my-blue" style="width: 100%" type="button" onclick="btnPostExam()">Post exam schedules</button-->
							<button class="w3-button my-blue" style="width: 100%" type="button" onclick="document.getElementById('dlgPostSchedule').style.display='block'">Post exam schedules</button>
							<script type="text/javascript">
								function btnPostExam(){
									if($("#period").val() == 0){
										alert("Please select period");
									}
									else{
										$.ajax({
											url: "ajax_update_exam_visible_show.php",
											dataType: "json",
											data: { period: $("#period").val() },
											success: function(response){
												location.reload();
											}
										});
									}
									return false
								}
							</script>
							<?php
						}
						else{
							?>
								<button class="w3-button my-blue" style="width: 100%" type="button" onclick="btnHideExam()">Hide exam schedules</button>
								<script type="text/javascript">
									function btnHideExam(){
										$.ajax({
											url: "ajax_update_exam_visible_hide.php",
											success: function(response){
												location.reload();
											}
										});
										return false
									}
								</script>
							<?php
						}
						?>
							<a href="print_friendly_exam_schedules.php" target="_blank"><button class="w3-button my-blue" style="width: 100%" type="button">View Printer Friendly (All days)</button></a>
							<button class="w3-button w3-red" style="width: 100%" type="button" onclick="btnDeleteExams()">Delete exam schedules</button>
							<script type="text/javascript">
								function btnDeleteExams(){
									if (confirm("Are you sure you want to delete all exam schedules?") == true){
										$.ajax({
											url: "ajax_delete_all_skeds.php",
											success: function(response){
												location.reload();
											}
										});
									}
									return false
								}
							</script>

						<?php
					}
			?>
		</div>
		
		<div class="w3-rest w3-container">
			<!--br>
			<div class="w3-card w3-padding" style="display: inline-block;">
				<input id="inputDate" class="my-input-2" type="date" min="<?php echo date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")+1, date("Y")));; ?>" max="<?php echo (date("Y") + 1) . date("-m-d"); ?>">
				<button class="my-input-2 my-blue" style="cursor: pointer;" type="button" onclick="addDate()">Add Day</button>
			</div>
			<br>
			<br-->
			<div class="w3-border-bottom w3-border-blue" style="width: 100%; display: table;">
				<div class="my-cell" style="width: 50%"><div class="w3-center"><b>Unscheduled Subjects</b></div></div>
				<div class="my-cell" style="width: 50%"><div class="w3-center">
					<b>Scheduled Subjects:
						<select class="my-input-2">
							<option>January 1, 2018</option>
							<option>January 2, 2018</option>
							<option>January 3, 2018</option>
							<option>Add Date</option>
						</select>
					</b></div></div>
			</div>
			<div id="scheduleContainer" style="width: 100%; display: table;">
				<div class="my-cell" style="width: 60%">
					<div class="w3-cell-row w3-container">
						<div class="my-cell"><b>Subject Name</b></div>
						<div class="my-cell" style="width: 1in;"><b>Proctor</b></div>
						<div class="my-cell" style="width: 1in;"><b>Room</b></div>
						<div class="my-cell" style="width: 0.5in;"><b>Day</b></div>
						<div class="my-cell" style="width: 1in;"><b>Subject Code</b></div>
						<div class="my-cell" style="width: 0.5in;"><b>Span</b></div>
						<div class="my-cell" style="width: 0.3in;"><b></b></div>
					</div>
					<div>
						<div class="w3-cell-row w3-container">
							<div class="my-cell">Test Subject Name</div>
							<div class="my-cell" style="width: 1in;"><input type="text" name="" style="width: 100%"></div>
							<div class="my-cell" style="width: 1in;"><input type="text" name="" style="width: 100%"></div>
							<div class="my-cell" style="width: 0.5in;">1st</div>
							<div class="my-cell" style="width: 1in;">SuCode</div>
							<div class="my-cell" style="width: 0.5in;">Long</div>
							<div class="my-cell" style="width: 0.3in;">
								<button title="Add class" class="my-button w3-hover-green w3-hover-text-white">
									<i class="fas fa-angle-double-right" aria-hidden="true"></i>
								</button>
							</div>
						</div>
						<div class="w3-cell-row w3-container">
							<div class="my-cell">Test Subject Name</div>
							<div class="my-cell" style="width: 1in;"><input type="text" name="" style="width: 100%"></div>
							<div class="my-cell" style="width: 1in;"><input type="text" name="" style="width: 100%"></div>
							<div class="my-cell" style="width: 0.5in;">1st</div>
							<div class="my-cell" style="width: 1in;">SuCode</div>
							<div class="my-cell" style="width: 0.5in;">Long</div>
							<div class="my-cell" style="width: 0.3in;">
								<button title="Add class" class="my-button w3-hover-green w3-hover-text-white">
									<i class="fas fa-angle-double-right" aria-hidden="true"></i>
								</button>
							</div>
						</div>
						<div class="w3-cell-row w3-container">
							<div class="my-cell">Test Subject Name</div>
							<div class="my-cell" style="width: 1in;"><input type="text" name="" style="width: 100%"></div>
							<div class="my-cell" style="width: 1in;"><input type="text" name="" style="width: 100%"></div>
							<div class="my-cell" style="width: 0.5in;">1st</div>
							<div class="my-cell" style="width: 1in;">SuCode</div>
							<div class="my-cell" style="width: 0.5in;">Long</div>
							<div class="my-cell" style="width: 0.3in;">
								<button title="Add class" class="my-button w3-hover-green w3-hover-text-white">
									<i class="fas fa-angle-double-right" aria-hidden="true"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="w3-border-blue w3-border-left" style="display:table-cell"></div>
				<div class="my-cell" style="width: 40%">
					<div class="w3-cell-row w3-container">
						<div class="my-cell" style="width: 1in;"><b>Subject Code</b></div>
						<div class="my-cell"><b>Proctor Name</b></div>
						<div class="my-cell" style="width: 1in;"><b>Room</b> <button class="my-button w3-hover-green"><i class="fas fa-filter" aria-hidden="true"></i></button></div>
						<div class="my-cell" style="width: 1in;"><b>Time</b></div>
						<div class="my-cell" style="width: 0.5in;"><b></b></div>
					</div>
					<div>
						<div class="w3-cell-row w3-container">
							<div class="my-cell" style="width: 1in;">SuCode</div>
							<div class="my-cell">Test Proctor Name</div>
							<div class="my-cell" style="width: 1in;">100</div>
							<div class="my-cell" style="width: 1in;">1:00a - 2:00a</div>
							<div class="my-cell" style="width: 0.5in;">
								<button title="Add class" class="my-button w3-hover-red w3-hover-text-white">
									<i class="fas fa-angle-double-left" aria-hidden="true"></i>
								</button>
							</div>
						</div>
						<div class="w3-cell-row w3-container">
							<div class="my-cell" style="width: 1in;">SuCode</div>
							<div class="my-cell">Test Proctor Name</div>
							<div class="my-cell" style="width: 1in;">100</div>
							<div class="my-cell" style="width: 1in;">1:00a - 2:00a</div>
							<div class="my-cell" style="width: 0.5in;">
								<button title="Add class" class="my-button w3-hover-red w3-hover-text-white">
									<i class="fas fa-angle-double-left" aria-hidden="true"></i>
								</button>
							</div>
						</div>
						<div class="w3-cell-row w3-container">
							<div class="my-cell" style="width: 1in;">SuCode</div>
							<div class="my-cell">Test Proctor Name</div>
							<div class="my-cell" style="width: 1in;">100</div>
							<div class="my-cell" style="width: 1in;">1:00a - 2:00a</div>
							<div class="my-cell" style="width: 0.5in;">
								<button title="Add class" class="my-button w3-hover-red w3-hover-text-white">
									<i class="fas fa-angle-double-left" aria-hidden="true"></i>
								</button>
							</div>
						</div>
						<div class="w3-cell-row w3-container">
							<div class="my-cell" style="width: 1in;">SuCode</div>
							<div class="my-cell">Test Proctor Name</div>
							<div class="my-cell" style="width: 1in;">100</div>
							<div class="my-cell" style="width: 1in;">1:00a - 2:00a</div>
							<div class="my-cell" style="width: 0.5in;">
								<button title="Add class" class="my-button w3-hover-red w3-hover-text-white">
									<i class="fas fa-angle-double-left" aria-hidden="true"></i>
								</button>
							</div>
						</div>
						<div class="w3-cell-row w3-container">
							<div class="my-cell" style="width: 1in;">SuCode</div>
							<div class="my-cell">Test Proctor Name</div>
							<div class="my-cell" style="width: 1in;">100</div>
							<div class="my-cell" style="width: 1in;">1:00a - 2:00a</div>
							<div class="my-cell" style="width: 0.5in;">
								<button title="Add class" class="my-button w3-hover-red w3-hover-text-white">
									<i class="fas fa-angle-double-left" aria-hidden="true"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<?php include "fragment_footer.php" ?>
	
	<script src="fragment_table_exam_schedules.js">//Contains filler of datalists</script>
	<!--script type="text/javascript">
		//##### OLD SCRIPTS ####

		/*$(document).ready(function() {
			$('#inputDate').datepicker({
				minDate: 0,						
				beforeShowDay: noSunday
			});

			function noSunday(date){
				var day = date.getDay();
				return [(day > 0), ''];
			}; 
		});*/

		function addDate(){
			$.ajax({
				url: "ajax_insert_exam_date.php",
				dataType: "json",
				data: { exDate: $("#inputDate").val() },
				success: function(response){
					if(response.sucess){
						alert(response["result"]);
						location.reload(false);
					}
					else{
						alert(response["result"]);
						//$("#dayChooser").html("Nothing to show");
					}
				}
			});
			return false;
		}

		function updateDate(id){
			var newDate = document.getElementById("txbEditDate-" + id).value;
			$.ajax({
				url: "ajax_update_exam_date.php",
				dataType: "json",
				data: { dateId: id,
						newDate: newDate
				},
				success: function(response){
					if(response.sucess){
						alert(response["result"]);
						location.reload(false);
					}
					else{
						alert(response["result"]);
					}
				}
			});
		}

		function deleteDate(id){
			if (confirm("Are you sure you want to delete " + document.getElementById("viewDayId-" + id).innerHTML + "?") == true){
				$.ajax({
					url: "ajax_delete_exam_date.php",
					dataType: "json",
					data: { dateId: id },
					success: function(response){
						if(response.sucess){
							alert(response["result"]);
							location.reload(false);
						}
						else{
							alert(response["result"]);
							//$("#dayChooser").html("Nothing to show");
						}
					}
				});
			}
			return false;
		}

		function fillDayButtons(){
			$.ajax({
				url: "ajax_table_exam_days.php",
				dataType: "json",
				success: function(response){
					$("#dayChooser").html("<button class='datePicker w3-button my-blue' style='width: 1.5in;' type='button' onclick='fillScheduleTable(&#39;&#39;,this)'>All Days</button>");
					if(response.sucess){
						$.each(response.result, function(i, item){
							$("#dayChooser").append("<button class='datePicker w3-button' style='width: 1.5in;' type='button' onclick='fillScheduleTable(&#39;" + item["Id"] + "&#39;,this)'>Day " + item["rank"] + "</button>");
						});
					}
					else{
						//$("#dayChooser").html("Nothing to show");
					}
				}
			});
		}

		function fillScheduleTable(day,obj){
			var scheduleContainer = document.getElementById("scheduleContainer");
			var datePickers = document.getElementsByClassName("datePicker");
			
			for (var i = 0; i < datePickers.length; i++) {
				datePickers[i].classList.remove("my-blue");
			}

			if (obj != null) obj.classList.add("my-blue");
			
			$.ajax({
				url: "fragment_table_exam_schedules.php",
				data: {
					day: day
				},
				success: function(response){
					scheduleContainer.innerHTML = response;
				}
			});

			return false
		}

		function manageTable(dir, name){
			//second parameter helps prevents duplication of window
			/*openwindow = window.open(dir, name, "toolbar=no, location=yes, scrollbars=yes, resizable=yes, width=600, height=700");
			openwindow.focus();*/
		}
		fillDayButtons();
		fillScheduleTable("", null);
	</script-->
</body>
</html>