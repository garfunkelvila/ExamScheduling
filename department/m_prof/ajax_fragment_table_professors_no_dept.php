<?php
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_prof_department_no_dean`();");
	#$stmt->bind_param('s', $_SESSION['ID']);
	$stmt->execute();
	$pResult = $stmt->get_result();
	if ($pResult->num_rows > 0) {
		?><div class="" id="profContainer">
				<h5>Professors registered by ITS</h5>
				<div class="w3-border-blue w3-border-top w3-container" style="width: 100%; display: table; max-width: 8in;">
					<div class="w3-container" style="display: table-row;">
			<div class="my-cell"><b>Professor Name</b></div>
			<div class="my-cell" style="width: 1in;"><b>Action</b></div>
		</div><?php
		while ($pRow = $pResult->fetch_assoc()) {
			?><div class="my-hover-light-grey w3-container" id="prof-view-<?php echo $pRow['Id Number']?>" style="display: table-row;">
				<div class="my-cell" id="lblSubjName-34"><?php echo $pRow['fullName'];?></div>
				<div class="my-cell" style="width: 1in;">
					<button title="Add to my professors" class="my-button w3-hover-green" onclick="addToMyProf('<?php echo $pRow['Id Number']?>')" type="button">
						<i class="fas fa-plus"></i>
					</button>
				</div>
			</div>
			<?php
		}
		?></div></div>
		<script type="text/javascript">
			function addToMyProf(id){
				$.ajax({
					url: "m_prof/ajax_json_add_prof.php",
					dataType: "json",
					data: {
						idNumber : id
					},
					success: function(response){
						if (response.sucess){
							alert(response.result);
							location.reload();
						}
						else{
							alert(response["result"]);
						}
					}
				});
			}
		</script>
		<?php
	}
?>