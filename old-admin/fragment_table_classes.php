<!-- MIGHT NOT BE USED : OBSELETE!!! -->
<div id="classListContainer">
	<h5 class="w3-border-bottom w3-border-blue " style="display: block;">
		<b>Course: </b>
		<select style="border: 0; width: 50%; min-width: 4in; max-width: 6in;" onchange="(fillMainTable(this.value))" id="optCourse">
			<?php include_once "fragment_option_course_names.php" ?>
		</select>
	</h5>
	<div class="w3-cell-row">
		<div class="my-cell w3-center" style="width: 65%"><b>Subjects</b></div>
		<div class="my-cell w3-center" style="width: 35%"><b>Classes</b></div>
	</div>
	<div id="subj_class_container">
	</div>
</div>
<script src="/scripts/ordinal.js"></script>
<script type="text/javascript">
	var subjectContainer = document.getElementById("subjectContainer");
	
	function fillSubjectOption(){
		var optCourseValue = document.frmAddClass.optCourse.value;
		var optLevelValue = document.frmAddClass.optLevel.value;
		subjectContainer.innerHTML = "";
		

		if(optCourseValue == "-" || optLevelValue == "-"){
			subjectContainer.innerHTML = "<option value='-'>Please select a course and level first</option>";
		}
		else{
			//AJAX HERE FOR CONTENT
			$.ajax({
				url: "ajax_select_subject_by_course_level.php",
				dataType: "json",
				data: {
					course: optCourseValue,
					level: optLevelValue
				},
				success: function(response){
					if (response.sucess){
						$("#subjectContainer").append("<option value='-'>Please select a course</option>");
						$.each(response.result, function(i, subject){
							$("#subjectContainer").append("<option value='" + subject['Id'] + "'>" + subject['Name'] + " (" + subject['Code'] +")</option>");
						});
					}
					else{
						$("#subjectContainer").append("<option value='-'>No Subject</option>");
					}
				}
			});
		}
	}

	function fillMainTable(courseId){
		$("#subj_class_container").html("<div class='w3-padding'><div style='margin: auto;' class='loader'></div></div>");
		$.ajax({
			url: "fragment_table_class_list_item_level.php",
			data: {courseId: courseId },
			success: function(response){
				$("#subj_class_container").html("");
				$("#subj_class_container").html(response);
			}
		});
		return true;
	}

	function frmAddClass(id,lvl){
		var txb = document.getElementById("txbSection-" + id);
		validateSection(txb);

		$.ajax({
			url: "ajax_insert_class.php",
			dataType: "json",
			data: {
				section: txb.value,
				subject: id
			},
			success: function(response){
				if (response.sucess){
					//document.getElementById("class-level-" + lvl).innerHTML = classTable(document.getElementById("optCourse").value,lvl);
					//txb.value = "";
					//Refresh class table
					refreshClass(lvl);
					txb.value = "";
					//--------------------------
				}
				else{
					alert(response["result"]);
					txb.focus();
				}
			}
		});
		
		return false;
	}

	function btnDeleteClass(id,lvl){
		//lvl is uded for refreshing
		if (confirm("Are you sure you want to delete " + document.getElementById("lblSubjCode-" + id).innerHTML + " - " + document.getElementById("lblSectCode-" + id).innerHTML + "?") == true){
			$.ajax({
				url: "ajax_delete_class.php",
				dataType: "json",
				data: {
					q: id
				},
				success: function(response){
					if (response.sucess){
						refreshClass(lvl);
					}
					else{
						alert(response["result"]);
					}
				}
			});
		}
		return false;
	}

	function btnDeleteSubj(id,lvl){
		//NEW 
			if (confirm("Are you sure you want to delete \"" + document.getElementById("lblSubjName-" + id).innerHTML + "?\"\nDeleting a subject also deletes related classes.") == true){
				$.ajax({
				url: "ajax_delete_subject.php",
				dataType: "json",
				data: { q: id },
				success: function(response){
					if (response.sucess){
						alert(response["result"]);
						//location.reload(false);
						//REFRESH SUBJECTS
						refreshSubject(lvl);
						//REFRESH CLASSES
						refreshClass(lvl);
					}
					else{
						alert(response["result"]);
					}
				}
				});
			}
			return false;
		}

	//REFRESHERS

	function refreshSubject(lvl){
		$("#subject-lvl-" + lvl).html("<div style='display: inline;' class='w3-padding'><div style='margin: auto;' class='loader'></div></div>");
		$.ajax({
			url: "fragment_table_class_list_item_subject_table.php",
			data: {
				year: lvl,
				course: $("#optCourse").val()
			},
			success: function(response){
				$("#subject-lvl-" + lvl).html("");
				$("#subject-lvl-" + lvl).html(response);
			}
		});
	}


	function refreshClass(lvl){
		$("#class-lvl-" + lvl).html("<div style='display: inline;' class='w3-padding'><div style='margin: auto;' class='loader'></div></div>");
		$.ajax({
			url: "fragment_table_class_list_item_class_table.php",
			data: {
				year: lvl,
				course: $("#optCourse").val()
			},
			success: function(response){
				$("#class-lvl-" + lvl).html("");
				$("#class-lvl-" + lvl).html(response);
			}
		});
	}

	// EDIT SUBJECT VISIBILITY

	function btnEditSubj(id){
		document.getElementById("subj-view-" + id).style.display = "none";
		document.getElementById("subj-edit-" + id).style.display = "table";
		//document.getElementById("txbSubjName-" + id).focus();
	}

	function btnCancelEditSubj(id){
		document.getElementById("subj-view-" + id).style.display = "table";
		document.getElementById("subj-edit-" + id).style.display = "none";
		document.getElementById("txbSubjName-" + id).value = document.getElementById("txbSubjName-" + id).defaultValue;
		document.getElementById("txbSubjCode-" + id).value = document.getElementById("txbSubjCode-" + id).defaultValue;
	}

	function btnComitEditSubj(id,lvl){
		$.ajax({
			url: "ajax_update_subject.php",
			dataType: "json",
			data: {
				q: id ,
				subjName: $("#txbSubjName-" + id).val(),
				subjCode : $("#txbSubjCode-" + id).val()
			},
			success: function(response){
				if (response.sucess){
					refreshSubject(lvl);
					refreshClass(lvl);
				}
				else{
					alert(response["result"]);
				}
			}
		});
		return false;
	}

	// VALIDATIONS

	function validateSection(obj){
		//obj.focus();
		if (obj.value == '') {
			obj.setCustomValidity("Please enter the section");
			return false;
		}
		else if (!/^[A-z]+$/.test(obj.value)){
			obj.setCustomValidity("Please enter only a letter");
			return false;
		}
		else{
			obj.setCustomValidity("");
			return true;
		}
	}
	//------------------

	
	fillMainTable($("#optCourse").val());
	//deptFilter();
</script>