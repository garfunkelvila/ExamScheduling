<?php 
	include "../util_dbHandler.php";
	$stmt = null;
	$stmt = $conn->prepare("SELECT `subjects`.`Code`, `classes`.`Section Code Full` FROM `classes` JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id` WHERE `classes`.`Id` = ?");
	$stmt->bind_param('s', $_REQUEST['classId']);
	$stmt->execute();
	$titleResult = $stmt->get_result();
	$titleRow = $titleResult->fetch_row();
	$strSubject = $titleRow[0];
	$strSection = $titleRow[1];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Courses</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-container" style="max-width: 5in;">
		<h5>Manage Class: <?php echo $strSubject . " " . $strSection; ?></h5>
		<div class="w3-container">
			<label class="w3-tiny">Add student:</label>
			<div>
				<input class="my-input-2" type="text" id="strQStudent" placeholder="Name or ID number" onkeyup="fillDropdownContainer(this.value);">
				<ul id="studentsDropdownContainer" class="w3-dropdown-content w3-bar-block w3-card">
					<li class="w3-bar-item w3-button" onclick="return addStudentToClass('aaa');">Test 1 prokopyo brawulyo labatete</li>
					<li href="#" class="w3-bar-item w3-button" onclick="return addStudentToClass('aaa');">labatete</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="w3-container">
		<br>
		<div id="studentsContainer" class="" style="display: table; width: 100%">
		</div>
	</div>
	
	<script type="text/javascript">
		function toggleStudentsDropdownContainer(){
			if ($('#strQStudent').val().length > 2){
				$('#studentsDropdownContainer').addClass('w3-show');
			}
			else{
				$('#studentsDropdownContainer').removeClass('w3-show');
			}
			//return false;
		}

		function fillDropdownContainer(q){
			$.ajax({
				url: "ajax_table_students_not_in_class.php",
				dataType: "json",
				data: {
					q: q,
					classId: <?php echo $_REQUEST['classId']; ?>
				},
				success: function(response){
					$("#studentsDropdownContainer").html("");
					if (response.sucess){
						$.each(response.result, function(i, item){
							$("#studentsDropdownContainer").append("<a class='w3-button' style='text-align: left; display:table-row;' onclick='return addStudentToClass(&#39;" + item['Id Number'] + "&#39;)'>" +
							 "<div class='w3-container' style='display: table-cell'>" + item['Id Number'] + "</div>"+
							 "<div class='w3-container' style='display: table-cell'>" + item['Full Name'] + "</div>"+
							 "</a>");
						});
						
					}
					else{
						$("#studentsDropdownContainer").append("Nothing to show");
					}
				}
			});
			toggleStudentsDropdownContainer();
			return false;
		}

		function fillStudentsContainer(){
			$("#studentsContainer").html("");
			$.ajax({
				url: "ajax_table_section_class_students.php",
				data: {
					classId: <?php echo $_REQUEST['classId']; ?>
				},
				success: function(response){
					$("#studentsContainer").html(response);
				}
			});
			
			return false;
		}

		function addStudentToClass(id){
			$.ajax({
				url: "ajax_insert_student_to_class.php",
				dataType: "json",
				data: {
					classId: <?php echo $_REQUEST['classId']; ?>,
					userId: id
				},
				success: function(response){
					if (response.sucess){
						$("#strQStudent").val("");
						$('#studentsDropdownContainer').removeClass('w3-show');
						fillStudentsContainer();
					}
					else{
						alert("An error occured");
					}
				}
			});


			
			return true;
		}

		function removeStudentFromClass(id){
			if (confirm("Are you sure you want to delete this student?") == true){
				$.ajax({
					url: "ajax_delete_student_from_class.php",
					dataType: "json",
					data: {
						userId: id
					},
					success: function(response){
						if (response.sucess){
							fillStudentsContainer();
						}
						else{
							alert("An error occured");
						}
					}
				});
			}
			return true;
		}

		fillStudentsContainer();
	</script>
</body>
</html>