<div id="tabContainer">
	<?php include_once "s_sect/ajax_fragment_scheduled_subjects.php"; ?>
</div>
<script type="text/javascript">
	function reloadContent(){
		//Reload full table
		$("#tabContainer").html("");
		$.ajax({
			url: "s_sect/ajax_fragment_scheduled_subjects.php",
			data: {
				id: '<?php echo isset($_REQUEST['id']) ? $_REQUEST['id'] : "%"; ?>',
				a: '1'},
			success: function(response){
				$("#tabContainer").html(response);
			}
		});
		return false;
	}
	function reloadContent(id){
		//Reload just a year
		$("#tabContainer").html("");
		$.ajax({
			url: "s_sect/ajax_fragment_scheduled_subjects.php",
			data: {
				id: id,
				a: '1'},
			success: function(response){
				$("#tabContainer").html(response);
			}
		});
		return false;
	}
	function deleteSection(id){
		if (confirm("Are you sure?")){
			$.ajax({
				url: "s_sect/ajax_json_delete_exam_schedule.php",
				dataType: "json",
				data: {
					q: id
				},
				success: function(response){
					if(response.sucess){
						alert(response["result"]);
						//refreshYearContent($("#optYearContainer").val());
						<?php 
							if (isset($_REQUEST['id'])){
								?>reloadContent('<?php echo $_REQUEST['id'] ?>');<?php
							}
							else{
								?>reloadContent();<?php
							}
						?>
					}
					else{
						alert(response["result"]);
					}
				}
			});
		}
		return false;
	}
	function updateSection(id){
		//Check if custom is chedked
		if (document.getElementById("tAuto").checked == true){
			$.ajax({
				url: "s_sect/edit_time/ajax_json_update_exam_schedule_stack.php",
				dataType: "json",
				data: {
					skedId: id,
					dayId: $("#optDay").val(),
					room: $("#txbRoom").val()
				},
				success: function(response){
					alert(response["result"]);
					if(response.sucess){
						document.getElementById('editSked').style.display='none';
						reloadContent();
					}
				}
			});
		}
		else{
			$.ajax({
				url: "s_sect/edit_time/ajax_json_update_exam_schedule_time.php",
				dataType: "json",
				data: {
					skedId: id,
					dayId: $("#optDay").val(),
					room: $("#txbRoom").val(),
					start: $("#txbTime").val()
				},
				success: function(response){
					if(response.sucess){
						alert(response["result"]);
						document.getElementById('editSked').style.display='none';
						reloadContent();
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
			url: "s_sect/edit_time/ajax_json_update_exam_schedule_merge.php",
			dataType: "json",
			data: {
				skedId: id,
				dayId: $("#optDay").val(),
				room: $("#txbRoom").val(),
				start: $("#txbTime").val()
			},
			success: function(response){
				alert(response["result"]);
				document.getElementById('editSked').style.display='none';
				reloadContent();
			}
		});
	}
</script>