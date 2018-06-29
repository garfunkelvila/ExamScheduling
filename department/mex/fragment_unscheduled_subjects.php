<div style="width: 100%; display: table; max-width: 8in;" class="w3-container" id="unscheduled_sections">
</div>
<script type="text/javascript">
	function toggleProctorChooser(id) {
		if ($("#txbProc-" + id).val().length > 0){
			$("#pc-" + id).addClass("w3-show");
			fillSudgestions(id);
		}
		else{
			$("#pc-" + id).removeClass("w3-show");
		}
	}
	function chooseProctor(pId,fName,id){
		$("#v1-" + id).toggle();
		$("#e1-" + id).toggle();
		$("#txbProc-" + id).val(pId);
		$("#lblNam-" + id).html(fName);
	}
	function editProctor(id){
		//Should be getSudgestion
		$("#v1-" + id).toggle();
		$("#e1-" + id).toggle();
	}
	function checkAll(obj){
		$(".chkSubjs").prop('checked', obj.checked);
	}

	function fillSudgestions(id){
		//get textbox value
		var q = $("#txbProc-" + id).val();

		$.ajax({
			url: "mex/ajax_fragment_filtered_proctors.php",
			data: {q:q,id:id},
			success: function(response){
				$("#pc-" + id).html(response);
			}
		});
		return false;
	}
	// Add to be endorsed -----------------
	function addToEndorse(id){
		$.ajax({
			url: "mex/ajax_json_insert_to_endorse.php",
			dataType: "json",
			data: {
				id: id,
				profId: $("#txbProc-" + id).val(),
				span: $("#span-" + id).val(),
				day: $("#day-" + id).val()
			},
			success: function(response){
				if(response.sucess){
					alert(response["result"]);
					fillTable();
				}
				else{
					alert(response["result"]);
				}
			}
		});
		return false;
	}
	fillTable();
</script>