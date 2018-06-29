function fillSectionDatalist(id){
	$("#sectionsDatalist-" + id).html("");

	$.ajax({
		url: "ajax_table_sections_no_skeds.php",
		dataType: "json",
		success: function(response){
			if (response.sucess){
				$.each(response.result, function(i, item){
					$("#sectionsDatalist-" + id).append("<option value='" + item["Section Code Full"] + "'>");
				});
			}
			else{
				//$("#proctors").html("Nothing to show");
			}
		}
	});
	return false;
}

function fillSubjectDatalist(id){
	$("#subjectsDatalist-" + id).html("");
	$.ajax({
		url: "ajax_table_subjects_class_no_skeds.php",
		dataType: "json",
		data: {section: $("#idStrSection-" + id).val()},
		success: function(response){
			if (response.sucess){
				$.each(response.result, function(i, item){
					$("#subjectsDatalist-" + id).append("<option value='" + item["Code"] + "'>");
				});
			}
			else{
				//$("#proctors").html("Nothing to show");
			}
		}
	});
	return false;
}

//Used for filling the form
function fillStudentCount(id){
	//No code yet
	$("#proctorsDatalist-" + id).html("");
	$.ajax({
		url: "ajax_count_students_by_section_and_subject.php",
		data: {
			section: $('#idStrSection-' + id).val(),
			subject: $('#idStrSubject-' + id).val()
		},
		success: function(response){
			$("#lblStudentCount-" + id).html(response);
		}
	});
	return false;

	//$("#lblStudentCount-" + id).html("99");
}

function fillProctorDatalist(id){
	$("#proctorsDatalist-" + id).html("");
	$.ajax({
		url: "ajax_table_proctors.php",
		dataType: "json",
		success: function(response){
			if (response.sucess){
				$.each(response.result, function(i, item){
					$("#proctorsDatalist-" + id).append("<option value='" + item["Id Number"] + "'>" + item["User Name"] + "</option>");
				});
			}
			else{
				//$("#proctors").html("Nothing to show");
			}
		}
	});
	return false;
}

//ATTEMP TO FULLY MATCH
function updateDayContainer(id){
	$("#dayItemsContainer-" + id).html("");
	$.ajax({
		url: "fragment_table_exam_schedules_item.php",
		data: {day: id},
		success: function(response){
			$("#dayItemsContainer-" + id).html(response);
		}
	});
	//alert("aaaaaaa");
	return false;
}

function addSchedule(dayId){
	var sectionCodeFull = $("#idStrSection-" + dayId).val();
	var subjectCode = $("#idStrSubject-" + dayId).val();
	var room = $("#idStrRoom-" + dayId).val();
	var startTime = $("#idstrStartTime-" + dayId).val();
	//var endTime = $("#idstrEndTime-" + dayId).val();
	var length = $("#idStrLength-" + dayId).val();
	var proctorId = $("#idstrProctorId-" + dayId).val();

	$.ajax({
		url: "ajax_insert_exam_schedule.php",
		dataType: "json",
		data: {
			subjectCode: subjectCode,
			sectionCodeFull: sectionCodeFull,
			dayId: dayId,
			startTime: startTime,
			examLength: length,
			room: room,
			proctorId: proctorId
		},
		success: function(response){
			if (response.sucess){
				//alert(response["result"]);
				updateDayContainer(dayId);
				$("#idStrSection-" + dayId).val("");
				$("#idStrSubject-" + dayId).val("");
				$("#idStrRoom-" + dayId).val("");
				//$("#idstrStartTime-" + dayId).val();
				//$("#idstrEndTime-" + dayId).val();
				$("#idstrProctorId-" + dayId).val("");
				$("#lblStudentCount-" + dayId).html("--");
			}
			else{
				var res = response["result"];
				if (res.indexOf("Merge with") >= 0){
					if (confirm(response["result"]) == true) {
						$.ajax({
							url: "ajax_insert_exam_schedule.php",
							data: {
								subjectCode: subjectCode,
								sectionCodeFull: sectionCodeFull,
								dayId: dayId,
								startTime: startTime,
								//endTime: endTime,
								examLength: length,
								room: room,
								proctorId: proctorId,
								merge: 'true'
							},
							success: function(response){
								updateDayContainer(dayId);
								$("#idStrSection-" + dayId).val("");
								$("#idStrSubject-" + dayId).val("");
								$("#idStrRoom-" + dayId).val("");
								//$("#idstrStartTime-" + dayId).val();
								//$("#idstrEndTime-" + dayId).val();
								$("#idstrProctorId-" + dayId).val("");
								$("#lblStudentCount-" + dayId).html("--");
							}
						});
					}
				}
				else{
					alert(response["result"]);
				}
			}
		}
	});
	//updateDayContainer(dayId);
	return false;
}

function btnDeleteSchedule(id,dayId){
	if (confirm("Are you sure you want to delete schedule?") == true){
		$.ajax({
			url: "ajax_delete_exam_schedule.php",
			dataType: "json",
			data: {
				q: id
			},
			success: function(response){
				if (response.sucess){
					//alert(response["result"]);
					updateDayContainer(dayId);
				}
				else{
					alert(response["result"]);
				}
			}
		});
	}
	//updateDayContainer(dayId);
	return false;
}