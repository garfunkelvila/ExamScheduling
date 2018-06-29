<!--h5>Parent that monitor</h5-->
<br>
<a href="print_friendly_guardian_monitor.php?idNum=<?php echo $_REQUEST['idNum']; ?>" target="_self">
	<button class="my-button my-blue" type="button"><i class="fas fa-print" aria-hidden="true"></i> View Printer Friendly</button>
</a><br><br>
Name: <b><?php echo $name; ?></b><br>
Login ID: <b><?php echo $_REQUEST['idNum']; ?></b>

<!--button class="my-button my-blue">
	<i class="fas fa-print" aria-hidden="true"></i> Printer friendly
</button-->
<br><br>
<div style="display: table; width: 100%" id="tblSubjContainer">
</div>
<br>
<div style="">
	<input class="my-input-1" type="text" id="txbGuardianId" placeholder="Student name or ID" onkeyup="updateSudgestion()">
	<div class="w3-card-2" id="sudgestions" style="display: table; background-color: white; position: absolute;">
	</div>
</div>
<em class="w3-tiny">Enter some part of name or ID number and click on the suggestion to add them.</em>
<script type="text/javascript">
	function fillSubjects(){
		$.ajax({
			url: "popups/ajax_table_popup_guardian_monitor.php",
			data: {
				idNum: "<?php echo $_REQUEST['idNum'] ?>"
			},
			success: function(response){
				//alert("ID number already exist, and is registered to " + response.result + ".");
				//tblSubjContainer
				$("#tblSubjContainer").html(response);
			}
		});
		return false;
	}

	function updateSudgestion(){
		if ($("#txbGuardianId").val().length < 1){
			$("#sudgestions").html("");
			return;
		};

		$.ajax({
			url: "popups/ajax_select_users_popup_register_guardian.php",
			dataType: "json",
			data: {
				q: $("#txbGuardianId").val(),
				idNum: '<?php echo $_REQUEST['idNum']; ?>'
			},
			success: function(response){
				$("#sudgestions").html("");
				if(response.sucess){
					
					$.each(response.result, function(index, value){
						var midName = value['Middle Name'].length == 0 ? "" : value['Middle Name'] + " "; //Prevents double space
						var wholeName = value['First Name'] + " " + midName + value['Family Name'];

						$("#sudgestions").append("<a class='w3-button' style='text-align: left; display:table-row;' onclick=\"addStudent('" + value['Id Number'] + "')\">" + 
							"<div class='w3-container' style='display: table-cell;'>" + value['Id Number'] + "</div>" +
							"<div class='w3-container' style='display: table-cell;'>" + wholeName + "</div>" + 
							"</a>");
					});
				}
				else{
					//
				}
			}
		});
	}

	function addStudent(q){
		$.ajax({
			url: "popups/ajax_insert_guardian_monitor.php",
			data: {
				studentId: q,
				tUserId: '<?php echo $_REQUEST['idNum']; ?>'
			},
			success: function(response){
				fillSubjects();
				$("#txbGuardianId").val("");
				$("#sudgestions").html("");
			}
		});
		return false;
	}

	function removeStudent(e){
		$.ajax({
			url: "popups/ajax_delete_from_guardian_monitor.php",
			data: {
				monitorId: e
			},
			success: function(response){
				fillSubjects();
			}
		});
		return false;
	}

	fillSubjects();
</script>