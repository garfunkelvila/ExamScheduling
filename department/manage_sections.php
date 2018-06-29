<!DOCTYPE html>
<?php
	include "../util_dbHandler.php";
	include("util_check_session.php");
	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);


	$stmt = null;
	$stmt = $conn->prepare("SELECT COUNT(`ProctorId`) FROM `proctor_department` WHERE `DeanId` = ?");
	$stmt->bind_param('s',$_SESSION['ID']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$profCount = $sRow[0];
?>
<html>
<head>
	<title>Manage sections</title>
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
			
			<?php 
				if ($profCount > 0){
					if (isset($_REQUEST['view'])){
						?><?php
					}
					else{
						?><P><em>Please view a course to be able to create a section.</em></P><?php
					}
				}#End of if ($profCount > 0)
				else{
					?><!--P><em>You don't have any professors in your department. Click <a href="manage_professors.php"><b>here</b></a> to add.</em></P--><?php
				}
			?><?php include 'fragment_starter_warning.php'; ?>
		</div>
		<div class="w3-rest w3-container">
			<h3>Section manager</h3>
			<div class="w3-border-bottom w3-border-blue" id="dayChooser">
				<a href="manage_sections.php" class="w3-button my-blue subj-tabs" id="deptHomeTab" type="button"><i class="fas fa-home" aria-hidden="true"></i></a><?php
					$stmt = null;
					$stmt = $conn->prepare("SELECT `Course Code`,`Name`,`Acronym` FROM `courses` WHERE `Dean_Id` = ?;");
					$stmt->bind_param("s",$_SESSION["ID"]);
					$stmt->execute();
					$departments = $stmt->get_result();
					if ($departments->num_rows > 0) {
						while ($deptRow = $departments->fetch_assoc()) {
							?><a id="btnDept-<?php echo $deptRow['Course Code']; ?>" class="w3-button subj-tabs" style="" type="button" href="manage_sections.php?view=<?php echo $deptRow['Course Code']; ?>"><?php echo $deptRow['Acronym']; ?></a><?php
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
						url: "m_sect/ajax_subjects_home.php",
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


					//if (obj != null) obj.classList.add("my-blue");

					$("#subjects-main-container").html("");
					$.ajax({
						url: "m_sect/ajax_table_sections.php",
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
	<script type="text/javascript">
		//-- Add Subject codes ----------------------------------------
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

		function checkOptExLength(e){
			// Di ko na tanda saan ginamit
			// Last check feb2: no usage
			if(e !== undefined){
				if (e.value == "-"){
					e.setCustomValidity("Please select a length");
					return false;
				}
				else{
					e.setCustomValidity("");
					return true;
				}
			}
			return false;
		}

		function checkOptDept(e){
			if(e !== undefined){
				if (e.value == "-"){
					e.setCustomValidity("Please select a department");
					//updateOptCourse(e.value);
					return false;
				}
				else{
					e.setCustomValidity("");
					//updateOptCourse(e.value);
					return true;
				}
			}
			return false;
		}

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
	</script>
	<!--script src="scripts/course_crud.js"></script-->
</body>
</html>