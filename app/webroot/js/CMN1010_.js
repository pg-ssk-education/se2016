$(function() {
	$("#reload").click(function() {
		$("#hidAction").val("reload");
		$("#indexForm").submit();
		
		return true;

	});
});
