<?php
	include_once "../../util_dbHandler.php";
	include_once("../util_check_session.php");

	$deptName = isset($_COOKIE['deptName']) ? $_COOKIE['deptName'] : '';
	$deptAccr = isset($_COOKIE['deptAccr']) ? $_COOKIE['deptAccr'] : '';
?>
<div class="views" id="view-1">
	<h4 class="w3-border-bottom w3-border-blue">Department Information</h4>
	<div class="w3-container">
		<form name="frmNameDept" onsubmit="return false">
			<input class="w3-input" id="txbName" required="" type="text" placeholder="Name" oninput="checkDept()" value="<?php echo $deptName; ?>">
			<input class="w3-input" id="txbAccr" required="" type="text" placeholder="Accronym" oninput="checkDept()" value="<?php echo $deptAccr; ?>">
			<div class="w3-panel w3-red" id="msgPanel" style="display: none;">
				<p id="msg">asd</p>
			</div>
		</form>
	</div>
	<div class="w3-center w3-margin">
		<button class="w3-button my-blue" id="nextBtn" onclick="next()" disabled>Next</button>
	</div>
</div>
<script type="text/javascript">
	function next(){
		document.getElementById("myForm").submit();
	}
	function checkDept(){
		$.ajax({
			url: "init/ajax_json_check_department.php",
			dataType: "json",
			data: {
				deptName: $("#txbName").val(),
				deptAccr: $("#txbAccr").val()
			},
			success: function(response){
				if(response.sucess == false){
					if(response.result != 'Empty field.'){
						$("#msg").html(response.result);
						$("#msgPanel").css("display", "block");
					}
					$('#nextBtn').prop('disabled', true);
				}
				else{
					$("#msgPanel").css("display", "none");
					$('#nextBtn').prop('disabled', false);
				}
				
			}
		});
		return false;
	}
	function next(){
		$.ajax({
			url: "init/ajax_set_dept_cookie.php",
			data: {
				deptName: $("#txbName").val(),
				deptAccr: $("#txbAccr").val()
			},
			success: function(response){
				switchView('2');
			}
		});
		return false;
	}
	checkDept();
</script>