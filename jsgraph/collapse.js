$(document).ready(function(){
	//hide message li after the 5th
	$(".message_list").each(function() {
		var a = $(this).attr('id');
		if (a.substring(0,6) === "tlist_");  {
			$('#'+a+' li:gt(2)').hide();
		}
	});
	$(".arrowDown").click(function(){
		var a = $(this).attr('id').replace("show_all_","");
		$(this).hide();
		$("#show_recent_"+a).show();
		$("#tlist_"+a+" li:gt(2)").slideDown();
		return false;
	});
	$(".arrowUp").click(function(){
		var a = $(this).attr('id').replace("show_recent_","");
		$(this).hide();
		$("#show_all_"+a).show();
		$("#tlist_"+a+" li:gt(2)").slideUp();
		return false;
	});	
});