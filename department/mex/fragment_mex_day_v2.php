<?php
if (isset($_REQUEST["dayRank"])){
	?><script type="text/javascript">
		function fillSection(){
			$.ajax({
				url: "mex/ajax_fragment_options_sections.php",
				data: {sect:$("#optSect").val()},
				success: function(response){
					$("#optSect").html(response);
				}
			});
			return false;
		}
		function fillSubject(){
			$.ajax({
				url: "mex/ajax_fragment_options_subjects.php",
				data: {sect:$("#optSect").val()},
				success: function(response){
					$("#optSubj").html(response);
					$("#teacher").val("---");
				}
			});
			return false;
		}
		function fillTeacher(){
			$.ajax({
				url: "mex/ajax_json_select_teacher.php",
				dataType: "json",
				data: {
					sect : $("#optSect").val(),
					subj : $("#optSubj").val()
				},
				dataType: "json",
				success: function(response){
					var span = response.isMajor == '1' ? "90" : "60";

					$("#teacher").val(response.teacher);
					$("#optProc").val(response.idNum)
					$("#span").val(span);
				}
			});
			return false;
		}
		function addToEndorse(){
			$.ajax({
				url: "mex/ajax_json_insert_to_endorse_v2.php",
				dataType: "json",
				data: {
					section: $("#optSect").val(),
					subj : $("#optSubj").val(),
					profId: $("#optProc").val(),
					span: $("#span").val(),
					day: '<?php echo $_REQUEST['dayRank'] ?>'
				},
				success: function(response){
					alert(response["result"]);
					if(response.sucess){
						//fillSection();
						//fillSubject();
						//fillTeacher();
						fillTable();
					}
				}
			});
			return false;
		}
		function removeToEndorse(id){
			$.ajax({
				url: "mex/ajax_json_delete_to_endorse.php",
				dataType: "json",
				data: {
					id: id
				},
				success: function(response){
					alert(response["result"]);
					if(response.sucess){
						//fillSection();
						//fillSubject();
						//fillTeacher();
						fillTable();
					}
				}
			});
			return false;
		}
		fillSection();
	</script><?php
}?>

<div style="display: table; max-width: 8in; width: 100%" id="right-container">
</div>