
$(document).ready(function() {
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function(){	
	var uid 		= document.getElementById("id").value;
	var email 		= document.getElementById("email").value;
	var pass  		= document.getElementById("pass").value;
	var cpass  		= document.getElementById("cpass").value;
	var twitter  	= document.getElementById("twitter").value;
	var facebook  	= document.getElementById("facebook").value;
	var gplus  		= document.getElementById("gplus").value;
	var fname		= document.getElementById("fname").value;
	var lname		= document.getElementById("lname").value;
	var phone		= document.getElementById("phone").value;
	var address		= document.getElementById("address").value;
	save_signup_entry(uid,email,pass,cpass,twitter,facebook,gplus,fname,lname,phone,address);
});

$(".submit2").click(function(){
	document.write("amakuru");
});




function save_signup_entry(uid,email,pass,cpass,twitter,facebook,gplus,fname,lname,phone,address) {
    var url = 'ajax.php?action=save_signup_entry';
    url    += '&id='      	 + uid;
    url    += '&email='      + email;
    url    += '&pass='       + pass;
    url    += '&cpass='      + cpass;
    url    += '&twitter='    + twitter;
    url    += '&facebook='   + facebook;
    url    += '&gplus='      + gplus;
    url    += '&fname='      + fname;
    url    += '&lname='      + lname;
    url    += '&phone='      + phone;
    url    += '&address='    + address;
    var result = ajax_get_data(url);
    return result;
   
}

function ajax_get_data(this_url) {
	// Get Response
	var new_html = $.ajax({
		url: this_url,
		async: false,
		dataType: "html"
	}).responseText;
	alert(new_html);
	// Return Response
	return new_html;
}

});
