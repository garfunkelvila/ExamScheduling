<b>Date to fill:</b> <select id="dayId" class="my-input-1" style="width: 3in; border: none;">
	<option value="-">-Select a date-</option><?php 
		$stmt = null;
		$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('');");
		$stmt->execute();
		$dResult = $stmt->get_result();
		if ($dResult->num_rows > 0) {
			while ($dRow = $dResult->fetch_assoc()) {
				?><option value="<?php echo $dRow["Id"] ?>"><?php echo date("F j, Y (l)", strtotime($dRow["Date"])); ?></option><?php
			}
		}
	?></select>
<div class="w3-border-blue w3-border-top" id="subj_container" style="width: 100%; max-width: 8in; display: table;">
</div>
<script type="text/javascript">
	fillTable();
	function addSection(id){
		//Check if custom is chedked
		if (document.getElementById("ovT-" + id).checked == false){
			$.ajax({
				url: "e_sect/ajax_json_insert_exam_schedule_stack.php",
				dataType: "json",
				data: {
					endorseId: id,
					dayId: $("#dayId").val(),
					room: $("#room-" + id).val()
				},
				success: function(response){
					if(response.sucess){
						alert(response["result"]);
						//refreshYearContent($("#optYearContainer").val());
						fillTable();
					}
					else{
						alert(response["result"]);
					}
				}
			});
		}
		else{
			$.ajax({
				url: "e_sect/ajax_json_insert_exam_schedule_time.php",
				dataType: "json",
				data: {
					endorseId: id,
					dayId: $("#dayId").val(),
					room: $("#room-" + id).val(),
					start: $("#editT-" + id).val()
				},
				success: function(response){
					if(response.sucess){
						alert(response["result"]);
						//refreshYearContent($("#optYearContainer").val());
						fillTable();
					}
					else{
						if(response.m){
							if(confirm("Schedule can be merged. Do you want to merge it?")){
								addSectionMerge(id);
							}
						}
						else{
							alert(response["result"]);
						}
					}
				}
			});
		}
		return false;
	}

	function addSectionMerge(id){
		$.ajax({
			url: "e_sect/ajax_json_insert_exam_schedule_merge.php",
			dataType: "json",
			data: {
				endorseId: id,
				dayId: $("#dayId").val(),
				room: $("#room-" + id).val(),
				start: $("#editT-" + id).val()
			},
			success: function(response){
				alert(response["result"]);
				fillTable();
			}
		});
	}

	function fillTable(){
		$.ajax({
			url: "e_sect/ajax_fragment_unscheduled_subjects.php",
			success: function(response){
				$("#subj_container").html(response);
			}
		});
		return false;
	}
	function toggleBtnAdd(){
		/*if ($("#dayId").val() == '-'){
			$(".btnAdd").prop("disabled",true);
		}
		else{
			$(".btnAdd").prop("disabled",false);
		}*/
	}
</script>