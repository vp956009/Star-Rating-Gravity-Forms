
jQuery(document).ready(function(){
  	jQuery(".rateit-hover").click(function(){
	   	var $nnn = jQuery(this).closest(".rateit").find(".rateit-range").attr("aria-valuenow")
    	jQuery(this).closest(".ginput_container").find(".rating_val").val($nnn);	
  	});
});
	