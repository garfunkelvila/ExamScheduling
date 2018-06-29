<!DOCTYPE html>
<?php
	include "../util_dbHandler.php";
	include("util_check_session.php");
?>
<html>
<head>
	<title>Manage Courses and Subjects</title>
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
<body><?php 
		if (isset($_REQUEST['view'])){
			$stmt = null;
			$stmt = $conn->prepare("SELECT COUNT(`Course Code`) FROM `courses` WHERE `Course Code` = ?");
			$stmt->bind_param('s', $_REQUEST['view']);
			$stmt->execute();
			$sResult = $stmt->get_result();
			$sRow = $sResult->fetch_row();
			if($sRow[0] == '0'){
				?><script type="text/javascript">window.location = "manage_subjects.php";</script><?php
			}
		}
	?><script src="/scripts/jquery-3.2.1.min.js"></script>
	<?php include "fragment_header.php" ?>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<div class="w3-hide-small">
				<img  src="/images/sys-logo.png" style="width: 100%">
				<br>
				<br>
				<hr>
			</div>
			<?php 
				if(isset($_REQUEST['view'])){
					#JUST SHOW IF A CLASS IS SELECTED
					?><?php
				}
				else{
					?><em class="w3-tiny">To add a subject, view a course first and adding form will be visible. To edit a course, Select a class first and click the pencil inline with the course name</em>
					<p><em class="w3-tiny">Please do take note that <b>course code</b> can't be changed after adding.</em></p>
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
									if (response.sucess){
										alert("Course sucesfully added.");
										location.reload();
									}
									else{
										alert(response["result"]);
									}
								}
							});
							return false;
						}
					</script>
					<br><?php
				}
			?>
			<?php include 'fragment_starter_warning.php'; ?>
		</div>
		<div class="w3-rest w3-container">
			<h3>Subjects and course manager</h3>
			<div class="w3-border-bottom w3-border-blue" id="dayChooser">
				<a href="manage_subjects.php" class="w3-button my-blue subj-tabs" id="deptHomeTab" type="button"><i class="fas fa-home" aria-hidden="true"></i></a><?php
					$stmt = null;
					$stmt = $conn->prepare("SELECT `Course Code`,`Name`,`Acronym` FROM `courses` WHERE `Dean_Id` = ?;");
					$stmt->bind_param("s",$_SESSION["ID"]);
					$stmt->execute();
					$departments = $stmt->get_result();
					if ($departments->num_rows > 0) {
						while ($deptRow = $departments->fetch_assoc()) {
							?><a id="btnDept-<?php echo $deptRow['Course Code']; ?>" class="w3-button subj-tabs" style="" type="button" href="manage_subjects.php?view=<?php echo $deptRow['Course Code']; ?>"><?php echo $deptRow['Acronym']; ?></a><?php
						}
					}
				?>
			</div>
			<div id="subjects-main-container"></div>
			<script type="text/javascript">
				//--- TAB LOADING SCRIPTS -------------------------------------
				<?php
					//TODO: Convert this to tab changer, dynamics
					if (!isset($_REQUEST['view'])){
						?>loadHomeTab();<?php
					}
					else{
						?>
						loadTab('<?php echo $_REQUEST['view'];?>');
						<?php
					}
				?>
				function loadHomeTab(){
					var subjTabs = document.getElementsByClassName("subj-tabs");
					for (var i = 0; i < subjTabs.length; i++) {
						subjTabs[i].classList.remove("my-blue");
					}

					document.getElementById("deptHomeTab").classList.add("my-blue");
					//if (obj != null) obj.classList.add("my-blue");

					$("#subjects-main-container").html("");
					$.ajax({
						url: "m_subj/ajax_subjects_home.php",
						success: function(response){
							$("#subjects-main-container").html(response);

						}
					});
					return false;
				}
				function loadTab(id){
					var subjTabs = document.getElementsByClassName("subj-tabs");

					for (var i = 0; i < subjTabs.length; i++) {
						subjTabs[i].classList.remove("my-blue");
					}
					document.getElementById("btnDept-" + id).classList.add("my-blue");

					$("#subjects-main-container").html("");
					$.ajax({
						url: "m_subj/ajax_table_subjects.php",
						data: { id: id },
						success: function(response){
							$("#subjects-main-container").html(response);
						}
					});
					return false;
				}
			</script>
		</div>
	</div>
	<?php #include "fragment_footer.php" ?>
	
	
</body>
</html>