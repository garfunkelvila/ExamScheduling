<?php
	include "../util_dbHandler.php";
	include("util_check_session.php");
	include("util_check_isEndorsed.php");


	$stmt = null;
	$stmt = $conn->prepare("SELECT COUNT(`Dean_Id`) FROM `departments` WHERE `Dean_Id` = ?");
	$stmt->bind_param('s',$_SESSION['ID']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$isDeptExist = $sRow[0];

?><!DOCTYPE html>
<html>
<head>
	<title>Department Information</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<?php include "fragment_header.php" ?>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<img class="w3-hide-small" src="/images/sys-logo.png" style="width: 100%">
		</div>
		<div class="w3-rest w3-container">
			<div class="w3-half">
				<h3>Department Information</h3>
				<form method="POST" onsubmit="return updateDept()">
					<input class="w3-input" type="text" id="txbName" placeholder="Department Name" required="" value="<?php echo $deptName; ?>">
					<input class="w3-input" type="text" id="txbAccr" placeholder="Department Accronym" required="" value="<?php echo $deptAccr; ?>">
					<br>
					<button class="w3-button my-blue">Submit</button>
				</form>
			</div>
			<div class="w3-half">

			</div>
		</div>
	</div>
	<?php include "fragment_footer.php" ?>
	
	<?php
		if($isDeptExist == '0'){
			?><script type="text/javascript">
				function updateDept(){
					$.ajax({
						url: "ajax_json_insert_department.php",
						dataType: "json",
						data: {
							deptName: $("#txbName").val(),
							deptAccr: $("#txbAccr").val()
						},
						success: function(response){
							alert(response.result);
							if(response.sucess){
								window.location = "../";
							}
							
						}
					});
					return false;
				}
			</script><?php
		}
		else{
			?><script type="text/javascript">
				function updateDept(){
					$.ajax({
						url: "ajax_json_update_department.php#",
						dataType: "json",
						data: {
							deptName: $("#txbName").val(),
							deptAccr: $("#txbAccr").val()
						},
						success: function(response){
							alert(response.result);
							if(response.sucess){
								window.location = "../";
							}
						}
					});
					return false;
				}
			</script><?php
		}
	?>
</body>
</html>