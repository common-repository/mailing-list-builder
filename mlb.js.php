<?php
if (!function_exists('add_action'))
{
    require_once("../../../wp-config.php");
}
?>

jQuery(document).ready(function($) {
	
	/* Content Form */
	$("#mlb").submit(function() {
		
		$(".mlb-submit").val("Processing...").attr("disabled", "disabled");
		
  		var email = $("input#mlb-email").val();
  		
  		if (email == "") 
  		{
  			$(".mlb-submit").val("Try again...").removeAttr("disabled");
	        $("div#mlb-email-error").hide().fadeIn('fast');
	        $("input#mlb-email").focus();
	        return false;
  		}
		
		$.ajax({
			type: "POST",
			url: "<?php bloginfo("url"); ?>/?mlb-process=true",
			data: $("#mlb").serialize(),
			success: function(retval) 
			{
				if (retval == "1")
				{
					big_height = $('#mlb').height();
					$('#mlb').height(big_height);
					$('#mlb').html("<div class='success'></div>");
					$('.success').html("<h2>Success!</h2>")
					.append("<p>You've been subscribed.</p>")
					.hide();
					
					small_height = $('.success').height();
					
					$('.success').css({'margin-top': (big_height-small_height)/2}).fadeIn('fast');
				}
				else if (retval == 'Duplicated emails not allowed')
				{
					big_height = $('#mlb').height();
					$('#mlb').height(big_height);
					$('#mlb').html('<div class="success"></div>');
					$('.success').html('<h2>Thank You!</h2>')
					.append("<p>You're in our list.</p>")
					.hide();
					
					small_height = $('.success').height();
					
					$('.success').css({'margin-top': (big_height-small_height)/2}).fadeIn('fast');
				} 
				else
				{
					$(".mlb-submit").val("Try again...").removeAttr("disabled");
					$("div#mlb-email-error").html(retval).hide().fadeIn('fast');
					$("input#mlb-email").focus();
				}
			}
		});
		return false;
	});
	
	/* Sidebar Form */
	$("#mlbs").submit(function() {
		
		$(".mlbs-submit").val("Processing...").attr("disabled", "disabled");
		
  		var email = $("input#mlbs-email").val();
  		
  		if (email == "") 
  		{
  			$(".mlbs-submit").val("Try again...").removeAttr("disabled");
	        $("div#mlbs-email-error").hide().fadeIn('fast');
	        $("input#mlbs-email").focus();
	        return false;
  		}
		
		$.ajax({
			type: "POST",
			url: "<?php bloginfo("url"); ?>/?mlb-process=true",
			data: $("#mlbs").serialize(),
			success: function(retval) 
			{
				if (retval == "1")
				{
					big_height = $('#mlbs').height();
					$('#mlbs').height(big_height);
					$('#mlbs').html("<div class='success'></div>");
					$('.success').html("<h2>Success!</h2>")
					.append("<p>You've been subscribed.</p>")
					.hide();
					
					small_height = $('.success').height();
					
					$('.success').css({'margin-top': (big_height-small_height)/2}).fadeIn('fast');
				}
				else if (retval == 'Duplicated emails not allowed')
				{
					big_height = $('#mlb').height();
					$('#mlbs').height(big_height);
					$('#mlbs').html('<div class="success"></div>');
					$('.success').html('<h2>Thank You!</h2>')
					.append("<p>You're in our list.</p>")
					.hide();
					
					small_height = $('.success').height();
					
					$('.success').css({'margin-top': (big_height-small_height)/2}).fadeIn('fast');
				} 
				else
				{
					$(".mlbs-submit").val("Try again...").removeAttr("disabled");
					$("div#mlbs-email-error").html(retval).hide().fadeIn('fast');
					$("input#mlbs-email").focus();
				}
			}
		});
		return false;
	});
});
  