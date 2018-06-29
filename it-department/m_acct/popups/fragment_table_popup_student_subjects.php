<!--h5>Enrolled subjects</h5-->
Name: <b><?php echo $name; ?></b><br>
ID Number: <b><?php echo $_REQUEST['idNum']; ?></b>
<br><br>
<div style="display: table; width: 100%" id="tblSubjContainer">
</div>
<br>
<div style="">
	<b>Add subject: </b>
	<div>
		<input class="my-input-1" type="text" id="txbQ" placeholder="Subject code or section code" onkeyup="updateSudgestion()">
		<div class="w3-card-2" id="sudgestions" style="display: table; position: absolute; background-color: white;">
			<a class="w3-button" style="text-align: left; display:table-row;" onclick="addStudent('adasd')">
				<div class="w3-container" style="display: table-cell;">adasd</div>
				<div class="w3-container" style="display: table-cell;">Kevin Mocorro</div>
			</a>
		</div>
	</div>
	<div class="w3-card-2" id="sudgestions" style="display: table; background-color: white; position: absolute;">
	</div>
</div>
<em class="w3-tiny">Click on the suggestion to add them.</em>
<script type="text/javascript">
	function removeFromSection(id){
		$.ajax({
			url: "popups/ajax_delete_student_from_class.php",
			dataType: "json",
			data: {
				userId: id
			},
			success: function(response){
				//alert("ID number already exist, and is registered to " + response.result + ".");
				fillSubjects();
			}
		});
		return false;
	}
	function fillSubjects(){
		$.ajax({
			url: "popups/ajax_table_popup_student_subjects.php",
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

	function addClass(q){
		$.ajax({
			url: "popups/ajax_insert_student_to_class.php",
			data: {
				classId: q,
				userId: '<?php echo $_REQUEST['idNum']?>'
			},
			success: function(response){
				fillSubjects();
				$("#txbQ").val("");
				$("#sudgestions").html("");
			}
		});
		return false;
	}

	function updateSudgestion(){
		if ($("#txbQ").val().length < 1){
			$("#sudgestions").html("");
			return;
		};

		$.ajax({
			url: "popups/ajax_select_subjects_popup_view_user.php",
			dataType: "json",
			data: {
				q: $("#txbQ").val(),
				idNum: '<?php echo $_REQUEST['idNum']?>'
			},
			success: function(response){
				$("#sudgestions").html("");
				if(response.sucess){
					$.each(response.result, function(index, value){
						$("#sudgestions").append("<a class='w3-button' style='text-align: left; display:table-row;' onclick=\"addClass('" + value['Id'] + "')\">" + 
							"<div class='w3-container' style='display: table-cell;'>" + value['subjName'] + "</div>" +
							"<div class='w3-container' style='display: table-cell;'>" + value['subjCode'] + "</div>" + 
							"<div class='w3-container' style='display: table-cell;'>" + value['sectFull'] + "</div>" + 
							"</a>");
					});
				}
				else{
					//
				}
			}
		});
	}
	fillSubjects();
	updateSudgestion();
</script>