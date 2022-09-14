$(document).ready(function(){
	var is_admin=$('#admin_main');
	if(is_admin.length){
	    // var href = window.location.href;
	    // $('#admin_main #sidebar a[href="' + href + '"]').addClass('active');
	    // $('#admin_main #sidebar a[href="' + href + '"]').closest('.submenu_outerbox').addClass('show');
	    // console.log(window.location.pathname.split('/')[1]);
	    // console.log(window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1]);
	    $('#admin_main #sidebar a[href="' + window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1] + '"]').addClass('active');
	    $('#admin_main #sidebar a[href="' + window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1] + '"]').closest('.submenu_outerbox').addClass('show');
	    // var id=$('#admin_main #sidebar a[href="' + href + '"]').closest('.submenu_outerbox').attr('id');
	    // $('#admin_main #sidebar a[href="#' + id + '"]').addClass('active');
	}

	function showDelayMessage(){
		$("body").html('<div id="delay-message-myModal" class="delay-message-modal"><div class="delay-message-modal-content"><span class="delay-message-close">&times;</span><p>Your download is processing and should be done in about 5 seconds.</p></div></div>');
		return true;
	}
});